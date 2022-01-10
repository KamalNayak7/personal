<?php
class Video {
    private $con, $sqlData, $entity;

    public function __construct($con, $input) {
        $this->con = $con;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getThumbnail() {
        return $this->entity->getThumbnail();
    }

    public function getEpisodeNumber() {
        return $this->sqlData["episode"];
    }
    
    public function getSeasonNumber() {
        return $this->sqlData["season"];
    }

    public function getEntityId() {
        return $this->sqlData["entityId"];
    }



    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindValue(":id", $this->getId());
        $query->execute();
    }

    public function getSeasonAndEpisode(){ //to get season n ep no,for ex season 1 episode 2
            if($this->isMovie()){ //if its  a movie do nothing
                return;
            } 

            $season = $this->getSeasonNumber();//get season n ep number and return
            $episode =$this->getEpisodeNumber();

            return "Season $season, Episode $episode";
    }

    public function isMovie(){  //check if its a movie
        return $this->sqlData["isMovie"] == 1; //if this is 1 return true
    }

    

    public function isInProgress($username){//check if user is watching the series for "cont watchin"/"play" button
            $query = $this->con->prepare("SELECT * FROM videoProgress
                                         WHERE videoId=:videoId AND username=:username");//AND finished=0 add later
            $query->bindValue(":videoId",$this->getId());
            $query->bindValue(":username",$username);

            $query->execute();

            return $query->rowCount() != 0;//if row count not = 0 return true else return false,if there is nothing in return tabel it means username hasn;t watched the video yet

    }

    public function hasSeen($username){
        $query = $this->con->prepare("SELECT * FROM videoProgress
                                        WHERE videoId=:videoId AND username=:username");//to check if they have seen the video
        $query->bindValue(":videoId",$this->getId());
        $query->bindValue(":username",$username);

        $query->execute();

        return $query->rowCount() != 0;
    }
}
?>