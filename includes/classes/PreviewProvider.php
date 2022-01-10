<?php
require_once("Video.php");
require_once("VideoProvider.php");
class PreviewProvider {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createCategoryPreviewVideo($categoryId) {
        $entitiesArray = EntityProvider::getEntities($this->con, $categoryId, 1);

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createTVShowPreviewVideo() {
        $entitiesArray = EntityProvider::getTVShowEntities($this->con, null, 1);

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No TV shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createMoviesPreviewVideo() {
        $entitiesArray = EntityProvider::getMoviesEntities($this->con, null, 1);

        if(sizeof($entitiesArray) == 0) {
            ErrorMessage::show("No movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }


    public function createPreviewVideo($entity) {
        
         if($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();
        $amountInr=$entity->getAmountInr();
        $isPaid  = $entity->getIsPaid();
        $isSeries = $entity->getIsSeries();

        // TODO: ADD SUBTITLE

            $videoId = VideoProvider::getEntityVideoForUser($this->con,$id,$this->username);//If you call $this inside a normal method in a normal class, $this returns the Object (the class) to which that method belongs.
            $video = new Video($this->con,$videoId);//create new instance with videoId
            $inProgress = $video->isInProgress($this->username);

            $description = $video->getDescription();
           /* $seasonEpisode = $video->getSeasonAndEpisode();
            
            
            $playButtonText  = $inProgress ? "Continue Watching" : "Play";
 
             $description =  $video->getDescription();
             $subHeading = $video->isMovie() ? "" : "<h4> $seasonEpisode</h4>"; if its a movie do "" or else "next part"*/
             
           if($isPaid == 0){
                $playButtonText = " BUY";
            }elseif($inProgress >= 1){
                $playButtonText = "Continue Watching";
            }elseif ($inProgress == 0){
                $playButtonText = " Play";
            }else{
                $playButtonText = " BUY";
            }
            

            
        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            <h4>$description</h4>

                            <div class='buttons'>
                                <button onclick='watchVideo($id,$isPaid,$videoId,$isSeries)'><i class='fas fa-play'></i> $playButtonText </button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>

                        </div>

                    </div>
        
                </div>";
            
    }

    public function createEntityPreviewSquare($entity) {
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();
        $preview=$entity->getPreview();
        $amount  = $entity->getAmountInr();
        $isPaid  = $entity->getIsPaid();
        $isSeries = $entity->getIsSeries();

        $videoId = VideoProvider::getEntityVideoForUser($this->con,$id,$this->username);//If you call $this inside a normal method in a normal class, $this returns the Object (the class) to which that method belongs.
        $video = new Video($this->con,$videoId);//create new instance with videoId

        if($isPaid == 1){
            $playButtonText = " Play";
        } elseif($isPaid == 0){
            $playButtonText = "Buy for $amount Rs";
        }else{
            $playButtonText = "Buy for $amount Rs";
        }
   
     
        return "<a href='entity.php?id=$id'>
         <div class='previewContainer small'>
       
            <div class ='contents'>
           
                <video  muted class='previewVideoTrailer' id='trailerVideo' onended='previewEnd()' 
                controls controlsList='nodownload' poster='$thumbnail' title='$name' preload='none'>
                <source src='$preview' type='video/mp4'>
                </video>

              <div class ='buyButton'>
                
                <button class='btn' onclick='watchVideo($id,$isPaid,$isSeries,$videoId)'><i class='fas fa-play'></i> $playButtonText</button>

              </div>

             </div>
         </div>
         </a> ";
     

}  


private function getRandomEntity() {

        $entity = EntityProvider::getEntities($this->con, null, 1);
        return $entity[0];
    }

}
?>