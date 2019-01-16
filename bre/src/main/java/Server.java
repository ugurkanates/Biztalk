import SatSolver.Business;
import com.mysql.jdbc.JDBC4PreparedStatement;
import io.vertx.core.AbstractVerticle;
import io.vertx.core.Future;
import io.vertx.core.Vertx;
import io.vertx.core.http.HttpServerResponse;
import io.vertx.ext.web.Router;
import io.vertx.ext.web.RoutingContext;
import io.vertx.ext.web.handler.BodyHandler;
import org.xml.sax.SAXException;

import javax.xml.parsers.ParserConfigurationException;
import java.io.IOException;
import java.sql.*;

import static java.sql.Statement.RETURN_GENERATED_KEYS;

public class Server extends AbstractVerticle {

	private static final String DB_HOST = "jdbc:mysql://localhost:3306";
	private static final String DB_NAME = "biztalk_bre";
	private static final String DB_USER = "root";
	private static final String DB_PASS = "my-secret-pw";
	private static final String DRIVER = "com.mysql.jdbc.Driver";
	private Connection dbConnection;

//	private Server(Connection dbConnection) {
//		this.dbConnection = dbConnection;
//	}

	/**
	 * @param args
	 */
	public static void main(String[] args) {

//		Connection conn;
//		try {
//			Class.forName(DRIVER);
//			final String URI = DB_HOST + "/" + DB_NAME;
//			conn = DriverManager.getConnection(URI, DB_USER, DB_PASS);
//			System.out.println("Connected");
//		} catch (SQLException | ClassNotFoundException e) {
//			e.printStackTrace();
//			System.exit(1);
//			return;
//		}

		Vertx vertx = Vertx.vertx();
		vertx.deployVerticle(new Server());
	}

	/**
	 * Database bağlantısı yapar.
	 *
	 * @return {Connection}
	 */
	private Connection createDBConnection() {
		final String URI = DB_HOST + "/" + DB_NAME;
		System.out.println(URI);
		Connection conn = null;
		try {
			Class.forName(DRIVER);
			conn = DriverManager.getConnection(URI, DB_USER, DB_PASS);
			System.out.println("Connected");
		} catch (SQLException | ClassNotFoundException e) {
			e.printStackTrace();
			System.exit(1);
		}

		return conn;
	}

	/**
	 * Api server bağlantılarının hazırladığı kısım.
	 *
	 * @param future {Future<Void>}
	 */
	@Override
	public void start(Future<Void> future) {
		dbConnection = createDBConnection();

		Router router = Router.router(vertx);

		// Middleware for request body parsing
		router.route().handler(BodyHandler.create());

		router.put("/rule").handler(this::handlePutRole);
		router.put("/rule/answer").handler(this::handlePutAnswer);
//		router.put("/healthcheck").handler(this::handleHealthCheck);

		vertx.createHttpServer().requestHandler(router).listen(5000);
	}

	private void handleHealthCheck(RoutingContext routingContext) {
		routingContext.response().setStatusCode(200).end();
	}

	/**
	 * Yeni eklenecek olacak Rule'ların gelen istekle birlikte
	 * handle edildiği method.
	 *
	 * @param rc {void}
	 */
	private void handlePutRole(RoutingContext rc) {

		// This handler will be called for every request
		HttpServerResponse response = rc.response();
		response.putHeader("content-type", "application/xml");

		// Gelen http isteğindeki xml ifadeyi string olarak alıyoruz
		String body = rc.getBodyAsString();

		if (body == null) {
			rc.response().setStatusCode(400).end("F");
			return;
		}

		// String olarak almış olduğumuz xml ifadeyi parse edilmesi için rule objemize veriyoruz.
		Rule rule = new Rule();
		try {
			rule.setFromXML(body);
			System.out.println(rule);
		} catch (ParserConfigurationException | IOException | SAXException e) {
			e.printStackTrace();
			rc.response().setStatusCode(400).end("F");
			return;
		}

		Business business = new Business();
		final String result = business.firstCheck(rule.getClause(), rule.getRelatives());
		System.out.println(rule.getRelatives());
		System.out.println(result);
		if (!result.equals("true")) {
			rc.response().setStatusCode(400).end(result);
			return;
		}


		PreparedStatement preparedStmt = null;
		boolean isExist = false;
		try {
			preparedStmt = dbConnection.prepareStatement("SELECT * FROM rules WHERE rule_id=?");

			preparedStmt.setString(1, rule.getId());
			ResultSet rs = preparedStmt.executeQuery();

			if (rs.next()) {
				isExist = true;
			}

			preparedStmt.close();
			rs.close();

			if (isExist) {

				rc.response().setStatusCode(200).end("E");
				return;
			}

			preparedStmt = dbConnection.prepareStatement("INSERT INTO rules (rule_id, clause, relatives) VALUES (?, ?, ?)");

			preparedStmt.setString(1, rule.getId());
			preparedStmt.setString(2, rule.getClause());
			preparedStmt.setString(3, rule.getRelatives());

			String query = ((JDBC4PreparedStatement) preparedStmt).asSql();
			preparedStmt.executeUpdate(query, RETURN_GENERATED_KEYS);
			rs = preparedStmt.getGeneratedKeys();

			boolean completed = false;

			if (rs.next())
				completed = true;

			preparedStmt.close();

			if (completed) {
				// Success!
				rc.response().setStatusCode(201).end("T");
			} else {
				// Failed!
				rc.response().setStatusCode(400).end("F");
			}
		} catch (SQLException e) {
			e.printStackTrace();
		}


	}

	/**
	 * Kullanıcıların joblara verdiği cevapları database'e kaydedip.
	 * Sonra tüm cevaplarla birlikte engine bu verilein işletilmesine
	 * sağlar ardından döndürdüğü cevapla koşulun sağlanıp sağlanamadığı
	 * veya daha fazla veriye ihtiyaç olduğunu bildirr.
	 *
	 * @param rc {handlePutAnswer}
	 */
	private void handlePutAnswer(RoutingContext rc) {

		// This handler will be called for every request
		HttpServerResponse response = rc.response();
		response.putHeader("content-type", "application/xml");

		// Gelen http isteğindeki xml ifadeyi string olarak alıyoruz
		String body = rc.getBodyAsString();

		if (body == null) {
			rc.response().setStatusCode(400).end("F");
			return;
		}

		// String olarak almış olduğumuz xml ifadeyi parse edilmesi için answer objemize veriyoruz.
		Response resp = new Response();
		try {
			resp.setFromXML(body);
		} catch (ParserConfigurationException | IOException | SAXException e) {
			e.printStackTrace();
			rc.response().setStatusCode(400).end("T"); // TODO: false yapılacak
			return;
		}

		// Veritabanına kaydediyorz
		PreparedStatement preparedStmt;
		ResultSet rs;
		boolean completed = false;
		try {
			preparedStmt = dbConnection.prepareStatement("INSERT INTO responses (rule_id, user_id, answer) VALUES (?, ?, ?)");
			preparedStmt.setString(1, resp.getRuleID());
			preparedStmt.setString(2, resp.getUserID());
			preparedStmt.setString(3, resp.getAnswer());
			String query = ((JDBC4PreparedStatement) preparedStmt).asSql();
			preparedStmt.executeUpdate(query, RETURN_GENERATED_KEYS);
			rs = preparedStmt.getGeneratedKeys();
			if (rs.next())
				completed = true;
			preparedStmt.close();

		} catch (SQLException e) {
			e.printStackTrace();
		}

		// Veritabanından daha önce de verilmiş tüm cevapları çekiyoruz ve
		// Rle ile birlikte enginin hesaplamasını sağlıoruz.
		ResultSet answerSet;
		ResultSet ruleSet;
		if (completed) {
			try {
				PreparedStatement psanswer;
				psanswer = dbConnection.prepareStatement("SELECT rule_id, user_id, answer FROM responses WHERE rule_id = ? AND Id IN(SELECT MAX(Id) FROM responses GROUP BY user_id)");
				psanswer.setString(1, resp.getRuleID());
				answerSet = psanswer.executeQuery();

				preparedStmt = dbConnection.prepareStatement("SELECT rule_id, clause, relatives FROM rules WHERE rule_id = ? LIMIT 1");
				preparedStmt.setString(1, resp.getRuleID());
				ruleSet = preparedStmt.executeQuery();

				// Engine'nin bu işi yapması.
				Business business = new Business();
				String result = "f";
				ruleSet.next();
				business.rule = ruleSet.getString("clause");

				while (answerSet.next()) {
					String rule_id = answerSet.getString("rule_id");
					String user_id = answerSet.getString("user_id");
					String answer = answerSet.getString("answer");
					result = business.solver(user_id, answer);
					System.out.println(result);
					System.out.println(business.rule);

				}
				preparedStmt.close();
				psanswer.close();
				//answerSet.close();
				//ruleSet.close();

				rc.response().setStatusCode(200).end(result);
				return;


			} catch (SQLException e) {
				e.printStackTrace();
			}

		}
		// DB'den tüm veriler çekilemedi demektir.
		rc.response().setStatusCode(500).end("F");
	}
}
