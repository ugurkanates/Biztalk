import io.vertx.core.AbstractVerticle;
import io.vertx.core.Future;
import io.vertx.core.Vertx;
import io.vertx.core.VertxOptions;
import io.vertx.core.http.HttpServerResponse;
import io.vertx.ext.web.Router;
import io.vertx.ext.web.RoutingContext;
import io.vertx.ext.web.handler.BodyHandler;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import java.io.StringReader;
import java.io.StringWriter;
import java.sql.Timestamp;
import java.util.Date;
import java.util.List;

import static java.util.concurrent.TimeUnit.NANOSECONDS;
import static java.util.concurrent.TimeUnit.SECONDS;

public class LogService extends AbstractVerticle {
	private static LogDBHandler logDBHandler;

	public static void main(String[] args) {
		logDBHandler = new LogDBHandler();
		long maxBlockedThreadCheckInterval = NANOSECONDS.convert(10, SECONDS);
		Vertx vertx = Vertx.vertx(new VertxOptions().setBlockedThreadCheckInterval(maxBlockedThreadCheckInterval));
		vertx.deployVerticle(new LogService());
	}

	@Override
	public void start(Future<Void> startFuture) throws Exception {
		Router router = Router.router(vertx);
		// Middleware
		router.route().handler(BodyHandler.create());

		router.route("/jobdesc").handler(this::handleJobDesc);
		router.route("/ruleupdate").handler(this::handleRuleUpdate);
		router.route("/jobrule").handler(this::handleJobRule);
		router.route("/orchdesc").handler(this::handleOrchDesc);
		router.route("/orch").handler(this::handleOrch);
		router.route("/onlydesc").handler(this::handleDesc);
		router.route("/query").handler(this::handleQuery);
//    router.route("/").handler(this::handleQuery);

		vertx.createHttpServer().requestHandler(router).listen(4000, http -> {
			if (http.succeeded()) {
				startFuture.complete();
				System.out.println("HTTP server started on http://localhost:4000");
			} else {
				startFuture.fail(http.cause());
			}
		});
	}


	private void handleQuery(RoutingContext routingContext) {
		List<String> query = routingContext.queryParam("function");

		HttpServerResponse response = routingContext.response();

		System.out.println(query.get(0));
		QueryStringCheck qsc = new QueryStringCheck();
		if (qsc.isValid(query.get(0))) {
			System.out.println("valid query");
			System.out.println("command:" + qsc.command);
			System.out.println("command params:" + qsc.params);

			if (qsc.params.size() == 2 && qsc.command.equals("get")) {
				String queryResult = logDBHandler.GetLogsBetweenDates(qsc.params.get(0), qsc.params.get(1));
				response.putHeader("content-type", "application/xml");
				response.end(queryResult);
			} else if (qsc.params.size() == 1 && qsc.command.equals("get")) {
				Date today = new Date();
				Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
				String queryResult = logDBHandler.GetLogsBetweenDates(qsc.params.get(0), timestamp.toString());
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}

			if (qsc.params.size() == 2 && qsc.command.equals("geterror")) {
				String queryResult = logDBHandler.GetFilteredLogsBetweenDates(qsc.params.get(0), qsc.params.get(1), "ERROR");
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			} else if (qsc.params.size() == 1 && qsc.command.equals("geterror")) {
				Date today = new Date();
				Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
				String queryResult = logDBHandler.GetFilteredLogsBetweenDates(qsc.params.get(0), timestamp.toString(), "ERROR");
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}

			if (qsc.params.size() == 2 && qsc.command.equals("getfailedjob")) {
				String queryResult = logDBHandler.GetFilteredLogsBetweenDates(qsc.params.get(0), qsc.params.get(1), "FAIL");
				response.end(queryResult);
			} else if (qsc.params.size() == 1 && qsc.command.equals("getfailjob")) {
				Date today = new Date();
				Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
				String queryResult = logDBHandler.GetFilteredLogsBetweenDates(qsc.params.get(0), timestamp.toString(), "FAIL");
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}

			if (qsc.command.equals("getjobs")) {
				String queryResult = logDBHandler.GetJobsByOwnerID(Integer.parseInt(qsc.params.get(0)));
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}

			if (qsc.command.equals("getreport")) {
				Date today = new Date();
				Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
				Date yesterday = new Date(System.currentTimeMillis() - 1000L * 60L * 60L * 24L);
				Timestamp timestampYesterday = new Timestamp(yesterday.getYear(), yesterday.getMonth(), yesterday.getDate(), yesterday.getHours(), yesterday.getMinutes(), yesterday.getSeconds(), 0);
				String queryResult = logDBHandler.GetLogsBetweenDates(timestampYesterday.toString(), timestamp.toString());
				System.out.println("query result: \n" + queryResult);
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}

			if (qsc.command.equals("clearlog")) {
				String queryResult = logDBHandler.ClearDatabase();
				response.putHeader("content-type", "application/xml");

				response.end(queryResult);
			}
		} else {
			System.out.println("invalid query");
			response.putHeader("content-type", "application/xml");

			response.end("<result>Invalid Query.</result>");
		}

		System.out.println(response.toString());
	}

	private org.w3c.dom.Document parseTag(String body) {
		try {

			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			org.w3c.dom.Document document = builder.parse(new InputSource(new StringReader(body)));
			TransformerFactory transformerFactory = TransformerFactory.newInstance();
			Transformer transformer = transformerFactory.newTransformer();
			DOMSource source = new DOMSource(document);
			StreamResult result = new StreamResult(new StringWriter());
			transformer.transform(source, result);
			String str1 = result.getWriter().toString();
			return document;
		} catch (Exception e) {
			e.printStackTrace();
//      System.out.println(e.printStackTrace(););
		}
		return null;
	}

	private void handleJobDesc(RoutingContext routingContext) {
		String body = routingContext.getBodyAsString();
		try {
			org.w3c.dom.Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("job");

			for (int i = 0; i < logNodeList.getLength(); ++i) {
				Node logNode = logNodeList.item(i);

				if (Node.ELEMENT_NODE == logNode.getNodeType()) {
					Element logElement = (Element) logNode;

					//job things
					GetJobFromXml getJob = new GetJobFromXml(logElement);
					String description = logElement.getElementsByTagName("description").item(0).getTextContent();
					String log_level = logElement.getElementsByTagName("log_level").item(0).getTextContent();

					Date today = new Date();
					Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
					int logId = logDBHandler.insertNewLog(getJob.getOwner_id(), log_level, timestamp, description);
					logDBHandler.insertJob(getJob, logId);

					System.out.println(getJob.getUpdate_time());

					System.out.println("handleJobDesc");
				}
			}
		} catch (Exception e) {
			System.err.println("Exception");
			e.printStackTrace();
		}

		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>Job and Desc Handled</result>");
	}

	private void handleJobRule(RoutingContext routingContext) {
		String body = routingContext.getBodyAsString();
		try {

			org.w3c.dom.Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("job");

			NodeList logLevelList = document.getElementsByTagName("level");
			Node logLevelNode = logLevelList.item(0);
			Element logLevelElement = (Element) logLevelNode;

			String log_level = logLevelElement.getElementsByTagName("log_level").item(0).getTextContent();

			int logId = -1;
			for (int i = 0; i < logNodeList.getLength(); ++i) {
				Node logNode = logNodeList.item(i);

				if (Node.ELEMENT_NODE == logNode.getNodeType()) {
					Element logElement = (Element) logNode;

					GetJobFromXml getJob = new GetJobFromXml(logElement);
					Date today = new Date();
					Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
					logId = logDBHandler.insertNewLog(getJob.getOwner_id(), log_level, timestamp, "Job and Rule added");
					logDBHandler.insertJob(getJob, logId);

					System.out.println("handleJobRule-job");
				}
			}
			logNodeList = document.getElementsByTagName("rule");

			for (int i = 0; i < logNodeList.getLength(); ++i) {
				Node logNode = logNodeList.item(i);

				if (Node.ELEMENT_NODE == logNode.getNodeType()) {
					Element logElement = (Element) logNode;

					GetRuleFromXml getRule = new GetRuleFromXml(logElement);
					logDBHandler.insertRule(getRule, logId);

					System.out.println("handleJobRule-rule");
				}
			}

		} catch (Exception e) {
			e.printStackTrace();
		}

		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>Job and Rule Handled</result>");

	}

	private void handleOrchDesc(RoutingContext routingContext) {
		String body = routingContext.getBodyAsString();
		try {

			Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("orchestration");

			for (int i = 0; i < logNodeList.getLength(); ++i) {
				Node logNode = logNodeList.item(i);

				if (Node.ELEMENT_NODE == logNode.getNodeType()) {
					Element logElement = (Element) logNode;

					GetOrchFromXml getOrch = new GetOrchFromXml(logElement);
					String description = logElement.getElementsByTagName("description").item(0).getTextContent();
					String log_level = logElement.getElementsByTagName("log_level").item(0).getTextContent();

					Date today = new Date();
					Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
					int logId = logDBHandler.insertNewLog(getOrch.getOwner_id(), log_level, timestamp, description);
					logDBHandler.insertOrch(getOrch, logId);
					System.out.println("handleOrchDesc");
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>orch desc handled.</result>");

	}

	private void handleOrch(RoutingContext routingContext) {
		String body = routingContext.getBodyAsString();
		try {
			org.w3c.dom.Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("orchestration");
			NodeList jobNodeList = document.getElementsByTagName("job");
			NodeList ruleNodeList = document.getElementsByTagName("rule");
			NodeList levelNodeList = document.getElementsByTagName("level");

			int logId = -1;
			for (int i = 0; i < logNodeList.getLength(); ++i) {
				Node logNode = logNodeList.item(i);
				if (Node.ELEMENT_NODE == logNode.getNodeType()) {
					Element logElement = (Element) logNode;
					GetOrchFromXml getOrch = new GetOrchFromXml(logElement);

					Node levelNode = levelNodeList.item(0);
					Element levelElement = (Element) levelNode;
					String log_level = levelElement.getElementsByTagName("log_level").item(0).getTextContent();

					Date today = new Date();
					Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
					logId = logDBHandler.insertNewLog(getOrch.getOwner_id(), log_level, timestamp, "Orchestration is ended");
					logDBHandler.insertOrch(getOrch, logId);
				}
			}
			for (int i = 0; i < jobNodeList.getLength(); ++i) {
				Node jobNode = jobNodeList.item(i);
				if (Node.ELEMENT_NODE == jobNode.getNodeType()) {
					Element jobElement = (Element) jobNode;
					GetJobFromXml getJob = new GetJobFromXml(jobElement);
					logDBHandler.insertJob(getJob, logId);

//          System.out.println(jobElement.getElementsByTagName("owner_id").item(0).getTextContent());
//          System.out.println("job");
				}
			}

			for (int i = 0; i < ruleNodeList.getLength(); ++i) {
				Node ruleNode = ruleNodeList.item(i);
				if (Node.ELEMENT_NODE == ruleNode.getNodeType()) {
					Element ruleElement = (Element) ruleNode;
					GetRuleFromXml getRule = new GetRuleFromXml(ruleElement);
					logDBHandler.insertRule(getRule, logId);

//          System.out.println(ruleElement.getElementsByTagName("query").item(0).getTextContent());
//          System.out.println("rule");
				}
			}
			System.out.println("Orch,Rules,Jobs ended");
		} catch (Exception e) {
			e.printStackTrace();
		}
		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>logged.</result>");
	}

	private void handleRuleUpdate(RoutingContext routingContext) {

		String body = routingContext.getBodyAsString();
		try {

			org.w3c.dom.Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("rule");

			Node logNodeRule1 = logNodeList.item(0);
			Node logNodeRule2 = logNodeList.item(1);

			if (Node.ELEMENT_NODE == logNodeRule1.getNodeType() && Node.ELEMENT_NODE == logNodeRule2.getNodeType()) {
				Element logElementRule1 = (Element) logNodeRule1;
				Element logElementRule2 = (Element) logNodeRule2;

				GetRuleFromXml getRule1 = new GetRuleFromXml(logElementRule1);
				GetRuleFromXml getRule2 = new GetRuleFromXml(logElementRule2);

				String description = "Old Relatives : " + getRule1.getRelative_results() + " New Relatives : " + getRule2.getRelative_results();

				Date today = new Date();
				Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
				int logId = logDBHandler.insertNewLog(getRule1.getOwner_id(), "UPDATE", timestamp, description);
				logDBHandler.insertRule(getRule2, logId);
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>rule logged.</result>");
	}

	private void handleDesc(RoutingContext routingContext) {
		String body = routingContext.getBodyAsString();
		try {
			org.w3c.dom.Document document = parseTag(body);
			NodeList logNodeList = document.getElementsByTagName("description");
			Node logNodeRule1 = logNodeList.item(0);
			Element logElementRule1 = (Element) logNodeRule1;

			String id = logElementRule1.getElementsByTagName("id").item(0).getTextContent();
			String desc = logElementRule1.getElementsByTagName("desc").item(0).getTextContent();
			String logLevel = logElementRule1.getElementsByTagName("log_level").item(0).getTextContent();

			Date today = new Date();
			Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);
			int logId = logDBHandler.insertNewLog(Integer.parseInt(id), logLevel, timestamp, desc);
		} catch (Exception e) {
			e.printStackTrace();
		}
		// This handler will be called for every request
		HttpServerResponse response = routingContext.response();
		response.putHeader("content-type", "application/xml");

		// Write to the response and end it
		response.end("<result>description logged.</result>");
	}

}
