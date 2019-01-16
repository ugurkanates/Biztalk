package Services.InfoService;

import DB.Job;
import DB.Rule;
import Services.Orchestration.Requests.JobRequest;
import Services.Orchestration.Requests.RuleRequest;

import java.util.ArrayList;
import java.util.Date;

public class OrchestrationCapsule {
    private int id;
    private int ownerID;
    private int status;
    private int startJobID;
    private Date InsertDateTime;
    private Date UpdateDateTime;
    private ArrayList<JobRequest> jobs;
    private ArrayList<RuleRequest> rules;

    public OrchestrationCapsule(int id, int ownerID, int status, int startJobID, Date InsertDataTime, Date UpdateDateTime, ArrayList<JobRequest> jobs, ArrayList<RuleRequest> rules) {
        this.id = id;
        this.ownerID = ownerID;
        this.status = status;
        this.startJobID = startJobID;
        this.InsertDateTime = new Date();
        this.UpdateDateTime = new Date();
        this.jobs = jobs;
        this.rules = rules;
    }

    public OrchestrationCapsule() {

    }

    public int getId() {
        return id;
    }

    public int getOwnerID() {
        return ownerID;
    }

    public int getStatus() {
        return status;
    }

    public int getStartJobID() {
        return startJobID;
    }

    public Date getInsertDateTime() {
        return InsertDateTime;
    }

    public Date getUpdateDateTime() {
        return UpdateDateTime;
    }

    public ArrayList<JobRequest> getJobs() {
        return jobs;
    }

    public ArrayList<RuleRequest> getRules() {
        return rules;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setOwnerID(int ownerID) {
        this.ownerID = ownerID;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public void setStartJobID(int startJobID) {
        this.startJobID = startJobID;
    }

    public void setInsertDateTime(Date InsertDateTime) {
        this.InsertDateTime = InsertDateTime;
    }

    public void setUpdateDateTime(Date UpdateDateTime) {
        this.UpdateDateTime = UpdateDateTime;
    }

    public void setJobs(ArrayList<JobRequest> jobs) {
        this.jobs = jobs;
    }

    public void setRules(ArrayList<RuleRequest> rules) {
        this.rules = rules;
    }
}
