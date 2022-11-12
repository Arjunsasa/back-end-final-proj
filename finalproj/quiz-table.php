<?php
include "lib/config.php";
include "lib/functions.php";
include "lib/db.class.php";
session_start();
if(!isLoggedIn()){
  jsRedirect(SITE_ROOT . "login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Quizzard Quizzes</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Quizzard</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">A. Fellow</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Admin Fellow</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo SITE_ROOT . "signout.php"?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Please Select a Quiz</h1>
      <button class="btn btn-info"><a href="<?php echo SITE_ROOT; ?>add-quiz.php">Create Quiz</a></button>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12"> 
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Quizzes</h5>
              <!-- Table with hoverable rows -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Quiz</th>
                    <th scope="col">Description</th>
                    <th scope="col">Difficulty</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $allQuizQuery = DB::query("SELECT * FROM quiz");
                foreach($allQuizQuery as $allQuizResult){
                    $allQuizID = $allQuizResult["quizID"];
                    $allQuizName = $allQuizResult["quizName"];
                    $allQuizDes = $allQuizResult["quizDesc"];
                    $allQuizDiff = $allQuizResult["quizDiff"];
                ?>
                  <tr>
                    <th scope="row"><?php echo $allQuizID; ?></th>
                    <td><?php echo $allQuizName; ?></td>
                    <td><?php echo $allQuizDes; ?></td>
                    <td><?php echo $allQuizDiff; ?></td>
                    <td>
                        <a href="<?php echo SITE_ROOT; ?>create-questions.php?quizID=<?php echo $allQuizID?>"><i class="bi bi-pencil-square me-3 fs-5"></i></a>
                        <a href="<?php echo SITE_ROOT; ?>quiz.php?quizID=<?php echo $allQuizID?>"><i class="fa-solid fa-play me-3 fs-5"></i></a>
                    </td>
                  </tr>
                <?php
                }
                ?>  
                </tbody>
              </table>
              <!-- End Table with hoverable rows -->
            </div>
          </div>
        </div>
        

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Arjun</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/e420ddd349.js" crossorigin="anonymous"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>