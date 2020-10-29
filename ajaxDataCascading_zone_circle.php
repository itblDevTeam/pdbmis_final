<?PHP
include 'Connection.php';
 set_time_limit(1000);

 $P_ZONE_CODE =$_POST['zone_id'];
 
 $curs = oci_new_cursor($conn);

$stid = oci_parse($conn, "begin DPG_MINISTRY_REPORT.DPD_CIRCLE_LIST(:cur_data,:P_ZONE_CODE); end;");


oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
oci_bind_by_name($stid, ":P_ZONE_CODE", $P_ZONE_CODE, -1, SQLT_CHR);

oci_execute($stid);
oci_execute($curs);

echo '<option value="%">Select Circle </option>';
while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {

	echo '<option value="' . $row['CIRCLE_CODE'] . '">' . $row['CIRCLE_NAME'] . '</option>';
//   $output[]=$row;
}
// print($output);
// print(gettype($output));
// print json_encode($output);

oci_free_statement($stid);
oci_free_statement($curs);
oci_close($conn);



?>