<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['USERNAME'])) {
  header("location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" type="image/ico" href="img/logo1.ico" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- font-awesome link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/fontawesome.min.css" integrity="sha512-kJ30H6g4NGhWopgdseRb8wTsyllFUYIx3hiUwmGAkgA9B/JbzUBDQVr2VVlWGde6sdBVOG7oU8AL35ORDuMm8g==" crossorigin="anonymous" />


  <style>
    body {
      overflow-x: hidden;
    }

    /* sidebar style starts  */

    .center {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .sidenav a {
      text-decoration: none;
      font-size: 14px;
      color: #fff;
      display: block;
      padding: 20px 0 20px 20px;
    }

    .sidenav a:hover {
      color: rgba(255, 255, 255, 0.7);
    }

    /* sidebar style ends  */
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include 'slider.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <!-- Begin Page Content -->
        <div class="container-fluid">


          <div class="row">
            <!-- Bar1 -->
            <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Size Wise Bill</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myBarChart2"></canvas>
                  </div>
                </div>
              </div>
            </div>



            <!-- Pie Chart 2 -->
            <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">BUILDING TYPE</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart2"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Bar Chart  -->
            <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">WARD Wise Bill</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myBarChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bar2 -->
            <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">AREA TYPE</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Bar2 -->
          </div>


          <!-- End of Main Content -->
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->


  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- footer starts -->
  <div class="row footer center" style="background-color: #34495e; color: #fff; height: 80px;">
    <div class="title">
      <strong>Powered By Isaam Enterprise Limited</strong>
    </div>
  </div>
  <!-- footer ends -->

  <!-- Scroll to Top Button-->
  <!-- <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a> -->

  <!-- Logout Modal-->
  <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
      </div>
    </div>
  </div> -->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <?php include 'Connection.php';
  $AREA_TYPE_NAME = "[";
  $AMOUNT = "[";
  //$sql = "select AREA_TYPE_NAME,sum(amount) AMOUNT from v_bill group by AREA_TYPE_NAME";
  $parseresults = ociparse($conn, $sql);
  ociexecute($parseresults);

  while ($row = oci_fetch_assoc($parseresults)) {
    $AREA_TYPE_NAME .= '"' . $row['AREA_TYPE_NAME'] . '",';
    $AMOUNT .= '"' . $row['AMOUNT'] . '",';
  }
  $AREA_TYPE_NAME = substr($AREA_TYPE_NAME, 0, -1);
  $AMOUNT = substr($AMOUNT, 0, -1);
  $AREA_TYPE_NAME = $AREA_TYPE_NAME . ']';
  $AMOUNT = $AMOUNT . ']';

  $BUILDING_TYPE_NAME = "[";
  $AMOUNT1 = "[";
  //$sql1 = "select BUILDING_TYPE_NAME,sum(amount) AMOUNT1 from v_bill group by BUILDING_TYPE_NAME";
  $parseresults1 = ociparse($conn, $sql1);
  ociexecute($parseresults1);

  while ($row1 = oci_fetch_assoc($parseresults1)) {
    $BUILDING_TYPE_NAME .= '"' . $row1['BUILDING_TYPE_NAME'] . '",';
    $AMOUNT1 .= '"' . $row1['AMOUNT1'] . '",';
  }
  $BUILDING_TYPE_NAME = substr($BUILDING_TYPE_NAME, 0, -1);
  $AMOUNT1 = substr($AMOUNT1, 0, -1);
  $BUILDING_TYPE_NAME = $BUILDING_TYPE_NAME . ']';
  $AMOUNT1 = $AMOUNT1 . ']';

  $WARD_NAME = "[";
  $AMOUNT2 = "[";
  //$sql2 = "select  WARD_NAME,sum(amount) AMOUNT2 from v_bill group by ward_name order by ward_name";
  $parseresults2 = ociparse($conn, $sql2);
  ociexecute($parseresults2);

  while ($row2 = oci_fetch_assoc($parseresults2)) {
    $WARD_NAME .= '"' . $row2['WARD_NAME'] . '",';
    $AMOUNT2 .= '"' . $row2['AMOUNT2'] . '",';
  }
  $WARD_NAME = substr($WARD_NAME, 0, -1);
  $AMOUNT2 = substr($AMOUNT2, 0, -1);
  $WARD_NAME = $WARD_NAME . ']';
  $AMOUNT2 = $AMOUNT2 . ']';

  $SIZE_NAME = "[";
  $AMOUNT3 = "[";
  // $sql2 = "select SIZE_NAME,sum(amount) AMOUNT3 from v_bill group by SIZE_NAME";
  $parseresults2 = ociparse($conn, $sql2);
  ociexecute($parseresults2);

  while ($row2 = oci_fetch_assoc($parseresults2)) {
    $SIZE_NAME .= '"' . $row2['SIZE_NAME'] . '",';
    $AMOUNT3 .= '"' . $row2['AMOUNT3'] . '",';
  }
  $SIZE_NAME = substr($SIZE_NAME, 0, -1);
  $AMOUNT3 = substr($AMOUNT3, 0, -1);
  $SIZE_NAME = $SIZE_NAME . ']';
  $AMOUNT3 = $AMOUNT3 . ']';
  oci_free_statement($parseresults);
  oci_close($conn); ?>
  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';


    // Pie Chart 1
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: <?php echo "$AREA_TYPE_NAME" ?>,
        datasets: [{
          data: <?php echo "$AMOUNT" ?>,
          backgroundColor: ['#4e73df', '#1cc88a'],
          hoverBackgroundColor: ['#2e59d9', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 50,
      },
    });
    // Pie Chart 2
    var ctx = document.getElementById("myPieChart2").getContext('2d');
    var myPieChart2 = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: <?php echo "$BUILDING_TYPE_NAME" ?>,
        datasets: [{
          data: <?php echo "$AMOUNT1" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 50,
      },
    });

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$WARD_NAME" ?>,
        datasets: [{
          label: 'WARD Wise Bill',
          data: <?php echo "$AMOUNT2" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
          borderWidth: 1
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
    // Bar Chart 2
    var ctx = document.getElementById("myBarChart2").getContext('2d');
    var myBarChart2 = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$SIZE_NAME" ?>,
        datasets: [{
          label: 'Size Wise Bill',
          data: <?php echo "$AMOUNT3" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
          borderWidth: 1
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>

</body>

</html>