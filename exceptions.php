<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/main3.css" rel="stylesheet">
<link rel="stylesheet" href="ums/css/main.css">';
echo '<form method="POST" action="exceptions2.php">

<label>Please Enter the CSR #</label><input type="text" name="csr_no"><input type="submit"  value="Search" class="button"><br>';




?>
