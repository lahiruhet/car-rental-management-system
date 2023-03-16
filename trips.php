<?php
require_once './config/dbconnect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"]) || $_SESSION["usertype"] != 'user') {
  // Redirect to login page
  header("Location: ./login.html");
}

$username = $_SESSION["username"];

if (isset($_GET['cancel']) && isset($_GET['reservationID'])) {
  $reservationID = mysqli_real_escape_string($conn, $_GET['reservationID']);
  $sql = "DELETE FROM reservations WHERE reservationID = $reservationID";
  mysqli_query($conn, $sql);
}

$sql = "SELECT * FROM users WHERE UserName='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$userid = $row["UserID"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Carbook - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Font Awesome Icons -->
  <link href="./assets/css/font-awesome.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link id="pagestyle" href="./admin/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />


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
  <style>
    a:hover {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      color: white;
    }
  </style>
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
          <li class="nav-item"><a href="./profile.php" class="nav-link"><?php echo ucwords($row['UserName']); ?></a></li>
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



  <section class="hero-wrap " style="background-image: url('images/bg_2.jpg');">
    <div class="overlay"></div>
    <div class=" container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center heading-section ftco-animate">
        </div>
      </div>
      <div class="row ftco-animate align-items-center" style="margin-top: 200px;">
        <div class="col-md-12">
          <div class="container">
            <div class="px-4 card card-profile shadow mt--300">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 ">Car</th>
                      <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 align-middle text-center text-sm">Status</th>
                      <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 ">Date</th>
                      <th class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 ps-2">Fair</th>
                      <th class="text-uppercase text-dark text-xxs font-weight-bolder text-center opacity-7 ps-2">Rating</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $sql = "SELECT reservations.PickupDate, reservations.TotalPrice, reservations.Status, reservations.ReservationID, cars.ViewCar, cars.Make, cars.Model\n"
                      . "FROM reservations\n"
                      . "INNER JOIN cars ON reservations.carID = cars.carID\n"
                      . "WHERE reservations.UserID = $userid;";


                    $result = mysqli_query($conn, $sql);

                    // Query the database to retrieve all users
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>';
                      echo '<td>';
                      echo '<div class="d-flex">';
                      echo '<div>';
                      echo '<img class="avatar avatar-lg rounded-circle me-4" style="object-fit: cover;" src="' . $row['ViewCar'] . '">';
                      echo '</div>';
                      echo '<div class="my-auto">';
                      echo '<h6 class="mb-0 text-sm">' . $row['Make'] . ' ' . $row['Model'] . '</h6>';
                      echo '</div>';
                      echo '</div>';
                      echo '</td>';
                      if ($row["Status"] == "Completed") {
                        $color = "success";
                      } else {
                        $color = "primary";
                      };
                      echo "<td class='align-middle text-center text-sm'><span class='badge badge-sm bg-gradient-" . $color . "'>" . $row["Status"] . "</span></td>";
                      echo '<td>' . $row['PickupDate'] . '</td>';
                      echo '<td><p class="text-sm font-weight-bold mb-0">LKR' . $row['TotalPrice'] . '</p></td>';
                      echo "<td class='align-middle'>";
                      if ($row["Status"] !== 'Completed') {
                        echo "<a class='badge badge-sm bg-gradient-danger' href='?cancel=true&reservationID=" . $row["ReservationID"] . "'>Delete</a>";
                      }
                      echo "</td>";
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

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