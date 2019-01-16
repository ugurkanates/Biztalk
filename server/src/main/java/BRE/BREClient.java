package BRE;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;

public class BREClient {
    private static final String ruleUrl
            = "http://localhost:3000/rule";
    private static final String answerUrl
            = "http://localhost:3000/rule/answer";
    private static String ruleParameters = "<rule id='%d'>" + "<clause>%s</clause>" + "<relatives>%s</relatives>" + "</rule>";
    private static String answerParameters = "<response>\n" +
            "    <user_id>%d</user_id>\n" +
            "    <rule_id>%d</rule_id>\n" +
            "    <answer>%s</answer>\n" +
            "</response>\n";

    private static HttpURLConnection conn;

    private static String request(String url, String urlParameters) {
        byte[] postData = urlParameters.getBytes(StandardCharsets.UTF_8);

        try {
            URL myUrl = new URL(url);
            conn = (HttpURLConnection) myUrl.openConnection();

            conn.setDoOutput(true);
            conn.setRequestMethod("PUT");
            conn.setRequestProperty("Content-Type", "application/xml");

            try (DataOutputStream wr = new DataOutputStream(conn.getOutputStream())) {
                wr.write(postData);
            }

            StringBuilder content;

            try (BufferedReader in = new BufferedReader(
                    new InputStreamReader(conn.getInputStream()))) {

                String line;
                content = new StringBuilder();

                while ((line = in.readLine()) != null) {
                    content.append(line);
                    content.append(System.lineSeparator());
                }
            }
            return content.toString();

        } catch (IOException e) {
            e.printStackTrace();
        } finally {

            conn.disconnect();
        }
        return "";
    }

    public static int add(String query, int ruleID, String relatives) {
        String response = request(ruleUrl, String.format(ruleParameters, ruleID, query, relatives));
        response = response.toLowerCase();
        System.out.println(response);

        if (response.contains("T")) {
            return 1;
        }

        return -1;
    }

    public static String approve(int ruleID, int relativeID, String answer) {
        String response = request(answerUrl, String.format(answerParameters, relativeID, ruleID, answer));
        System.out.println("response from bre" + response);
        return response;
    }
}
