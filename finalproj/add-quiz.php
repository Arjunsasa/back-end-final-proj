<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}
if(isStudent()){
    jsRedirect(SITE_ROOT . "quiz-table.php");
}
?>
<?php
$pageName = " Registration";
include "lib/header.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/registerStyles.css">
</head>

<?php
$newQuizName = $newQuizDesc = $newQuizDiff = "";

if(isset($_POST["createQuiz"])){
    $newQuizName = filterInput($_POST["quizName"]); //filter the input and grab the name from the input field
    $newQuizDesc = filterInput($_POST["quizDesc"]);
    $newQuizDiff = filterInput($_POST["quizDiff"]);

    if($newQuizName != "" && $newQuizDiff != ""){
        DB::startTransaction();
        DB::insert('quiz', [
            'quizName' => $newQuizName,
            'quizDesc' => $newQuizDesc,
            'quizDiff' => $newQuizDiff,
        ]);
        $success = DB::affectedRows();
        if($success){
            jsAlert("Insert Success");
            DB::commit();
            jsRedirect(SITE_ROOT . "quiz-table.php");
        } else {
            jsAlert("Insert Fail");
            DB::rollback();
        }
    } else{
        $errorMsg = "Please enter both a name and a difficulty";
        jsAlert("Please enter both a name and a difficulty");  
    }
}
?>
<body>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card">
     <h2 class="card-title text-center">Create your Quiz</a></h2>
      <div class="card-body py-md-4">
       <form method="POST">
            <div class="form-group">
             <input type="text" class="form-control" name="quizName" placeholder="Title of your quiz E.g. Maths" value="<?php echo $newQuizName; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="quizDesc" placeholder="Quiz Description E.g. math quiz from chapter 3-6" value="<?php echo $newQuizDesc; ?>">
            </div>                   
            <div class="form-group">
                <input type="text" class="form-control" name="quizDiff" placeholder="Please state a difficulty E.g. medium" value="<?php echo $newQuizDiff; ?>">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
            <button class="btn btn-primary" type="submit" name="createQuiz">Create Quiz</button>
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
</body>
</html>