package BizTalkLog.Logger;

import DB.Job;
import DB.Orchestration;
import DB.Rule;

import java.util.Date;

/**
 * The class that identifies each log that consists of the pars of the incoming xml file.
 * Any log entry's container class created from XML file's parse.
 */
public class LogEntry {
    /**
     * The status of the orchestration
     */
    private int orchStatus;
    /**
     * The String of logID
     */
    private String logID;
    /**
     * The String of logID
     */
    private String userID;
    /**
     * The Enum LogLevel of level
     */
    private LogLevel level;
    /**
     * The String of id of user is effected by admin
     */
    private int effectedID;
    /**
     * Current Date Created Log
     */
    private Date date;
    /**
     * String of log of detail
     */
    private String detail;
    /**
     * List of Destination IPs
     */
    private String destinationIPs;
    /**
     * The relatives for rule
     */
    private String relatives;
    /**
     * Keeping Job of rules
     */
    private String rule;
    /**
     ** The enum that JobStep
     */
    private Status jobStep;
    /**
     * Int of Orchestration
     */
    private int orchID;
    /**
     * Keeping Job ID
     */
    private int jobID;
    /**
     *  String of ruleID
     */
    private int ruleID;
    /**
     * Setter for  logID field
     * @param logID new log id
     */
    public void setLogID(String logID) {
        this.logID = logID;
    }

    /**
     * Setter for userID field
     * @param userID new user id
     */
    public void setUserID(String userID) {
        this.userID = userID;
    }

    /**
     * Setter for level field
     * @param level new custom level
     */
    public void setLevel(LogLevel level) {
        this.level = level;
    }

    /**
     * Setter for created date
     * @param date current date
     */
    public void setDate(Date date) {
        this.date = date;
    }

    /**
     * Setter for log Detail
     * @param detail new log Detail
     */
    public void setDetail(String detail) {
        this.detail = detail;
    }

    /**
     * Getter User by who admin effected.
     * @return effectedID
     */
    public int getEffectedID() {
        return effectedID;
    }

    /**
     * Setter User is effected by admin
     * @param effectedID
     */
    public void setEffectedID(int effectedID) {
        this.effectedID = effectedID;
    }

    /**
     * Default Constructor .
     */
    public LogEntry() {
        this.level = LogLevel.INFO;
        this.date = new Date();
        this.logID = "empty_logid";
        this.userID = "empty_userid";
        this.detail = "empty_detail";
        this.effectedID = -1;
        this.orchID = -1;
        this.rule= "empty_rule";
        this.destinationIPs = null;
        this.relatives = null;
        this.jobStep = Status.NONE;
    }

    /**
     *  Constructor used in the initialization of log entry object in the general logging method.
     * @param logID Unique id for a log
     * @param userID Unique user id
     * @param level level of log
     * @param detail include details of log message
     */
    public LogEntry(String logID, String userID, LogLevel level, String detail) {
        this.level = level;
        this.date = new Date();
        this.logID = logID;
        this.userID = userID;
        this.detail = detail;
        this.effectedID = -1;
        this.rule= "empty_rule";
        this.jobID = -1;
        this.ruleID = -1;
        this.relatives = null;
        this.destinationIPs = null;
        this.jobStep = Status.NONE;
        this.orchID = -1;
    }

    /**
     *  Initialization of admin actions
     * @param logID  Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     * @param detail include details of log message
     * @param effectedID Unique id effected by admin actions.
     */

    public LogEntry(String logID, String userID, LogLevel level, AdminAction detail, int effectedID) {
        this(logID, userID, level, detail.name());
        this.effectedID = effectedID;
    }

    /**
     * Initialization of information related to a job
     * @param logID  Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     * @param effectedID Unique id for a job
     */
    public LogEntry(String logID, String userID, LogLevel level, int effectedID, Job job, Rule rule) {
        this(logID, userID, level, job.getFileUrl());
        this.effectedID = -1;
        this.destinationIPs = job.getDestination();
        this.relatives = job.getRelatives().replaceAll(",","|");
        this.jobID = job.getId();
        this.ruleID = rule.getId();
        this.rule = rule.getRelativeResults();
        this.jobStep = Status.values()[job.getStatus() + 1];
    }

    /**
     * Initialization of information related to a Orchestrations
     *
     * @param logID Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     * @param effectedID Unique id for a job
     * @param rule includes CNF format of job.
     */
    public LogEntry(String logID, String userID, LogLevel level, int effectedID,Job job , Rule rule , Orchestration orch) {
        this(logID,userID,level,effectedID,job,rule);
        this.orchID = orch.getId();
        this.orchStatus = orch.getStatus();
    }

    /**
     * getter of custom level
     * @return level
     */
    public LogLevel getLevel() {
        return level;
    }

    /**
     * getter of log id
     * @return logID
     */
    public String getLogID() {
        return logID;
    }

    /**
     * getter of OrchID
     * @return orchID
     */
    public int getOrchID() {
        return orchID;
    }

    /**
     * getter of getRule
     * @return rule
     */
    public String getRule() {
        return rule;
    }

    /**
     * getter of UserID
     * @return userID
     */
    public String getUserID() {
        return userID;
    }

    /**
     * getter of detail
     * @return detail
     */
    public String getDetail() {
        return detail;
    }

    /**
     * getter current date
     * @return date
     */
    public Date getDate() {
        return date;
    }

    /**
     * getter IP of Destinations
     * @return
     */
    public String getDestinationIPs() {
        return destinationIPs;
    }

    /**
     * getter Relatives Rule
     * @return
     */
    public String getRelatives() {
        return relatives;
    }

    /**
     * getter for each steo of job
     * @return
     */
    public Status getJobStep() {
        return jobStep;
    }
    /**
     * toString include general logging concept .
     * @return
     */
    @Override
    public String toString()
    {
        StringBuilder sb = new StringBuilder();
        sb.append(logID).append(",").append(date).append(",").append(level).append(",").append(userID).append(",").append(detail);
        if (detail != null && detail.contains("ADMIN")){
            sb.append(",").append(effectedID);
        }

        if (jobID != -1){
            sb.append(",").append(jobID).append(",").append(ruleID).append(",").append(destinationIPs).append(",").
                    append(rule).append(",").append(relatives).append(",").append(jobStep);
        }

        if (orchID != -1){
            sb.append(",").append(orchID).append(",").append(orchStatus);
    }

        return sb.toString();

        ///if not job or orch,
        // if not job or orch and admin
        //if job and rule
        //if job,rule and orch


//        sb.append(  date.toString()).append(",").append(level.toString()).append(",").append(userID).append(",").append(logID).append(",").append(detail);

//        StringBuilder sb = new StringBuilder();
//
//        if(detail.contains("ADMIN")){
//            sb.append(",").append(effectedID);
//        } else if(orchID == -1) {
//            sb.append(",").append(destinationIPs.toString()).append(",").append(relatives.toString()).append(",").append(jobStep.name()).append(",").append(rule);
//        }
//        if(orchID != -1)
//            sb.append(",").append(rule).append(",").append(orchID).append(",").append(jobID).append(",").append(ruleID).append(",").append(orchStatus);
//
//        return sb.toString();
    }
}