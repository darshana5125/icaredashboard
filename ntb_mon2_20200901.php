<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php');?>
<?php
if(!isset($_SESSION['user_id'])){
header('Location:ums/index2.php');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="\icaredashboard/libraries/cloudflare/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/ntb_mon2.css">
  <link rel="stylesheet" href="\icaredashboard\ums/css/main.css">

   <script src="\icaredashboard/js/jquery.aCollapTable.js"></script>
	

  	<meta charset="UTF-8">
	<title>NTB Monitoring Dashboard</title>
	<script type="text/javascript">		

$(document).ready(function(){

	 $('.collaptable').aCollapTable({ 

// the table is collapased at start
startCollapsed: true,

// the plus/minus button will be added like a column
addColumn: true, 

// The expand button ("plus" +)
plusButton: '<span class="i">+</span>', 

// The collapse button ("minus" -)
minusButton: '<span class="i">-</span>' 
  
});


	});
</script>
</head>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header btn btn-danger">
				<span>NTB MONITORING ISSUES - JANUARY 2019 ONWARDS - SUMMARY</span>
				<span class="date">As @: <?php date_default_timezone_set("Asia/Colombo"); echo date('Y-m-d'); echo date(" h:ia");?>					
				</span>
			</div>
	  <div class="card-body">
	  	<div class="row">
	  		<div class="col-md-3">
	  			<table class="table table-success">
				    <thead>
				    	<tr>
				      		<th colspan="2"><span>All Tickets from:</span><span id="rdate">2019-01-01</span></th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state="select tv.ts_name,count(distinct tv.tn) as count from view_temp2 tv
						where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01' and cx_id='LKA-NTB'
						group by tv.ts_name";
						$query_state_run=mysqli_query($connection,$query_state);
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	<tr>
				    		<td><?php echo $query_state_result['ts_name'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php
				    		}

				    	$beginday='2019-01-01';
						$lastday =date('Y-m-d');

 function getWorkingDays($startDate, $endDate){
 $begin=strtotime($startDate);
 $end=strtotime($endDate);
 if($begin>$end){//check if the end date is beyond begin date
  echo "startdate is in the future! <br />";
  return 0;
 }else{
   $no_days=0;
   $weekends=0;
  while($begin<$end){
    $no_days++; // no of days in the given interval
    $what_day=date("N",$begin);
     if($what_day>5) { // 6 and 7 are weekend days
          $weekends++;
     };
    $begin+=86400; // +1 day
  };
  $working_days=$no_days-$weekends;
  $holidays=array("2019-01-15","2019-02-04","2019-02-19","2019-03-20","2019-04-15","2019-04-19","2019-05-01","2019-05-17",
  "2019-06-16","2019-07-15","2019-07-16","2019-08-14","2019-09-13","2019-10-09","2019-11-12","2019-12-11","2019-12-25");
   foreach($holidays as $holiday){	 
    $time_stamp=strtotime($holiday);
    //If the holiday doesn't fall in weekend
    if ($startDate <= $holiday && $holiday <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7){
	 $working_days--;
	 }  
}
// in case after deducting public holidays if the working days count comes to a minus figure, then it will return 0 as the number of working days.
  if($working_days>0){
	return $working_days;
  }
  else{
	return 0;  
  }
 }
}
$nr_work_days = getWorkingDays($beginday,$lastday);
				    	?>
				    </tbody>
				</table>
	  		</div>

	  		<div  class="col-md-3">
	  			<table id="table2" class="collaptable table table-danger">
				    <thead>
				    	<tr>
				      		<th colspan="3">Assigned CSR Breakup</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state2="select
						coalesce(sum(issview.helpdesk),0) as helpdesk,
						        coalesce(sum(issview.cslogs),0) as cslogs,
						        coalesce(sum(issview.csinfra),0) as csinfra,
						        coalesce(sum(issview.atm),0) as atm,
						        coalesce(sum(issview.sdi),0) as sdi,
						        coalesce(sum(issview.others),0) as others						       
						from
						(select
						case when u.first_name='Shanaka' or u.first_name='John'or
						u.first_name='Aathif' or u.first_name='Priyadarshana' or
						u.first_name='Suganthan' or u.first_name='Damith' or
						u.first_name='Interblocks'
						then count(iv.id) end as helpdesk,
						case when u.first_name = 'CS-Logs'
						then count(iv.id) end as cslogs,
						case when u.first_name='Prabath'or  
						u.first_name='Sanjaya' then count(iv.id) end as csinfra,
						case when u.first_name='Udul' or u.first_name='Sujith' then count(iv.id) end as sdi,
						case when u.first_name='Geehan' or u.first_name='Venura'
						or u.first_name='Nalin' or u.first_name='Dilan' or
						u.first_name='Dilantha' or u.first_name='Sameera'
						then count(iv.id) end as atm,
						case when u.first_name not in('Shanaka','John','Aathif',
                        'Suganthan','Priyadarshana','Damith','Interblocks','CS-Logs',
                        'Prabath','Sanjaya','Udul','Sujith','Geehan','Venura',
                        'Nalin','Dilantha','Sameera','Dilan') then count(iv.id) end as others
						from issuestate_view iss inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
						u.id=iv.user_id where iv.queue_id=80 and iv.create_time>='2019-01-01'
						and iss.name='Assigned' and iv.customer_id='LKA-NTB'
						group by iv.user_id) issview";
						$query_state2_run=mysqli_query($connection,$query_state2);
						$data_id=1;
						while($query_state2_result=mysqli_fetch_assoc($query_state2_run)){
				    	?>
				    	<tr data-id="1" data-parent="">
				    		<td class="state">Tech Team</td>
				    		<td class="own"><?php echo $query_state2_result['atm'];?></td>				    		
				    	</tr>
				    		<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time  from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Geehan','Venura','Dilan','Nalin','Sameera','Dilantha')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="1">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>
				    	<tr data-id="2" data-parent="">
				    		<td class="state">CS-Logs</td>
				    		<td class="own"><?php echo $query_state2_result['cslogs'];?></td>			    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and
							u.first_name in ('CS-Logs')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="2">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>
				    	<tr data-id="3" data-parent="">
				    		<td class="state">CS-Infra</td>
				    		<td class="own"><?php echo $query_state2_result['csinfra'];?></td>			    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time  from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Sanjaya','Prabath')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="3">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days;?> days</td>
							</tr>
							<?php							
							}
							?>
				    	<tr data-id="4" data-parent="">
				    		<td class="state">CS-Helpdesk</td>
				    		<td class="own"><?php echo $query_state2_result['helpdesk'];?></td>			    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Priyadarshana','Suganthan','Damith','Shanaka','Aathif','John','Interblocks')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="4">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>
				    	<tr data-id="5" data-parent="">
				    		<td class="state">SDI</td>
				    		<td class="own"><?php echo $query_state2_result['sdi'];?></td>				    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time  from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Udul','Sujith')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="5">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>
							<tr data-id="0" data-parent="">
					    		<td class="state">Others</td>
					    		<td class="own"><?php echo $query_state2_result['others'];?></td>		    		
				    		</tr>
				    		<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Assigned' and iv.customer_id='LKA-NTB' and 
							u.first_name not in ('Shanaka','John','Aathif',
                        'Suganthan','Priyadarshana','Damith','Interblocks','CS-Logs',
                        'Prabath','Sanjaya','Udul','Sujith','Geehan','Venura',
                        'Nalin','Dilantha','Sameera','Dilan')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="0">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
																
				    		}
				    	?>
				    </tbody>
				</table>
	  		</div>

	  		<div  class="col-md-3">
	  			<table id="table3" class="collaptable table table-warning">
				    <thead>
				    	<tr>
				      		<th colspan="4">Info Pending CSR Breakup</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state2="select	coalesce(sum(issview.cs),0) as cs,
							coalesce(sum(issview.sdi),0) as sdi,
							coalesce(sum(issview.bank),0) as bank,
							coalesce(sum(issview.others),0) as others
							from(select
							case when u.first_name='Shanaka' or u.first_name='John'or
							u.first_name='Aathif' or u.first_name='Priyadarshana' or
							u.first_name='Suganthan' or u.first_name='Damith' or u.first_name='Sanjaya' or 
							u.first_name='Prabath'						
							then count(iv.id) end as cs,						
							case when u.first_name='Udul' or u.first_name='Sujith' then count(iv.id) end as sdi,
							case when u.first_name='Interblocks' then count(iv.id) end as bank,
							case when u.first_name not in('Shanaka','John','Aathif',
                        'Suganthan','Priyadarshana','Damith','Interblocks','CS-Logs',
                        'Prabath','Sanjaya','Udul','Sujith','Geehan','Venura',
                        'Nalin','Dilantha','Sameera','Dilan') then count(iv.id) end as others
							from issuestate_view iss inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Info pending from bank ' and iv.customer_id='LKA-NTB'
							group by iv.user_id) issview";
						$query_state2_run=mysqli_query($connection,$query_state2);
						
						while($query_state2_result=mysqli_fetch_assoc($query_state2_run)){
				    	?>
				    	<tr data-id="6" data-parent="">
				    		<td class="state">Bank</td>
				    		<td class="own"><?php echo $query_state2_result['bank'];?></td>				    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Info pending from bank ' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Interblocks')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							//$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="6">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>		
				    	<tr data-id="7" data-parent="">
				    		<td class="state">CS</td>
				    		<td class="own"><?php echo $query_state2_result['cs'];?></td>				    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Info pending from bank ' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Priyadarshana','Suganthan','Damith','Shanaka','Aathif','John','Sanjaya','Prabath')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							//$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="7">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>	
				    	<tr data-id="8" data-parent="">
				    		<td class="state">SDI</td>
				    		<td class="own"><?php echo $query_state2_result['sdi'];?></td>				    		
				    	</tr>
				    		<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Info pending from bank ' and iv.customer_id='LKA-NTB' and 
							u.first_name in ('Udul','Sujith')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							//$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="8">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
							?>
						<tr data-id="9" data-parent="">
				    		<td class="state">Others</td>
				    		<td class="own"><?php echo $query_state2_result['others'];?></td>			    		
				    	</tr>
				    	<?php
				    	$sup_ass="select u.first_name as owner,iss.name as state,iv.tn as tn,iv.id,iv.create_time from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.user_id 
							where iv.queue_id=80 and iv.create_time>='2019-01-01'
							and iss.name='Info pending from bank ' and iv.customer_id='LKA-NTB' and 
							u.first_name not in ('Shanaka','John','Aathif',
                        'Suganthan','Priyadarshana','Damith','Interblocks','CS-Logs',
                        'Prabath','Sanjaya','Udul','Sujith','Geehan','Venura',
                        'Nalin','Dilantha','Sameera','Dilan')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							//$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
								$create_date=strtotime($sup_ass_result['create_time']);
								$beginday=date('Y-m-d',$create_date);
								$lastday =date('Y-m-d');
								$nr_work_days = getWorkingDays($beginday,$lastday);
							?>
							<tr data-parent="9">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['owner'];?></td>
								<td><?php echo $nr_work_days; ?> days</td>
							</tr>
							<?php							
							}
																							
				    		}
				    	?>
				    </tbody>
				</table>
	  		</div>
	  		<div class="col-md-3 sup" >
	  			<table id="table4" class="collaptable table table-info">
				    <thead>
				    	<tr>
				      		<th colspan="4">Todays CSR</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_today="select iss.name as state,count(iv.tn) as count,iss.id from issue_view iv
						inner join issuestate_view iss on iv.ticket_state_id=iss.id
						where iv.queue_id=80 and iv.customer_id='LKA-NTB'
						and date(iv.create_time)=curdate()
						group by state";
						$query_today_run=mysqli_query($connection,$query_today);
						
						while($result_today=mysqli_fetch_array($query_today_run)){
				    	?>
				    	<tr data-id="<?php echo $result_today['id'];?>" data-parent="">
				    		<td class="state"><?php echo $result_today['state'] ?></td>
				    		<td><?php echo $result_today['count'] ?></td>				    	   	
				    	</tr>
				    	<?php 
				    	$query_today_csr="select iv.tn,iv.id,u.first_name as owner from issue_view iv
						inner join issuestate_view iss on iv.ticket_state_id=iss.id
						inner join intuser_view u on iv.user_id=u.id
						where iv.queue_id=80 and iv.customer_id='LKA-NTB'
						and date(iv.create_time)=curdate()
						and iss.name='".$result_today['state']."'";	
						$query_today_csr_run=mysqli_query($connection,$query_today_csr);

						while($result_today_csr=mysqli_fetch_assoc($query_today_csr_run)){
						?>
						<tr data-parent="<?php echo $result_today['id'];?>">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $result_today_csr['id'];?>" target="_blank"><?php echo $result_today_csr['tn'];?></a></td>
								<td><?php echo $result_today_csr['owner'];?></td>
						</tr>
						<?php
						}

						}		    	
				    	?>
				    </tbody>
				</table>
	  		</div>
	  	</div>
	  </div>
	 </div>
	</div>	 
	</body>
</html>
<?php
}
?>