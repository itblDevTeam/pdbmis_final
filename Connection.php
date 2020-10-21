<?PHP
//header('Content-Type: text/html; charset=utf-8'); 
$PDBMIS=
"(DESCRIPTION =
(ADDRESS = (PROTOCOL = TCP)(HOST = 180.211.137.17)(PORT = 1521))
(CONNECT_DATA =(SERVER = DEDICATED)(SERVICE_NAME = ebps)
)
)";
$conn = ocilogon( "PDBMIS", "pdbmis123",$PDBMIS,"WE8ISO8859P15");

?>