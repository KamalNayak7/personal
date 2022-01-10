<?php

    class Season{
        private $seasonNumber, $video;
        public function __construct($seasonNumber, $video){
              $this->seasonNumber=$seasonNumber;
              $this->videos= $video;
        }

        public function getSeasonNumber(){ 
            return $this->seasonNumber;
        }
        public function getVideos(){
            return $this->videos;
        }
    
    }
?>