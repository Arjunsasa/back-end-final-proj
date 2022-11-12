<?php
include "lib/config.php"; 
include "lib/functions.php";
session_start();

//If the user is logged in

if(isLoggedIn()){
            //Clear & Destroy all sessions
            session_unset(); // remove all session variables
            session_destroy(); // destroy the session
            jsRedirect(SITE_ROOT . "login.php");
} else{
    jsRedirect(SITE_ROOT . "login.php");
}
?>