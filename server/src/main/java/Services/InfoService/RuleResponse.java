package Services.InfoService;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlRootElement;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name ="RuleResponse", namespace="Rule")
public class RuleResponse {
      
    private int id;
    private int ownerID;
    private String query;
    private int yesEdge;
    private int noEdge;
    private String relativeResults;

    public int getId() {
        return id;
    }

    public int getOwnerID() {
        return ownerID;
    }

    public String getQuery() {
        return query;
    }

    public int getYesEdge() {
        return yesEdge;
    }

    public int getNoEdge() {
        return noEdge;
    }

    public String getRelativeResults() {
        return relativeResults;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setOwnerID(int ownerID) {
        this.ownerID = ownerID;
    }

    public void setQuery(String query) {
        this.query = query;
    }

    public void setYesEdge(int yesEdge) {
        this.yesEdge = yesEdge;
    }

    public void setNoEdge(int noEdge) {
        this.noEdge = noEdge;
    }

    public void setRelativeResults(String relativeResults) {
        this.relativeResults = relativeResults;
    }

    @Override
    public String toString() {
        return id + ownerID + query + yesEdge + noEdge + relativeResults;
    }
    
    
}
