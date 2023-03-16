<?php
require_once '../config/dbconnect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"]) || $_SESSION["usertype"] != 'admin') {
    // Redirect to login page
    header("Location: ../login.html");
}

$username = $_SESSION["username"];

if (isset($_GET['cancel']) && isset($_GET['reservationID']) && isset($_GET['carID'])) {
    $reservationID = mysqli_real_escape_string($conn, $_GET['reservationID']);
    $carID = mysqli_real_escape_string($conn, $_GET['carID']);
    $sql = "DELETE FROM reservations WHERE reservationID = $reservationID";
    mysqli_query($conn, $sql);
    $sql = "UPDATE cars SET available = 1 WHERE CarID='$carID'";
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>
        Argon Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <style>
        #edit-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        a:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            color: white;
        }
    </style>
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" target="_blank">
                <img src="./assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Carsons</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./reserv.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Reservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./users.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
          <a class="nav-link active" href="./users.php">
            <div class="mt-2 mb-5 d-flex">
              <h6 class="mb-0">Light / Dark</h6>
              <div class="form-check form-switch ps-0 ms-auto my-auto">
                <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
              </div>
            </div>
          </a>
        </li> -->


            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Users</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Admin</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Admin</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="../auth/logout.php" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>User table</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Car</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pickup Date</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Return Date</th>
                                            <th class="text-secondary opacity-7"></th>
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT u.UserName,u.UserType,u.Avatar, r.PickupDate, r.ReturnDate, r.TotalPrice, r.Status, r.ReservationID, c.Make, c.Model, c.ViewCar, c.CarID 
                                        FROM reservations r 
                                        JOIN users u ON r.userID = u.userID 
                                        JOIN cars c ON r.carID = c.carID";
                                        $result = $conn->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo "<div class='d-flex px-2 py-1'>";
                                            echo "<div>";
                                            echo "<img src='" . $row["Avatar"] . "' class='avatar avatar-lg rounded-circle me-4' style='object-fit: cover;'>";
                                            echo "</div>";
                                            echo "<div class='d-flex flex-column justify-content-center'>";
                                            echo "<h6 class='mb-0 text-sm'>" . ucwords($row["UserName"]) . "</h6>";
                                            echo "<p class='text-xs text-secondary mb-0'>" . $row["UserName"] . "</p>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "<td>";
                                            echo "<div class='d-flex px-2 py-1'>";
                                            echo "<div>";
                                            echo "<img src='" . $row["ViewCar"] . "' class='avatar avatar-lg rounded-circle me-4' style='object-fit: cover;'>";
                                            echo "</div>";
                                            echo "<div class='d-flex flex-column justify-content-center'>";
                                            echo "<h6 class='mb-0 text-sm'>" . $row["Make"] . "</h6>";
                                            echo "<p class='text-xs text-secondary mb-0'>" . $row["Model"] . "</p>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</td>";
                                            if ($row["Status"] == "Completed") {
                                                $color = "success";
                                            } else {
                                                $color = "primary";
                                            };
                                            echo "<td class='align-middle text-center text-sm'><span class='badge badge-sm bg-gradient-" . $color . "'>" . $row["Status"] . "</span></td>";

                                            echo "<td class='align-middle text-center text-sm'>" . $row["PickupDate"] . "</td>";
                                            echo "<td class='align-middle text-center text-sm'>" . $row["ReturnDate"] . "</td>";
                                            echo "<td class='align-middle text-center text-sm'></td>";
                                            echo "<td class='align-middle'>";
                                            if ($row["Status"] !== 'Completed') {
                                                echo "<a class='badge badge-sm bg-gradient-danger' href='?cancel=true&reservationID=" . $row["ReservationID"] . "&carID=" . $row["CarID"] . "'>Delete</a>";
                                            }
                                            echo "</td>";

                                            echo "</tr>";
                                        }

                                        ?>
                                    </tbody>
                                </table>
                                <button id="edit-btn" style="display:none">Edit User</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-lg" id="edit-form" style="display:none">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit User</p>
                            </div>
                        </div>
                        <form method="post">
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" id="edit-id" name="edit_id">
                                            <label class="form-control-label" for="new-username">New Username:</label>
                                            <input class="form-control" type="text" id="new-username" name="new_username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email address</label>
                                            <input class="form-control" type="email" value="jesse@example.com">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">About me</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="new-usertype">New UserType:</label>
                                            <input class="form-control" type="text" type="text" id="new-usertype" name="new_usertype">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit">Save</button>
                                <button type="button" onclick="hideEditForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </main>

    <script>
        function showEditForm(edit_id, username, usertype) {
            document.getElementById("edit-id").value = edit_id;
            document.getElementById("new-username").value = username;
            document.getElementById("new-usertype").value = usertype;
            document.getElementById("edit-form").style.display = "block";
        }

        function hideEditForm() {
            document.getElementById("edit-form").style.display = "none";
        }
    </script>





    <!--   Core JS Files   -->
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>