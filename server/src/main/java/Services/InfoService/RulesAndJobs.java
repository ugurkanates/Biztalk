package Services.InfoService;

import DB.Job;
import DB.Rule;

import java.util.ArrayList;

public class RulesAndJobs  {

    private ArrayList<Rule> rules = new ArrayList<>();
    private ArrayList<Job> jobs = new ArrayList<>();

    public void addJob(Job job){
        jobs.add(job);
    }

    public void addRule(Rule rule){
        rules.add(rule);
    }

    public ArrayList<Rule> getRules() {
        return rules;
    }

    public ArrayList<Job> getJobs() {
        return jobs;
    }
}
