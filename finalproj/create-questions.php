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
$pageName = " Question Creation";
include "lib/header.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/registerStyles.css">
</head>

<?php
$newQuestionName = $newQuestionRightAns = $newQuestionFirstWrongAns = $newQuestionSecondWrongAns = $newQuestionThirdWrongAns = $newQuestionFormName = "";
$newQuizID = $_GET["quizID"]; 

if(isset($_POST["addQuestions"])){
    $newQuestionName = filterInput($_POST["questionName"]); //filter the input and grab the name from the input field
    $newQuestionRightAns = filterInput($_POST["questionAns"]);
    $newQuestionFirstWrongAns = filterInput($_POST["questionWrongFirstAns"]);
    $newQuestionSecondWrongAns = filterInput($_POST["questionWrongSecondAns"]);
    $newQuestionThirdWrongAns = filterInput($_POST["questionWrongThirdAns"]);
    $newQuestionFormName = filterInput($_POST["questionFormName"]);

    if($newQuestionName != "" && $newQuestionRightAns != "" && $newQuestionFirstWrongAns != "" && $newQuestionSecondWrongAns != "" && $newQuestionThirdWrongAns != "" && $newQuestionFormName != ""){
        DB::startTransaction();
        DB::insert('questions', [
            'questionName' => $newQuestionName,
            'questionRightAns' => $newQuestionRightAns,
            'questionFirstWrongAns' => $newQuestionFirstWrongAns,
            'questionSecondWrongAns' => $newQuestionSecondWrongAns,
            'questionThirdWrongAns' => $newQuestionThirdWrongAns,
            'questionFormName' => $newQuestionFormName,
            'quizID' => $newQuizID
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
        $errorMsg = "Please fill in all the spaces";
        jsAlert("Please fill in all the spaces");  
    }
}
?>
<body>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card">
     <h2 class="card-title text-center">Add your Questions</a></h2>
      <div class="card-body py-md-4">
       <form method="POST">
            <div class="form-group">
             <input type="text" class="form-control" name="questionName" placeholder="What is your question E.g. 1+1=?" value="<?php echo $newQuestionName; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="questionAns" placeholder="The correct answer" value="<?php echo $newQuestionRightAns; ?>">
            </div>                   
            <div class="form-group">
                <input type="text" class="form-control" name="questionWrongFirstAns" placeholder="First wrong option" value="<?php echo $newQuestionFirstWrongAns; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="questionWrongSecondAns" placeholder="Second wrong option" value="<?php echo $newQuestionSecondWrongAns; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="questionWrongThirdAns" placeholder="Third wrong option" value="<?php echo $newQuestionThirdWrongAns; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="questionFormName" placeholder="To name the question E.g. math1" value="<?php echo $newQuestionFormName; ?>">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
            <button class="btn btn-primary" type="submit" name="addQuestions">Add to question Bank</button>
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