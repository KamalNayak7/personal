<?php
    include_once("includes/header.php");
?>

<div class = "textBoxContainer">
<input type="text" class="searchInput"  placeholder="Search for Something">
    
</div>
 
<div class ="results"></div>

<script>
    $(function(){  //created and anonymous function
        
        var username = '<?php  echo $userLoggedIn; ?>';//php code to get username of user looged in,which comes from header file.JS var will contain string of userlogged in
        var timer;

        $(".searchInput").keyup(function(){   //event handler to text box.keyup-when u type something in searchinput textbox
            clearTimeout(timer);  //clear timer
            
            timer = setTimeout(function(){ //create a new timer
                var val = $(".searchInput").val();//get any value to timer inside the text box for every 500ms
                
                if(val != ""){
                    $.post("ajax/getSearchResults.php", { term:val, username:username}, function(data){        //data is pit returned from getsearchresults.php
                        $(".results").html(data);//function() is the code that will executed once reutned
                    })
                }
                else{
                    $(".results").html("");//if there is nothing in search box display nothing/empty..clear "results" div and anything inside the div
                }
            },500);
        })
    })
</script>







































