<?php

    class CustomerPayment {

        private $con,$sqlData;

        public function __construct($con, $entityId,$username){
            $this->con=$con;

            $query = $con->prepare("SELECT *  FROM billing WHERE username=:username AND  entityId=:entityId");
            $query->bindValue(":username",$username);
            $query->bindValue("entityId",$entityId);

            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

            


        }

        public function getEntityName(){
            return $this->sqlData["entityName"];
        }

        public function getUsername(){
            return $this->sqlData["username"];
        }

        public function getAmountINR(){
            return $this->sqlData["amountINR"];
        }


        


    }