import java.text.ParsePosition;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;

public class QueryStringCheck {
    private ArrayList<String> commandList = new ArrayList<String>(Arrays.asList(
            "Get",
            "GetJobs",
            "ClearLog",
            "GetError",
            "GetError",
            "GetFailedJob",
            "GetFailJob",
            "GetReport"));
    public ArrayList<String> params;

    public String command;

    private void commandCheck(String inp) {
        if (inp == null || inp.equals(""))
            return;

        else {
            int openIndex = inp.indexOf('(');
            int closeIndex = inp.indexOf(')');

            if (openIndex == -1 || closeIndex == -1 || openIndex > closeIndex)
                return;

            else {
                String commandStr = inp.substring(0, openIndex);
                if (!commandList.contains(commandStr)) {
                    command = null;
                    params = null;
                    return;

                }

                else {
                    command = commandStr.toLowerCase();
                }

                if (closeIndex - openIndex == 1) {
                    params = new ArrayList<>();
                    command = commandStr.toLowerCase();

                } else {
                    String parameterSubStr = inp.substring(openIndex + 1, closeIndex);
                    int commaIndex = parameterSubStr.indexOf(',');
                    if (commaIndex == -1) {
                        params = new ArrayList<>();
                        params.add(parameterSubStr.replaceAll("\\s+", "").toLowerCase());
                        return;

                    }

                    else {
                        String[] paramMid = parameterSubStr.split("\\,", -1);
                        if (paramMid.length > 2) {
                            command = null;
                            params = null;
                            return;
                        } else {
                            params = new ArrayList<>();
                            params.add(paramMid[0].replaceAll("\\s+", "").toLowerCase());
                            params.add(paramMid[1].replaceAll("\\s+", "").toLowerCase());
                        }

                    }
                }
            }
        }
    }

    public boolean isDate(String date) {
        SimpleDateFormat ft = new SimpleDateFormat("yyyy-MM-dd-HH:mm:ss");
        Date date1 = ft.parse(date, new ParsePosition(0));
        if (date1 == null)
            return false;
        return true;
    }

    public boolean isValid(String inp) {
        commandCheck(inp);
        if (params == null){
            return false;
        }
        else if (params.size() == 0) {
            if (command.equals("clearlog") || command.equals("getreport")){
                return true;
            }
            return false;
        } else if (params.size() == 1) {
            boolean firstIsDate = isDate(params.get(0));
            if (!firstIsDate) {
                if (command.equals("getjobs"))
                    return true;
                else
                    return false;
            } else {
                if (command.equals("get") || command.equals("geterror") || command.equals("getfailjob"))
                    return true;
                return false;
            }

        } else if (params.size() == 2) {
            boolean firstDateValid = isDate(params.get(0));
            boolean secondDateValid = isDate(params.get(1));

            if (firstDateValid && secondDateValid) {
                if (command.equals("get") || command.equals("geterror") || command.equals("getfailedjob"))
                    return true;

                return false;
            }

            return false;

        } else
            return false;

    }
}

