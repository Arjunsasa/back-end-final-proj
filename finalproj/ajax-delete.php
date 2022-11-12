<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";

if(isset($_POST["action"])){
  if($_POST["action"] == "delete"){
    delete();
  }
}

function delete(){
  $id = $_POST["id"];

  DB::delete('student', 'studentID=%i', $id);
  echo 1;
}
?>