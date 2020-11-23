<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
	$mid=$_GET['mid'];
	$uid = $_SESSION['user_id'];
	$access="";

	$sql="select access from module_access_view where user_id=$uid and module_id=$mid";
	$sql_run=mysqli_query($connection,$sql);

		while($result_sql=mysqli_fetch_assoc($sql_run)){
		$access=$result_sql['access'];
	}
	
if($access==1){

echo'<html><head>

<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
  <script src="\icaredashboard/libraries/jquery/jquery-1.9.1.js" ></script>
  <script src="\icaredashboard/libraries/jquery/ui/1.10.3/jquery-ui.js"></script>';


echo '<link href="css/main3.css" rel="stylesheet">
<link rel="stylesheet" href="ums/css/main.css">';



 echo '</head>
 
 <body>';
?>
<!--header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header-->
<?php
 echo'<h3>Search breached issues for a specific date range.</h3>';
 ?>
<form method="POST" action="<?php echo htmlspecialchars('breached_results.php');?>">

<?php
echo'
<table border="0">
<tr>

<td>';
echo "<script type='text/javascript'>
		 
		 $(document).ready(function() {
			  document.getElementById('dtlabel1').style.display = 'block';
		 document.getElementById('datepicker1').style.display = 'block';
			 
    $( '#datepicker1' ).datepicker({ minDate: -1800, maxDate: '3Y+1M+7D',
	changeMonth: true, changeYear: true,
	numberOfMonths:1,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	dateFormat:'yy-mm-dd',
	showAnim:'drop'});//fold, slide, blind, bounce, slideDown, show, fadeIn, clip.
  
  
});
	
		 

</script>";
 echo'<label class="day" id="dtlabel1" style="display:none">Select start date</label><input type="text" id="datepicker1"  name="datepicker1" style="display:none"/> 
</td>';

echo'<td>';
echo "<script type='text/javascript'>
		 
		 $(document).ready(function() {
			  document.getElementById('dtlabel2').style.display = 'block';
		 document.getElementById('datepicker2').style.display = 'block';
			 
    $( '#datepicker2' ).datepicker({ minDate: -1800, maxDate: '3Y+1M+7D',
	changeMonth: true, changeYear: true,
	numberOfMonths:1,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	dateFormat:'yy-mm-dd',
	showAnim:'drop'});//fold, slide, blind, bounce, slideDown, show, fadeIn, clip.
  
  
});
	
		 

</script>";
echo'  <label class="day" id="dtlabel2" style="display:none">Select end date</label><input type="text" id="datepicker2"  name="datepicker2" style="display:none"/> ';
echo'</td>

	<td><input type="submit" name="ok" value="OK" class="button"></input>
	</td>
</tr>
</table>';

echo '</form>';

 
echo'</body>';
 
		
	
	
echo' </html>';
 
 //mysqli_close($link);
}else{
	header('Location: index.php');
}
 
 ?>
