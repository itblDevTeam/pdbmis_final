<?php
    session_start();
	session_destroy();
	setcookie(PHPSESSID,$_SESSION['USERNAME'],time()-1);
	header("Location: index.php");
?>