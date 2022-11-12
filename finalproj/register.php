<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
?>
<?php
$pageName = " Registration";
include "lib/header.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/registerStyles.css">
</head>

<?php
$newName = $newEmail = $newPass = $confirmP = $newDesc = $newFB = $newIG = $newPhone = "";
$newClass = 0;

if(isset($_POST["register"])){
    $newName = filterInput($_POST["name"]); //filter the input and grab the name from the input field
    $newEmail = filterInput($_POST["email"]);
    $newPass = filterInput($_POST["pass"]);
    $confirmP = filterInput($_POST["cPass"]);
    $newDesc = filterInput($_POST["desc"]);
    $newFB = filterInput($_POST["FB"]);
    $newIG = filterInput($_POST["IG"]);
    $newPhone = filterInput($_POST["phone"]);

    if($newName != "" && $newEmail != "" && $newPass != "" && $confirmP != "" && $newPhone != ""){
        if(isValidEmail($newEmail)){
            if(isValidPhone($newPhone)){
                if($newPass == $confirmP){
                    DB::startTransaction();
                    DB::insert('student', [
                        'studentName' => $newName,
                        'studentEmail' => $newEmail,
                        'studentPass' => password_hash($newPass, PASSWORD_DEFAULT),
                        'studentPhone' => $newPhone,
                        'studentInstg' => $newIG,
                        'studentFB' => $newFB,
                        'studentDes' => $newDesc,
                        'studentClass' => $newClass
                    ]);
                    $success = DB::affectedRows();
                    if($success){
                        jsAlert("Insert Success");
                        DB::commit();
                        jsRedirect(SITE_ROOT . "login.php");
                    } else {
                        jsAlert("Insert Fail");
                        DB::rollback();
                    }
                } else{
                    $errorMsg = "passwords do not match";
                    jsAlert("passwords do not match");
                }
            } else{
                $errorMsg = "Phone number is not valid";
                jsAlert("invalid-phone-number");
            }
        } else{
            $errorMsg = "invalid-email";
            jsAlert("invalid-email");
        }
    } else {
        $errorMsg = "please fill up required fields";
        jsAlert("please fill up required fields");
}
}
?>
<body>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card">
        <div>Search user:</div> 
        <input type="text" name="search" id="search" placeholder="Search" class="form-control" />
        <div id="result"></div>
        <br>
     <h2 class="card-title text-center">Register your account</a></h2>
      <div class="card-body py-md-4">
       <form method="POST">
            <div class="form-group">
             <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $newName; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $newEmail; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="IG" placeholder="Instagram" value="<?php echo $newIG; ?>">
            </div>                   
            <div class="form-group">
                <input type="text" class="form-control" name="FB" placeholder="Facebook" value="<?php echo $newFB; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Phone No." value="<?php echo $newPhone; ?>">
            </div>
            <div class="form-group">
                <input type="textarea" class="form-control" name="desc" placeholder="Short description" value="<?php echo $newDesc; ?>">
            </div>                      
            <div class="form-group">
                <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="cPass" placeholder="confirm-password">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
            <a href="<?php echo SITE_ROOT?>login.php">Login</a>
            <button class="btn btn-primary" type="submit" name="register">Create Account</button>
            </div>
       </form>
     </div>
  </div>
</div>
</div>
</div>
<!-- Jquery and Bootstrap Script -->
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<!-- Ajax Script -->
<script>
        $(document).ready(function(){
            load_data();
            function load_data(query){
                $.ajax({
                    url: "search-user.php",
                    method: "POST",
                    data:{
                        query: query
                    },
                    success:function(data){
                        $('#result').html(data);
                    }
                });
            }

            $('#search').keyup(function(){
                var search = $(this).val();
                if(search != ''){
                    load_data(search);
                } else {
                    load_data();
                }
            });
        });
</script>

</body>
</html>