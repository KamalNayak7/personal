<?php

require_once("includes/header.php");

    $preview = new PreviewProvider($con ,$userLoggedIn);
    echo $preview->createMoviesPreviewVideo();//call to function in previewProvider.php

    $containers= new CategoryContainers($con ,$userLoggedIn);
    echo $containers->showMovieCategories();//call to function  in categoryContainer.php
?>