<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
if(!isAdmin()){
    jsRedirect(SITE_ROOT . "signout.php");
}
?>
<?php
$pageName = " teacher-edit";
include "lib/header.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/registerStyles.css">
</head>

<?php

if(!isset($_GET["teacherID"]) || $_GET["teacherID"] == ""){
    jsRedirect(SITE_ROOT . "admin.php");
} else {
    $getTeacherQuery = DB::query("SELECT * FROM teacher WHERE teacherID=%i", $_GET["teacherID"]);
    foreach($getTeacherQuery as $getTeacherResult){
        $teacherDBName = $getTeacherResult["teacherName"];
        $teacherDBEmail = $getTeacherResult["teacherEmail"];
        $teacherDBBio = $getTeacherResult["teacherDes"];
        $teacherDBFB = $getTeacherResult["teacherFB"];
        $teacherDBIG = $getTeacherResult["teacherIstg"];
        $teacherDBphone = $getTeacherResult["teacherPhone"];
        $teacherDBClass = $getTeacherResult["teacherClass"];
    }
}

if(isset($_POST["editTeacher"])){
    $editTeacherName = filterInput($_POST["name"]); //filter the input and grab the name from the input field
    $editTeacherEmail = filterInput($_POST["email"]);
    $editTeacherPass = filterInput($_POST["pass"]);
    $editTeacherconfirmP = filterInput($_POST["cPass"]);
    $editTeacherDesc = filterInput($_POST["desc"]);
    $editTeacherFB = filterInput($_POST["FB"]);
    $editTeacherIG = filterInput($_POST["IG"]);
    $editTeacherPhone = filterInput($_POST["phone"]);
    $editTeacherClass = filterInput($_POST["class"]);

    if($editTeacherName != "" && $editTeacherEmail != "" && $editTeacherPhone != ""){
        if(isValidEmail($editTeacherEmail)){
            if(isValidPhone($editTeacherPhone)){
                if($editTeacherPass == $editTeacherconfirmP){
                    DB::startTransaction();
                    if($editTeacherPass == ""){ // Do not change password
                        DB::update('teacher', [
                            'teacherName' => $editTeacherName,
                            'teacherEmail' => $editTeacherEmail,
                            'teacherDes' => $editTeacherDesc,
                            'teacherFB' => $editTeacherFB,
                            'teacherIstg' => $editTeacherIG,
                            'teacherPhone' => $editTeacherPhone,
                            'teacherClass' => $editTeacherClass
                        ], "teacherID=%i", $_GET["teacherID"]);
                    } else { // Change Password
                        DB::update('teacher', [
                            'teacherName' => $editTeacherName,
                            'teacherEmail' => $editTeacherEmail,
                            'teacherPass' => password_hash($editTeacherPass, PASSWORD_DEFAULT),
                            'teacherDes' => $editTeacherDesc,
                            'teacherFB' => $editTeacherFB,
                            'teacherIstg' => $editTeacherIG,
                            'teacherPhone' => $editTeacherPhone,
                            'teacherClass' => $editTeacherClass
                        ], "teacherID=%i", $_GET["teacherID"]);
                    }

                    $success = DB::affectedRows();
                    if($success){
                        jsAlert("Update Success");
                        DB::commit();
                        jsRedirect(SITE_ROOT . "edit-teacher.php?userID=" . $_GET["teacherID"]);
                    } else {
                        jsAlert("Insert Fail");
                        DB::rollback();
                    }
                }else {
                //passwords do not match
                $errorMsg = "passwords do not match";
                jsAlert("passwords do not match");
            }
            } else {
                //phone no. is Not Valid
                $errorMsg = "phone no. is Not Valid";
                jsAlert("phone no. is Not Valid");
            }
        } else {
            //Email is Not Valid
            $errorMsg = "invalid-email";
            jsAlert("invalid-email");
        }
    } else {
        //Empty fields
        $errorMsg = "empty-fields";
        jsAlert("empty-fields");
    }  
}

?>
<body>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card">
     <h2 class="card-title text-center">Edit Profile</a></h2>
      <div class="card-body py-md-4">
       <form method="POST">
            <div class="form-group">
             <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $teacherDBName; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $teacherDBEmail; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="IG" placeholder="Instagram" value="<?php echo $teacherDBIG; ?>">
            </div>                   
            <div class="form-group">
                <input type="text" class="form-control" name="FB" placeholder="Facebook" value="<?php echo $teacherDBFB; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Phone No." value="<?php echo $teacherDBphone; ?>">
            </div>
            <div class="form-group">
                <input type="textarea" class="form-control" name="desc" placeholder="Short description" value="<?php echo $teacherDBBio; ?>">
            </div>                      
            <div class="form-group">
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="cPass" placeholder="confirm-password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="class" placeholder="Class" value="<?php echo $teacherDBClass; ?>">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
            <button class="btn btn-primary" type="submit" name="editTeacher">Edit Profile</button>
            </div>
       </form>
     </div>
  </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>