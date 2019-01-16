package Services;

import Services.Approve.ApproveService;
import Services.InfoService.InfoService;
import Services.Orchestration.OrchestrationService;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.net.SocketException;
import java.net.UnknownHostException;

@WebService(serviceName = "AdminService")
public class AdminService {
	private String orchestrationServiceAddress;
	private String infoServiceAddress;
	private String approveServiceAddress;
	private Endpoint orchestrationEndpoint;
	private Endpoint infoEndpoint;
	private Endpoint approveEndpoint;

	public AdminService() {
		String hostIp = getHostIp();
		orchestrationServiceAddress = "http://localhost:9001/OrchestrationService";
		orchestrationEndpoint = Endpoint.publish(orchestrationServiceAddress, new OrchestrationService());

		infoServiceAddress = "http://localhost:9001/InfoService";
		infoEndpoint = Endpoint.publish(infoServiceAddress, new InfoService());

		approveServiceAddress = "http://localhost:9001/ApproveService";
		approveEndpoint = Endpoint.publish(approveServiceAddress, new ApproveService());

		String adminServiceAddress = "http://localhost:9001/AdminService";
		Endpoint.publish(adminServiceAddress, this);
	}

	private static String getHostIp() {
		String ip = "";
		try (final DatagramSocket socket = new DatagramSocket()) {
			socket.connect(InetAddress.getByName("8.8.8.8"), 10002);
			ip = socket.getLocalAddress().getHostAddress();
		} catch (UnknownHostException | SocketException e) {
			e.printStackTrace();
		}
		return ip;
	}

	@WebMethod
	public String startServer() {
		if (!orchestrationEndpoint.isPublished()) {
			orchestrationEndpoint = Endpoint.publish(orchestrationServiceAddress, new OrchestrationService());
			infoEndpoint = Endpoint.publish(infoServiceAddress, new InfoService());
			approveEndpoint = Endpoint.publish(approveServiceAddress, new ApproveService());
			System.out.println("----> Server has been started!");
			return "*** Server has just been started! ***";
		}
		return "*** Server is running now! ***";
	}

	@WebMethod
	public String stopServer() {
		if (orchestrationEndpoint.isPublished()) {
			orchestrationEndpoint.stop();
			infoEndpoint.stop();
			approveEndpoint.stop();
			System.out.println("----> Server has been stopped!");
			return "*** Server has just been stopped! ***";
		}
		return "*** Server was stopped! ***";
	}
}
