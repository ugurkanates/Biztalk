package DB;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Orchestration {

    private int id;
    private int ownerID;
    private int status;
    private int startJobID;
    private Date InsertDateTime;
    private Date UpdateDateTime;

    private SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

    public Orchestration(){

    }

    public Orchestration(int ownerID, int status, int startJobID) {
        this.ownerID = ownerID;
        this.status = status;
        this.startJobID = startJobID;
        InsertDateTime = new Date();
        UpdateDateTime = new Date();
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getOwnerID() {
        return ownerID;
    }

    public void setOwnerID(int ownerID) {
        this.ownerID = ownerID;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public int getStartJobID() {
        return startJobID;
    }

    public void setStartJobID(int startJobID) {
        this.startJobID = startJobID;
    }

    public String getInsertDateTime() {
        String date = dateFormat.format(InsertDateTime);
        return date;
    }

    public void setInsertDateTime(String time) throws ParseException {
        this.InsertDateTime = dateFormat.parse(time);
    }

    public void setInsertDateTime(Date time){
        this.InsertDateTime = time;
    }

    public String getUpdateDateTime() {
        String date = dateFormat.format(UpdateDateTime);
        return date;
    }

    public void setUpdateDateTime(String update) throws ParseException {
        this.UpdateDateTime = dateFormat.parse(update);
    }
    public Date getUpdateDateTime_Date() {

        return InsertDateTime;
    }

    public Date getInsertDateTime_Date() {

        return UpdateDateTime;
    }

}
