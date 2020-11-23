<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}



echo '<link rel="stylesheet" type="text/css" href="table_style.css"/>
<link rel="stylesheet" href="ums/css/main.css"> ';
?>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
echo '<div id="box"><table id="tablestyle"><th>Number</th><th>CustomerID</th><th>CSR#</th><th>Title</th><th>Created</th><th>Changed</th><th>Close Time</th>
<th>Queue</th><th>State</th><th class="pri">Priority</th><th>Service</th><th>Agent/Owner</th><th>SLA</th>';


$query="select distinct * from temp2_view where create_time>='2015-04-01' and exception=0 and q_name!='Change Request Queue' and q_name  !='NDB - Live Issues'
 and q_name!='SDI Queue::SDI-Software ( iATMClient)' and q_name!='SDI Queue::SDI-Hardware' and q_name!='SDI Queue' and q_name!='DELETED_TICKETS'
union(
select distinct * from temp2_view where q_name  ='NDB - Live Issues' and create_time>'2015-11-05 00:00:00')
order by tn desc";

$query_run=mysqli_query($connection,$query);
$count=1;

while($result2=mysqli_fetch_assoc($query_run)) 
{
	if($result2['sla_state']==1)
	{
	echo '<tr><td class="no">'.$count.'</td>
	<td class="cx">'.$result2['cx_id'].'</td>'	;
	echo'<td class="csr">'.$result2['tn'].'</td>
	<td class="subject">'.$result2['title'].'</td>
	<td class="time">'.$result2['create_time'].'</td>
	<td class="time"> '.$result2['ct'].'</font></td>
	<td class="time"> '.$result2['close_time'].'</td>
	<td class="queue"> '.$result2['q_name'].'</td>
	<td class="state"><font color="#31B404"> '.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td class="service"> '.$result2['s_name'].'</td> 
	<td class="owner"> '.$result2['first_name'].'</td>
	<td><font color="#31B404">SLA Met</font></td>
	
	</tr>'; 
	
$count++;
	}
	if($result2['sla_state']==2 || $result2['sla_state']=="" )
	{
	echo '<tr><td class="no">'.$count.'</td>
	<td class="cx">'.$result2['cx_id'].'</td>'	;
	echo'<td class="csr">'.$result2['tn'].'</td>
	<td class="subject">'.$result2['title'].'</td>
	<td class="time">'.$result2['create_time'].'</td>
	<td class="time"> '.$result2['ct'].'</font></td>
	<td class="time"> '.$result2['close_time'].'</td>
	<td class="queue"> '.$result2['q_name'].'</td>
	<td class="state"> <font color="black">'.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td class="service"> '.$result2['s_name'].'</td> 
	<td class="owner"> '.$result2['first_name'].'</td>
	<td> <font color="black">Within SLA</font></td>

	</tr>'; 
	
$count++;	
	}
	if($result2['sla_state']==3)
	{
	echo '<tr><td class="no">'.$count.'</td>
	<td class="cx">'.$result2['cx_id'].'</td>'	;
	echo'<td class="csr">'.$result2['tn'].'</td>
	<td class="subject">'.$result2['title'].'</td>
	<td class="time">'.$result2['create_time'].'</td>
	<td class="time"> '.$result2['ct'].'</font></td>
	<td class="time"> '.$result2['close_time'].'</td>
	<td class="queue"> '.$result2['q_name'].'</td>
	<td class="state"> <font color="red">'.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td class="service"> '.$result2['s_name'].'</td> 
	<td class="owner"> '.$result2['first_name'].'</td>
	<td> <font color="red">SLA Not Met</font></td>
	
	</tr>'; 
	
$count++;	
	}
	// if($result2['sla_state'] == null)
	// {
	// echo '<tr><td class="no">'.$count.'</td>
	// <td>'.$result2['cx_id'].'</td>'	;
	// echo'<td>'.$result2['tn'].'</td>
	// <td class="subject">'.$result2['title'].'</td>
	// <td class="time">'.$result2['create_time'].'</td>
	// <td class="time"> '.$result2['ct'].'</font></td>
	// <td class="time"> '.$result2['close_time'].'</td>
	// <td> '.$result2['q_name'].'</td>
	// <td> '.$result2['ts_name'].'</td>
	// <td> '.$result2['tp_name'].'</td>
	// <td> '.$result2['s_name'].'</td> 
	// <td> '.$result2['first_name'].'</td>
	
	// </tr>'; 
	
// $count++;	
	// }
	
}
mysqli_close($link);
?>
