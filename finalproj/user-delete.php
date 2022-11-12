<?php
include "lib/config.php"; 
include "lib/functions.php";
include "lib/db.class.php";


if(isset($_GET["teacherID"])){
    $getTeacherID = $_GET["teacherID"];
    DB::delete('teacher', 'teacherID=%i', $getTeacherID);
    jsRedirect(SITE_ROOT . "admin.php");
} elseif(isset($_GET["studentID"])){
    $getStudentID = $_GET["studentID"];
    DB::delete('student', 'studentID=%i', $getStudentID);
    jsRedirect(SITE_ROOT . "admin.php");
} else {
    jsRedirect(SITE_ROOT . "admin.php");
}
?>