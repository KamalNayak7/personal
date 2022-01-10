<?php
class VideoProvider{
    public static function getUpNext($con, $currentVideo){
            $query = $con->prepare("SELECT * FROM videos WHERE entityId =:entityId AND  
            id != :videoId AND (
                (season = :season AND episode > :episode) OR season > :season)
                ORDER BY season, episode ASC LIMIT 1");   //query to select next video or next series in ascending order
            
        $query->bindValue(":entityId",$currentVideo->getEntityId());
        $query->bindValue(":season",$currentVideo->getSeasonNumber());
        $query->bindValue(":episode",$currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId",$currentVideo->getId());

        $query->execute();


        if($query->rowCount() == 0){        //if no more videos to play from a season ,play a different video
            $query = $con->prepare("SELECT * FROM videos WHERE 
                                    season <= 1 AND episode <= 1
                                    AND id != :videoId 
                                    ORDER BY views DESC LIMIT 1");//select a new series with sea=1 and ep=1,if selects a movie,seas=0,video with highesh vidws plays first

            $query->bindValue(":videoId",$currentVideo->getId());
            $query->execute();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Video($con,$row);
    }


    public static function getEntityVideoForUser($con, $entityId, $username){//if user wants to resume the series and series doesn't from the beginning 
        $query = $con->prepare("SELECT videoId FROM `videoProgress`  
                     INNER JOIN videos
                     ON videoProgress.videoId = videos.Id
                     WHERE videos.entityId =:entityId
                     AND videoProgress.username= :username
                     ORDER BY videoProgress.dateModified DESC
                     LIMIT 1");

        $query->bindValue(":entityId",$entityId);
        $query->bindValue(":username",$username);
        $query->execute();


        if($query->rowCount() == 0){ // if user hasn't the that entity query row will be 0,hence select lowest series,like season 1
                $query = $con->prepare("SELECT id FROM videos 
                                        WHERE entityId=:entityId
                                        ORDER BY season,episode ASC
                                        LIMIT 1");
             $query->bindValue(":entityId",$entityId);
             $query->execute();

        }

        return $query->fetchColumn();//return one column
        
    }
}
?>