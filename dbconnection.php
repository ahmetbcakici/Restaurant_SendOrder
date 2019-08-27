<?php
	$con = new MYSQLI("localhost","root","","biget");
    mysqli_set_charset($con,"utf8");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    } 

?>