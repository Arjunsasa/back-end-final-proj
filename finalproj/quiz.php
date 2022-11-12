<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
if(!isLoggedIn()){
    jsRedirect(SITE_ROOT . "login.php");
}
?>
<?php
$pageName = " quiz";
include "lib/header.php";
 ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/quiz.css">
</head>
<body>   
<form method="POST">
<div class="container mt-sm-5 my-1">
<?php
    $allQuestionQuery = DB::query("SELECT * FROM questions WHERE quizID=%i", $_GET["quizID"]);
    foreach($allQuestionQuery as $allQuestionResult){
        $allQuestionID = $allQuestionResult["questionID"];
        $allQuestionName = $allQuestionResult["questionName"];
        $allQuestionRightAns = $allQuestionResult["questionRightAns"];
        $allQuestionFirstWrongAns = $allQuestionResult["questionFirstWrongAns"];
        $allQuestionSecondWrongAns = $allQuestionResult["questionSecondWrongAns"];
        $allQuestionThirdWrongAns = $allQuestionResult["questionThirdWrongAns"];
        $allQuestionFormName = $allQuestionResult["questionFormName"];

        $answers = array("$allQuestionRightAns", "$allQuestionFirstWrongAns", "$allQuestionSecondWrongAns", "$allQuestionThirdWrongAns");
        for ($i = 0; $i <= 4; $i++) {
        if(count($answers) == 4){
            shuffle($answers);
            $first = array_pop($answers);
        } elseif(count($answers) == 3){
            shuffle($answers);
            $second = array_pop($answers);
        } elseif(count($answers) == 2){
            shuffle($answers);
            $third = array_pop($answers);
        } elseif(count($answers) == 1){
            shuffle($answers);
            $last = array_pop($answers);
        }
    }
?>
    <div class="question ml-sm-5 pl-sm-5 pt-2">
        <div class="py-2 h5"><b>Question: <?php echo $allQuestionName; ?></b></div>
        <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
            <label class="options"><?php echo $first; ?>
                <input type="radio" name="<?php echo $allQuestionFormName; ?>" value="<?php echo $first; ?>">
                <span class="checkmark"></span>
            </label>
            <label class="options"><?php echo $second; ?>
                <input type="radio" name="<?php echo $allQuestionFormName; ?>" value="<?php echo $second; ?>">
                <span class="checkmark"></span>
            </label>
            <label class="options"><?php echo $third; ?>
                <input type="radio" name="<?php echo $allQuestionFormName; ?>" value="<?php echo $third; ?>">
                <span class="checkmark"></span>
            </label>
            <label class="options"><?php echo $last; ?>
                <input type="radio" name="<?php echo $allQuestionFormName; ?>" value="<?php echo $last; ?>">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
<?php
}
?> 
        <div class="ml-auto mr-sm-5">
            <button class="btn btn-success" type="submit" name="submitAns">Submit</button>
        </div>
    </div>
</div> 
</form>
<?php

if(isset($_POST['submitAns'])){
    $submittedAns = filterInput($_POST["$allQuestionFormName"]);
    if($submittedAns == ""){
        $errorMsg = "answer is blank";
        jsAlert("answer is blank"); 
    } else{
        $_SESSION["submittedAns"] = $submittedAns;
        $errorMsg = "test complete";
        jsAlert("test complete");
        jsRedirect(SITE_ROOT . "signout.php");
    }
}

?> 
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>