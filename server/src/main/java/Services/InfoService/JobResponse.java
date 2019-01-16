package Services.InfoService;

import java.util.Date;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlRootElement;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name ="JobResponse", namespace="Server")
public class JobResponse {
    
    private int id;
    private int owner;
    private String description;
    private String destination;
    private String fileUrl;
    private String relatives;
    private int status;
    private int ruleId;
    private Date insertDateTime;
    private Date updateDateTime;
    private int orchFlag;

    public JobResponse(int id, int owner, String description, String destination, String fileUrl, String relatives, int status, int ruleId, Date insertDateTime, Date updateDateTime, int orchFlag) {
        this.id = id;
        this.owner = owner;
        this.description = description;
        this.destination = destination;
        this.fileUrl = fileUrl;
        this.relatives = relatives;
        this.status = status;
        this.ruleId = ruleId;
        this.insertDateTime = insertDateTime;
        this.updateDateTime = updateDateTime;
        this.orchFlag = orchFlag;
    }

    public JobResponse() {

    }

    public int getId() {
        return id;
    }

    public int getOwner() {
        return owner;
    }

    public String getDescription() {
        return description;
    }

    public String getDestination() {
        return destination;
    }

    public String getFileUrl() {
        return fileUrl;
    }

    public String getRelatives() {
        return relatives;
    }

    public int getStatus() {
        return status;
    }

    public int getRuleId() {
        return ruleId;
    }

    public Date getInsertDateTime() {
        return insertDateTime;
    }

    public Date getUpdateDateTime() {
        return updateDateTime;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setOwner(int owner) {
        this.owner = owner;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setDestination(String destination) {
        this.destination = destination;
    }

    public void setFileUrl(String fileUrl) {
        this.fileUrl = fileUrl;
    }

    public void setRelatives(String relatives) {
        this.relatives = relatives;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public void setRuleId(int ruleId) {
        this.ruleId = ruleId;
    }

    public void setInsertDateTime(Date insertDateTime) {
        this.insertDateTime = insertDateTime;
    }

    public void setUpdateDateTime(Date updateDateTime) {
        this.updateDateTime = updateDateTime;
    }

    public int getOrchFlag() {
        return orchFlag;
    }

    public void setOrchFlag(int orchFlag) {
        this.orchFlag = orchFlag;
    }

    @Override
    public String toString() {
        return id + owner + description + destination + fileUrl + relatives + status + ruleId + insertDateTime.toString() + updateDateTime.toString() + orchFlag;
    }
    
    
}
