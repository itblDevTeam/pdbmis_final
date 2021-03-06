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
	<title>Circle Wise Report</title>
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
						<div class="col-lg-2 col-md-2 col-2">
							<span class="menulines" onclick="openNav()" id='bar'>&#9776;</span>
						</div>
						<!-- menu line ends  -->

						<!-- bill cycle select starts  -->
						<div class="col-lg-2 col-md-2 col-2">
							<?php
							include 'Connection.php';
							$sql = "select BILL_CYCLE_CODE from MIS_BILL_CYCLE_MASTER order by BILL_CYCLE_CODE desc";
							$parseresults = ociparse($conn, $sql);
							ociexecute($parseresults);
							echo '<select name="P_BILL_CYCLE_CODE" id="bill_cycle" class="custom-select text-size form-control ">';
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

						<!-- zone code select starts  -->
						<div class="col-lg-2 col-md-2 col-2">
							<?PHP
							include 'Connection.php';
							error_reporting(0);
							set_time_limit(1000);
							$curs = oci_new_cursor($conn);
							$stid = oci_parse($conn, "begin DPG_MINISTRY_REPORT.DPD_ZONE_LIST(:cur_data); end;");
							oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
							oci_execute($stid);
							oci_execute($curs);
							echo '<select name="P_ZONE_CODE" class="custom-select text-size form-control" id="zone_code">';
							echo '<option value="%" selected>Select Zone</option>';
							while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
								echo '<option value="' . $row['ZONE_CODE'] . '">' . $row['ZONE_NAME'] . '</option>';
								$zone_code_result[] = $row['ZONE_CODE'];
							}
							echo '</select>';
							$zone_code = $zone_code_result[0];
							oci_free_statement($stid);
							oci_free_statement($curs);
							oci_close($conn);
							?>
						</div>
						<!-- zone code select ends  -->

						<!-- circle code select starts  -->
						<div class="col-lg-2 col-md-2 col-2">
							<select name="P_CIRCLE_CODE" id="circle_code" class="custom-select text-size form-control">
								<option value="%" selected>Select Circle</option>
							</select>
						</div>
						<!-- circle code select ends  -->

						<!-- submit button starts  -->
						<div class="col-lg-2 col-md-2 col-2">
							<input type="submit" class="btn btn-primary text-size" id="submit" name="submit" value="Submit">
						</div>
						<!-- submit button ends  -->
						
					</div>
				</form>
			</div>
		</div>
	</header>

	<div class="sidenav" id='mySidenav'  style="overflow-y: hidden;">
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
			<?php
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
				$P_ZONE_CODE = $_POST['P_ZONE_CODE'];
				$P_CIRCLE_CODE = $_POST['P_CIRCLE_CODE'];
				
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
                            <label style='font-weight:normal;font-size: 1.4rem; color:#000;'>(Circle Wise)</label><br>
                            <label style='font-weight:normal;font-size: 1.4rem; color:#000;'>For The Month : " . getMYEAR($P_BILL_CYCLE_CODE) . "</label>
                        </div>
                        <div class='col-lg-2 col-md-2 col-12 pt-4' style='display:flex; justify-content:center; align-items:baseline'>Date:" . date('Y/m/d') . "</div>
                    </div>
                
                </div>";
				// heading ends

				// execute query starts
				$curs = oci_new_cursor($conn);
				$stid = oci_parse($conn, "begin DPG_MINISTRY_REPORT.DPD_CIRCLE_WISE(:cur_data,:P_BILL_CYCLE_CODE,:P_ZONE_CODE,:P_CIRCLE_CODE); end;");
				oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
				oci_bind_by_name($stid, ":P_BILL_CYCLE_CODE", $P_BILL_CYCLE_CODE, -1, SQLT_CHR);
				oci_bind_by_name($stid, ":P_ZONE_CODE", $P_ZONE_CODE, -1, SQLT_CHR);
				oci_bind_by_name($stid, ":P_CIRCLE_CODE", $P_CIRCLE_CODE, -1, SQLT_CHR);
				oci_execute($stid);
				oci_execute($curs);
				// execute query ends

				// show data in table starts
				echo '<div class="table-responsive-md text_black">';
				echo "<table class='display' id='circleWise'>
								
				                <thead>
									<tr>   
										<th style='text-align: center;'>SL No.</th>
										<th style='text-align: left;'>Zone Name</th>
										<th style='text-align: left;'>Circle Name</th>
										<th style='text-align: left;'>Ministry</th>
										<th style='text-align: right;'>Energy Arr</th>
										<th style='text-align: right;'>Current Prin</th>
										<th style='text-align: right;'>Vat Arr</th>
										<th style='text-align: right;'>Current Vat</th>
										<th style='text-align: right;'>Surcharge Arr</th>
										<th style='text-align: right;'>Current LPS</th>
									</tr>
								</thead>
							<tbody>";

							// store fetch data in variable array starts 
							while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
									$output[] = $row;
							}
							// store fetch data in variable array ends

							// $i=0;
							$j = 1;
							$ZONE_CODE = 0;
							$CIRCLE_CODE = 0;

							// declare variable for circle total 
							$sum_energy_arr = $sum_currnet_prin = $sum_vat_arr = $sum_current_vat = $sum_surcharge_arr = $sum_current_lps = 0;

							// declare variable for circle
							$total_circle_sum_energy_arr = $total_circle_sum_currnet_prin = $total_circle_sum_vat_arr = $total_circle_sum_current_vat = $total_circle_sum_surcharge_arr = $total_circle_sum_current_lps = 0;

							// declare variable for zone
							$total_zone_sum_energy_arr = $total_zone_sum_currnet_prin = $total_zone_sum_vat_arr = $total_zone_sum_current_vat = $total_zone_sum_surcharge_arr = $total_zone_sum_current_lps = 0;

							// declare variable for last circle total
							$last_circle_sum_energy_arr = $last_circle_sum_currnet_prin = $last_circle_sum_vat_arr = $last_circle_sum_current_vat = $last_circle_sum_surcharge_arr = $last_circle_sum_current_lps = 0;
							
							$sum = 0;

							// show result in table starts
							for ($k = 0; $k < count($output); $k++) {

								// condition for zone_code and circle code
								if (($ZONE_CODE != $output[$k]['ZONE_CODE'] && $CIRCLE_CODE != $output[$k]['CIRCLE_CODE']) 
								||  ($ZONE_CODE == $output[$k]['ZONE_CODE'] && $CIRCLE_CODE != $output[$k]['CIRCLE_CODE']))
							    {
									// individual circle total starts
									if ($k != '0' && $CIRCLE_CODE != $output[$k]['CIRCLE_CODE']) {
											echo "<tr>";
											echo "<td style='text-align: center;'>" . $j . "</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td style='text-align: left;'><b>Circle Total</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_energy_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_currnet_prin, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_vat_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_current_vat, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_surcharge_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$sum_current_lps, 2, '.', ',') . "</b></td>";
											echo "</tr>";
											
											// calculation
											$total_circle_sum_energy_arr += $sum_energy_arr;

											// for showing grand total 
											$total_zone_sum_energy_arr += $sum_energy_arr;
											$sum_energy_arr = 0;

											$total_circle_sum_currnet_prin += $sum_currnet_prin;

											// for showing grand total 
											$total_zone_sum_currnet_prin += $sum_currnet_prin;
											$sum_currnet_prin = 0;

											$total_circle_sum_vat_arr += $sum_vat_arr;

											// for showing grand total 
											$total_zone_sum_vat_arr += $sum_vat_arr;
											$sum_vat_arr = 0;

											$total_circle_sum_current_vat += $sum_current_vat;

											// for showing grand total 
											$total_zone_sum_current_vat += $sum_current_vat;
											$sum_current_vat = 0;

											$total_circle_sum_surcharge_arr += $sum_surcharge_arr;

											// for showing grand total 
											$total_zone_sum_surcharge_arr += $sum_surcharge_arr;
											$sum_surcharge_arr = 0;

											$total_circle_sum_current_lps += $sum_current_lps;

											// for showing grand total 
											$total_zone_sum_current_lps += $sum_current_lps;
											$sum_current_lps = 0;

											$j++;
									}
									// individual circle total ends

									// individual zone total starts
									if ($k != '0' && $ZONE_CODE != $output[$k]['ZONE_CODE']) {
											echo "<tr>";
											echo "<td style='text-align: center;'>" . $j . "</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td style='text-align: left;'><b>Zone Total</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_energy_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_currnet_prin, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_vat_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_current_vat, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_surcharge_arr, 2, '.', ',') . "</b></td>";
											echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_current_lps, 2, '.', ',') . "</b></td>";
											echo "</tr>";

											// reset value
											$total_circle_sum_energy_arr = 0;
											$total_circle_sum_currnet_prin = 0;
											$total_circle_sum_vat_arr = 0;
											$total_circle_sum_current_vat = 0;
											$total_circle_sum_surcharge_arr = 0;
											$total_circle_sum_current_lps = 0;
											$j++;
									}
									// individual zone total ends

									// show particular data for first time starts
									echo "<tr>";
									echo "<td style='text-align: center;'>" . $j . "</td>";
									echo "<td style='text-align: left;'><b>" . $output[$k]['ZONE_NAME'] . "</b></td>";
									echo "<td style='text-align: left;'>" . $output[$k]['CIRCLE_NAME'] . "</td>";
									echo "<td style='text-align: left;'>" . $output[$k]['MINISTRY'] . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['ENERGY_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_PRIN'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['VAT_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_VAT'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['SURCHARGE_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_LPS'], 2, '.', ',') . "</td>";
									echo "</tr>";

									// sum particular data
									$sum_energy_arr += $output[$k]['ENERGY_ARR'];
									$sum_currnet_prin += $output[$k]['CURRENT_PRIN'];
									$sum_vat_arr += $output[$k]['VAT_ARR'];
									$sum_current_vat += $output[$k]['CURRENT_VAT'];
									$sum_surcharge_arr += $output[$k]['SURCHARGE_ARR'];
									$sum_current_lps += $output[$k]['CURRENT_LPS'];

									// set zone_code, circle_code, sl_no.
									$ZONE_CODE = $output[$k]['ZONE_CODE'];
									$CIRCLE_CODE = $output[$k]['CIRCLE_CODE'];
									$j++;

									// show particular data for first time ends 
								} 
								else {
									// show particular rest data starts
									echo "<tr>";
									echo "<td style='text-align: center;'>" . $j . "</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td style='text-align: left;'>" . $output[$k]['MINISTRY'] . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['ENERGY_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_PRIN'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['VAT_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_VAT'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['SURCHARGE_ARR'], 2, '.', ',') . "</td>";
									echo "<td style='text-align: right;'>" . number_format((float)$output[$k]['CURRENT_LPS'], 2, '.', ',') . "</td>";
									echo "</tr>";

									// sum particular rest data
									$sum_energy_arr += $output[$k]['ENERGY_ARR'];
									$sum_currnet_prin += $output[$k]['CURRENT_PRIN'];
									$sum_vat_arr += $output[$k]['VAT_ARR'];
									$sum_current_vat += $output[$k]['CURRENT_VAT'];
									$sum_surcharge_arr += $output[$k]['SURCHARGE_ARR'];
									$sum_current_lps += $output[$k]['CURRENT_LPS'];
									$j++;
									// show particular rest data ends
							}
							}
							// show result in table ends

							// last individual circle total starts
							$last_circle_sum_energy_arr += $sum_energy_arr;
							$last_circle_sum_currnet_prin += $sum_currnet_prin;
							$last_circle_sum_vat_arr += $sum_vat_arr;
							$last_circle_sum_current_vat += $sum_current_vat;
							$last_circle_sum_surcharge_arr += $sum_surcharge_arr;
							$last_circle_sum_current_lps += $sum_current_lps;

							echo "<tr>";
							echo "<td style='text-align: center;'>" . $j . "</td>"; // $j for displaying SL No.
							echo "<td></td>";
							echo "<td></td>";
							echo "<td style='text-align: left;'><b>Circle Total</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_energy_arr, 2, '.', ',') . "</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_currnet_prin, 2, '.', ',') . "</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_vat_arr, 2, '.', ',') . "</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_current_vat, 2, '.', ',') . "</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_surcharge_arr, 2, '.', ',') . "</b></td>";
							echo "<td style='text-align: right;'><b>" . number_format((float)$last_circle_sum_current_lps, 2, '.', ',') . "</b></td>";
							echo "</tr>";
							// last individual circle total ends

							// last individual zone total starts
							$total_circle_sum_energy_arr += $last_circle_sum_energy_arr;
							$total_circle_sum_currnet_prin += $last_circle_sum_currnet_prin;
							$total_circle_sum_vat_arr += $last_circle_sum_vat_arr;
							$total_circle_sum_current_vat += $last_circle_sum_current_vat;
							$total_circle_sum_surcharge_arr += $last_circle_sum_surcharge_arr;
							$total_circle_sum_current_lps += $last_circle_sum_current_lps;

							if($P_CIRCLE_CODE == '%'){
									echo "<tr>";
									echo "<td style='text-align: center;'>" . ++$j . "</td>"; // $j for displaying SL No.
									echo "<td></td>";
									echo "<td></td>";
									echo "<td style='text-align: left;'><b>Zone Total</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_energy_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_currnet_prin, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_vat_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_current_vat, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_surcharge_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_circle_sum_current_lps, 2, '.', ',') . "</b></td>";
									echo "</tr>";
							}
							// last individual zone total ends

							// show grand total starts
							$total_zone_sum_energy_arr += $last_circle_sum_energy_arr;
							$total_zone_sum_currnet_prin += $last_circle_sum_currnet_prin;
							$total_zone_sum_vat_arr += $last_circle_sum_vat_arr;
							$total_zone_sum_current_vat += $last_circle_sum_current_vat;
							$total_zone_sum_surcharge_arr += $last_circle_sum_surcharge_arr;
							$total_zone_sum_current_lps += $last_circle_sum_current_lps;

							if($P_ZONE_CODE == '%'){
									echo "<tr>";
									echo "<td style='text-align: center;'>" . ++$j . "</td>"; // $j for displaying SL No.
									echo "<td></td>";
									echo "<td></td>";
									echo "<td style='text-align: left;'><b>Grand Total</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_energy_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_currnet_prin, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_vat_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_current_vat, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_surcharge_arr, 2, '.', ',') . "</b></td>";
									echo "<td style='text-align: right;'><b>" . number_format((float)$total_zone_sum_current_lps, 2, '.', ',') . "</b></td>";
									echo "</tr>";
							}
							// show grand total ends

							// add last total with privious grand total 
							$total_energy_arr += $sum_energy_arr;
							$total_currnet_prin += $sum_currnet_prin;
							$total_vat_arr += $sum_vat_arr;
							$total_current_vat += $sum_current_vat;
							$total_surcharge_arr += $sum_surcharge_arr;
							$total_current_lps += $sum_current_lps;
							// add last total with privious grand total ends

							echo '</tbody>';
							echo '</table>';
							echo '</div>';

							oci_free_statement($stid);
							oci_free_statement($curs);
							oci_close($conn);
					}
		        ?>
            </div>
        </div>
        <!-- show output ends  -->

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
			$('#circleWise').DataTable({
				"columnDefs": [{
						"targets": [0],
						"className": 'dt-center text-center',
						"orderable": true
					},
					{
						"targets": [1, 2, 3],
						"className": 'dt-left',
						"orderable": false
					},
					{
						"targets": [4, 5, 6, 7, 8, 9],
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
                            "<label style='font-weight:normal;font-size: 1.4rem; color:#000;'>(Circle Wise)</label><br>" +
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

			// circle code cascading starts 
			$('#zone_code').on('change', function() {
				var zoneID = $(this).val();
				if (zoneID) {
					$.ajax({
						type: 'POST',
						url: 'ajaxDataCascading_zone_circle.php',
						data: 'zone_id=' + zoneID,
						success: function(html) {
							$('#circle_code').html(html);
						}
					});
				} else {
					$('#circle_code').html('<option value="">Select zone first</option>');
				}
			});
			// circle code cascading ends 

		});
	</script>
	<!-- show data in datatable ends  -->

</body>
</html>