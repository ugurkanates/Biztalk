<?php
include("session.php");

        $yesEdgeContent_sql = "SELECT `reachingNode` FROM `orcLeadsToEdge` WHERE `startingNode` = 14 AND `yesNoType` = 'yes'";
        $resultYesContent = $db->query($yesEdgeContent_sql); 
        $rowYesContent = $resultYesContent->fetch_assoc();

        echo "Ta ta ta ta ".$rowYesContent['reachingNode']."<br>";

        $noEdgeContent_sql = "SELECT `reachingNode` FROM `orcLeadsToEdge` WHERE `startingNode` = 14 AND `yesNoType` = 'no'";
        $resultNoContent = $db->query($noEdgeContent_sql); 
        
        $rowNoContent = $resultNoContent->fetch_assoc();
        echo "Ta ta ta ta ".$rowNoContent['reachingNode']."<br>";

