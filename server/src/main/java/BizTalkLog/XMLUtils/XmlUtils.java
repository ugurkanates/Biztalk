package BizTalkLog.XMLUtils;

import BizTalkLog.Logger.LogEntry;
import BizTalkLog.Logger.LogLevel;
import org.w3c.dom.*;
import org.xml.sax.SAXException;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.*;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

/**
 * Utility class for reading and writing logs from/to and xml file
 *
 * Logs can be written individually or as a list
 *
 * Logs in the file are returned as log-list
 */
public class XmlUtils {

    /**
     * Path of xml file to create or read
     */
    private String xmlFilePath;

    /**
     * Object representation of xml file
    */
    private File xmlFileObject;

    /**
     * Object to make changes to xml file
     */
    private DocumentBuilder documentBuilder;

    /**
     * Used to transform Document object to xml file
     */
    private Transformer xmlTransformer;

    /**
     * Constructor
     * @param xmlFilePath File Path to create or read
     */
    public XmlUtils (String xmlFilePath) {

        try {
            boolean success = checkFileExistsAndCreate(xmlFilePath);

            if(!success) {
                System.err.println("Not able to create or read the specified xml file in " + xmlFilePath);
                System.exit(1);
            }
        } catch (ParserConfigurationException | TransformerException | IOException e) {
            e.printStackTrace();

            System.err.println("Not able to create or read the specified xml file in " + xmlFilePath);
            System.exit(1);
        }

        setXmlFilePath(xmlFilePath);
        setXmlFileObject(new File(getXmlFilePath()));

        try {
            documentBuilder = DocumentBuilderFactory.newInstance().newDocumentBuilder();
        } catch (ParserConfigurationException e) {
            e.printStackTrace();
            System.err.println("An error happened , while configuring parser for xml file");
            System.exit(1);
        }

        try {
            xmlTransformer = TransformerFactory.newInstance().newTransformer();
        } catch (TransformerConfigurationException e) {
            e.printStackTrace();
            System.err.println("An error happened , while configuring transformer for xml file");
            System.exit(1);
        }
    }

    private boolean checkFileExistsAndCreate(String filePath) throws IOException, ParserConfigurationException, TransformerException {
        Path xmlFilePath = Paths.get(filePath);

        if(Files.exists(xmlFilePath) && Files.isRegularFile(xmlFilePath) && Files.isReadable(xmlFilePath)) {
            return true;
        } else if(Files.notExists(xmlFilePath)) {

            Path newFilePath = Files.createFile(xmlFilePath);

            DocumentBuilder documentBuilder = DocumentBuilderFactory.newInstance().newDocumentBuilder();

            Document documentObject = documentBuilder.newDocument();
            documentObject.appendChild(documentObject.createElement(XmlElements.ELEMENT_ROOT.toString()));

            Transformer transformer = TransformerFactory.newInstance().newTransformer();
            DOMSource source = new DOMSource(documentObject);
            StreamResult result = new StreamResult(new File(filePath));

            transformer.transform(source, result);

            return filePath.equals(newFilePath.toString());
        }

        return false;
    }

    /**
     * Add new log to xml file
     * @param newLogEntry new log to be added to to xml
     * @return true if no error happened and log written successfully
     */
    public boolean logToXml (LogEntry newLogEntry) {

        String logID = newLogEntry.getLogID();
        String userID = newLogEntry.getUserID();
        String logLevel = newLogEntry.getLevel().toString();
        Date logDate = newLogEntry.getDate();
        String logDetail = newLogEntry.getDetail();

        try {
            Document documentObject = documentBuilder.parse(getXmlFileObject());
            documentObject.getDocumentElement().normalize();

            NodeList rootNodes = documentObject.getElementsByTagName(XmlElements.ELEMENT_ROOT.toString());

            if(1 != rootNodes.getLength()) {
                System.err.println("ERROR: " + getXmlFilePath() + " must contain only one root element of: " + XmlElements.ELEMENT_ROOT.toString());
                System.exit(1);
            }

            Node rootNode = rootNodes.item(0);
            Element newLogElement = documentObject.createElement(XmlElements.ELEMENT_LOG.toString());

            Attr idAttribute = documentObject.createAttribute(XmlElements.ELEMENT_ATTR_ID.toString());
            idAttribute.setValue(logID);
            newLogElement.setAttributeNode(idAttribute);

            Element elementUserID = documentObject.createElement(XmlElements.ELEMENT_USER_ID.toString());
            elementUserID.setTextContent(userID);
            newLogElement.appendChild(elementUserID);

            Element elementLogLevel = documentObject.createElement(XmlElements.ELEMENT_LEVEL.toString());
            elementLogLevel.setTextContent(logLevel);
            newLogElement.appendChild(elementLogLevel);

            Element elementDateYear = documentObject.createElement(XmlElements.ELEMENT_DATE_YEAR.toString());
            elementDateYear.setTextContent(String.valueOf(logDate.getYear() + 1900));
            newLogElement.appendChild(elementDateYear);

            Element elementDateMonth = documentObject.createElement(XmlElements.ELEMENT_DATE_MONTH.toString());
            elementDateMonth.setTextContent(String.valueOf(logDate.getMonth()));
            newLogElement.appendChild(elementDateMonth);

            Element elementDateDay = documentObject.createElement(XmlElements.ELEMENT_DATE_DAY.toString());
            elementDateDay.setTextContent(String.valueOf(logDate.getDay()));
            newLogElement.appendChild(elementDateDay);

            Element elementDateHour = documentObject.createElement(XmlElements.ELEMENT_DATE_HOUR.toString());
            elementDateHour.setTextContent(String.valueOf(logDate.getHours()));
            newLogElement.appendChild(elementDateHour);

            Element elementDateMinutes = documentObject.createElement(XmlElements.ELEMENT_DATE_MIN.toString());
            elementDateMinutes.setTextContent(String.valueOf(logDate.getMinutes()));
            newLogElement.appendChild(elementDateMinutes);

            Element elementDateSeconds = documentObject.createElement(XmlElements.ELEMENT_DATE_SEC.toString());
            elementDateSeconds.setTextContent(String.valueOf(logDate.getSeconds()));
            newLogElement.appendChild(elementDateSeconds);

            Element elementLogDetail = documentObject.createElement(XmlElements.ELEMENT_DETAIL.toString());
            elementLogDetail.setTextContent(logDetail);
            newLogElement.appendChild(elementLogDetail);

            rootNode.appendChild(newLogElement);
            documentObject.getDocumentElement().normalize();

            DOMSource domSource = new DOMSource(documentObject);
            StreamResult destination = new StreamResult(getXmlFileObject());

            xmlTransformer.transform(domSource , destination);

        } catch (SAXException e) {
            e.printStackTrace();
            System.err.println("Error happened while parsing xml file: " + getXmlFilePath());
            return false;
        } catch (IOException e) {
            e.printStackTrace();
            return false;
        } catch (TransformerException e) {
            e.printStackTrace();
            System.err.println("Error happened while transforming to xml file: " + getXmlFilePath());
            return false;
        }

        return true;
    }

    /**
     * Add a list of logs to xml file
     * @param newLogEntryList new logs to be added to to xml
     * @return true if no error happened and log written successfully
     */
    public boolean logToXml (List<LogEntry> newLogEntryList) {

        boolean errorOccurred = false;

        for (LogEntry logEntry : newLogEntryList) {
            boolean logSuccess = logToXml(logEntry);

            if(!logSuccess) {
                System.err.println("Log: " + logEntry + "could not be written to xml");
                errorOccurred = true;
            }
        }

        return !errorOccurred;
    }

    /**
     * Reads the logs in the xml file and returns as a list
     * @return list of LogEntry objects
     */
    public List<LogEntry> readXmlFile() {

        String logID;
        String userID;
        LogLevel level = LogLevel.INFO;//Default value
        Date date;
        String detail;

        List<LogEntry> logEntryList = new ArrayList<>();

        try {
            Document documentObject = documentBuilder.parse(xmlFileObject);
            documentObject.getDocumentElement().normalize();

            NodeList logNodeList = documentObject.getElementsByTagName(XmlElements.ELEMENT_LOG.toString());

            for(int i = 0; i < logNodeList.getLength(); ++i) {
                Node logNode = logNodeList.item(i);

                if(Node.ELEMENT_NODE == logNode.getNodeType()) {
                    Element logElement = (Element) logNode;

                    logID = logElement.getAttribute(XmlElements.ELEMENT_ATTR_ID.toString());
                    userID = logElement.getElementsByTagName(XmlElements.ELEMENT_USER_ID.toString()).item(0).getTextContent();
                    String levelElement = logElement.getElementsByTagName(XmlElements.ELEMENT_LEVEL.toString()).item(0).getTextContent();

                    if(LogLevel.INFO.toString().equals(levelElement)) {
                        level = LogLevel.INFO;
                    } else if(LogLevel.ERROR.toString().equals(levelElement)) {
                        level = LogLevel.ERROR;
                    } else if(LogLevel.UPDATE.toString().equals(levelElement)) {
                        level = LogLevel.UPDATE;
                    } else if(LogLevel.WARNING.toString().equals(levelElement)) {
                        level = LogLevel.WARNING;
                    } else if(LogLevel.FATAL.toString().equals(levelElement)) {
                        level = LogLevel.FATAL;
                    }

                    int year = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_YEAR.toString()).item(0).getTextContent());
                    int month = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_MONTH.toString()).item(0).getTextContent());
                    int day = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_DAY.toString()).item(0).getTextContent());
                    int hour = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_HOUR.toString()).item(0).getTextContent());
                    int minute = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_MIN.toString()).item(0).getTextContent());
                    int second = Integer.parseInt(logElement.getElementsByTagName(XmlElements.ELEMENT_DATE_SEC.toString()).item(0).getTextContent());

                    date = new Date(year,month,day,hour,minute,second); //constructorda initilizae edilir
                    detail = logElement.getElementsByTagName(XmlElements.ELEMENT_DETAIL.toString()).item(0).getTextContent();
                    LogEntry newLogEntry = new LogEntry(logID , userID , level , detail);
                    newLogEntry.setDate(date);

                    logEntryList.add(newLogEntry);
                }
            }
        } catch (SAXException | IOException exception) {
            exception.printStackTrace();
            System.err.println("An error happened while parsing file: " + getXmlFilePath());
            System.exit(1);
        }

        return logEntryList;
    }

    private String getXmlFilePath() {
        return xmlFilePath;
    }

    private void setXmlFilePath(String xmlFilePath) throws IllegalArgumentException {
        if(null != xmlFilePath) {
            this.xmlFilePath = xmlFilePath;
        } else {
            throw new IllegalArgumentException("XML file path must not be null!!!");
        }
    }

    private File getXmlFileObject() {
        return xmlFileObject;
    }

    private void setXmlFileObject(File xmlFileObject) throws IllegalArgumentException {
        if(null != xmlFileObject) {
            this.xmlFileObject = xmlFileObject;
        } else {
            throw new IllegalArgumentException("File object must not be null!!!");
        }
    }
}
