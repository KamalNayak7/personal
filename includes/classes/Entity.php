 <?php

    class Entity{

        private $con,$sqlData;

        public function __construct($con, $input){ //$input  can  be  data from  db or entityID

            $this->con=$con;

            if(is_array($input)){//if input is in array

            $this->sqlData=$input;

            }
            else{//if not,get data from table
                $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
                $query->bindValue(":id",$input);
                $query->execute();

                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC); 

            }


        }

        public function getId(){
            return $this->sqlData["id"];
        }

        public function getName(){
            return $this->sqlData["name"];
        }

        public function getThumbnail(){
            return $this->sqlData["thumbnail"];
        }

        public function getPreview(){
            return $this->sqlData["preview"];
        }

        public function getCategoryId(){
            return $this->sqlData["categoryId"];
        }

        public function getAmountInr(){
            return $this->sqlData["amountINR"];
        }

        public function getIsPaid(){
            return $this->sqlData["isPaid"];
        }
        public function getIsSeries(){
            return $this->sqlData["isSeries"];
        }
       
        



        

        public function getSeasons(){
            $query=$this->con->prepare("SELECT * FROM videos WHERE entityId=:id AND isMovie=0 ORDER BY season,episode ASC");
            $query->bindValue(":id",$this->getId());
            $query->execute();

            $season = array();
            $videos=array();
            $currentSeason=null;

            while($row = $query->fetch(PDO::FETCH_ASSOC)){

                    if($currentSeason != null && $currentSeason != $row["season"]){
                        $season[] = new Season($currentSeason,$videos);
                        $videos=array();
                    }

            $currentSeason= $row["season"];
            $videos[] = new Video($this->con, $row);
            }
            if(sizeof($videos)!= 0){
                $season[] = new Season($currentSeason,$videos);

            }

            return $season;
        }

        


    }



?>