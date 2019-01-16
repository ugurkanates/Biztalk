package BizTalkLog.CSVUtils;

import java.io.*;

/**
 *  Has useful methods to read .csv file.
 *  Can read, parse, count line number of a .csv file with this class.
 */
public class CSV_Reader{
    /**
     *  Holds file's data.
     */
    private File file;
    /**
     *  Reader to hold line number of .csv file.
     */
    private BufferedReader lineNumberReader;
    /**
     *  Reader to hold 1 line of .csv file.
     */
    private BufferedReader lineReader;
    /**
     *  File's line number (data number).
     */
    private int lineNumber;

    /**
     * Opens .csv file and inits BufferedReader readers.
     *
     * @param filename String that holds file's name.
     * @return Returns file pointer.
     * @throws NullPointerException
     * @throws FileNotFoundException
     */
    public File openCSV(String filename) throws NullPointerException, FileNotFoundException {
        try {
            file = new File(filename);
        }
        catch (NullPointerException e) {
            System.err.println("Caught NullPointerException: " + e.getMessage());
        }

        lineNumberReader = new BufferedReader(new FileReader(filename));
        lineReader = new BufferedReader(new FileReader(filename));
        System.out.println("Reading from: " + filename);
        return file;
    }

    /**
     *  Parses and returns one line's data with specific splitter.
     *
     * @param line Line to be parsed.
     * @param split String that parses line.
     * @return Returns line's parsed data as a String Array.
     */
    public String[] splitLineWith(String line,String split){
        String[] info;
        info = line.split(split);
        return info;
    }

    /**
     *  Getter to line number.
     * @return returns line number in a .csv file.
     * @throws IOException
     */
    public int getLineNumber() throws IOException {
        try {
            while (lineNumberReader.readLine() != null) {
                lineNumber++;
            }
        }
        catch (IOException e) {
            System.err.println("Caught IOException: " + e.getMessage());
        }

        return lineNumber;
    }

    /**
     *  Reads one line at one time.
     *  Uses BufferedReader to keep track of the file iterator, where it was last time.
     * @param file File to read.
     * @return Returns line in the .csv file as a string.
     * @throws IOException
     */
    public String readLineFromCSV(File file) throws IOException {
        String line = " ";
        try {
            line = lineReader.readLine();
        }
        catch (IOException e) {
            System.err.println("Caught IOException: " + e.getMessage());
        }
        return line;
    }
}

