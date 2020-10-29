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
    <link rel="icon" href="./img/logo1.ico" type="image/ico">
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <title>Ministry Wise Report</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- font-awesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/fontawesome.min.css" integrity="sha512-kJ30H6g4NGhWopgdseRb8wTsyllFUYIx3hiUwmGAkgA9B/JbzUBDQVr2VVlWGde6sdBVOG7oU8AL35ORDuMm8g==" crossorigin="anonymous" />
    
    <!-- custom css & js  -->
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/main.js" defer></script>
</head>

<body>
    <header>
        <div class="tophead" id="tophead">
            <div class="jumbotron text-center" style="background-color: #272634!important;">
                <form action="" method='post'>
                    <div class="form-row">
                        
                        <!-- menu line starts  -->
                        <div class="col-lg-3 col-md-3 col-3">
                            <span class="menulines" onclick="openNav()" id='bar'>&#9776;</span>
                        </div>
                        <!-- menu line ends  -->

                        <!-- bill cycle select starts  -->
                        <div class="col-lg-3 col-md-3 col-3">
                            <?php
                            include 'Connection.php';
                            $sql = "select BILL_CYCLE_CODE from MIS_BILL_CYCLE_MASTER order by BILL_CYCLE_CODE desc";
                            $parseresults = ociparse($conn, $sql);
                            ociexecute($parseresults);
                            echo '<select name="P_BILL_CYCLE_CODE" id="bill_cycle" class="custom-select text-size form-control">';
                            echo '<option value="">Select Bill Cycle</option>';
                            while ($row = oci_fetch_assoc($parseresults)) {
                                echo '<option value=' . $row['BILL_CYCLE_CODE'] . '>' . $row['BILL_CYCLE_CODE'] . '</option>';
                            }
                            echo '</select>';
                            oci_free_statement($parseresults);
                            oci_close($conn);
                            ?>
                        </div>
                        <!-- bill cycle select ends  -->

                        <!-- submit button starts  -->
                        <div class="col-lg-3 col-md-3 col-3">
                            <input type="submit" class="btn btn-primary text-size" id="submit" name="submit" value="Submit">
                        </div>
                        <!-- submit button ends  -->
                    </div>
                </form>
            </div>
        </div>
    </header>

    <div class="sidenav" id='mySidenav' style="overflow-y: hidden;">
        <a href="javascrpit:void(0)" class="closebtn text-right mr-4" onclick="closeNav()">&times;</a>
        <div class="logo">
            <img src="./img/Logo.png" alt="" height='60px' width='60px'>
        </div>
        <div class="dashboard">
            <h1 class='mt-2'>Dashboard</h1>
        </div>
        <a href="./zoneWiseReport.php"><i class="fas fa-chart-bar mr-2"></i>Zone Wise</a>
        <a href="./circleWiseReport.php"><i class="fas fa-chart-bar mr-2"></i>Circle Wise</a>
        <a href="./locationWiseReport.php"><i class="fas fa-chart-bar mr-2"></i>Location Wise</a>
        <a href="./customerWiseReport.php"><i class="fas fa-chart-bar mr-2"></i>Customer Wise</a>
        <a href="./ministryWiseReport.php"><i class="fas fa-chart-bar mr-2"></i>Ministry Wise</a>
        <a href="logout.php"><img src="./svg/logout.svg" alt="logo"> Logout</a>
        
        <hr class="sidebar-divider" style="margin-top: 0px!important; margin-bottom: 0px!important; border-top: 1px solid rgba(255,255,255, .5)">
        <p style="color: #fff;"><center style="color: #fff;">Powered By</center>  <center style="color: #fff;">Isaam Enterprise Limited</center></p>
    </div>

    <section class="mainpart" id='mainpart'>
        <div class="container-fluid">
            <?PHP
            function getMYEAR($myer)
            {
                $myYear = "";
                include 'Connection.php';
                $sql = "SELECT TO_CHAR( to_date(" . $myer . ",'YYYYmm'), 'FMMonth YYYY' ) as MYEAR FROM dual";
                $parseresults = ociparse($conn, $sql);
                ociexecute($parseresults);
                while ($row = oci_fetch_assoc($parseresults)) {
                    $myYear = $row['MYEAR'];
                }
                oci_free_statement($parseresults);
                oci_close($conn);
                return $myYear;
            }
            include 'Connection.php';
            error_reporting(0);
            set_time_limit(1000);
            if (isset($_POST['submit'])) {

                // grab value from submit data from url starts
                $P_BILL_CYCLE_CODE = $_POST['P_BILL_CYCLE_CODE'];
                // grab value from submit data from url ends

                // getMonth
                $bill_month = getMYEAR($P_BILL_CYCLE_CODE);

                //getdate
                $bill_date = date('Y/m/d');

                // heading starts
                echo "<div class='container-fluid text-center mb-4'>
                    <div class='row'>
                        <div class='col-lg-2 col-md-2 col-12'></div>
                        <div class='col-lg-8 col-md-8 col-12'>
                            <img src='./img/Logo.png' alt='BPDB Logo' height='60px' width='60px' class='mr-2'>
                            <strong class='lbl_title' style='font-size: 1.7rem; color:#000;margin-right:1.5rem;'>
                            Bangladesh Power Development Board </strong><br>
                            <label style='font-weight:normal;font-size: 1.4rem; color:#000;'>Ministry Wise Arrear Report</label><br>
                            <label style='font-weight:normal;font-size: 1.4rem; color:#000;'>For The Month : " . getMYEAR($P_BILL_CYCLE_CODE) . "</label>
                        </div>
                        <div class='col-lg-2 col-md-2 col-12 pt-4' style='display:flex; justify-content:center; align-items:baseline'>Date:" . date('Y/m/d') . "</div>
                    </div>
                </div>";
                // heading ends 

                // execute query starts
                $curs = oci_new_cursor($conn);
                $stid = oci_parse($conn, "begin DPG_MINISTRY_REPORT.DPD_MINISTRY_WISE(:cur_data,:P_BILL_CYCLE_CODE); end;");
                oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
                oci_bind_by_name($stid, ":P_BILL_CYCLE_CODE", $P_BILL_CYCLE_CODE, -1, SQLT_CHR);
                oci_execute($stid);
                oci_execute($curs);
                // execute query ends

                // show data in table starts
                echo '<div class="table-responsive-md text_black">';
                echo "<table class='display' id='ministryWise'>

							<thead>
								<tr>   
									<th style='text-align: center;'>SL No.</th>
									<th style='text-align: left;'>Ministry</th>
                                    <th style='text-align: right;'>Current Prin</th>
                                    <th style='text-align: right;'>Prin Arr</th>
									<th style='text-align: right;'>Surcharge Arr</th>
									<th style='text-align: right;'>Total Arr</th>
								</tr>
						    </thead>
                        <tbody>";

                // store fetch data in variable array starts 
                while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $output[] = $row;
                }

                // store fetch data in variable array ends
                $j = 1;

                // declare variable for grand total 
                $total_currnet_prin = $total_prin_arr = $total_surcharge_arr = $total_total_arr = 0;
                $sum = 0;

                // show result in table starts
                for ($k = 0; $k < count($output); $k++) {
                    if ($ZONE_CODE != $output[$k]['ZONE_CODE']) {

                        // individual total starts
                        if ($k != "0") {
                            echo "<tr>";
                            echo "<td style='text-align: center;'>" . $j . "</td>"; // $j for displaying SL No.
                            echo "<td style='text-align: left;'><b>Ministry Total</b></td>";
                            echo "<td style='text-align: right;'><b>" . number_format((float)$sum_currnet_prin, 2, '.', ',') . "</b></td>";
                            echo "<td style='text-align: right;'><b>" . number_format((float)$sum_prin_arr, 2, '.', ',') . "</b></td>";
                            echo "<td style='text-align: right;'><b>" . number_format((float)$sum_surcharge_arr, 2, '.', ',') . "</b></td>";
                            echo "<td style='text-align: right;'><b>" . number_format((float)$sum_total_arr, 2, '.', ',') . "</b></td>";
                            echo "</tr>";

                            // keep track privious sum 
                            $total_currnet_prin += $sum_currnet_prin;
                            $sum_currnet_prin = 0;

                            $total_prin_arr += $sum_prin_arr;
                            $sum_prin_arr = 0;

                            $total_surcharge_arr += $sum_surcharge_arr;
                            $sum_surcharge_arr = 0;

                            $total_total_arr += $sum_total_arr;
                            $sum_total_arr = 0;
                            // keep track privious sum ends

                            $j++;
                        }
                        // individual total ends

                        // show particular data for first time starts
                        echo "<tr>";
                        echo "<td style='text-align: center;'>" . $j . "</td>";
                        echo "<td style='text-align: left;'>" . $output[$k]['MINISTRY'] . "</b></td>";
                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_PRIN'], 2, '.', ',') . "</td>";
                        $sum_currnet_prin += $output[$k]['CURRENT_PRIN'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['PRIN_ARR'], 2, '.', ',') . "</td>";
                        $sum_prin_arr += $output[$k]['PRIN_ARR'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['SURCHARGE_ARR'], 2, '.', ',') . "</td>";
                        $sum_surcharge_arr += $output[$k]['SURCHARGE_ARR'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['TOTAL_ARR'], 2, '.', ',') . "</td>";
                        $sum_total_arr += $output[$k]['TOTAL_ARR'];

                        echo "</tr>";

                        $j++;
                        // show particular data for first time ends
                    } 
                    else {
                        // show particular rest data starts
                        echo "<tr>";
                        echo "<td style='text-align: center;'>" . $j . "</td>";
                        echo "<td style='text-align: left;'>" . $output[$k]['MINISTRY'] . "</b></td>";

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_PRIN'], 2, '.', ',') . "</td>";
                        $sum_currnet_prin += $output[$k]['CURRENT_PRIN'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['PRIN_ARR'], 2, '.', ',') . "</td>";
                        $sum_prin_arr += $output[$k]['PRIN_ARR'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['SURCHARGE_ARR'], 2, '.', ',') . "</td>";
                        $sum_surcharge_arr += $output[$k]['SURCHARGE_ARR'];

                        echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['TOTAL_ARR'], 2, '.', ',') . "</td>";
                        $sum_total_arr += $output[$k]['TOTAL_ARR'];

                        echo "</tr>";
                        $j++;
                        // show particular rest data ends
                    }
                }
                // show result in table ends

                // add last total with privious grand total 
                $total_currnet_prin += $sum_currnet_prin;
                $total_prin_arr += $sum_prin_arr;
                $total_surcharge_arr += $sum_surcharge_arr;
                $total_total_arr += $sum_total_arr;
                // add last total with privious grand total ends

                // last indivisual total starts
                echo "<tr>";
                echo "<td style='text-align: center;'>" . $j . "</td>"; // $j for displaying SL No.
                echo "<td style='text-align: left;'><b>Ministry Total</b></td>";
                echo "<td style='text-align: right;'><b>" . number_format((float)$sum_currnet_prin, 2, '.', ',') . "</b></td>";
                echo "<td style='text-align: right;'><b>" . number_format((float)$sum_prin_arr, 2, '.', ',') . "</b></td>";
                echo "<td style='text-align: right;'><b>" . number_format((float)$sum_surcharge_arr, 2, '.', ',') . "</b></td>";
                echo "<td style='text-align: right;'><b>" . number_format((float)$sum_total_arr, 2, '.', ',') . "</b></td>";
                echo "</tr>";
                // last indivisual total ends

                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                oci_free_statement($stid);
                oci_free_statement($curs);
                oci_close($conn);
            }
            ?>
        </div>

    </section>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

    <!-- show data in datatable starts  -->
    <script>
        $(document).ready(function() {
            $('#ministryWise').DataTable({
                "columnDefs": [{
                        "targets": [0],
                        "className": 'dt-center text-center',
                        "orderable": true
                    },
                    {
                        "targets": [1],
                        "className": 'dt-left',
                        "orderable": false
                    },
                    {
                        "targets": [2, 3, 4, 5],
                        "className": 'dt-right',
                        "orderable": false
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: "excel",
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        className: 'btn btn-default',
                        autoPrint: true,
                        title: '',
                        customize: function(win) {
                            $(win.document.body).find('th').addClass('display').css('border',
                                '1px solid black');
                            $(win.document.body).find('tr:nth-child(odd) td').each(function(
                                index) {
                                $(this).css('border', '1px solid black');
                            });
                            $(win.document.body).find('tr:nth-child(even) td').each(function(
                                index) {
                                $(this).css('border', '1px solid black');
                            });
                            var css = '@media print{@page {size: landscape; margin-top:6mm;}}';
                            head = win.document.head || win.document.getElementsByTagName(
                                    'head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }
                            head.appendChild(style);
                        },
                        exportOptions: {
                            columns: ':visible',
                            stripHtml: false
                        },
                        messageTop: "<div class='container-fluid text-center mb-4'>" +
                            "<div class='row'>" +
                            "<div class='col-lg-2 col-md-2 col-12'></div>" +
                            "<div class='col-lg-8 col-md-8 col-12'>" +
                            "<img src='./img/Logo.png' alt='BPDB Logo' height='60px' width='60px' class='mr-2'>" +
                            "<strong class='lbl_title' style='font-size: 1.7rem; color:#000;margin-right:1.5rem;'>" +
                            "Bangladesh Power Development Board </strong><br>" +
                            "<label style='font-weight:normal;font-size: 1.4rem; color:#000;'>Ministry Wise Arrear Report</label><br>" +
                            "<label style='font-weight:normal;font-size: 1.4rem; color:#000;'>For The Month : " +
                            "<?php echo $bill_month; ?>" +
                            "</label>" +
                            "</div>" +
                            "<div class='col-lg-2 col-md-2 col-12 pt-4' style='display:flex; justify-content:center; align-items:baseline'>Date:" +
                            "<?php echo $bill_date; ?>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "paging": true,
                "Responsive": true,
                "info": false
            });

        });
    </script>
    <!-- show data in datatable ends  -->
</body>

</html>