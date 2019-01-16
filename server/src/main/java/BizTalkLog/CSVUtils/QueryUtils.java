package BizTalkLog.CSVUtils;

import BizTalkLog.Logger.LogEntry;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.*;

public class QueryUtils {

    /**
     * will be used in private functions
     */
    private List<LogEntry> queriedLogs = new ArrayList<>();

    private List<LogEntry> unQueriedLogs;

    /**
     * @param logs constructed with logs to be queried
     */
    public QueryUtils(List<LogEntry> logs){
        unQueriedLogs = logs;
    }

    /**
     * @param type should be one of [DATE,LOG_ID,USER_ID,DETAILS,LOGLEVEL,EFFECTED_ID,RULE,ORCH_ID] as string
     * @param key search key
     * @return
     */
    public List<LogEntry> queryRequestHandler(String type, String key){//QueryEntry qq
        queriedLogs.clear();
        switch (type){//QueryEntry.getType()
            case("DATE"): return queryByDate(unQueriedLogs, key);

            case("LOG_ID"): return queryByLogID(unQueriedLogs, key);

            case("USER_ID"): return queryByUserID(unQueriedLogs, key);

            case("DETAILS"): return queryByDetails(unQueriedLogs, key);

            case("LOGLEVEL"): return queryByLogLevel(unQueriedLogs, key);

            case("EFFECTED_ID"): return queryByLogEffectedId(unQueriedLogs, key);

            case("RULE"): return queryByRule(unQueriedLogs, key);

            case("ORCH_ID"): return queryByLogOrchId(unQueriedLogs, key);

            default: return unQueriedLogs; // THROW EXCEPTION HERE?
        }
    }



    //Query functions
    //Input: List<LogEntry>, Search key
    //Output: List<LogEntry>


    /**
     * Returns logs from a specific day
     *
     * @param listOfLogs
     * @param key Input key should be dd-MM-yyyy format example : "20-10-2018"
     * @return
     */
    private List<LogEntry> queryByDate(List<LogEntry> listOfLogs, String key){
        try {
            Date dateStart  = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss").parse(key+" 00:00:00");
            Date dateEnd = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss").parse(key+" 23:59:59");
            queriedLogs = queryByDateRange(listOfLogs,dateStart,dateEnd);
        } catch (ParseException e) {
            e.printStackTrace();
        }

        return queriedLogs;
    }


    /**
     * @param listOfLogs
     * @param logID
     * @return logs with same log id, should always return one log
     */
    private List<LogEntry> queryByLogID(List<LogEntry> listOfLogs, String logID){
        for(LogEntry x : listOfLogs){
            if(x.getLogID().equals(logID))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }

    /**
     * @param listOfLogs  logs to be queried
     * @param userId
     * @return logs with same user id
     */
    private List<LogEntry> queryByUserID(List<LogEntry> listOfLogs, String userId){
        for(LogEntry x : listOfLogs){
            if(x.getUserID().equals(userId))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }


    /**
     * @param listOfLogs  logs to be searched
     * @param word
     * @return logs with details that contains the specified word
     */
    private List<LogEntry> queryByDetails(List<LogEntry> listOfLogs, String word){
        for(LogEntry x : listOfLogs){
            if(x.getDetail().contains(word))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }

    /**
     * @param listOfLogs  logs to be queried
     * @param logLevel
     * @return logs with same log level
     */
    private List<LogEntry> queryByLogLevel(List<LogEntry> listOfLogs, String logLevel){
        for(LogEntry x : listOfLogs){
            if(x.getLevel().name().equals(logLevel))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }



    /**
     * @param listOfLogs  logs to be queried
     * @param orchId
     * @return
     */
    private List<LogEntry> queryByLogOrchId(List<LogEntry> listOfLogs, String orchId) {
        for(LogEntry x : listOfLogs){
            String tmp = x.toString();
            if(tmp.equals(orchId))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }

    /**
     * @param listOfLogs  logs to be queried
     * @param rule
     * @return
     */
    private List<LogEntry> queryByRule(List<LogEntry> listOfLogs, String rule) {
        for(LogEntry x : listOfLogs){
            if(x.getRule().equals(rule))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }

    /**
     * @param listOfLogs logs to be queried
     * @param effectedID
     * @return logs with selected input
     */
    private List<LogEntry> queryByLogEffectedId(List<LogEntry> listOfLogs, String effectedID) {
        for(LogEntry x : listOfLogs){
            String tmp = x.toString();
            if(tmp.equals(effectedID))
                queriedLogs.add(x);
        }
        return queriedLogs;
    }




    /**
     * Returns log entries between two dates
     * @param listOfLogs input logs to be queried
     * @param startDate date
     * @param endDate date
     * @return queried logs
     */
    public static List<LogEntry> queryByDateRange(List<LogEntry> listOfLogs, Date startDate,Date endDate){
        List<LogEntry> queriedLogs = new ArrayList<>();

        for(LogEntry x : listOfLogs){
            if (x.getDate().compareTo(startDate)>=0 && x.getDate().compareTo(endDate)<0) {
                queriedLogs.add(x);
            }
        }
        //Code here
        return queriedLogs;
    }


}