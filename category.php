<?php

require_once("includes/header.php");

if(!isset($_GET["id"])){//to check if category id has been passed,$_GET is from url
    ErrorMessage::show("No Id passed to page");
}

    $preview = new PreviewProvider($con ,$userLoggedIn);
    echo $preview->createCategoryPreviewVideo($_GET["id"]);//call to function in previewProvider.php

    $containers= new CategoryContainers($con ,$userLoggedIn);
    echo $containers->showCategory($_GET["id"]);//call to function  in categoryContainer.php
?>