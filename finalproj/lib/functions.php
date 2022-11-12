<?php

function jsRedirect($url){
    echo "<script>window.location.href = '" . $url . "';</script>";
}

function jsAlert($text){
    echo "<script>alert('" . $text . "');</script>";
}


function isValidPhone($phone){
    if(preg_match('/^[0-9]{8}+$/', $phone)) {//check if 8 numbers in phone numbers from 0-9
        return true;
        } else {
        return false;
        }
    }
    
function filterInput($input){
    $input = trim($input); // remove unnecessary spaces, tabs, or new line
    $input = stripslashes($input); // remove backslashes "\"
    $input = htmlspecialchars($input); // remove any special html characters that might harm your code
    return $input; // final filtered input
}

function isValidEmail($email){
    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // Check if email format is valid
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function isLoggedIn() {
        //Check if user is logged in
        if(isset($_SESSION["adminEmail"]) || isset($_SESSION["teacherEmail"]) || isset($_SESSION["studentEmail"])){ //email & name session exists
            return true;
        } else {
            return false;
        }    
}

function isAdmin(){//check if user is admin
    if(isset($_SESSION["adminName"]) && isset($_SESSION["adminEmail"])){ //email & name session exists
        return true;
      } else {
        return false;
      }
}

function isTeacher(){//check if user is teacher
    if(isset($_SESSION["teacherName"]) && isset($_SESSION["teacherEmail"])){ //email & name session exists
        return true;
      } else {
        return false;
      }
}

function isStudent(){//check if user is student
    if(isset($_SESSION["studentName"]) && isset($_SESSION["studentEmail"])){ //email & name session exists
        return true;
      } else {
        return false;
      }
}
?>