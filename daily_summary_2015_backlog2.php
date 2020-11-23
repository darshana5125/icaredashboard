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

// $daily_reported="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and queue_id not in (7,21,24,25,26,13)";
$daily_reported="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%'";
$daily_reported_run=mysqli_query($connection,$daily_reported);
$daily_row=mysqli_fetch_assoc($daily_reported_run);
$daily_count=$daily_row['num'];


// $daily_closed="select  count(tn) as num from sla_table where exception=0 and  tn in
// (select tn from issue_view where date(create_time)= CURRENT_DATE 
// and date(change_time)= CURRENT_DATE and ticket_state_id in
// (select id from issuestate_view where id=17))";
$daily_closed="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Closed')";
$daily_closed_run=mysqli_query($connection,$daily_closed);
$daily_row2=mysqli_fetch_assoc($daily_closed_run);
$daily_count2=$daily_row2['num'];


// $daily_pending="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) = CURRENT_DATE and ticket_state_id in
// (select id from issuestate_view where id in(4,23,20,26)))" ;
$daily_pending="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Assigned','QA / testing','Pending SVN Release',
'Pending Site visit','Under Observation','CR Processing')";
$daily_pending_run=mysqli_query($connection,$daily_pending) ;
$daily_row3=mysqli_fetch_assoc($daily_pending_run);
$daily_count3=$daily_row3['num'];

// $daily_pending2="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) = CURRENT_DATE and ticket_state_id in
// (select id from issuestate_view where id in(14)))" ;
$daily_pending2="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Info pending from bank','Pending Remote Session / Discussion')";
$daily_pending2_run=mysqli_query($connection,$daily_pending2) ;
$daily_row4=mysqli_fetch_assoc($daily_pending2_run);
$daily_count4=$daily_row4['num'];

// $daily_sla="select count(tn) as num from sla_table where exception=0 and sla_state=3  and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) = CURRENT_DATE)" ;
$daily_sla="select count(distinct tn) as num from view_temp2 where date(breached_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and sla_state=3";
$daily_sla_run=mysqli_query($connection,$daily_sla) ;
$daily_row5=mysqli_fetch_assoc($daily_sla_run);
$daily_count5=$daily_row5['num'];

// $daily_uat="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) = CURRENT_DATE and
// ticket_state_id in(select id from issuestate_view where id in (25,24,29,28,27,7)))";
$daily_uat="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Fix given for UAT',
'Explanation given','Pending Permanent Fix','Time Line Given',
'Pending Clarification','Pending Closure','Assigned to Pre Sales')";
$daily_uat_run=mysqli_query($connection,$daily_uat) ;
$daily_row6=mysqli_fetch_assoc($daily_uat_run);
$daily_count6=$daily_row6['num'];

// $daily_hold="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn  in(
// select tn from issue_view where date(create_time) = CURRENT_DATE and ticket_state_id in
// (select id from issuestate_view where id in(13)))";
$daily_hold="select count(distinct tn) as num from view_temp2 where date(create_time) = CURRENT_DATE and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('on hold')";
$daily_hold_run=mysqli_query($connection,$daily_hold) ;
$daily_row7=mysqli_fetch_assoc($daily_hold_run);
$daily_count7=$daily_row7['num'];


// $weekly_reported="select  count(distinct tn) as num from view_temp2 where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and exception=0 and queue_id not in (7,21,24,25,26,13)";
$weekly_reported="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY)";
$weekly_reported_run=mysqli_query($connection,$weekly_reported) ;
$weekly_row=mysqli_fetch_assoc($weekly_reported_run);
$weekly_count=$weekly_row['num'];
$weekly_reported_run=mysqli_query($connection,$weekly_reported) ;
$weekly_row=mysqli_fetch_assoc($weekly_reported_run);
$weekly_count=$weekly_row['num'];

// $weekly_closed="select count(tn) as num from sla_table where exception=0 and tn in
// (select tn from issue_view where date(create_time)>= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) 
// and date(change_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(change_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and ticket_state_id in
// (select id from issuestate_view where id=17))";
$weekly_closed="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and ts_name in('Closed')";
$weekly_closed_run=mysqli_query($connection,$weekly_closed) ;
$weekly_row2=mysqli_fetch_assoc($weekly_closed_run);
$weekly_count2=$weekly_row2['num'];

// $weekly_pending="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and ticket_state_id in
// (select id from issuestate_view where id in(4,23,20,26)))";
$weekly_pending="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and 
ts_name in('Assigned','QA / testing','Pending SVN Release','Pending Site visit','Under Observation','CR Processing')";
$weekly_pending_run=mysqli_query($connection,$weekly_pending) ;
$weekly_row3=mysqli_fetch_assoc($weekly_pending_run);
$weekly_count3=$weekly_row3['num'];

// $weekly_pending2="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and ticket_state_id in
// (select id from issuestate_view where id in(14)))";
$weekly_pending2="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and 
 ts_name in('Info pending from bank','Pending Remote Session / Discussion')";
$weekly_pending2_run=mysqli_query($connection,$weekly_pending2) ;
$weekly_row4=mysqli_fetch_assoc($weekly_pending2_run);
$weekly_count4=$weekly_row4['num'];

// $weekly_sla="select count(tn) as num from sla_table where exception=0 and sla_state=3 and queue_id not in (7,21,24,25,26,13)and tn in(
// select tn from issue_view where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY))" ;
$weekly_sla="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(breached_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(breached_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and sla_state=3";
$weekly_sla_run=mysqli_query($connection,$weekly_sla) ;
$weekly_row5=mysqli_fetch_assoc($weekly_sla_run);
$weekly_count5=$weekly_row5['num'];

// $weekly_uat="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and
// ticket_state_id in(select id from issuestate_view where id in (25,24,29,28,27,7)))" ;
$weekly_uat="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and 
 ts_name in('Fix given for UAT','Explanation given','Pending Permanent Fix','Time Line Given','Pending Clarification','Pending Closure','Assigned to Pre Sales')";
 
$weekly_uat_run=mysqli_query($connection,$weekly_uat) ;
$weekly_row6=mysqli_fetch_assoc($weekly_uat_run);
$weekly_count6=$weekly_row6['num'];

// $weekly_hold="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
// and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and ticket_state_id in
// (select id from issuestate_view where id in(13)))";
$weekly_hold="select  count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues',
'DELETED_TICKETS') and q_name not like '%_UAT%' and date(create_time) >= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY)
and date(create_time) <= DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-7 DAY) and 
 ts_name in('on hold')";
$weekly_hold_run=mysqli_query($connection,$weekly_hold) ;
$weekly_row7=mysqli_fetch_assoc($weekly_hold_run);
$weekly_count7=$weekly_row7['num'];


//$monthly_reported="select  count(distinct tn) as num from view_temp2 where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) and exception=0";
$monthly=$monthly_reported="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name not in('merged')";
$monthly_reported_run=mysqli_query($connection,$monthly_reported) ;
$monthly_row=mysqli_fetch_assoc($monthly_reported_run);
$monthly_count=$monthly_row['num'];


// $monthly_closed="select count(tn) as num from sla_table where exception=0 and  tn in
// (select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) 
// and month(change_time) = month(CURDATE()) and year(change_time)= year(CURDATE()) and ticket_state_id in
// (select id from issuestate_view where id=17))";
$monthly_closed="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Closed')" ;
$monthly_closed_run=mysqli_query($connection,$monthly_closed) ;
$monthly_row2=mysqli_fetch_assoc($monthly_closed_run);
$monthly_count2=$monthly_row2['num'];

// $monthly_pending="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) and ticket_state_id in
// (select id from issuestate_view where id in(4,23,20,26)))";
$monthly_pending="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Assigned','QA / testing','Pending SVN Release','Pending Site visit','Under Observation','CR Processing' )";
$monthly_pending_run=mysqli_query($connection,$monthly_pending) ;
$monthly_row3=mysqli_fetch_assoc($monthly_pending_run);
$monthly_count3=$monthly_row3['num'];

// $monthly_pending2="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) and ticket_state_id in
// (select id from issuestate_view where id in(14)))" ;
$monthly_pending2="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Info pending from bank','Pending Remote Session / Discussion')";
$monthly_pending2_run=mysqli_query($connection,$monthly_pending2) ;
$monthly_row4=mysqli_fetch_assoc($monthly_pending2_run);
$monthly_count4=$monthly_row4['num'];

// $monthly_sla="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and sla_state=3 and tn in(
// select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()))" ;
$monthly_sla="select  count(distinct tn) as num from view_temp2 where exception=0 and sla_state=3 and month(breached_time) = month(CURDATE()) and year(breached_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%'";
$monthly_sla_run=mysqli_query($connection,$monthly_sla) ;
$monthly_row5=mysqli_fetch_assoc($monthly_sla_run);
$monthly_count5=$monthly_row5['num'];

// $monthly_uat="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) and
// ticket_state_id in(select id from issuestate_view where id in (25,24,29,28,27,7)))";
$monthly_uat="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Fix given for UAT','Explanation given','Pending Permanent Fix',
'Time Line Given','Pending Clarification','Pending Closure','Assigned to Pre Sales')";
$monthly_uat_run=mysqli_query($connection,$monthly_uat) ;
$monthly_row6=mysqli_fetch_assoc($monthly_uat_run);
$monthly_count6=$monthly_row6['num'];

// $monthly_hold="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE()) and ticket_state_id in
// (select id from issuestate_view where id in(13)))";
$monthly_hold="select  count(distinct tn) as num from view_temp2 where exception=0 and month(create_time) = month(CURDATE()) and year(create_time)= year(CURDATE())
 and exception=0 and  q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('on hold')";
$monthly_hold_run=mysqli_query($connection,$monthly_hold) ;
$monthly_row7=mysqli_fetch_assoc($monthly_hold_run);
$monthly_count7=$monthly_row7['num'];

$reported="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception =0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name not in('merged')";
//select count(distinct(tn)) as num from view_temp2 where exception=0  and queue_id not in (7,21,24,25,26,13);
$reported_run=mysqli_query($connection,$reported) ;
$row=mysqli_fetch_assoc($reported_run);
$count=$row['num'];

$reported="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception='0' and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name not in('merged')";
//select count(distinct(tn)) as num from view_temp2 where exception=0  and queue_id not in (7,21,24,25,26,13);
$reported_run=mysqli_query($connection,$reported) ;
$row=mysqli_fetch_assoc($reported_run);
$count_backlog=$row['num'];
 //$count='333';
 
 
// $closed="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00' and ticket_state_id in
// (select id from issuestate_view where id=17))";
$closed="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name='Closed'";
$closed_run=mysqli_query($connection,$closed) ;
$row2=mysqli_fetch_assoc($closed_run);
$count2=$row2['num'];

$closed="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name='Closed'";
$closed_run=mysqli_query($connection,$closed) ;
$row2=mysqli_fetch_assoc($closed_run);
$count2_backlog=$row2['num'];

// $pending="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00' and ticket_state_id in
// (select id from issuestate_view where id in(4,23,20,26)))" ;
$pending="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Assigned', 'Pending Site visit','QA / testing','Pending SVN Release','Under Observation','CR Processing')";
$pending_run=mysqli_query($connection,$pending) ;
$row3=mysqli_fetch_assoc($pending_run);
$count3=$row3['num'];

$pending1="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Assigned', 'Pending Site visit','QA / testing','Pending SVN Release','Under Observation', 'CR Processing' )";
$pending1_run=mysqli_query($connection,$pending1) ;
$row3=mysqli_fetch_assoc($pending1_run);
$count3_backlog=$row3['num'];

// $pending2="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00' and ticket_state_id in
// (select id from issuestate_view where id in(14)))" ;
$pending2="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Info pending from bank','Pending Remote Session / Discussion')";
$pending2_run=mysqli_query($connection,$pending2) ;
$row4=mysqli_fetch_assoc($pending2_run);
$count4=$row4['num'];

$pending2="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Info pending from bank','Pending Remote Session / Discussion')";
$pending2_run=mysqli_query($connection,$pending2) ;
$row4=mysqli_fetch_assoc($pending2_run);
$count4_backlog=$row4['num'];

// $sla="select count(tn) as num from sla_table where exception=0 and sla_state=3 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00')" ;
$sla="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and sla_state=3 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name not in('merged')";



$sla_run=mysqli_query($connection,$sla) ;
$row5=mysqli_fetch_assoc($sla_run);
$count5=$row5['num'];

$sla="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and sla_state=3 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name not in ('merged')";
$sla_run=mysqli_query($connection,$sla) ;
$row5=mysqli_fetch_assoc($sla_run);
$count5_backlog=$row5['num'];

// $uat="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00' and
// ticket_state_id in(select id from issuestate_view where id in (25,24,29,28,27,7)))";
$uat="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Fix given for UAT','Explanation given','Pending Permanent Fix',
'Time Line Given','Pending Clarification','Pending Closure','Assigned to Pre Sales')";

$uat_run=mysqli_query($connection,$uat) ;
$row6=mysqli_fetch_assoc($uat_run);
$count6=$row6['num'];

$uat="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('Fix given for UAT','Explanation given','Pending Permanent Fix',
'Time Line Given','Pending Clarification','Pending Closure','Assigned to Pre Sales')";

$uat_run=mysqli_query($connection,$uat) ;
$row6=mysqli_fetch_assoc($uat_run);
$count6_backlog=$row6['num'];

// $hold="select count(tn) as num from sla_table where exception=0 and queue_id not in (7,21,24,25,26,13) and tn in(
// select tn from issue_view where create_time >'2014-11-10 00:01:00' and ticket_state_id in
// (select id from issuestate_view where id in(13)))";
$hold="select count(distinct tn) as num from view_temp2 where create_time>='2019-04-01' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('on hold')";
$hold_run=mysqli_query($connection,$hold) ;
$row7=mysqli_fetch_assoc($hold_run);
$count7=$row7['num'];

$hold="select count(distinct tn) as num from view_temp2 where create_time between '2014-11-10' and '2019-03-31' and exception=0 and q_name not in('Change Request Queue','NDB - Live Issues','DELETED_TICKETS') and q_name not like '%_UAT%' and ts_name in('on hold')";
$hold_run=mysqli_query($connection,$hold) ;
$row7=mysqli_fetch_assoc($hold_run);
$count7_backlog=$row7['num'];

$wper=@($weekly_count2/$weekly_count);
$wclosed=number_format( $wper * 100, 0 ) . '%';

$wper2=@($weekly_count3/$weekly_count);
$wpen=number_format( $wper2 * 100, 0 ) . '%';

$wper3=@($weekly_count4/$weekly_count);
$wpen2=number_format( $wper3 * 100, 0 ) . '%';

$wper4=@($weekly_count5/$weekly_count);
$wsla=number_format( $wper4 * 100, 0 ) . '%';

$wper5=@($weekly_count6/$weekly_count);
$wuat=number_format( $wper5 * 100, 0 ) . '%';

$wper6=@($weekly_count7/$weekly_count);
$whold=number_format( $wper6 * 100, 0 ) . '%';


$mper=$monthly_count2/$monthly_count;
$mclosed=number_format( $mper * 100, 0 ) . '%';

$mper2=$monthly_count3/$monthly_count;
$mpen=number_format( $mper2 * 100, 0 ) . '%';

$mper3=$monthly_count4/$monthly_count;
$mpen2=number_format( $mper3 * 100, 0 ) . '%';

$mper4=$monthly_count5/$monthly_count;
$msla=number_format( $mper4 * 100, 0 ) . '%';

$mper5=$monthly_count6/$monthly_count;
$muat=number_format( $mper5 * 100, 0 ) . '%';

$mper6=$monthly_count7/$monthly_count;
$mhold=number_format( $mper6 * 100, 0 ) . '%';



$per=$count2/$count;
$closed=number_format( $per * 100, 0 ) . '%';

$per=$count2_backlog/$count_backlog;
$closed_backlog=number_format( $per * 100, 0 ) . '%';

$per2=$count3/$count;
$pen=number_format( $per2 * 100, 0 ) . '%';

$per2=$count3_backlog/$count_backlog;
$pen_backlog=number_format( $per2 * 100, 0 ) . '%';


$per3=$count4/$count;
$pen2=number_format( $per3 * 100, 0 ) . '%';

$per3=$count4_backlog/$count_backlog;
$pen2_backlog=number_format( $per3 * 100, 0 ) . '%';

$per4=$count5/$count;
$sla=number_format( $per4 * 100, 0 ) . '%';

$per4=$count5_backlog/$count_backlog;
$sla_backlog=number_format( $per4 * 100, 0 ) . '%';

$per5=$count6/$count;
$uat=number_format( $per5 * 100, 0 ) . '%';

$per5=$count6_backlog/$count_backlog;
$uat_backlog=number_format( $per5 * 100, 0 ) . '%';

$per6=$count7/$count;
$hold=number_format( $per6 * 100, 0 ) . '%';

$per6=$count7_backlog/$count_backlog;
$hold_backlog=number_format( $per6 * 100, 0 ) . '%';



echo'<link rel="stylesheet" type="text/css" href="css/summary.css"/> 
<link rel="stylesheet" href="ums/css/main.css">';
?>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php

echo'<table id="tablestyle" border="1" cellpadding="1" cellspacing="1" >
	<tbody>
		<tr>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor=2C4DA1 class="third">Daily Summary</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" rowspan="2" class="forth"># Issues Reported</td>
			<td colspan="1" rowspan="2" class="forth"># Issues Closed</td>
			<td colspan="2" rowspan="1" class="forth"># Pending</td>
			
			<td colspan="1" rowspan="2" class="forth"># Fix / UAT /Explanation given</td>
			<td colspan="1" rowspan="2" class="forth"># On Hold</td>
			<td colspan="1" rowspan="2" class="forth"># SLA Not Met</td>
		</tr>
		<tr>
			<td class="inside">IBL</td>
			<td class="inside">Customer</td>
		</tr>
		<tr>
			<td align="center">'.$daily_count.'</td>
			<td align="center">'.$daily_count2.'</td>
			<td align="center">'.$daily_count3.'</td>
			<td align="center">'.$daily_count4.'</td>
		
			<td align="center">'.$daily_count6.'</td>
			<td align="center">'.$daily_count7.'</td>
				<td align="center">'.$daily_count5.'</td>
		</tr>
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		
		
		<tr>
			<td bgcolor=2C4DA1 class="third">Weekly Summary</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" rowspan="2" class="forth"># Issues Reported</td>
			<td colspan="1" rowspan="2" class="forth"># Issues Closed</td>
			<td colspan="2" rowspan="1" class="forth"># Pending</td>
		
			<td colspan="1" rowspan="2" class="forth"># Fix / UAT /Explanation given</td>
			<td colspan="1" rowspan="2" class="forth"># On Hold</td>
				<td colspan="1" rowspan="2" class="forth"># SLA Not Met</td>
		</tr>
		<tr>
			<td class="inside">IBL</td>
			<td class="inside">Customer</td>
		</tr>
		<tr>
			<td align="center">'.$weekly_count.'</td>
			<td align="center">'.$weekly_count2.'</td>
			<td align="center">'.$weekly_count3.'</td>
			<td align="center">'.$weekly_count4.'</td>
			
			<td align="center">'.$weekly_count6.'</td>
			<td align="center">'.$weekly_count7.'</td>
			<td align="center">'.$weekly_count5.'</td>
		</tr>
		<tr>
			<td align="center" hieght="20px">%</td>
			<td align="center" hieght="20px">'.$wclosed.'</td>
			<td align="center" hieght="20px">'.$wpen.'</td>
			<td align="center" hieght="20px">'.$wpen2.'</td>
			
			<td align="center" hieght="20px">'.$wuat.'</td>
			<td align="center"hieght="20px" >'.$whold.'</td>
			<td align="center" hieght="20px"><font color="red">-</font></td>
		</tr>
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		
		
		<tr>
			<td bgcolor=2C4DA1 class="third">Monthly Summary</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" rowspan="2" class="forth"># Issues Reported</td>
			<td colspan="1" rowspan="2" class="forth"># Issues Closed</td>
			<td colspan="2" rowspan="1" class="forth"># Pending</td>
			
			<td colspan="1" rowspan="2" class="forth"># Fix / UAT /Explanation given</td>
			<td colspan="1" rowspan="2" class="forth"># On Hold</td>
			<td colspan="1" rowspan="2" class="forth"># SLA Not Met</td>
		</tr>
		<tr>
			<td class="inside">IBL</td>
			<td class="inside">Customer</td>
		</tr>
		<tr>
			<td  align="center">'.$monthly_count.'</td>
			<td  align="center">'.$monthly_count2.'</td>
			<td  align="center">'.$monthly_count3.'</td>
			<td  align="center">'.$monthly_count4.'</td>
			
			<td  align="center">'.$monthly_count6.'</td>
			<td  align="center">'.$monthly_count7.'</td>
			<td  align="center">'.$monthly_count5.'</td>
		</tr>
		<tr>
			<td align="center" hieght="20px">%</td>
			<td align="center" hieght="20px">'.$mclosed.'</td>
			<td align="center" hieght="20px">'.$mpen.'</td>
			<td align="center" hieght="20px">'.$mpen2.'</td>
			
			<td align="center" hieght="20px">'.$muat.'</td>
			<td align="center"hieght="20px">'.$mhold.'</td>
			<td align="center" hieght="20px"><font color="red">-</font></td>
		</tr>
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		
		
		<tr>
			<td bgcolor=2C4DA1 class="third">Cumulative Summary</td>
			<td bgcolor=2C4DA1 class="third">1st Apr 2019 Onwards</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
			<td bgcolor=2C4DA1>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" rowspan="2" class="forth"># Issues Reported</td>
			<td colspan="1" rowspan="2" class="forth"># Issues Closed</td>
			<td colspan="2" rowspan="1" class="forth"># Pending</td>
			
			<td colspan="1" rowspan="2" class="forth"># Fix / UAT /Explanation given</td>
			<td colspan="1" rowspan="2" class="forth"># On Hold</td>
			<td colspan="1" rowspan="2" class="forth"># SLA Not Met</td>
		</tr>
		<tr>
			<td class="inside">IBL</td>
			<td class="inside">Customer</td>
		</tr>
		<tr>
			<td align="center">'.$count.'</td>
			<td align="center">'.$count2.'</td>
			<td align="center">'.$count3.'</td>
			<td align="center">'.$count4.'</td>
			
			<td align="center">'.$count6.'</td>
			<td align="center">'.$count7.'</td>
			<td align="center">'.$count5.'</td>
		</tr>
		<tr>
			<td align="center" hieght="20px">%</td>
			<td align="center" hieght="20px">'.$closed.'</td>
			<td align="center" hieght="20px">'.$pen.'</td>
			<td align="center" hieght="20px">'.$pen2.'</td>

			<td align="center" hieght="20px">'.$uat.'</td>
			<td align="center"hieght="20px">'.$hold.'</td>
			<td align="center" hieght="20px"><font color="red">'.$sla.'</font></td>
		</tr>
		
		
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		
		
		<tr>
			<td bgcolor= #8fb283  class="third2">Cumulative Summary</td>
			<td bgcolor= #8fb283 class="third2" >10th Nov 2014 - 31st Mar 2019</td>
			<td bgcolor= #8fb283 >&nbsp;</td>
			<td bgcolor= #8fb283 >&nbsp;</td>
			<td bgcolor= #8fb283 >&nbsp;</td>
			<td bgcolor= #8fb283 >&nbsp;</td>
			<td bgcolor= #8fb283 >&nbsp;</td>
		</tr>
		<tr>
			<td colspan="1" rowspan="2" class="forth"># Issues Reported</td>
			<td colspan="1" rowspan="2" class="forth"># Issues Closed</td>
			<td colspan="2" rowspan="1" class="forth"># Pending</td>
			
			<td colspan="1" rowspan="2" class="forth"># Fix / UAT /Explanation given</td>
			<td colspan="1" rowspan="2" class="forth"># On Hold</td>
			<td colspan="1" rowspan="2" class="forth"># SLA Not Met</td>
		</tr>
		<tr>
			<td class="inside">IBL</td>
			<td class="inside">Customer</td>
		</tr>
		<tr>
			<td align="center">'.$count_backlog.'</td>
			<td align="center">'.$count2_backlog.'</td>
			<td align="center">'.$count3_backlog.'</td>
			<td align="center">'.$count4_backlog.'</td>
			
			<td align="center">'.$count6_backlog.'</td>
			<td align="center">'.$count7_backlog.'</td>
			<td align="center">'.$count5_backlog.'</td>
		</tr>
		<tr>
			<td align="center" hieght="20px">%</td>
			<td align="center" hieght="20px">'.$closed_backlog.'</td>
			<td align="center" hieght="20px">'.$pen_backlog.'</td>
			<td align="center" hieght="20px">'.$pen2_backlog.'</td>

			<td align="center" hieght="20px">'.$uat_backlog.'</td>
			<td align="center"hieght="20px">'.$hold_backlog.'</td>
			<td align="center" hieght="20px"><font color="red">'.$sla_backlog.'</font></td>
		</tr>
		<tr>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=#FACC2E>&nbsp;</td>
			<td bgcolor=red>&nbsp;</td>
		</tr>
		
		<tr>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
			<td bgcolor="black">&nbsp;</td>
		</tr>
		
	</tbody>
</table>';


$backlog_qa="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='23' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_qa=mysqli_query($connection,$backlog_qa);
$result_backlog_qa=mysqli_fetch_assoc($backlog_run_qa);
$num_qa=mysqli_num_rows($backlog_run_qa);

$backlog_psv="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='20' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_psv=mysqli_query($connection,$backlog_psv);
$result_backlog_psv=mysqli_fetch_assoc($backlog_run_psv);
$num_psv=mysqli_num_rows($backlog_run_psv);

$backlog_pac="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='7' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_pac=mysqli_query($connection,$backlog_pac);
$result_backlog_pac=mysqli_fetch_assoc($backlog_run_pac);
$num_pac=mysqli_num_rows($backlog_run_pac);

$backlog_mer="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='9' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_mer=mysqli_query($connection,$backlog_mer);
$result_backlog_mer=mysqli_fetch_assoc($backlog_run_mer);
$num_mer=mysqli_num_rows($backlog_run_mer);

$backlog_hold="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='13' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_hold=mysqli_query($connection,$backlog_hold);
$result_backlog_hold=mysqli_fetch_assoc($backlog_run_hold);
$num_hold=mysqli_num_rows($backlog_run_hold);

$backlog_pc="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='27' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_pc=mysqli_query($connection,$backlog_pc);
$result_backlog_pc=mysqli_fetch_assoc($backlog_run_pc);
$num_pc=mysqli_num_rows($backlog_run_pc);

$backlog_ip="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='14' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_ip=mysqli_query($connection,$backlog_ip);
$result_backlog_ip=mysqli_fetch_assoc($backlog_run_ip);
$num_ip=mysqli_num_rows($backlog_run_ip);

$backlog_uat="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='25' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_uat=mysqli_query($connection,$backlog_uat);
$result_backlog_uat=mysqli_fetch_assoc($backlog_run_uat);
$num_uat=mysqli_num_rows($backlog_run_uat);

$backlog_eg="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='24' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_eg=mysqli_query($connection,$backlog_eg);
$result_backlog_eg=mysqli_fetch_assoc($backlog_run_eg);
$num_eg=mysqli_num_rows($backlog_run_eg);


$backlog_cls="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='17' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_cls=mysqli_query($connection,$backlog_cls);
$result_backlog_cls=mysqli_fetch_assoc($backlog_run_cls);
$num_cls=mysqli_num_rows($backlog_run_cls);

$backlog_pmo="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='16' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_pmo=mysqli_query($connection,$backlog_pmo);
$result_backlog_pmo=mysqli_fetch_assoc($backlog_run_pmo);
$num_pmo=mysqli_num_rows($backlog_run_pmo);

$backlog_asn="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='4' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_asn=mysqli_query($connection,$backlog_asn);
$result_backlog_asn=mysqli_fetch_assoc($backlog_run_asn);
$num_asn=mysqli_num_rows($backlog_run_asn);

$backlog_tlg="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='28' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_tlg=mysqli_query($connection,$backlog_tlg);
$result_backlog_tlg=mysqli_fetch_assoc($backlog_run_tlg);
$num_tlg=mysqli_num_rows($backlog_run_tlg);

$backlog_ppf="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='29' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_ppf=mysqli_query($connection,$backlog_ppf);
$result_backlog_ppf=mysqli_fetch_assoc($backlog_run_ppf);
$num_ppf=mysqli_num_rows($backlog_run_ppf);

$backlog_psr="SELECT count(issue_view.tn) as counter, issuestate_view.name FROM issue_view inner join
issuestate_view where
issuestate_view.id='26' and
issue_view.create_time between '2013-01-01 00:00:00' and 
'2014-11-11 00:00:00'  and issue_view.queue_id
in(5,7,8,9,10,12,18,11) and !(issue_view.change_time  <'2014-11-10 00:00:00'  and issue_view.ticket_state_id='17') 
and issue_view.tn
not in('100000854','100000866','100001595','100001614','100002024') 
and issue_view.ticket_state_id=issuestate_view.id
group by issuestate_view.name";
$backlog_run_psr=mysqli_query($connection,$backlog_psr);
$result_backlog_psr=mysqli_fetch_assoc($backlog_run_psr);
$num_psr=mysqli_num_rows($backlog_run_psr);


}else{
	header('Location: index.php');
}	


//mysqli_close($link);

?>
