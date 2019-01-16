package BizTalkLog.CSVUtils;
import BizTalkLog.Logger.LogEntry;
import BizTalkLog.Logger.LogLevel;

public class LocalCSVMain {
    public static void main(String[] args){
        LogEntry sampleLog1 = new LogEntry("LOGID1", "USRID1", LogLevel.UPDATE, "This is log message");
        LogEntry sampleLog2 = new LogEntry("LOGID2", "USRID2", LogLevel.WARNING, "This is log message");
        LogEntry sampleLog3 = new LogEntry("LOGID3", "USRID3", LogLevel.WARNING, "This is log message");
        CSV_Writer write = new CSV_Writer("sampleWrite.csv");
        write.writeLogToCSV(sampleLog1);
        write.writeLogToCSV(sampleLog2);
        write.writeLogToCSV(sampleLog3);
    }
}
