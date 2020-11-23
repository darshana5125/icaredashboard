<?php session_start(); 

ini_set('display_errors',1);
error_reporting(-1);
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>

<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

echo'<html><head>

<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
  <script src="jquery/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
  <script src="jquery.com/ui/1.10.3/jquery-ui.js" integrity="sha384-Kv4u0J/5Vhwb62xGQP6LXO686+cmeHY3DPXG9uf265EghKCn2SRAKu9hcHb2FS+L" crossorigin="anonymous"></script>';


echo '<link rel="stylesheet" href="googleapis/font.css" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/main3.css" rel="stylesheet">
<link rel="stylesheet" href="ums/css/main.css">';

echo '</head><body>';
?>

<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<form method="POST" action="sla_update.php">

<?php echo'<span style="margin-left:50px;">Please Enter the CSR #</span><input type="text" name="csr_no"><input type="submit"  name ="search" value="Search" class="button"><br>';

function test_input($data) {
  $data = trim($data);
  $data=strip_tags($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST['search']) )
{

	
$csr_no=trim($_POST['csr_no']);
$csr_no=test_input($csr_no);

$csr_query="select distinct * from temp2_view where tn='$csr_no'";
$csr_query_run=mysqli_query($connection,$csr_query);
$csr_num_rows=mysqli_num_rows($csr_query_run);
if($csr_num_rows!=0)
{
while($result=mysqli_fetch_assoc($csr_query_run)) 
{
	 date_default_timezone_set('Asia/Colombo');
echo'<br>
<div class="label"><label class="radio">CSR #   :<label><label name="csr" >'.$csr_no.'</label><br>
<label class="radio">Customer     :<label name="cx_id" >'.$result['cx_id'].'</label><br>
<label class="radio">Create Time     :<label name="ct" >'.date('Y-m-d',strtotime($result['create_time'])).'</label><br>
 <label class="radio">Subject    :<label name="subject" >'.$result['title'].'</label><br>
 <label class="radio">State    :<label name="state" >'.$result['ts_name'].'</label><br>
 <label class="radio">Service    :<label name="service" >'.$result['s_name'].'</label><br>
 <label class="radio">Priority    :<label name="priority" >'.$result['tp_name'].'</label><br>
 <label class="radio">Owner     :<label name="owner" >'.$result['first_name'].'</label><br>
 <label class="radio">Current SLA State   :<label name="sla" ></label>';


 ?>
 <?php
 
 if ($result['sla_state']==1)
	 echo '<font color="#31B404">Met</font>';
 elseif ($result['sla_state']==2 || $result['sla_state']=='' )
	echo "Within SLA";
	else{
		echo '<font color="red">Not Met</font>
		 <label class="radio">Breached Date     :<label name="breached" >'.$result['breached_time'].'</label><br>';
	
	}
	
	
 ?>
<?php
 echo '</label>';
  }
echo '<input type="text" name="csr_hold" style="display:none" value='.$csr_no.'><br>';
 


 
echo "<script type='text/javascript'>
function date() {
	
	if(document.getElementById('select').value=='3')
	{
		 document.getElementById('dtlabel').style.display = 'block';
		 document.getElementById('datepicker').style.display = 'block';
		 
		 $(document).ready(function() {
    $( '#datepicker' ).datepicker({ minDate: -180, maxDate: '3Y+1M+7D',
	changeMonth: true, changeYear: true,
	numberOfMonths:2,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	dateFormat:'yy/mm/dd',
	showAnim:'drop'});//fold, slide, blind, bounce, slideDown, show, fadeIn, clip.
  });
	}
              
}
</script>";


   echo'<label >Select SLA state to update</label> <select name="sla_select" id="select" onchange="date();"> 
 <option value="sts">Select the SLA</option>
 <option value="1">1 SLA Met </option>
  <option value="2">2 Within SLA </option>
   <option value="3">3 SLA Not Met </option>
  </select> ';
  echo '<input type="submit" name="update" value="Update" class="button"><br>';
  
 
 
  
  echo '<label class="day" id="dtlabel" style="display:none">Select a Date</label><input type="text" id="datepicker"  name="datepicker" style="display:none"/> </div>';

  }
  else
  {
	  if(!empty($csr_no))
	  {
	  echo "<script type='text/javascript'>alert('Invalid CSR number!');
	window.location.href = 'sla_update.php';
</script>";
	  }
  }
  
 


 
}

if(isset($_POST['update']) )

{
	$user_id=$_SESSION['user_id'];
	$csr=$_POST['csr_hold'];
	$sla=$_POST['sla_select'];
	$breached_time_string=$_POST['datepicker'];
if($sla!="sts")
	{
	date_default_timezone_set('Asia/Colombo');
	//echo $breached_time_string;
	
	 if($breached_time_string!=""){
		$breached_time_str=strtotime($breached_time_string);
		$breached_time=date('Y-m-d',$breached_time_str);
		//echo $breached_time;
		$query_sla= "update sla_table set sla_state='$sla',updated_by='$user_id', breached_time='$breached_time' where tn='$csr'";
	}
	
	
	else{
  //$query_sla= "update temp2_view set sla_state='$sla' where tn='$csr'";
  $query_sla= "update sla_table set sla_state='$sla',updated_by='$user_id' where tn='$csr'";
	}
  mysqli_query($connection,$query_sla);
  echo "<script type='text/javascript'>alert('Successfully update the SLA state!');
window.location.href = 'sla_update.php';
</script>";                                                                     
	}
	

}



echo '</form></body></html>';






?>
