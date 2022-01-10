<?php
    class User{
        private $con, $sqlData,$sqlData1;//stick it in here--4

        public function __construct($con,$email,$phoneNumber){//take the data from here --1
            $this->con = $con;

            $query = $con->prepare("SELECT * FROM users WHERE (email=:email OR phoneNumber=:phoneNumber)");//selecting a row from the table which has "$username"--2
            $query->bindValue(":email", $email);
            $query->bindValue(":phoneNumber", $phoneNumber);

            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);//store the sqldata returned from that row from database--3

        }

        

    

        public function getFirstName(){
    
            return $this->sqlData["firstName"];//return "firstName" from DB which is store in "$this->sqlData"
        }

        public function getLastName(){
            return $this->sqlData["lastName"];//return "lastName" from DB which is store in "$this->sqlData"
        }
        public function getEmail(){
            
            return $this->sqlData["email"];//return "email" from DB which is store in "$this->sqlData"
        }

        public function getPhoneNumber(){
            return $this->sqlData["phoneNumber"];//return "email" from DB which is store in "$this->sqlData"
        }


    }
?>