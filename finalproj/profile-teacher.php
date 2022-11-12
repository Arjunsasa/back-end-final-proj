<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
if(!isTeacher()){
    jsRedirect(SITE_ROOT . "signout.php");
}

?>
<?php
$pageName = " teacher";
include "lib/header.php";
 ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php    
$allTeacherQuery = DB::query("SELECT * FROM teacher WHERE teacherEmail=%s", $_SESSION["teacherEmail"]);
    foreach($allTeacherQuery as $allTeacherResult){
        $allTeacherID = $allTeacherResult["teacherID"];
        $allTeacherName = $allTeacherResult["teacherName"];
        $allTeacherEmail = $allTeacherResult["teacherEmail"];
        $allTeacherDes = $allTeacherResult["teacherDes"];
        $allTeacherFB = $allTeacherResult["teacherFB"];
        $allTeacherIG = $allTeacherResult["teacherIstg"];
        $allTeacherPhone = $allTeacherResult["teacherPhone"];
        $allTeacherClass = $allTeacherResult["teacherClass"];
    }
?>   
<div class="container mt-5">
    
    <div class="row d-flex justify-content-center">
        
        <div class="col-md-7">
            
            <div class="card p-3 py-4">
                <div class="text-center mt-3">
                    <span class="bg-secondary p-1 px-4 rounded text-white">Teacher</span>
                    <h5 class="mt-2 mb-0"><?php echo $allTeacherName?></h5>
                    <span>Class: <?php echo $allTeacherClass?></span>
                    <div class="px-4 mt-1">
                        <p class="fonts"><?php echo $allTeacherDes?></p>
                        <p class="fonts">Contact no: <?php echo $allTeacherPhone?></p>
                        <p class="fonts">Email: <?php echo $allTeacherEmail?></p>
                    </div>
                    
                     <ul class="social-list">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
        
                    <div class="buttons">
                        <button class="btn btn-outline-primary px-4 ms-3"><a class="" href="<?php echo SITE_ROOT; ?>signout.php">Sign Out</a></button>
                        <button class="btn btn-outline-primary px-4 ms-3"><a class="" href="<?php echo SITE_ROOT; ?>quiz-table.php">Quiz</a></button>
                    </div>  
                </div>   
            </div>   
        </div>
        
    </div>
    
</div>
<!-- scripts -->
<script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>
</html>