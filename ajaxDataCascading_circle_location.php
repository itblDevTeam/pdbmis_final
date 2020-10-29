<?PHP
include 'Connection.php';
set_time_limit(1000);



$P_CIRCLE_CODE =$_POST['circle_id'];
$P_COMP_CNTR_CODE = "%";
 
$curs = oci_new_cursor($conn);

$stid = oci_parse($conn, "begin DPG_MINISTRY_REPORT.DPD_LOCATION_LIST(:cur_data,  :P_COMP_CNTR_CODE, :P_CIRCLE_CODE); end;");


oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);

oci_bind_by_name($stid, ":P_CIRCLE_CODE", $P_CIRCLE_CODE, -1, SQLT_CHR);

oci_bind_by_name($stid, ":P_COMP_CNTR_CODE", $P_COMP_CNTR_CODE, -1, SQLT_CHR);

oci_execute($stid);
oci_execute($curs);

echo '<option value="%">Select Location </option>';
while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {

	echo '<option value="' . $row['LOCATION_CODE'] . '">' . $row['LOCATION_NAME'] . '</option>';
//   $output[]=$row;
}
// print($output);
// print(gettype($output));
// print json_encode($output);

oci_free_statement($stid);
oci_free_statement($curs);
oci_close($conn);



?>