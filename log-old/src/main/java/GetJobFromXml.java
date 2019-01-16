import org.w3c.dom.Element;

/**
 * Data Container Class for Job object to store information coming from xml
 */
public class GetJobFromXml {
    private int jobID;
    private int owner_id;
    private String job_description ;
    private String destination ;
    private String file_url ;
    private String relatives ;
    private int status ;
    private int rule_id;
    private String insert_time;
    private String update_time ;

    public GetJobFromXml(Element logElement){
        jobID =  Integer.parseInt(logElement.getElementsByTagName("id").item(0).getTextContent());
        owner_id = Integer.parseInt(logElement.getElementsByTagName("owner_id").item(0).getTextContent());
        job_description = logElement.getElementsByTagName("job_description").item(0).getTextContent();
        destination = logElement.getElementsByTagName("destination").item(0).getTextContent();
        file_url = logElement.getElementsByTagName("file_url").item(0).getTextContent();
        relatives = logElement.getElementsByTagName("relatives").item(0).getTextContent();
        status = Integer.parseInt(logElement.getElementsByTagName("status").item(0).getTextContent());
        rule_id = Integer.parseInt(logElement.getElementsByTagName("rule_id").item(0).getTextContent());
        insert_time = logElement.getElementsByTagName("insert_time").item(0).getTextContent();
        update_time = logElement.getElementsByTagName("update_time").item(0).getTextContent();
    }

    public int getJobID() {
        return jobID;
    }

    public int getOwner_id() {
        return owner_id;
    }

    public String getJob_description() {
        return job_description;
    }

    public String getDestination() {
        return destination;
    }

    public String getFile_url() {
        return file_url;
    }

    public String getRelatives() {
        return relatives;
    }

    public int getStatus() {
        return status;
    }

    public int getRule_id() {
        return rule_id;
    }

    public String getInsert_time() {
        return insert_time;
    }

    public String getUpdate_time() {
        return update_time;
    }

}
