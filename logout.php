<?php
 session_start();//seesions are how we keep track of logged in.session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
 session_destroy();//we need to start the sess to destroy.if we dont there wont be any session on the page to destroy 
 header("Location: login.php");
?>