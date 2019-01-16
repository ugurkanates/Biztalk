import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import java.io.IOException;
import java.io.StringReader;

public class Response {
	private String userID;
	private String answer;
	private String ruleID;

	public void setFromXML(String xml) throws ParserConfigurationException, IOException, SAXException {
		DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
		DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
		InputSource is = new InputSource(new StringReader(xml));
		Document doc = docBuilder.parse(is);
		doc.getDocumentElement().normalize();

//			System.out.println("Root element :" + doc.getDocumentElement().getNodeName());
		NodeList nList = doc.getElementsByTagName("response");

		for (int temp = 0; temp < nList.getLength(); temp++) {
			Node nNode = nList.item(temp);
//				System.out.println("\nCurrent Element :" + nNode.getNodeName());

			if (nNode.getNodeType() == Node.ELEMENT_NODE) {
				Element eElement = (Element) nNode;

				this.setUserID(eElement.getElementsByTagName("user_id").item(0).getTextContent());
				this.setRuleID(eElement.getElementsByTagName("rule_id").item(0).getTextContent());
				this.setAnswer(eElement.getElementsByTagName("answer").item(0).getTextContent());
			}
		}
	}

	public String getUserID() {
		return userID;
	}

	public void setUserID(String userID) {
		this.userID = userID;
	}

	public String getAnswer() {
		return answer;
	}

	public void setAnswer(String answer) {
		this.answer = answer;
	}

	public String getRuleID() {
		return ruleID;
	}

	public void setRuleID(String ruleID) {
		this.ruleID = ruleID;
	}

	@Override
	public String toString() {
		return "{" +
				"'userID':'" + userID + '\'' +
				", 'answer':'" + answer + '\'' +
				", 'ruleID':'" + ruleID + '\'' +
				'}';
	}
}
