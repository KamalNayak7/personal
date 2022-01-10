$(document).scroll(function() {  //toggle once scrolled
  var isScrolled =$(this).scrollTop() > $(".topBar").height();//if top of the page > top of topBar element then var will be true
  $(".topBar").toggleClass("scrolled",isScrolled);//class we wanna toggle is scrolled ,vlaue to determine whether to add or remove the class,it will add only if its true
})

function volumeToggle(button){
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted",!muted);

    $(button).find("i").toggleClass("fa-volume-mute");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnd(){
    $(".previewVideo").toggle();
    $(".previewImage").toggle();
}


$(new Document).ready(function(){
  
    $(".previewVideoTrailer").on("mouseover", function(event) {
      $(this).get(0).play();
  
    }).on('mouseout', function(event) {
      this.load();
    });
  })

  function goBack(){
    window.history.back();
  }

  function startHideTimer(){
    
    var timeout=null;
    $(document).on("mousemove",function(){
        clearTimeout(timeout);                               //resetting the timer whenever we move the mouse
        $(".watchNav").fadeIn();               //when mouse moves in  div moves in or show navigation bar
           timeout = setTimeout(function(){                     //start a new timer
          $(".watchNav").fadeOut();           //after 2 seconds fadeout the nav bar
        },1500);
    })

  }

  function initVideo(videoId, username){               //create a function ,basically any set up when the page loads
    startHideTimer();
    setStartTime(videoId,username);
    updateProgressTimer(videoId, username);                 //calling updateProgres func and passing 2 values
    
  }    
  
  function updateProgressTimer(videoId,username){    //to update the progress of video playing
        addDuration(videoId,username) ;   
        
        var timer;

        $("video").on("playing",function(event) {             //only video on watch.php page so can be accessed directly without id tag  //do the code in the parenthesis as video is "playing"
              window.clearInterval(timer);                   //clears the timers  
              timer = window.setInterval(function(){        //set a new timmer
                updateProgress(videoId, username, event.target.currentTime); //call function,pass.. param:-event=playing event,target=video,currentTime=current time of video.                                 
              },3000)                                      //every 3 sec this line of code is working                           
        })
        .on("ended",function(){
          setFinished(videoId,username);
          window.clearInterval(timer);                       //on video ended clear/stop timmer
        })                                    
  }

  function addDuration(videoId,username){
       $.post("ajax/addDuration.php", { videoId :videoId, username:username}, function(data){ 
                                                                                              //makes an ajax request to addDuration.php ,
        if(data !== null && data !==""){     //for now 2nd param is code taht will executed when ajax request returns
          alert(data);                          //data-will anything rturned from the file
         }                                        //sending data using post method the second parameter is the data to send                      
        })                                         //check if there is an err, "==" is used to check the type as well                 
      }                                                              
                                                                                                  
                                                                    
                                                  
      function updateProgress(videoId,username,progress){                                    //to update the video progress
        $.post("ajax/updateDuration.php", { videoId :videoId, username:username, progress:progress}, function(data){ 
          
            if(data !== null && data !==""){    
            alert(data); 
          }                                                      
          }) 
      }

      function setFinished(videoId,username){                                    
        $.post("ajax/setFinished.php", { videoId :videoId, username:username}, function(data){ 
          
            if(data !== null && data !==""){    
            alert(data); 
          }                                                      
          }) 
      }

      function isPaid(videoId,username){                                    
        $.post("ajax/isPaid.php", { videoId :videoId, username:username}, function(data){ 
          
            if(data !== null && data !==""){    
            alert(data); 
          }                                                      
          }) 
      }

      function setStartTime(videoId,username){                                    
        $.post("ajax/getProgress.php", { videoId :videoId, username:username}, function(data){ //ajax will return anything that is echoed in the page i.e getProgress.php 
          
                if(isNaN(data)){     //isNaN=is Not a number?
                      alert(data);   //data will contain progress time,so it has to be number ,if its a string then its error
                      return;
                } 
                $("video").on("canplay",function(){ //on can play event,browser is ready to play
                  this.currentTime=data;            //set current time of video(this) to data
                  $("video").off("canplay");        //detach 
                })                                                  
          }) 
      }

      function restartVideo(){
        $("video")[0].currentTime = 0//"video" jquery object for the video,when [0] on a jquery object ("video") it access javascript object that it relates to and set time =0
        $("video")[0].play();
        $(".upNext").fadeOut();//fade out upNext conatiner once clicked on replay button

      }

      function watchVideo(id,isPaid,videoId,isSeries){ //to watch next video
        if(isPaid == 1 && isSeries == 1 && videoId >=1){
          window.location.href ="watch.php?id=" + videoId;
        }
        if(isPaid == 1 && isSeries == 0 && videoId >=1){
          window.location.href ="watch.php?id=" + videoId;
        }
        if(isPaid == 0){
          window.location.href ="paymentPage.php?id=" + id;
        }

    }
  

    function watchNextVideo(nextVideoId){
      window.location.href ="watch.php?id=" + nextVideoId;
    }

    function takeToBillingPage(entityId){
      window.location.href ="billing.php?id=" + entityId;
    }

      function showUpNext(){
        $(".upNext").fadeIn();
      }

      function chechIfUserPaid(){

      }
         
         
                                                  
  

    


