<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

    if(isset($_POST["submitButton"])) {
        $emailsession=FormSanitizer::sanitizeFormEmail($_POST["emailorphonenumber"]);
        $phonenumbersession=FormSanitizer::sanitizeFormPhonenumber($_POST["emailorphonenumber"]);
        $password=FormSanitizer::sanitizeFormPassword($_POST["password"]);

        if(filter_var($emailsession, FILTER_VALIDATE_EMAIL)){
            $success= $account->login($emailsession,$phonenumbersession,$password);

            if($success){
                $_SESSION["userLoggedIn"]= $emailsession;
                header("Location:index.php");
              }
        }else{
           $success= $account->login($emailsession,$phonenumbersession,$password);
            if($success){
                $_SESSION["userLoggedIn"]= $phonenumbersession;
                header("Location:index.php");
              }
        }
        }
function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
} 

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to kamalflix</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="signInContainer">

            <div class="column">

                <div class="header">
                    <img src="assets/images/logo.png" title="Logo" alt="Site logo" />
                    <h3 style="color:brown;">Sign In</h3>
                    <span>to continue to Cinetury</span>
                </div>

                <form method="POST">
                <input type="text" name="emailorphonenumber" placeholder="Email/Phone Number" value="<?php getInputValue("emailorphonenumber");  ?>" required>
                <span style="color:white;text-align:center;font-size:14px;font-weight:400"><?php echo $account->getError(Constants::$loginFailed);?> </span>

                    <input type="password" name="password" placeholder="Password" required>

                    <input type="submit" name="submitButton" value="SUBMIT">

                </form>

                <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>

            </div>

        </div>

    </body>
</html>