package Services.Orchestration.Requests;

public class JobRequest {
    public int id;
    public int owner;
    public String description;
    public String destination;
    public String fileUrl;
    public String relatives;
    public int ruleId;
    public int nextJobId;
    public int orchFlag;
}
