import org.w3c.dom.Element;

public class GetOrchFromXml {
    private int orchID;
    private int owner_id ;
    private int status ;
    private int start_job_id;
    private String insert_time;
    private String update_time;

    public GetOrchFromXml(Element logElement){
        orchID =  Integer.parseInt(logElement.getElementsByTagName("id").item(0).getTextContent());
        owner_id = Integer.parseInt(logElement.getElementsByTagName("owner_id").item(0).getTextContent());
        status = Integer.parseInt(logElement.getElementsByTagName("status").item(0).getTextContent());
        start_job_id = Integer.parseInt(logElement.getElementsByTagName("start_job_id").item(0).getTextContent());
        insert_time = logElement.getElementsByTagName("insert_time").item(0).getTextContent();
        update_time = logElement.getElementsByTagName("update_time").item(0).getTextContent();
    }

    public int getOrchID() {
        return orchID;
    }

    public int getOwner_id() {
        return owner_id;
    }

    public int getStatus() {
        return status;
    }

    public int getStart_job_id() {
        return start_job_id;
    }

    public String getInsert_time() {
        return insert_time;
    }

    public String getUpdate_time() {
        return update_time;
    }
}
