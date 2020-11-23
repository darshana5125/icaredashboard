<?php 

	$dbhost = '192.168.1.164';
	$dbuser = 'root';
	$dbpass = 'ib1234';
	$dbname = 'icaredashboard2'; 

	$connection = mysqli_connect('192.168.0.15','dashboard', 'aSha@5588#','icaredashboard2');
	//$connection = mysqli_connect('192.168.0.15','root', 'ib1234','otrs');

	// Checking the connection
	if (mysqli_connect_errno()) {
		die('Database connection failed' . mysqli_connect_error());
	}

?>
