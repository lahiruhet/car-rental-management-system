<?php
session_start();

if (!isset($_SESSION['username'])) {
  // User is not logged in
  header('Location: ./login.html');
  exit();
}

$username = $_SESSION['username'];
require_once './config/dbconnect.php';


$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE username = ?');
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$userid = $user["UserID"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Carbook - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">Carsons</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="./profile.php" class="nav-link"><?php echo ucwords($user['UserName']); ?></a></li>
          <li class="nav-item"><a href="./trips.php" class="nav-link">My Trips</a></li>
          <li class="nav-item"><a href="./reserve.php" class="nav-link">Reserve</a></li>
          <li class="nav-item btn btn-primary rounded" style="padding: 0px;"><a href="./auth/logout.php" class="nav-link">Log
              Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->



  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class=" container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center heading-section ftco-animate">
        </div>
      </div>
      <div class="row ftco-animate align-items-center" style="margin-top: 200px; margin-left:300px; width: 500px;">
        <div class="col-md-12">
          <div class="item">
            <div class="testimony-wrap rounded text-center py-4 pb-5">
              <div class="user-img mb-2" style="background-image: url(<?php echo $user['Avatar']; ?>)">
              </div>
              <div class="text pt-4">
                <p class="name"><?php echo ucwords($user['UserName']); ?></p>
                <span class="position">User</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <?php

  $sql = "SELECT reservations.PickupDate, reservations.TotalPrice, reservations.Status, reservations.ReservationID, cars.ViewCar, cars.Make, cars.Model\n"
    . "FROM reservations\n"
    . "INNER JOIN cars ON reservations.carID = cars.carID\n"
    . "WHERE reservations.UserID = $userid;";


  $result = mysqli_query($conn, $sql);
  ?>
  <section class="ftco-counter ftco-section img" id="section-counter" style="padding: 30px 0 0 120px;">
    <div class="container">
      <div class="row">
        <div class="col-md-4 justify-content-center counter-wrap ftco-animate">
          <div class="block-18">
            <div class="text text-border d-flex align-items-center">
              <strong class="number" data-number="<?php echo $num_rows = mysqli_num_rows($result); ?>">0</strong>
              <span>Past trips</span>
            </div>
          </div>
        </div>
        <div class="col-md-4 justify-content-center counter-wrap ftco-animate">
          <div class="block-18">
            <div class="text text-border d-flex align-items-center">
              <strong class="number" data-number="<?php echo $num_rows = mysqli_num_rows($result); ?>">2</strong>
              <span>Upcoming <br>trips</span>
            </div>
          </div>
        </div>
        <div class="col-md-4 justify-content-center counter-wrap ftco-animate">
          <div class="block-18">
            <div class="text text-border d-flex align-items-center">
              <strong class="number" data-number="<?php if (mysqli_num_rows($result) > 0) {
                                                    echo '10000';
                                                  } else {
                                                    echo '0';
                                                  } ?>">0</strong>
              <span>Loyalty <br>Status</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>







  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

</body>

</html>