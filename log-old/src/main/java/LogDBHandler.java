import java.sql.*;
import java.util.HashMap;

import static java.sql.Statement.RETURN_GENERATED_KEYS;

public class LogDBHandler {
    private String dbUrl = "jdbc:mysql://localhost:3306/biztalk_log";
    private String userName = "root";
    private String password = "my-secret-pw";
    private String driver = "com.mysql.jdbc.Driver";
    private Connection dbConnection;

    public LogDBHandler() {
        Connection con = null;
        try {
            Class.forName(driver);
            con =  DriverManager.getConnection(dbUrl, userName, password);
            this.dbConnection = con;
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void closeConnection(){
        if(dbConnection != null) {
            try {
                dbConnection.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    public void closePreparedStatement(PreparedStatement pst) throws SQLException {
        if (pst != null)
            pst.close();
    }

    public void closeResultSet(ResultSet rs) throws Exception {
        if (rs != null)
            rs.close();
    }

    /**
     *
     * @param user_id
     * @param log_level
     * @param log_date this must be sql date
     * @param desc
     * @return created log id
     */
    public int insertNewLog(int user_id,String log_level,Timestamp log_date,String desc){
        String query = "INSERT INTO log ( user_id, log_level,log_date, description) " +
                "values ( ?, ?, ?, ?)";
        try {
            PreparedStatement preparedStmt = dbConnection.prepareStatement(query, RETURN_GENERATED_KEYS);
            preparedStmt.setInt(1, user_id);
            preparedStmt.setString(2, log_level);
            preparedStmt.setString(3, log_date.toString());
            preparedStmt.setString(4, desc);
            preparedStmt.execute();
            ResultSet rs = preparedStmt.getGeneratedKeys();
            if (rs.next())
                return rs.getInt(1);

        }catch (SQLException e) {
                    e.printStackTrace();
        }
        return -1;
    }

    public void insertJob(GetJobFromXml job,int logId) throws Exception {

        System.out.println(dbConnection);
        String query = "INSERT INTO job (log_id,job_id, owner_id, job_description, destination, file_url, relatives, status, rule_id, insert_time, update_time) " +
                "values (?, ?, ?, ?,?, ?, ?, ?,?, ?,?)";
        try {
            PreparedStatement preparedStmt = dbConnection.prepareStatement(query);
            preparedStmt.setInt(1, logId);
            preparedStmt.setInt(2, job.getJobID());
            preparedStmt.setInt(3, job.getOwner_id());
            preparedStmt.setString(4, job.getJob_description());
            preparedStmt.setString(5, job.getDestination());
            preparedStmt.setString(6, job.getFile_url());
            preparedStmt.setString(7, job.getRelatives());
            preparedStmt.setInt(8, job.getStatus());
            preparedStmt.setInt(9, job.getRule_id());
            preparedStmt.setString(10, getDate(job.getInsert_time()));
            preparedStmt.setString(11, getDate(job.getUpdate_time()));
            preparedStmt.execute();
        }catch (SQLException e) {
            e.printStackTrace();
        }

    }

    public void insertRule(GetRuleFromXml rule, int logId) {
        System.out.println(dbConnection);
        String query = "INSERT INTO rule (log_id, rule_id, user_id, query, yes_edge, no_edge, relative_results) " +
                "values(?, ?, ?, ?, ?, ?, ?)";

        try {
            PreparedStatement preparedStatement = dbConnection.prepareStatement(query);
            preparedStatement.setInt(1, logId);
            preparedStatement.setInt(2, rule.getRuleId());
            preparedStatement.setInt(3, rule.getOwner_id());
            preparedStatement.setString(4, rule.getQuery());
            preparedStatement.setInt(5, rule.getYes_edge());
            preparedStatement.setInt(6, rule.getNo_edge());
            preparedStatement.setString(7, rule.getRelative_results());
            preparedStatement.execute();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public void insertOrch(GetOrchFromXml orch,int logId) throws Exception {
        System.out.println(dbConnection);
        String query = "INSERT INTO orch (log_id,orch_id, user_id, status, start_job_id, insert_time, update_time) " +
                "values (?, ?, ?, ?,?, ?, ?)";
        try {
            PreparedStatement preparedStmt = dbConnection.prepareStatement(query);
            preparedStmt.setInt(1, logId);
            preparedStmt.setInt(2, orch.getOrchID());
            preparedStmt.setInt(3, orch.getOwner_id());
            preparedStmt.setInt(4, orch.getStatus());
            preparedStmt.setInt(5, orch.getStart_job_id());
            System.out.println(orch.getInsert_time());
            System.out.println(orch.getUpdate_time());
            preparedStmt.setString(6, getDate(orch.getInsert_time()));
            preparedStmt.setString(7, getDate(orch.getUpdate_time()));
            preparedStmt.execute();
        }catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public String GetLogsBetweenDates(String sDate, String eDate) {
        StringBuilder queryResult = new StringBuilder();
        // header query result XML
        queryResult.append("<query_result>\n");

        try {
            PreparedStatement preparedStatement = dbConnection.prepareStatement("SELECT * FROM log WHERE log_date BETWEEN ? AND ?");
            preparedStatement.setString(1, sDate);
            preparedStatement.setString(2, eDate);

            ResultSet resultSet = preparedStatement.executeQuery();

            queryResult.append(String.format("<logs>\n"));
            while (resultSet.next()) {
                int logid = resultSet.getInt("id");
                // header for each log
                queryResult.append(String.format("    <logn>\n"));
                queryResult.append(String.format("        <user_id>%d</user_id>\n", resultSet.getInt("user_id")));
                queryResult.append(String.format("        <log_level>%s</log_level>\n", resultSet.getString("log_level")));
                queryResult.append(String.format("        <log_date>%s</log_date>\n", resultSet.getDate("log_date").toString()));
                queryResult.append(String.format("        <description>%s</description>\n", resultSet.getString("description")));

                // getting jobs with the same log id
                PreparedStatement jobTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM job WHERE log_id=?");
                jobTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet jobTableResultSet = jobTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<jobs>\n"));
                while (jobTableResultSet.next()) {
                    queryResult.append(String.format("        <job>\n"));
                    queryResult.append(String.format("            <job_id>%d</job_id>\n", jobTableResultSet.getInt("job_id")));
                    queryResult.append(String.format("            <owner_id>%d</owner_id>\n", jobTableResultSet.getInt("owner_id")));
                    queryResult.append(String.format("            <job_description>%s</job_description>\n", jobTableResultSet.getString("job_description")));
                    queryResult.append(String.format("            <destination>%s</destination>\n", jobTableResultSet.getString("destination")));
                    queryResult.append(String.format("            <file_url>%s</file_url>\n", jobTableResultSet.getString("file_url")));
                    queryResult.append(String.format("            <relatives>%s</relatives>\n", jobTableResultSet.getString("relatives")));
                    queryResult.append(String.format("            <status>%d</status>\n", jobTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", jobTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", jobTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", jobTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </job>\n"));
                }
                queryResult.append(String.format("</jobs>\n"));

                // getting rules with the same log id
                PreparedStatement ruleTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM rule WHERE log_id=?");
                ruleTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet ruleTableResultSet = ruleTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<rules>\n"));
                while (ruleTableResultSet.next()) {
                    queryResult.append(String.format("        <rule>\n"));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", ruleTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", ruleTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <query>%s</query>\n", ruleTableResultSet.getString("query")));
                    queryResult.append(String.format("            <yes_edge>%d</yes_edge>\n", ruleTableResultSet.getInt("yes_edge")));
                    queryResult.append(String.format("            <no_edge>%d</no_edge>\n", ruleTableResultSet.getInt("no_edge")));
                    queryResult.append(String.format("            <relative_results>%s</relative_results>\n", ruleTableResultSet.getString("relative_results")));
                    queryResult.append(String.format("        </rule>"));
                }
                queryResult.append(String.format("</rules>\n"));

                // getting orchestrations with the same log id
                PreparedStatement orchTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM orch WHERE log_id=?");
                orchTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet orchTableResultSet = orchTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<orchs>\n"));
                while (orchTableResultSet.next()) {
                    queryResult.append(String.format("        <orchestration>\n"));
                    queryResult.append(String.format("            <orch_id>%d</orch_id>\n", orchTableResultSet.getInt("orch_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", orchTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <status>%d</status>\n", orchTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <start_job_id>%d</start_job_id>\n", orchTableResultSet.getInt("start_job_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", orchTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", orchTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </orchestration>\n"));
                }
                queryResult.append(String.format("</orchs>\n"));
                closePreparedStatement(orchTablePreparedStatement);
                closePreparedStatement(ruleTablePreparedStatement);
                closePreparedStatement(jobTablePreparedStatement);


                // closing log header
                queryResult.append(String.format("    </logn>\n"));
            }
            queryResult.append(String.format("</logs>\n"));

            closePreparedStatement(preparedStatement);
            closeResultSet(resultSet);
        } catch (Exception e) {
            e.printStackTrace();
        }

        // closing header for query result XML
        queryResult.append("</query_result>\n");
        return queryResult.toString();
    }

    public String GetJobsByOwnerID(int owner_id) {
        StringBuilder queryResult = new StringBuilder();
        // header query result XML
        queryResult.append("<query_result>\n");

        try {
            // Owner_id ye denk dusen job'ları al.
            PreparedStatement preparedStatement = dbConnection.prepareStatement("SELECT * FROM job WHERE owner_id=?");
            preparedStatement.setInt(1, owner_id);

            ResultSet resultSet = preparedStatement.executeQuery();

            queryResult.append(String.format("<logs>\n"));
            while (resultSet.next()) {
                // Job table'indan log_id al.
                int logid = resultSet.getInt("log_id");

                // Bu logid'ye denk gelen bir tane log olacak onu al.
                PreparedStatement preparedStatement2 = dbConnection.prepareStatement("SELECT * FROM log WHERE id=?");
                preparedStatement2.setInt(1, logid);
                ResultSet resultSet2 = preparedStatement2.executeQuery();

                if(resultSet2.next()){
                    // header for each log
                    queryResult.append(String.format("    <logn>\n"));
                    queryResult.append(String.format("        <user_id>%d</user_id>\n", resultSet2.getInt("user_id")));
                    queryResult.append(String.format("        <log_level>%s</log_level>\n", resultSet2.getString("log_level")));
                    queryResult.append(String.format("        <log_date>%s</log_date>\n", resultSet2.getDate("log_date").toString()));
                    queryResult.append(String.format("        <description>%s</description>\n", resultSet2.getString("description")));
                }

                closePreparedStatement(preparedStatement2);

                // getting jobs with the same log id
                PreparedStatement jobTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM job WHERE log_id=?");
                jobTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet jobTableResultSet = jobTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<jobs>\n"));
                while (jobTableResultSet.next()) {
                    queryResult.append(String.format("        <job>\n"));
                    queryResult.append(String.format("            <job_id>%d</job_id>\n", jobTableResultSet.getInt("job_id")));
                    queryResult.append(String.format("            <owner_id>%d</owner_id>\n", jobTableResultSet.getInt("owner_id")));
                    queryResult.append(String.format("            <job_description>%s</job_description>\n", jobTableResultSet.getString("job_description")));
                    queryResult.append(String.format("            <destination>%s</destination>\n", jobTableResultSet.getString("destination")));
                    queryResult.append(String.format("            <file_url>%s</file_url>\n", jobTableResultSet.getString("file_url")));
                    queryResult.append(String.format("            <relatives>%s</relatives>\n", jobTableResultSet.getString("relatives")));
                    queryResult.append(String.format("            <status>%d</status>\n", jobTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", jobTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", jobTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", jobTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </job>\n"));
                }
                queryResult.append(String.format("</jobs>\n"));
                closePreparedStatement(jobTablePreparedStatement);

                // getting rules with the same log id
                PreparedStatement ruleTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM rule WHERE log_id=?");
                ruleTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet ruleTableResultSet = ruleTablePreparedStatement.executeQuery();
                queryResult.append(String.format("<rules>\n"));
                while (ruleTableResultSet.next()) {
                    queryResult.append(String.format("        <rule>\n"));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", ruleTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", ruleTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <query>%s</query>\n", ruleTableResultSet.getString("query")));
                    queryResult.append(String.format("            <yes_edge>%d</yes_edge>\n", ruleTableResultSet.getInt("yes_edge")));
                    queryResult.append(String.format("            <no_edge>%d</no_edge>\n", ruleTableResultSet.getInt("no_edge")));
                    queryResult.append(String.format("            <relative_results>%s</relative_results>\n", ruleTableResultSet.getString("relative_results")));
                    queryResult.append(String.format("        </rule>\n"));
                }
                queryResult.append(String.format("</rules>\n"));
                closePreparedStatement(ruleTablePreparedStatement);

                // getting orchestrations with the same log id
                PreparedStatement orchTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM orch WHERE log_id=?");
                orchTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet orchTableResultSet = orchTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<orchs>\n"));
                while (orchTableResultSet.next()) {
                    queryResult.append(String.format("        <orchestration>\n"));
                    queryResult.append(String.format("            <orch_id>%d</orch_id>\n", orchTableResultSet.getInt("orch_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", orchTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <status>%d</status>\n", orchTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <start_job_id>%d</start_job_id>\n", orchTableResultSet.getInt("start_job_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", orchTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", orchTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </orchestration>\n"));
                }
                queryResult.append(String.format("</orchs>\n"));
                closePreparedStatement(orchTablePreparedStatement);

                // closing log header
                queryResult.append(String.format("    </logn>\n"));
            }
            queryResult.append(String.format("</logs>\n"));

            closePreparedStatement(preparedStatement);
            closeResultSet(resultSet);
        } catch (Exception e) {
            e.printStackTrace();
        }

        // closing header for query result XML
        queryResult.append("</query_result>\n");
        return queryResult.toString();
    }

    public String GetFilteredLogsBetweenDates(String sDate, String eDate, String filter) {
        StringBuilder queryResult = new StringBuilder();
        // header query result XML
        queryResult.append("<query_result>\n");

        try {
            PreparedStatement preparedStatement = dbConnection.prepareStatement("SELECT * FROM log WHERE log_level=? AND log_date BETWEEN ? AND ?");
            preparedStatement.setString(1, filter);
            preparedStatement.setString(2, sDate);
            preparedStatement.setString(3, eDate);

            ResultSet resultSet = preparedStatement.executeQuery();

            queryResult.append(String.format("<logs>\n"));
            while (resultSet.next()) {
                int logid = resultSet.getInt("id");
                // header for each log
                queryResult.append(String.format("    <logn>\n"));
                queryResult.append(String.format("        <user_id>%d</user_id>\n", resultSet.getInt("user_id")));
                queryResult.append(String.format("        <log_level>%s</log_level>\n", resultSet.getString("log_level")));
                queryResult.append(String.format("        <log_date>%s</log_date>\n", resultSet.getDate("log_date").toString()));
                queryResult.append(String.format("        <description>%s</description>\n", resultSet.getString("description")));

                // getting jobs with the same log id
                PreparedStatement jobTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM job WHERE log_id=?");
                jobTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet jobTableResultSet = jobTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<jobs>\n"));
                while (jobTableResultSet.next()) {
                    queryResult.append(String.format("        <job>\n"));
                    queryResult.append(String.format("            <job_id>%d</job_id>\n", jobTableResultSet.getInt("job_id")));
                    queryResult.append(String.format("            <owner_id>%d</owner_id>\n", jobTableResultSet.getInt("owner_id")));
                    queryResult.append(String.format("            <job_description>%s</job_description>\n", jobTableResultSet.getString("job_description")));
                    queryResult.append(String.format("            <destination>%s</destination>\n", jobTableResultSet.getString("destination")));
                    queryResult.append(String.format("            <file_url>%s</file_url>\n", jobTableResultSet.getString("file_url")));
                    queryResult.append(String.format("            <relatives>%s</relatives>\n", jobTableResultSet.getString("relatives")));
                    queryResult.append(String.format("            <status>%d</status>\n", jobTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", jobTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", jobTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", jobTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </job>\n"));
                }
                queryResult.append(String.format("</jobs>\n"));
                closePreparedStatement(jobTablePreparedStatement);

                // getting rules with the same log id
                PreparedStatement ruleTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM rule WHERE log_id=?");
                ruleTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet ruleTableResultSet = ruleTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<rules>\n"));
                while (ruleTableResultSet.next()) {
                    queryResult.append(String.format("        <rule>\n"));
                    queryResult.append(String.format("            <rule_id>%d</rule_id>\n", ruleTableResultSet.getInt("rule_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", ruleTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <query>%s</query>\n", ruleTableResultSet.getString("query")));
                    queryResult.append(String.format("            <yes_edge>%d</yes_edge>\n", ruleTableResultSet.getInt("yes_edge")));
                    queryResult.append(String.format("            <no_edge>%d</no_edge>\n", ruleTableResultSet.getInt("no_edge")));
                    queryResult.append(String.format("            <relative_results>%s</relative_results>\n", ruleTableResultSet.getString("relative_results")));
                    queryResult.append(String.format("        </rule>\n"));

                }
                queryResult.append(String.format("</rules>\n"));
                closePreparedStatement(ruleTablePreparedStatement);

                // getting orchestrations with the same log id
                PreparedStatement orchTablePreparedStatement = dbConnection.prepareStatement("SELECT * FROM orch WHERE log_id=?");
                orchTablePreparedStatement.setString(1, Integer.toString(logid));
                ResultSet orchTableResultSet = orchTablePreparedStatement.executeQuery();

                queryResult.append(String.format("<orchs>\n"));
                while (orchTableResultSet.next()) {
                    queryResult.append(String.format("        <orchestration>\n"));
                    queryResult.append(String.format("            <orch_id>%d</orch_id>\n", orchTableResultSet.getInt("orch_id")));
                    queryResult.append(String.format("            <user_id>%d</user_id>\n", orchTableResultSet.getInt("user_id")));
                    queryResult.append(String.format("            <status>%d</status>\n", orchTableResultSet.getInt("status")));
                    queryResult.append(String.format("            <start_job_id>%d</start_job_id>\n", orchTableResultSet.getInt("start_job_id")));
                    queryResult.append(String.format("            <insert_time>%s</insert_time>\n", orchTableResultSet.getDate("insert_time").toString()));
                    queryResult.append(String.format("            <update_time>%s</update_time>\n", orchTableResultSet.getDate("update_time").toString()));
                    queryResult.append(String.format("        </orchestration>\n"));
                }
                queryResult.append(String.format("</orchs>\n"));
                closePreparedStatement(orchTablePreparedStatement);

                // closing log header
                queryResult.append(String.format("    </logn>\n"));
            }
            queryResult.append(String.format("</logs>\n"));

            closePreparedStatement(preparedStatement);
            closeResultSet(resultSet);
        } catch (Exception e) {
            e.printStackTrace();
        }

        // closing header for query result XML
        queryResult.append("</query_result>\n");
        return queryResult.toString();
    }

    public String ClearDatabase(){
        StringBuilder queryResult = new StringBuilder();
        // header query result XML
        queryResult.append("<query_result>\n");

        try {
            PreparedStatement ps_unlock = dbConnection.prepareStatement("SET FOREIGN_KEY_CHECKS = 0");
            ps_unlock.execute();
            closePreparedStatement(ps_unlock);
            PreparedStatement preparedStatementLog = dbConnection.prepareStatement("TRUNCATE log");
            preparedStatementLog.execute();
            closePreparedStatement(preparedStatementLog);
            PreparedStatement preparedStatementJob = dbConnection.prepareStatement("TRUNCATE job");
            preparedStatementJob.execute();
            closePreparedStatement(preparedStatementJob);
            PreparedStatement preparedStatementRule = dbConnection.prepareStatement("TRUNCATE rule");
            preparedStatementRule.execute();
            closePreparedStatement(preparedStatementRule);
            PreparedStatement preparedStatementOrch = dbConnection.prepareStatement("TRUNCATE orch");
            preparedStatementOrch.execute();
            closePreparedStatement(preparedStatementOrch);
            PreparedStatement ps_lock = dbConnection.prepareStatement("SET FOREIGN_KEY_CHECKS = 1");
            ps_lock.execute();
            closePreparedStatement(ps_lock);
        } catch (Exception e) {
            e.printStackTrace();
        }

        queryResult.append("    <clear>true</clear>\n");
        queryResult.append("</query_result>\n");
        return queryResult.toString();
    }

    private String getDate(String startDate) {
        String[] tokens = startDate.split(" ");
        //tokens[0] year
        //tokens[1] hours
        String [] yearToken = tokens[0].split("-");
        String [] hoursToken = tokens[1].split(":");
        java.util.Date today = new java.util.Date(Integer.parseInt(yearToken[0]) - 1900,Integer.parseInt(yearToken[1]) - 1,Integer.parseInt(yearToken[2]),
                Integer.parseInt(hoursToken[0]),Integer.parseInt(hoursToken[1]),Integer.parseInt(yearToken[2]));

        Timestamp timestamp = new Timestamp(today.getYear(), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), today.getSeconds(), 0);

        System.out.println("return " + timestamp.toString());
        return timestamp.toString();
    }
}
