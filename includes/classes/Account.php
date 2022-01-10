<?php

    class Account{ 


        private $con;
        private $errorArray = array();

        public function __construct($con){
          $this->con= $con;
        }

        public function updateDetails($fn, $ln, $em, $pn) {
          $this->validateFirstName($fn);
          $this->validateLastName($ln);
          $this->validateNewEmail($em, $pn);

          if(empty($this->errorArray)){
            
              $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em WHERE  (email=:pn OR phoneNumber=:pn)");
              $query->bindValue(":fn",$fn);
              $query->bindValue(":ln",$ln);
              $query->bindValue(":em",$em);
              $query->bindValue(":pn",$pn);

              $query->execute();

              return true;
            
          }
          return false;
        }

        public function register($fn, $ln, $pn, $em, $pw, $pw2){
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validatePhoneNumber($pn);
            $this->validateEmails($em);
            $this->validatePasswords($pw,$pw2);


            if(empty($this->errorArray)){
              return $this->insertUserDetails($fn, $ln, $pn, $em, $pw);
            }
            return false;

      }


      public function login($em,$pn,$pw){
        
        $pw= hash("sha512", $pw);
        
        $query= $this->con->prepare("SELECT * FROM users WHERE  (email=:em OR phoneNumber=:pn) AND password=:pw");

        $query->bindValue(":em",$em);
        $query->bindValue(":pn",$pn); 
        $query->bindValue(":pw",$pw); 
  
         $query->execute();

         if($query->rowCount() == 1){
           return true;
         } 
         array_push($this->errorArray, Constants::$loginFailed);
         return false;


      }

        private function insertUserDetails($fn, $ln, $pn, $em, $pw){

          $pw= hash("sha512", $pw);
          $query= $this->con->prepare("INSERT INTO users(firstName,lastName,phoneNumber,email,password)
                                      VALUES(:fn, :ln, :pn, :em, :pw)");
          $query->bindValue(":fn",$fn);
          $query->bindValue(":ln",$ln);
          $query->bindValue(":pn",$pn);
          $query->bindValue(":em",$em); 
          $query->bindValue(":pw",$pw); 

          return $query->execute();
  
        }

        private function validateFirstName($fn) { 
                 if(strlen($fn)< 2 || strlen($fn)> 25){
                     array_push($this->errorArray,Constants::$firstNameCharacters);
                    }
        }

        private function validateLastName($ln) { 
               if(strlen($ln)< 2 || strlen($ln)> 25){
                   array_push($this->errorArray,Constants::$lastNameCharacters);

     }
       } 

        private function validatePhoneNumber($pn){ 
               if(strlen($pn)< 9 || strlen($pn)> 14){
                    array_push($this->errorArray,Constants::$phoneNumberCharacters);
                   return;

       }
              $query=$this->con->prepare("SELECT * FROM users WHERE phoneNumber=:pn");
              $query->bindValue(":pn",$pn);
              $query->execute(); 
                

             if($query->rowCount() != 0){
              array_push($this->errorArray,Constants::$phoneNumberExists);
      } 
    }

         private function validateEmails($em){
              if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray,Constants::$emailInvalid); 
                return;
              }


              $query=$this->con->prepare("SELECT * FROM users WHERE email=:em");
              $query->bindValue(":em",$em);
              $query->execute();
                
              if($query->rowCount() != 0){
                array_push($this->errorArray,Constants::$emailExists);
              }    
       }
       private function validateNewEmail($em, $pn){

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
          array_push($this->errorArray,Constants::$emailInvalid); 
          return;
        }
        

        $query= $this->con->prepare("SELECT * FROM users WHERE email=:em AND phoneNumber != :pn");//when the page loads,txtbox will be with current email,checks current emial and will find a row
        $query->bindValue(":em",$em);//coz i have it set,shows an error saying this email is already taken
        $query->bindValue(":pn",$pn);
        $query->execute();
          
        if($query->rowCount() != 0){
          array_push($this->errorArray,Constants::$emailExists);
        }    
 }


          private function validatePasswords($pw,$pw2){

              if($pw != $pw2){
                array_push($this->errorArray,Constants::$passwordsDontMatch); 
                return;
                }

                if(strlen($pw)< 5 || strlen($pw)> 25){
                  array_push($this->errorArray,Constants::$passwordLenght);
                  return;
                 }
              }

        public function getError($error){
          if(in_array($error, $this->errorArray)){
            return $error;
          }
        }

        public function getFirstError(){
          if(!empty($this->errorArray)){
            return $this->errorArray[0];//return first item in erray array

          }
        }

        public function updatePassword($oldPw, $pw, $pw2, $pn){//update new password
            $this->validateOldPassword($oldPw, $pn);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray)){
            
                $query = $this->con->prepare("UPDATE users SET password=:pw WHERE  (email=:pn OR phoneNumber=:pn)");
                $pw= hash("sha512", $pw);
                $query->bindValue(":pw",$pw);
                $query->bindValue(":pn",$pn);

                $query->execute();

                return true;
                }
                return false;
                }

        public function validateOldPassword($oldPw, $pn){//to check if old password entered  is correct
          $pw= hash("sha512", $oldPw);
        
          $query= $this->con->prepare("SELECT * FROM users WHERE  (email=:pn OR phoneNumber=:pn) AND password=:pw");
  
          $query->bindValue(":pn",$pn); 
          $query->bindValue(":pw",$pw); 
     
           $query->execute();

           if($query->rowCount() == 0) {
              array_push($this->errorArray, Constants::$passwordIncorrect);
           }
        }

   }


     
?>


