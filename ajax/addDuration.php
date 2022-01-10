<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]))  {        //cheching if we have received the data i.e videoid and username using post method
     $query =$con->prepare("SELECT * FROM videoProgress WHERE username=:username AND videoId=:videoId");  //to check if row already exist
     $query->bindValue(":videoId",$_POST["videoId"]);
     $query->bindValue(":username",$_POST["username"]);
     $query->execute();

     if($query->rowCount()==0){                            //to check if row exist in the  videoProgress table 
            $query=$con->prepare("INSERT INTO videoProgress (username,videoId) VALUES(:username, :videoId)");
            $query->bindValue(":videoId",$_POST["videoId"]);
             $query->bindValue(":username",$_POST["username"]);
             $query->execute();
     }
} 



else{
    echo "No videoId or username passed into file";
}
?>