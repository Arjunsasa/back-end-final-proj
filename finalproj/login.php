<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
?>
<?php
$pageName = " login";
include "lib/header.php";
?>

<link rel="stylesheet" href="assets/css/login.css">
</head>
<?php
if(isset($_POST["login"])){ // if login form is submitted
  $loginEmail = filterInput($_POST["Email"]);
  $loginPassword = filterInput($_POST["Password"]);
  $loginPortal = filterInput($_POST["portal"]);
  if($loginPortal == "Student"){
    if($loginEmail == "" || $loginPassword == ""){ // check if email and password are filled
      jsAlert("Please fill up your email address and password.");
    } else {
      if(!isValidEmail($loginEmail)){ // check if email is valid
        jsAlert("Please enter a valid email address");
      } else {
        // check db if user exist
        $getStudentQuery = DB::query("SELECT * FROM student WHERE studentEmail=%s", $loginEmail);
        $studentExist = DB::count(); // if user exist. BOTH Email & Password exist.
        foreach($getStudentQuery as $getStudentResult){
          $getDBStudentName = $getStudentResult["studentName"];
          $getDBStudentPassword = $getStudentResult["studentPass"];
          $getDBStudentEmail = $getStudentResult["studentEmail"];
        }
  
        if($studentExist){ // user exists (return 1)
          if(password_verify($loginPassword, $getDBStudentPassword)){
            $_SESSION["studentName"] = $getDBStudentName;
            $_SESSION["studentEmail"] = $loginEmail;  
            jsRedirect(SITE_ROOT . "profile.php");
          } else {
            jsAlert("password invalid");
          }
          } 
         else { // user does not exist
          jsAlert("Email invalid. Please try again.");
        }
      }
    }
  }
  elseif($loginPortal == "Teacher"){
    if($loginEmail == "" || $loginPassword == ""){ // check if email and password are filled
      jsAlert("Please fill up your email address and password.");
    } else {
      if(!isValidEmail($loginEmail)){ // check if email is valid
        jsAlert("Please enter a valid email address");
      } else {
        // check db if user exist
        $getTeacherQuery = DB::query("SELECT * FROM teacher WHERE teacherEmail=%s", $loginEmail);
        $teacherExist = DB::count(); // if user exist. BOTH Email & Password exist.
        foreach($getTeacherQuery as $getTeacherResult){
          $getDBTeacherName = $getTeacherResult["teacherName"];
          $getDBTeacherPassword = $getTeacherResult["teacherPass"];
          $getDBTeacherEmail = $getTeacherResult["teacherEmail"];
        }
  
        if($teacherExist){ // user exists (return 1)
          if(password_verify($loginPassword, $getDBTeacherPassword)){
            $_SESSION["teacherName"] = $getDBTeacherName;
            $_SESSION["teacherEmail"] = $loginEmail;  
            jsRedirect(SITE_ROOT . "profile-teacher.php");
          } else {
            jsAlert("password invalid");
          }
          } 
         else { // user does not exist
          jsAlert("Email invalid. Please try again.");
        }
      }
    }
  } elseif($loginPortal == "Admin"){
    if($loginEmail == "" || $loginPassword == ""){ // check if email and password are filled
      jsAlert("Please fill up your email address and password.");
    } else {
      if(!isValidEmail($loginEmail)){ // check if email is valid
        jsAlert("Please enter a valid email address");
      } else {
        // check db if user exist
        $getAdminQuery = DB::query("SELECT * FROM admin WHERE adminEmail=%s", $loginEmail);
        $adminExist = DB::count(); // if user exist. BOTH Email & Password exist.
        foreach($getAdminQuery as $getAdminResult){
          $getDBAdminName = $getAdminResult["adminName"];
          $getDBAdminPassword = $getAdminResult["adminPass"];
          $getDBAdminEmail = $getAdminResult["adminEmail"];
        }
  
        if($adminExist){ // user exists (return 1)
          if(password_verify($loginPassword, $getDBAdminPassword)){
            $_SESSION["adminName"] = $getDBAdminName;
            $_SESSION["adminEmail"] = $loginEmail;  
            jsRedirect(SITE_ROOT . "admin.php");
          } else {
            jsAlert("password invalid");
          }
          } 
         else { // user does not exist
          jsAlert("Email invalid. Please try again.");
        }
      }
    }
  }
  else{
    jsRedirect(SITE_ROOT . "login.php");
  }
}
?>
<body>
<div id="login">

<h1><strong>Welcome.</strong> Please login.</h1>

<form method="POST">
  <fieldset>
    <p><input type="text" placeholder="Email" name="Email"></p>
    <p><input type="password" placeholder="Password" name="Password"></p>
    <input type="radio" name="portal" value="Teacher">
    <label for="Teacher">Teacher</label><br>
    <input type="radio" name="portal" value="Student">
    <label for="Student">Student</label><br>
    <input type="radio" name="portal" value="Admin">
    <label for="Admin">Admin</label><br>
    <p><input type="submit" value="Login" name="login"></p>
  </fieldset>
</form>

<p><span class="btn-round">or</span></p>

<p>
  <a href="<?php echo SITE_ROOT; ?>register.php" class="newUser-before"></a>
  <button class="newUser"><a href="<?php echo SITE_ROOT; ?>register.php">Create a new account</a></button>
</p>

</div>
</body>
</html>