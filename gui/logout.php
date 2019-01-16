<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: logged_out.html");
   }
?>