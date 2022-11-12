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
$pageName = " student-edit";
include "lib/header.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/registerStyles.css">
</head>

<?php

if(!isset($_GET["studentID"]) || $_GET["studentID"] == ""){
    jsRedirect(SITE_ROOT . "admin.php");
} else {
    $getStudentQuery = DB::query("SELECT * FROM student WHERE studentID=%i", $_GET["studentID"]);
    foreach($getStudentQuery as $getStudentResult){
        $studentDBName = $getStudentResult["studentName"];
        $studentDBEmail = $getStudentResult["studentEmail"];
        $studentDBBio = $getStudentResult["studentDes"];
        $studentDBFB = $getStudentResult["studentFB"];
        $studentDBIG = $getStudentResult["studentInstg"];
        $studentDBphone = $getStudentResult["studentPhone"];
        $studentDBClass = $getStudentResult["studentClass"];
    }
}

if(isset($_POST["editStudent"])){
    $editStudentName = filterInput($_POST["name"]); //filter the input and grab the name from the input field
    $editStudentEmail = filterInput($_POST["email"]);
    $editStudentPass = filterInput($_POST["pass"]);
    $editStudentconfirmP = filterInput($_POST["cPass"]);
    $editStudentDesc = filterInput($_POST["desc"]);
    $editStudentFB = filterInput($_POST["FB"]);
    $editStudentIG = filterInput($_POST["IG"]);
    $editStudentPhone = filterInput($_POST["phone"]);
    $editStudentClass = filterInput($_POST["class"]);

    if($editStudentName != "" && $editStudentEmail != "" && $editStudentPhone != ""){
        if(isValidEmail($editStudentEmail)){
            if(isValidPhone($editStudentPhone)){
                if($editStudentPass == $editStudentconfirmP){
                    DB::startTransaction();
                    if($editStudentPass == ""){ // Do not change password
                        DB::update('student', [
                            'studentName' => $editStudentName,
                            'studentEmail' => $editStudentEmail,
                            'studentDes' => $editStudentDesc,
                            'studentFB' => $editStudentFB,
                            'studentInstg' => $editStudentIG,
                            'studentPhone' => $editStudentPhone,
                            'studentClass' => $editStudentClass
                        ], "studentID=%i", $_GET["studentID"]);
                    } else { // Change Password
                        DB::update('student', [
                            'studentName' => $editStudentName,
                            'studentEmail' => $editStudentEmail,
                            'studentPass' => password_hash($editStudentPass, PASSWORD_DEFAULT),
                            'studentDes' => $editStudentDesc,
                            'studentFB' => $editStudentFB,
                            'studentInstg' => $editStudentIG,
                            'studentPhone' => $editStudentPhone,
                            'studentClass' => $editStudentClass
                        ], "studentID=%i", $_GET["studentID"]);
                    }

                    $success = DB::affectedRows();
                    if($success){
                        jsAlert("Update Success");
                        DB::commit();
                        jsRedirect(SITE_ROOT . "edit-student.php?userID=" . $_GET["studentID"]);
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
             <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $studentDBName; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $studentDBEmail; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="IG" placeholder="Instagram" value="<?php echo $studentDBIG; ?>">
            </div>                   
            <div class="form-group">
                <input type="text" class="form-control" name="FB" placeholder="Facebook" value="<?php echo $studentDBFB; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Phone No." value="<?php echo $studentDBphone; ?>">
            </div>
            <div class="form-group">
                <input type="textarea" class="form-control" name="desc" placeholder="Short description" value="<?php echo $studentDBBio; ?>">
            </div>                      
            <div class="form-group">
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="cPass" placeholder="confirm-password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="class" placeholder="Class" value="<?php echo $studentDBClass; ?>">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
            <button class="btn btn-primary" type="submit" name="editStudent">Edit Profile</button>
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