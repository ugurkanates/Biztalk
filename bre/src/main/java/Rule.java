import org.w3c.dom.*;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import java.io.IOException;
import java.io.StringReader;

public class Rule {

	private String id;
	private String clause;
	private String relatives;

	public void setFromXML(String xml) throws ParserConfigurationException, IOException, SAXException {
		DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
		DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
		InputSource is = new InputSource(new StringReader(xml));
		Document doc = docBuilder.parse(is);
		doc.getDocumentElement().normalize();

//			System.out.println("Root element :" + doc.getDocumentElement().getNodeName());
		NodeList nList = doc.getElementsByTagName("rule");

		for (int temp = 0; temp < nList.getLength(); temp++) {
			Node nNode = nList.item(temp);
//				System.out.println("\nCurrent Element :" + nNode.getNodeName());

			if (nNode.getNodeType() == Node.ELEMENT_NODE) {
				Element eElement = (Element) nNode;

				this.setId(eElement.getAttribute("id"));
				this.setClause(eElement.getElementsByTagName("clause").item(0).getTextContent());
//				this.setClause("(" + eElement.getElementsByTagName("clause").item(0).getTextContent() + ")");
				this.setRelatives("(" + eElement.getElementsByTagName("relatives").item(0).getTextContent() + ")");

			}
		}
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getClause() {
		return clause;
	}

	public void setClause(String clause) {
		this.clause = clause;
	}

	public String getRelatives() {
		return relatives;
	}

	public void setRelatives(String relatives) {
		this.relatives = relatives;
	}

	@Override
	public String toString() {
		return "{" +
				"'id':'" + id + '\'' +
				", 'clause':'" + clause + '\'' +
				", 'relatives':'" + relatives + '\'' +
				'}';
	}
}
