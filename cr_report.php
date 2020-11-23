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

echo '<link rel="stylesheet" type="text/css" href="table_style.css"/> 
<link rel="stylesheet" href="ums/css/main.css">';
?>

<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>

<?php
echo '<div id="box"><table id="tablestyle"><th>#</th><th>CSR #</th><th>Cx ID</th><th>Title</th><th>Created Time</th><th>Transferred to PMO
</th><th>State</th><th>Service</th><th>Owner</th>';


//$query="select distinct * from temp2_view where q_name='Change Request Queue' and cx_id!='LKA-NDB'";

// $query="select  distinct temp2_view.*,if(issue_view.ticket_state_id='16',issue_view.change_time,'') as pmo_time
// from temp2_view join issue_view 
// on temp2_view.tn=issue_view.tn
// where temp2_view.q_name='Change Request Queue' and temp2_view.cx_id!='LKA-NDB'";
$query="select issue_view.tn as tn,issue_view.customer_id as cx_id,issue_view.title as title,issue_view.create_time as create_time,issuehis_view.change_time as pmo_time,
issuestate_view.name as ts_name,
service_view.name as s_name,intuser_view.first_name as first_name from issue_view join issuehis_view join issuestate_view left join service_view on 
issue_view.service_id=service_view.id join intuser_view
on issue_view.id=issuehis_view.ticket_id and
issue_view.ticket_state_id=issuestate_view.id and
issue_view.user_id=intuser_view.id
where issue_view.create_time > '2014-11-10 00:00:00' and issuehis_view.state_id='16'
group by issuehis_view.ticket_id";

$query_run=mysqli_query($connection,$query);
$count=1;

while($result2=mysqli_fetch_assoc($query_run)) 
{
	
	echo '<tr><td class="no">'.$count.'</td>
	<td class="cx">'.$result2['tn'].'</td>'	;
	echo'<td class="csr">'.$result2['cx_id'].'</td>
	<td class="subject">'.$result2['title'].'</td>
	<td class="time">'.$result2['create_time'].'</td>
	
	<td class="time"> '.$result2['pmo_time'].'</td>
	
	<td class="state">'.$result2['ts_name'].'</td>
	
	<td class="service"> '.$result2['s_name'].'</td> 
	<td class="owner"> '.$result2['first_name'].'</td>
	
	</tr>'; 
	
$count++;
}

}else{
	header('Location: index.php');
}	

?>
