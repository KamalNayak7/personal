<?php
echo " ";
    require_once("includes/config.php");
    require_once("includes/classes/PreviewProvider.php"); 
    require_once("includes/classes/CategoryContainers.php"); 
    require_once("includes/classes/Entity.php"); 
    require_once("includes/classes/EntityProvider.php"); 
    require_once("includes/classes/ErrorMessage.php"); 
    require_once("includes/classes/SeasonProvider.php");
    require_once("includes/classes/Season.php"); 
    require_once("includes/classes/Video.php"); 
    require_once("includes/classes/VideoProvider.php");
    require_once("includes/classes/User.php");
    require_once("includes/classes/CustomerPayment.php");






    if(!isset($_SESSION["userLoggedIn"])){

        header("Location: register.php");  
    }
    $userLoggedIn = $_SESSION["userLoggedIn"];

    ?> 

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to kamalflix</title>
       
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/f725bb1c23.js" crossorigin="anonymous"></script> <!-- start using font awesome -->

        <script src="assets/js/script.js"></script>
    </head>
    <body style="background-color:#141414">
        <div class='wrapper'>  
            
<?php 
  if(!isset($hideNav))  {//if hidenav var is not set then show nav bar
      include_once("includes/navBar.php");
  }
?>


  