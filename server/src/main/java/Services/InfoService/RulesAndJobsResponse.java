package Services.InfoService;

import DB.Job;
import DB.Rule;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlRootElement;
import java.util.List;

@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name ="RulesAndJobsResponse", namespace="RulesAndJobs")
public class RulesAndJobsResponse {
    private List<Job> jobs;
    private List<Rule> rules;

    public RulesAndJobsResponse() {

    }

    public RulesAndJobsResponse(List<Job> jobList, List<Rule> ruleList) {
        this.rules = ruleList;
        this.jobs = jobList;
    }

    public List<Rule> getRules() {
        return rules;
    }

    public List<Job> getJobs() {
        return jobs;
    }

}
