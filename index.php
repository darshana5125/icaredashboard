<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
if(!isset($_SESSION['user_id'])){
header('Location:ums/index2.php');
}
$uid = $_SESSION['user_id'];
?>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="ums/css/main.css">
<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>

<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="\icaredashboard/libraries/cloudflare/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<header>
			<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>

<body id="background" class="home">
	<div class="container">
		<div class="col-md-4">
			<div class="list-group module">
<?php
 $user_access="select distinct mv.module_name,mv.url from modules_view mv
				inner join module_access_view mav
				on mav.module_id=mv.module_id
				where mav.user_id=".$uid." and mav.access=1";
$user_access_run=mysqli_query($connection,$user_access);
while($result=mysqli_fetch_assoc($user_access_run)){
?>
	<a href="http://localhost/icaredashboard/<?php echo $result['url']; ?>" target="_blank" class="list-group-item item"><?php echo $result['module_name']?></a>
<?php
}
?>			</div>
		</div>
	</div>			
<body>			
</html>
