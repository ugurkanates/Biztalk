package BizTalkLog.XMLUtils;

public class LocalXmlMain {
    public static void main(String[] args) {

        //ATTENTION!!
        //While testing , uncomment below code lines and enter a valid file path to XmlUtils constructor
        //If file does not exist , constructor will try to create it

        /*

        XmlUtils newObject = new XmlUtils("Enter a valid xml file path here");

        newObject.logToXml(new LogEntry("32131" , "re23" , LogLevel.UPDATE , "This is log message"));

        List<LogEntry> readLogs = newObject.readXmlFile();

        for(LogEntry logEntry : readLogs) {
            System.out.println(logEntry);
        }

        */
    }
}
