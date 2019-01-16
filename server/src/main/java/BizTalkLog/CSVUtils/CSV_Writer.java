package BizTalkLog.CSVUtils;

import BizTalkLog.Logger.LogEntry;

import java.io.*;

public class CSV_Writer {
    private String filename;

    public CSV_Writer(String filename){
        this.filename = filename;
    }

    public void writeLogToCSV(LogEntry log){
        try {
            FileWriter fw;
            BufferedWriter bw;
            PrintWriter pw;
            fw = new FileWriter(filename, true);
            bw = new BufferedWriter(fw);
            pw = new PrintWriter(bw);

            StringBuilder sb = new StringBuilder();
            sb.append(log.getUserID());
            sb.append(",");
            sb.append(log.getLevel());
            sb.append(",");
            sb.append(log.getDate());
            sb.append(",");
            sb.append(log.getLogID());
            sb.append(",");
            sb.append(log.getDetail());
            sb.append('\n');
            System.out.println(sb.toString());

            bw.write(sb.toString());
            pw.close();
            fw.close();
            bw.close();

        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
