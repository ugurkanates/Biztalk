package Services.InfoService;

import DB.DBHandler;
import DB.Job;
import DB.Orchestration;
import DB.Rule;
import Services.StatusCodes;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.xml.bind.annotation.XmlElement;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

@WebService(serviceName = "InfoService")
public class InfoService {
    private DBHandler handler = new DBHandler();

    @WebMethod
    @XmlElement(name = "getJob")
    public JobResponse getJob(@WebParam(name = "jobID") @XmlElement(required = true) Integer jobId) throws Exception {
        Job job = handler.getJob(jobId.intValue());
        JobResponse info = new JobResponse();
        info.setDescription(job.getDescription());
        info.setDestination(job.getDestination());
        info.setFileUrl(job.getFileUrl());
        info.setId(job.getId());
        info.setInsertDateTime(job.getInsertDateTime_Date());
        info.setOwner(job.getOwner());
        info.setRelatives(job.getRelatives());
        info.setRuleId(job.getRuleId());
        info.setStatus(job.getStatus());
        info.setUpdateDateTime(job.getUpdateDateTime_Date());
        return info;
    }


    @WebMethod
    @XmlElement(name = "getJobFromOwner")
    public ArrayList<JobResponse> getJobsFromOwner(@WebParam(name = "ownerID") @XmlElement(required = true)
                                                               Integer ownerId) throws Exception {
        ArrayList<Job> jobSet = handler.getJobSet(ownerId);
        ArrayList<JobResponse> jobList = new ArrayList<>();

        for(Job job : jobSet){
            if (job.getStatus() != StatusCodes.REMOVED) {
                JobResponse info = new JobResponse();
                info.setDescription(job.getDescription());
                info.setDestination(job.getDestination());
                info.setFileUrl(job.getFileUrl());
                info.setId(job.getId());
                info.setInsertDateTime(job.getInsertDateTime_Date());
                info.setOwner(job.getOwner());
                info.setRelatives(job.getRelatives());
                info.setRuleId(job.getRuleId());
                info.setStatus(job.getStatus());
                info.setUpdateDateTime(job.getUpdateDateTime_Date());
                jobList.add(info);
            }
        }

        return jobList;
    }

    @WebMethod
    @XmlElement(name = "getOrchestration")
    public ArrayList<OrchestrationResponse> getOrchestration(@WebParam(name = "ownerID") @XmlElement(required = true)
                                                                         Integer ownerId) throws Exception {
        ArrayList<Orchestration> orc = handler.getOrchestration(ownerId);
        ArrayList<OrchestrationResponse> orcList = new ArrayList<>();

        for (Orchestration temp : orc) {
            OrchestrationResponse res = new OrchestrationResponse();
            res.setId(temp.getId());
            res.setInsertDateTime(temp.getInsertDateTime_Date());
            res.setOwnerID(temp.getOwnerID());
            res.setStartJobID(temp.getStartJobID());
            res.setStatus(temp.getStatus());
            res.setUpdateDateTime(temp.getUpdateDateTime_Date());
            orcList.add(res);
        }

        return orcList;
    }

    @WebMethod
    @XmlElement(name = "getRule")
    public RuleResponse getRule(@WebParam(name = "ruleID") @XmlElement(required = true)Integer ruleId) throws Exception {
        Rule rule = handler.getRule(ruleId.intValue());
        RuleResponse info = new RuleResponse();

        info.setId(rule.getId());
        info.setNoEdge(rule.getNoEdge());
        info.setOwnerID(rule.getOwnerID());
        info.setQuery(rule.getQuery());
        info.setRelativeResults(rule.getRelativeResults());
        info.setYesEdge(rule.getYesEdge());

        return info;
    }

    @WebMethod
    @XmlElement(name = "get_job_and_rule_by_ownerID")
    public List<RulesAndJobsResponse> getJobAndRuleByOwnerID(@WebParam(name = "ownerID") @XmlElement(required = true) int ownerID) {
        try {
            List<RulesAndJobs> rulesAndJobs = handler.getRulesAndJobs(ownerID);
            List<RulesAndJobsResponse> rulesAndJobsResponses = new ArrayList<>();

            for (RulesAndJobs r: rulesAndJobs) {
                rulesAndJobsResponses.add(new RulesAndJobsResponse(r.getJobs(), r.getRules()));
            }
            return rulesAndJobsResponses;
        } catch (Exception e) {
            System.err.println("*** Rules and jobs could not get from DB ***");
        }
        return null;
    }

    @WebMethod
    @XmlElement(name = "getJobFromRelative")
    public ArrayList<JobResponse> getJobsFromRelative(@WebParam(name = "relativeID") @XmlElement(required = true)
                                                           Integer relativeId) throws Exception {
        ArrayList<Job> jobSet = handler.getAllJobs();
        ArrayList<JobResponse> jobList = new ArrayList<>();

        for(Job job : jobSet){
            String relatives = job.getRelatives();
            List<String> reList = Arrays.asList(relatives.split("\\s*,\\s*"));
            if(job.getStatus() != StatusCodes.REMOVED && reList.contains(Integer.toString(relativeId))){
                JobResponse info = new JobResponse();
                info.setDescription(job.getDescription());
                info.setDestination(job.getDestination());
                info.setFileUrl(job.getFileUrl());
                info.setId(job.getId());
                info.setInsertDateTime(job.getInsertDateTime_Date());
                info.setOwner(job.getOwner());
                info.setRelatives(job.getRelatives());
                info.setRuleId(job.getRuleId());
                info.setStatus(job.getStatus());
                info.setUpdateDateTime(job.getUpdateDateTime_Date());
                jobList.add(info);
            }
        }

        return jobList;
    }
  
    
    
    /**
        Added a new method for gettin all job from admin panel.
        MUST CHANGE LATER.
    **/
    @WebMethod
    @XmlElement(name = "getAllJobs")
    public ArrayList<JobResponse> getAllJobs() throws Exception {
        ArrayList<Job> jobSet = handler.getUnorchestrainedJobs();
        ArrayList<JobResponse> jobList = new ArrayList<>();

        for(Job job : jobSet){
            JobResponse info = new JobResponse();
            info.setDescription(job.getDescription());
            info.setDestination(job.getDestination());
            info.setFileUrl(job.getFileUrl());
            info.setId(job.getId());
            info.setInsertDateTime(job.getInsertDateTime_Date());
            info.setOwner(job.getOwner());
            info.setRelatives(job.getRelatives());
            info.setRuleId(job.getRuleId());
            info.setStatus(job.getStatus());
            info.setUpdateDateTime(job.getUpdateDateTime_Date());
            jobList.add(info);
        }

        return jobList;
    }
}
