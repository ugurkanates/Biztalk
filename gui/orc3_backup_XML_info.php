<?php 
include("session.php");

$orc_sql = "SELECT * FROM orchestrations WHERE id=$maxOrcID";

$resultOrc = $db->query($orc_sql); 

echo "<h3>XML ile gonderilmesi gereken data :</h3>";
echo "<h5>Orchestration bilgileri:</h5>";
echo "<table>";
if ($resultOrc->num_rows > 0) {
    while($rowOrc = $resultOrc->fetch_assoc()) {
        echo "<tr>";
        echo "<td>orchID : </td><td>".$rowOrc['id']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>orchOwner : </td><td>".$rowOrc['owner']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>startJobId : </td><td>".$rowOrc['startJobId']."</td>";
        echo "</tr>";
    }

}else{
    echo "0 results";
}
echo "</table>";

$orc_jobs_sql = "SELECT * FROM orcJobs j LEFT JOIN (SELECT r.query, f1.startingNode, f1.reachingNode FROM orcFollowsEdge f1 LEFT JOIN orcRules r ON f1.reachingNode = r.id) f2 ON j.id = f2.startingNode WHERE orchestrations_id=$maxOrcID";

$resultJobs = $db->query($orc_jobs_sql); 

echo "<h5>Job bilgileri:</h5>";
echo "<table>";
if ($resultJobs->num_rows > 0) {
    while($rowJobs = $resultJobs->fetch_assoc()) {
        echo "<tr>";
        echo "<td>JobID : </td><td>".$rowJobs['id']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>JobOwner : </td><td>".$rowJobs['owner']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>JobDesctiption : </td><td>".$rowJobs['description']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Destination Ips : </td><td>".$rowJobs['destination']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>File URL : </td><td>".$rowJobs['fileUrl']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Relatives : </td><td>".$rowJobs['query']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Rule Id :</td><td>".$rowJobs['reachingNode']."</td>";
        echo "</tr>";
    }

}else{
    echo "0 results";
}
echo "</table>";

$orc_rules_sql = "SELECT * FROM orcRules r LEFT JOIN (SELECT l.reachingNode, l.startingNode FROM orcLeadsToEdge l LEFT JOIN orcJobs j ON l.reachingNode = j.id) f2 ON r.id = f2.startingNode  WHERE orchestrations_id=$maxOrcID";

$resultRules = $db->query($orc_rules_sql); 

echo "<h5>Rules bilgileri:</h5>";
echo "<table>";
if ($resultRules->num_rows > 0) {
    while($rowRules = $resultRules->fetch_assoc()) {
        echo "<tr>";
        echo "<td>RuleID : </td><td>".$rowRules['id']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Rule name : </td><td>".$rowRules['ruleName']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Owner : </td><td>".$rowRules['owner']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Query : </td><td>".$rowRules['query']."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>yesEddge : </td><td>".$rowRules['reachingNode']."</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>noEdge : </td><td>0</td>";
        echo "</tr>";
    }

}else{
    echo "0 results";
}
echo "</table>";


?>