package BizTalkLog.Logger;

import DB.Job;
import DB.Orchestration;
import DB.Rule;
import Services.StatusCodes;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.nio.file.StandardOpenOption;
import java.util.*;

/**
 * This Class creates logfile such a .csv that means to created a root log object by this class.
 * Class includes various log methods.
 */
public class BizLog {

    /**
     * Each Orchestration has a queue that has a or more LogEntries
     */
    private static Queue<LogEntry> orchQueue = new LinkedList<>();

    /**
     * That creates LogEntry object. All parameters are written the file. The General logging method.
     * @param logID Unique id for a log
     * @param userID Unique user id
     * @param level level of log
     * @param detail include details of log message
     */
    public static void Log(String logID, String userID, LogLevel level, String detail)
    {
        LogEntry entry = new LogEntry(logID, userID, level, detail);
        writeToFile(entry,"");
    }

    /**
     * That creates LogEntry object. All parameters are written the file. The Admin actions is logged in this method.
     * @param logID Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     * @param detail include details of log message
     * @param effectedID Unique id effected by admin actions.
     */
    public static void Log(String logID, String userID, LogLevel level, AdminAction detail, int effectedID)
    {
        LogEntry entry = new LogEntry(logID, userID, level, detail, effectedID);
        writeToFile(entry,"");
    }

    /**
     * That creates LogEntry object. All parameters are written the file . This method is used for logging
     * of information related to a job.
     * @param logID  Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     */
    public static void Log(String logID, String userID, LogLevel level, Job job, Rule rule)
    {
        LogEntry entry = new LogEntry(logID, userID, level,job.getId(),job,rule);
        writeToFile(entry,"");
    }

    /**
     *  Overloaded Log Constructor for Orchestiraction
     *
     * @param logID Unique id for a log
     * @param userID Unique id for admin
     * @param level level of log
     * @param rule includes CNF format of job.
     */
    public static void Log(String logID, String userID, LogLevel level, Job job, Rule rule, Orchestration orch)
    {
        LogEntry entry = new LogEntry(logID,userID,level,job.getId(),job,rule,orch);
        writeToFile(entry,"");

        //add entries about orch to a queue to show orch path
        orchQueue.add(entry);
        //when orch is ended,write it to specified orch file
        if(Status.values()[orch.getStatus()] == Status.APPROVAL ){
            String orchFile = orch.getId() + ".csv";
            writeOrchToFile(orchFile,orchQueue);
        }
    }

    public static void Log(String logID, String userID, LogLevel level,Orchestration orch)
    {
        Job job = new Job();//mock objects
        Rule rule = new Rule();
        LogEntry entry = new LogEntry(logID,userID,level,job.getId(),job,rule,orch);
        writeToFile(entry,"");

        //add entries about orch to a queue to show orch path
        orchQueue.add(entry);
        //when orch is ended,write it to specified orch file
        if(orch.getStatus() == StatusCodes.SUCCESS){
            String orchFile = orch.getId() + ".csv";
            writeOrchToFile(orchFile,orchQueue);
        }
    }


    /*
    *   LogId,Date,LogLevel,UserId,Detail(enum kullanılacak),
        eğer admin ise effected id(int),
        if job and rule -> jobId,ruleId,destIp,rule,relatives,jobStep
        if orch -> orchId,orchStatus
    * */

    /**
     * Writing csv file in this method
     * @param entry Job of Orchestiration
     * @param fileName File name
     */
    private static void writeToFile(LogEntry entry,String fileName){
        String logFilename;
        if(fileName.equals(""))
            logFilename = "BizTalkLog.csv";
        else
            logFilename = fileName;

        String logText = entry.toString() + "\n";
        File file = new File(logFilename);
        try {
            file.createNewFile();
            Files.write(Paths.get(logFilename), logText.getBytes(), StandardOpenOption.APPEND);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    /**
     * All orchestiration jobs keeping a queue
     * @param orchId Unique orchestration id
     * @param queue Queue of Jobs for Orchestration
     */
    private static void writeOrchToFile(String orchId,Queue<LogEntry> queue){
        for(LogEntry i : queue){
            writeToFile(i,orchId);
        }
    }


}