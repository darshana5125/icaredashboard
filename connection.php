<?php 

	$dbhost = '192.168.1.164';
	$dbuser = 'root';
	$dbpass = 'ib1234';
	$dbname = 'otrs'; 

	$connection = mysqli_connect('192.168.1.164', 'root', 'ib1234', 'otrs');

	// Checking the connection
	if (mysqli_connect_errno()) {
		die('Database connection failed ' . mysqli_connect_error());
	}

?>