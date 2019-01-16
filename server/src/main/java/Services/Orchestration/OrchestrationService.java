package Services.Orchestration;

import BRE.BREClient;
/*import BizTalkLog.Logger.BizLog;
import BizTalkLog.Logger.LogLevel;*/
import DB.DBHandler;
import DB.Job;
import DB.Orchestration;
import DB.Rule;
import Services.Orchestration.Requests.JobRequest;
import Services.Orchestration.Requests.OrchestrationRequest;
import Services.Orchestration.Requests.RuleRequest;
import Services.StatusCodes;

import javax.jws.WebService;
import java.util.ArrayList;
import java.util.List;

@WebService(endpointInterface = "Services.Orchestration.IOrchestrationService",
        serviceName = "OrchestrationService")
public class OrchestrationService implements IOrchestrationService {

    /**
     * For accessing database
     */
    private DBHandler dbHandler = new DBHandler();

    /**
     * Introduce an orchestration.
     *
     * @param value        Object that contains orchestration information.
     * @param jobRequests  List that contains jobRequests of orchestration.
     * @param ruleRequests List that contains ruleRequests of orchestration.
     * @return Message.
     */
    @Override
    public String addOrchestration(OrchestrationRequest value, List<JobRequest> jobRequests,
                                   List<RuleRequest> ruleRequests) {
        if (value.id == 0) {
            //BizLog.Log("1", String.valueOf(value.ownerID), LogLevel.ERROR,
               //     new Orchestration(value.ownerID, StatusCodes.ERROR, value.startJobID));
            return "*** DB.OrchestrationRequest id could not be 0! ***";
        }

        List<Integer> JobIdList = new ArrayList<>();
        List<Integer> RuleIdList = new ArrayList<>();
        List<Job> jobList = new ArrayList<>();


        //End nodes
        JobIdList.add(0);
        RuleIdList.add(0);

        //Saving jobRequests to the database
        // and adding their generated id's from db to JobIdList.
        for (JobRequest temp : jobRequests){
            int id = addJobSub(temp);
            JobIdList.add(id);
            try {
                jobList.add(dbHandler.getJob(id));
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        List<RuleRequest> mockRuleReq = new ArrayList<>();
        for (int i = 0; i < jobList.size(); i++){
            Job currentJob = jobList.get(i);
            if (i < jobList.size() - 1){
                int actualRuleId;
                if (currentJob.getRuleId() == 0){
                    int jobId = i + 1 ;
                    RuleRequest mockRequest = new RuleRequest();
                    mockRequest.id = jobId;
                    mockRequest.noEdge = 0;
                    mockRequest.yesEdge = JobIdList.get(jobRequests.get(jobId - 1).nextJobId);
                    mockRequest.relativeResults = "T";
                    mockRequest.ownerID = currentJob.getOwner();
                    mockRequest.query = "";
                    actualRuleId = addRuleSub(mockRequest);
                    RuleIdList.add(actualRuleId);
                    mockRequest.id = actualRuleId;

                    mockRuleReq.add(mockRequest);
                }
                else {
                    RuleRequest temp = ruleRequests.get(currentJob.getRuleId() - 1);
                    temp.yesEdge = JobIdList.get(temp.yesEdge);
                    temp.noEdge = JobIdList.get(temp.noEdge);
                    temp.relativeResults = "X";
                    actualRuleId = addRuleSub(temp);
                    RuleIdList.add(actualRuleId);
                    try {
                        Rule rule = dbHandler.getRule(actualRuleId);
                        System.out.println("--------------> " + rule.getQuery() + " " + rule.getId() + " " + currentJob.getRelatives());

                        BREClient.add(rule.getQuery(), rule.getId(), currentJob.getRelatives());   // Return value kullanilmali. Return valuesu query formattan oturu hata verebilir.
                    } catch (Exception e) {
                        e.printStackTrace();
                    }
                    mockRuleReq.add(temp);
                }

                try {
                    dbHandler.updateJob(currentJob.getId(), "RuleId", actualRuleId);
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }

//        // Saving ruleRequests to db.
//        // creating edges between ruleRequests declared from gui.
//        // adding DB.RuleRequest id's to the RuleIdList.
//        for (RuleRequest temp : ruleRequests) {
//            temp.yesEdge = JobIdList.get(temp.yesEdge);
//            temp.noEdge = JobIdList.get(temp.noEdge);
//            temp.relativeResults = "X";
//            int ruleId = addRuleSub(temp);
//            RuleIdList.add(ruleId);
//        }

        // Set the start job's id.
        Orchestration actualOrch = new Orchestration(value.ownerID, StatusCodes.INITIAL, JobIdList.get(1));

        // Adding orchestration value to db.
        try {
            actualOrch.setId(dbHandler.insertOrchestration(actualOrch));
        } catch (Exception e) {
            System.err.println("DB.OrchestrationRequest could not be introduced: " + e);
            return "*** DB.OrchestrationRequest could not be introduced. ***";
        }

//        //Updating all jobRequests with their associated ruleRequests with db ids.
//        for (int jobId : JobIdList) {
//            if (jobId == 0) continue;
//
//            Job workOn;
//            try {
//                workOn = dbHandler.getJob(jobId);
//            } catch (Exception e) {
//                System.err.println("Error to access given id: " + jobId);
//                return String.format("*** Error to access given id (job): %d***", jobId);
//            }
//
//            int ruleId = RuleIdList.get(workOn.getRuleId()); // BURADA NE OLUYOR
//            workOn.setRuleId(ruleId); // BURADA NE OLUYOR
//            try {
//                // Update ruleId of the job.
//                dbHandler.updateJob(jobId, "RuleId", ruleId);
//
//                if (ruleId != 0) {
//                    Rule rule = dbHandler.getRule(ruleId);
//                    System.out.println(rule);
//                    System.out.println("--------------> " + rule.getQuery() + " " + rule.getId() + " " + workOn.getRelatives());
//
//                    BREClient.add(rule.getQuery(), rule.getId(), workOn.getRelatives());   // Return value kullanilmali. Return valuesu query formattan oturu hata verebilir.
//
//
//                 //   BizLog.Log("1", String.valueOf(value.ownerID), LogLevel.INFO, workOn, rule, actualOrch);
//                }
//
//            } catch (Exception e) {
//                System.err.println("Error to access given id: " + ruleId);
//                return String.format("*** Error to access given id (rule): %d***", ruleId);
//            }
//
//            //    public static void Log(String logID, String userID, LogLevel level, Job job, Rule rule, Orchestration orch)
//        }

        return "DB.OrchestrationRequest has been introduced successfully!";
    }

    /**
     * Add job and rule. (Rule is optional.)
     *
     * @param job  Job to be added.
     * @param rule Rule to be added.
     * @return Message
     */
    @Override
    public String addJobRule(JobRequest job, RuleRequest rule) {
        if (job.id == 0)
            return "*** An error occurred while adding job ***";
        job.id = -1;
        if (job.ruleId == 0) {
            System.out.println("addJobRule" + job.id + " Hata burada");
            return addJobSub(job) != -1 ? "Job has been added successfully!" : "*** An occurred while adding job ***";
        }
        rule.relativeResults = "X";
        job.ruleId = addRuleSub(rule);

        int ruleId = addJobSub(job);
        System.out.println("***********  " + rule.query +" " + ruleId +" "+ job.relatives);
        int s = BREClient.add(rule.query, ruleId, job.relatives);   // Return value kullanilmali. Return valuesu query formattan oturu hata verebilir.
        return ruleId != -1 ? "Job has been added with rule successfully!" : "*** An occurred while adding job with rule ***";
    }

    /**
     * Remove job and rule, If rule exists.
     *
     * @param jobID ID of Job to be added.
     * @return Message
     */
    @Override
    public String removeJob(int jobID) {
        try {
            Job job = dbHandler.getJob(jobID);
            if (job.getStatus() == StatusCodes.REMOVED)
                return "Job has already been removed!";
            int ruleId = job.getRuleId();
            if (ruleId != 0) {
                dbHandler.removeRule(ruleId);
                System.out.println("jkahdjkhsdjkashdkjasdhjkasdhjkashdlkjahskdjhasdj");
            }
            dbHandler.updateJob(jobID, "Status", StatusCodes.REMOVED);
        } catch (Exception e) {
            return "*** An error occurred while removing job ***";
        }
        return String.format("*** Job has just been removed! (ID: %d) ***", jobID);
    }

    /**
     * Add given job to database.
     *
     * @param value DB.JobRequest to be added to database.
     * @return If added, returns job id which is got from db, otherwise -1 to indicate an error.
     */
    private int addJobSub(JobRequest value) {
        int dbJobId;

        System.out.println(value.owner + " " + value.description + " " + value.destination + " " + value.fileUrl + " "
                + value.relatives + " " + 0 + " " +value.ruleId + " " + value.orchFlag);

        Job actualJob = new Job(value.owner, value.description, value.destination, value.fileUrl,
                value.relatives, 0, value.ruleId, value.orchFlag);

        if (value.id == -1) {
            actualJob.setStatus(StatusCodes.SINGLE_INITIAL_JOB);
        }
        try {
            dbJobId = dbHandler.insertJob(actualJob);
        } catch (Exception e) {
            System.err.println("DB.JobRequest Db insert error: " + e);
            return -1;
        }
        actualJob.setId(dbJobId);
        System.out.printf("addJobSub JobID: %d - RuleID: %d\n", value.id, value.ruleId);
        return dbJobId;
    }

    /**
     * Add given rule to database.
     *
     * @param value DB.RuleRequest to be added to database.
     * @return If added, returns rule id which is got from db, otherwise -1 to indicate an error.
     */
    private int addRuleSub(RuleRequest value) {
        int dbRuleId;

        Rule actualRule = new Rule(value.ownerID, value.query, value.yesEdge, value.noEdge, value.relativeResults);
        try {
            dbRuleId = dbHandler.insertRule(actualRule);

        } catch (Exception e) {
            System.out.println("DB.RuleRequest Db insert error: " + e);
            return -1;
        }
        actualRule.setId(dbRuleId);
        System.out.println("addRuleSub: " + value.id);
        return dbRuleId;
    }

}
