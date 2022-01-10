<?php
ob_start();// turns on buffer output
session_start();

date_default_timezone_set("Asia/Kolkata");

  try{
      $con=new PDO("mysql:dbname=kamalflix;host=localhost", "root","");
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

catch(PDOException $e){

  exit("Connection failed:" . $e->getmessage());

}
?>