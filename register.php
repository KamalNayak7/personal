 

<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");


    $account = new Account($con);

      if(isset($_POST["submitButton"])){
        
            $firstName=FormSanitizer::sanitizeFormString($_POST["firstName"]);
            $lastName=FormSanitizer::sanitizeFormString($_POST["lastName"]);
            $phoneNumber=FormSanitizer::sanitizeFormPhonenumber($_POST["phoneNumber"]);
            $email=FormSanitizer::sanitizeFormEmail($_POST["email"]);
            $password=FormSanitizer::sanitizeFormPassword($_POST["password"]);
            $password2=FormSanitizer::sanitizeFormPassword($_POST["password2"]);

            $success= $account->register($firstName, $lastName, $phoneNumber, $email, $password, $password2);

            if($success){
              $_SESSION["userLoggedIn"]= $phoneNumber;
              header("Location: index.php");
            }
 
        }

        function getInputValue($name){
          if(isset($_POST[$name])){
            echo $_POST[$name];
          }
        }
?>


<!DOCTYPE html>

<html>
   <head>  
  
   </style>
  
       <title> welcome to kamalflix</title>
       <link rel="stylesheet"  type="text/css" href="assets/style/style.css" />
      

</style>
 </head>

 <body>
  <div class="signInContainer">

       <div class="column">

         <div class="header">
         <img src= "assets/images/logo.png" title="logo" alt="site logo"/>
         <h3 style="color:brown;">Sign Up</h3>
         <span style="color:brown;" >to continue to Cinetury </span>
          
         </div>

       <form method= "POST">

       <input type="text" name="firstName"  placeholder="First Name" required value="<?php getInputValue("firstName");  ?>" required>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$firstNameCharacters )?></span>

       <input type="text" name="lastName"  placeholder="Last Name" value="<?php getInputValue("lastName");  ?>" required>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$lastNameCharacters )?></span>

      
       <input type="number" name="phoneNumber"  placeholder="Phone Number" value="<?php getInputValue("phoneNumber");  ?>" required>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$phoneNumberCharacters )?></span>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$phoneNumberExists )?></span>

      
      <input type="email" name="email"  placeholder="Email ID" value="<?php getInputValue("email");  ?>" required>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$emailInvalid)?></span>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$emailExists)?></span>

       <input type="password" name="password"  placeholder="Password " required>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$passwordsDontMatch)?></span>
       <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$passwordLenght)?></span>



       <input type="password" name="password2"  placeholder="Confirm Password" required>

       <input type="submit" name="submitButton"  value="SIGN UP">
       
      </form>

      <a href="login.php" class="signInMessage">Already have an account? Sign In here! </a>
     
       </div>

  </div>
    </body>

</html>