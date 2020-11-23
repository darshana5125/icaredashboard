<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/main3.css" rel="stylesheet">
<link rel="stylesheet" href="ums/css/main.css">';
?>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
echo '<form method="POST" action="exceptions2.php">';

function test_input($data) {
  $data = trim($data);
  $data=strip_tags($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['csr_no']) )
{
	
$csr_no=$_POST['csr_no'];


$query= mysqli_query($connection,"select distinct * from view_temp2 where tn='$csr_no'");
		


$csr_num_rows=mysqli_num_rows($query);



if($csr_num_rows!=0)
{
	
while($result=mysqli_fetch_array($query)) 
{
	$qname=$result['q_name'];
	$subject=$result['title'];
	$tp_name=$result['tp_name'];
	$create_time=$result['create_time'];
	$ct=$result['ct'];
	$ts_name=$result['ts_name'];
	$close_time=$result['close_time'];
	$excep=$result['exception'];
echo'CSR # :<input type="text" name="csr" id="csr" class="exceptions" readonly value='.$csr_no.'><br>
Customer    :<input type="text" id="cx" name="cx_id" class="exceptions" readonly value='.$result['cx_id'].'><br>
Queue :<input type="text" id="queue" name="q_name" class="exceptions" readonly value="'.$qname.'" /><br>
Subject   :<input type="text" id="subject" name="title" class="exceptions"  readonly value="'.$subject.'"/><br>
State  :<input type="text" id="state" name="state" class="exceptions" readonly value="'.$ts_name.'"><br>
 Service   :<input type="text" id="service" name="service" class="exceptions" readonly value='.$result['s_name'].'><br>
 Priority   :<input type="text" id="priority" name="priority" class="exceptions" readonly value="'.$tp_name.'"><br>
Owner     :<input type="text" id="owner" name="owner" class="exceptions" readonly value='.$result['first_name'].'><br>
 Created Date     :<input type="text" id="cd" name="create_time" class="exceptions" readonly value="'.$create_time.'"><br>
 
  Current SLA State   :<input type="text" id="sla" name="sla" class="exceptions" readonly value='.$result['sla_state'].'><br>
  <input type="text" name="ct" style="display:none" class="exceptions" readonly value="'.$ct.'">
  <input type="text" name="close_time" style="display:none" class="exceptions" readonly value="'.$close_time.'">';	
 
}

if ($excep==0)
 echo '<input type="submit"  name="add" id="btn_exception" value="Add to Exception">';
 else 
 echo '<input type="submit" value="Delete" name="delete" class="button">';

echo "<script type='text/javascript'>
function Redirect() {
               window.location = 'http://192.168.1.175/exceptions.php';
}
</script>";
 echo ' <input type="button" class="button" value="Back" onclick="Redirect();" />';
}
else
{
	echo "<script type='text/javascript'>alert('Invalid CSR number!');
	window.location.href = 'exceptions.php';
</script>";
	
}

}

if(isset($_POST['add']))
{
// $cx_id=$_POST['cx_id'];
// $csr_no=$_POST['csr'];
// $title=$_POST['title'];
// $create_time=$_POST['create_time'];
// $ct=$_POST['ct'];
// $close_time=$_POST['close_time'];
// $q_name=$_POST['q_name'];
// $ts_name=$_POST['state'];
// $tp_name=$_POST['priority'];
// $s_name=$_POST['service'];
// $first_name=$_POST['owner'];
// $sla_state=$_POST['sla'];

$csr_no=$_POST['csr'];

$query2= mysqli_query($connection,"update servicelevel_view set exception=1 where tn='$csr_no'");



echo "<script type='text/javascript'>alert('Successfully added to the exception list!');
window.location.href = 'exceptions.php';
</script>";
}

if(isset($_POST['delete']))
{
	$csr_no=$_POST['csr'];

	$query3 = mysqli_query($connection,"update servicelevel_view set exception=0 where tn='$csr_no'");
	
			
	echo "<script type='text/javascript'>alert('Successfully deleted from the exception list!');
window.location.href = 'exceptions.php';
</script>";
	
}


?>
