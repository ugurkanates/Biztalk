package Services.Orchestration;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebResult;
import javax.jws.WebService;

import Services.Orchestration.Requests.JobRequest;
import Services.Orchestration.Requests.OrchestrationRequest;
import Services.Orchestration.Requests.RuleRequest;

import javax.xml.bind.annotation.XmlElement;
import java.util.List;

@WebService(name = "OrchestrationService", targetNamespace = "http://orchestration.server.com")
public interface IOrchestrationService {

    /**
     * Introduce an orchestration.
     * @param value Object that contains orchestration information.
     * @param jobRequests List that contains jobRequests of orchestration.
     * @param ruleRequests List that contains ruleRequests of orchestration.
     * @return Message.
     */
    @WebMethod(action = "add_orchestration", operationName = "addOrchestration")
    @WebResult(name = "message")
    String addOrchestration(@WebParam(name = "orchestration") @XmlElement(required = true) OrchestrationRequest value,
                            @WebParam(name = "jobList") @XmlElement(required = true) List<JobRequest> jobRequests,
                            @WebParam(name = "ruleList") List<RuleRequest> ruleRequests);

    /**
     * Add job and rule. (Rule is optional.)
     * @param job Job to be added.
     * @param rule Rule to be added.
     * @return Message
     */
    @WebMethod(action = "add_job_rule", operationName = "addJobRule")
    @WebResult(name = "message")
    String addJobRule(@WebParam(name = "job") @XmlElement(required = true) JobRequest job,
                      @WebParam(name = "rule") RuleRequest rule);


    /**
     * Remove job and rule, If rule exists.
     *
     * @param jobID ID of Job to be added.
     * @return Message
     */
    @WebMethod(action = "remove_job", operationName = "removeJob")
    @WebResult(name = "message")
    String removeJob(@WebParam(name = "jobID") @XmlElement(required = true) int jobID);

}
