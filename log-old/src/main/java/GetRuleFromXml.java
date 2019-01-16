import org.w3c.dom.Element;

/**
 * Data Container Class for Job object to store information coming from xml
 */
public class GetRuleFromXml {
    private int ruleId;
    private int owner_id;
    private String query;
    private int yes_edge;
    private int no_edge;
    private String relative_results;


    public GetRuleFromXml( Element logElement){
        ruleId =  Integer.parseInt(logElement.getElementsByTagName("id").item(0).getTextContent());
        owner_id = Integer.parseInt(logElement.getElementsByTagName("owner_id").item(0).getTextContent());
        query = logElement.getElementsByTagName("query").item(0).getTextContent();
        yes_edge = Integer.parseInt(logElement.getElementsByTagName("yes_edge").item(0).getTextContent());
        no_edge = Integer.parseInt(logElement.getElementsByTagName("no_edge").item(0).getTextContent());
        relative_results = logElement.getElementsByTagName("relative_results").item(0).getTextContent();
    }

    public int getRuleId() {
        return ruleId;
    }

    public int getOwner_id() {
        return owner_id;
    }

    public String getQuery() {
        return query;
    }

    public int getYes_edge() {
        return yes_edge;
    }

    public int getNo_edge() {
        return no_edge;
    }

    public String getRelative_results() {
        return relative_results;
    }
}
