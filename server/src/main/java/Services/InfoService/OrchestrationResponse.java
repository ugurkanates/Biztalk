package Services.InfoService;

import java.util.Date;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlRootElement;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name ="OrchestrationResponse", namespace="Orchestration")
public class OrchestrationResponse {
    
     
    private int id;
    private int ownerID;
    private int status;
    private int startJobID;
    private Date InsertDateTime;
    private Date UpdateDateTime;

    public int getId() {
        return id;
    }

    public int getOwnerID() {
        return ownerID;
    }

    public int getStatus() {
        return status;
    }

    public int getStartJobID() {
        return startJobID;
    }

    public Date getInsertDateTime() {
        return InsertDateTime;
    }

    public Date getUpdateDateTime() {
        return UpdateDateTime;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setOwnerID(int ownerID) {
        this.ownerID = ownerID;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public void setStartJobID(int startJobID) {
        this.startJobID = startJobID;
    }

    public void setInsertDateTime(Date InsertDateTime) {
        this.InsertDateTime = InsertDateTime;
    }

    public void setUpdateDateTime(Date UpdateDateTime) {
        this.UpdateDateTime = UpdateDateTime;
    }
    
    
    
}
