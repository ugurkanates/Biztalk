package DB;

public class Rule {

    private int id;
    private int ownerID;
    private String query;
    private int yesEdge;
    private int noEdge;
    private String relativeResults;

    public Rule(){

    }

    public Rule(int ownerID, String query, int yesEdge, int noEdge, String relativeResults) {
        this.ownerID = ownerID;
        this.query = query;
        this.yesEdge = yesEdge;
        this.noEdge = noEdge;
        this.relativeResults = relativeResults;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getOwnerID() {
        return ownerID;
    }

    public void setOwnerID(int ownerID) {
        this.ownerID = ownerID;
    }

    public String getQuery() {
        return query;
    }

    public void setQuery(String query) {
        this.query = query;
    }

    public int getYesEdge() {
        return yesEdge;
    }

    public void setYesEdge(int yesEdge) {
        this.yesEdge = yesEdge;
    }

    public int getNoEdge() {
        return noEdge;
    }

    public void setNoEdge(int noEdge) {
        this.noEdge = noEdge;
    }

    public String getRelativeResults() {
        return relativeResults;
    }

    public void setRelativeResults(String relativeResults) {
        this.relativeResults = relativeResults;
    }

    @Override
    public String toString() {
        return id + ownerID + query + yesEdge + noEdge + relativeResults;
    }
}
