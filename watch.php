<?php
$hideNav = true;
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}

$video = new Video($con, $_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($con,$video); //pasing the param to watch.php to get upcoming vid
?>

<div class = "watchContainer">

    <div class="videoControls watchNav">  <!-- for current vid -->
        <button class="iconButton" onClick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>

    </div>

    <div class = "videoControls upNext" style ="display:none">        <!-- for next video -->
        
        <div class="upNextContainer">
        <button class = "redoIcon" onclick="restartVideo()";><i class="fas fa-redo"></i></button>
            <h2>Up Next:</h2>
            <h3><?php echo $upNextVideo->getTitle() ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode() ?></h3>

            <button class ="playIcon" onclick="watchNextVideo(<?php echo $upNextVideo->getId();?>)">  
            <i class="fas fa-play"></i>  Play
            </button>
        </div>
    
    </div>

        <video controls autoplay muted onended="showUpNext()">
            <source src ='<?php echo $video->getFilePath();?>' type="video/mp4">
        </video>

</div>
<script> 
  initVideo("<?php echo $video->getId();?>", "<?php echo $userLoggedIn;?> ");  // call function,send which user is logged in and which video is playing,send 2 parameters
</script>