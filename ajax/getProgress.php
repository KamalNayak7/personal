<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]))  {        
     $query =$con->prepare("SELECT progress FROM videoProgress  
                                    WHERE videoId=:videoId AND username=:username");           //setting finished =1 once finished watching video
     $query->bindValue(":videoId",$_POST["videoId"]);
     $query->bindValue(":username",$_POST["username"]);
     $query->execute();
     echo $query->fetchColumn();

  
} 



else{
    echo "No videoId or username passed into file";
}
?>