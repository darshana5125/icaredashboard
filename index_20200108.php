<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
if(!isset($_SESSION['user_id'])){
header('Location:ums/index2.php');
}
?>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  
 <script type='text/javascript'>
 	//uid = 0;
function hod()
{
	//uid=1;
	//window.open("http://localhost/icaredashboard/hod6.php?uid=1","_blank");
	window.open("https://192.168.47.25/icaredashboard/hod6.php?mid=14","_blank");
}
function brk_up()
{
	window.open("https://192.168.47.25/icaredashboard/hod_break_up2.php","_blank");
}
function daily()
{
	window.open("https://192.168.47.25/icaredashboard/daily_report_live_2015_2.php?mid=3","_blank");
}

function exceptions()
{
	window.open("https://192.168.47.25/icaredashboard/exceptions.php?mid=2","_blank");
}

function sla()
{
	window.open("https://192.168.47.25/icaredashboard/sla_update.php?mid=5","_blank");
}

function filter()
{
	window.open("https://192.168.47.25/icaredashboard/filter.php?mid=8","_blank");
}

function summary()
{
	window.open("https://192.168.47.25/icaredashboard/daily_summary_2015_backlog2.php?mid=6","_blank");
}

function cr()
{
	window.open("https://192.168.47.25/icaredashboard/cr_report.php?mid=9","_blank");
}

function escalation()
{
	window.open("https://192.168.47.25/icaredashboard/first_escalation_pending.php?mid=1","_blank");
}
function month()
{
window.open("https://192.168.47.25/icaredashboard/daily_report_live_2015_monthly.php","_blank");
}
function old_daily()
{
window.open("https://192.168.47.25/icaredashboard/daily_report_live_2015.php","_blank");
}
function breached_items()
{
window.open("https://192.168.47.25/icaredashboard/breached_list.php?mid=11","_blank");
}

function ucpb_issues()
{
window.open("https://192.168.47.25/icaredashboard/ticket_escalation_lastest_with_UCPB.php","_blank");
}

function state_count()
{
window.open("https://192.168.47.25/icaredashboard/state_wise_count_r9a.php?mid=7","_blank");
}

function pending_open()
{
window.open("https://192.168.47.25/icaredashboard/pending_follow_ups.php?mid=10","_blank");
}

function pending_fix()
{
window.open("https://192.168.47.25/icaredashboard/pending_follow_ups_fix.php?mid=17","_blank");
}
function sms_navigate()
{
window.open("https://192.168.47.25/icaredashboard:8084/Send_Message_Web/","_blank");
}

function mis()
{
window.open("https://192.168.47.25/icaredashboard/mis_graph.php","_blank");
}

function mis()
{
window.open("https://192.168.47.25/icaredashboard/mis_graph.php","_blank");
}

function mis()
{
window.open("https://192.168.47.25/icaredashboard/mis_graph.php","_blank");
}

function mis()
{
window.open("https://192.168.47.25/icaredashboard/mis_graph.php","_blank");
}
function mis()
{
window.open("https://192.168.47.25/icaredashboard/mis_graph.php","_blank");
}

function hod_new()
{
window.open("https://192.168.47.25/icaredashboard/hod_new.php","_blank");
}
function hod_backlog()
{
window.open("https://192.168.47.25/icaredashboard/hod_backlog.php","_blank");
}
function hod_res_new()
{
window.open("https://192.168.47.25/icaredashboard/hod_res_new.php","_blank");
}
function hod_res_backlog()
{
window.open("https://192.168.47.25/icaredashboard/hod_res_backlog.php","_blank");
}

function daily_old()
{
window.open("https://192.168.47.25/icaredashboard/daily_report_live_2015_2_old.php?mid=4","_blank");
}

function sla_count()
{
window.open("https://192.168.47.25/icaredashboard/sla_update_count.php?mid=12","_blank");
}

function sla_brk()
{
window.open("https://192.168.47.25/icaredashboard/sla_brkdwn.php?mid=13","_blank");
}

function ntb_mon()
{
window.open("https://192.168.47.25/icaredashboard/ntb_mon.php?mid=16","_blank");
}

function ntb_mon2()
{
window.open("https://192.168.47.25/icaredashboard/ntb_mon2.php?mid=15","_blank");
}

function cx_report()
{
window.open("https://192.168.47.25/icaredashboard/customer_report.php?mid=18","_blank");
}
function client_wise()
{
window.open("https://192.168.47.25/icaredashboard/client_wise.php?mid=19","_blank");
}
function agent_wise()
{
window.open("https://192.168.47.25/icaredashboard/agent_wise.php?mid=20","_blank");
}



</script>

<link href="css/home.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="ums/css/main.css">

</head>
<header>
			<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>

<body id="background" class="home">
<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>

<script type="text/javascript">
 var images = ['ibbl.jpg','wp_02.jpg','wp_03.jpg','wp_04.jpg','wp_05.jpg','wp_06.jpg','wp_07.jpg','wp_08.jpg','wp_10.jpg','wp_11.jpg',
 'wp_13.jpg','wp_14.jpg','wp_15.jpg','wp_16.jpg','wp_18.jpg','wp_19.jpg','wp_20.jpg','wp_21.jpg','wp_22_1.jpg','wp_23.jpg',
 'wp_25.jpg','wp_26.jpg','wp_27.jpg','wp_28.jpg','wp_29.jpg','wp_31.jpg','wp_33.jpg','wp_35.jpg'];
 $('#background').css({'background-image': 'url(wallpapers/' + images[Math.floor(Math.random() * images.length)] + ')' }) ;
</script>


	
	
	

<p class="texto">Dashboard</p>
<div class="Registro">
<table  >
<tr>
<td>
<input type="button" value="Ticket Escalation" onclick="escalation();">
</td>
<td>
<input type="button" value="Add/ Delete Exceptions" onclick="exceptions();" >
</td>
<td>
<input type="button" value="Daily Report" onclick="daily();" >
</td>
<td>
<input type="button" value="Daily Report Old" onclick="daily_old();" >
</td>
</tr>

<tr>
<td>
<input type="button" value="HOD Summary" onclick="hod();">
</td>
<td>
<input type="button" value="SLA Update" onclick="sla();">
</td>
<td>
<input type="button" value="Daily Summary" onclick="summary();">
</td>
<td>
<input type="button" value="Fix Stat Report" onclick="state_count();">
</td>
</tr>

<tr>
<td>
<input type="button" value="Report Filter" onclick="filter();">
</td>
<td>
<input type="button" value="CR Report" onclick="cr();">
</td>
<td>
<input type="button" value="Pending Follow Up Open" onclick="pending_open();">
</td>
<td>
<input type="button" value="Breached Items" onclick="breached_items();">
</td>
</tr>



<tr>
<td><input type="button" value="SLA Monitor" onclick="sla_count();"></td>
<td><input type="button" value="SLA Breakdown" onclick="sla_brk();"></td>
<td><input type="button" value="NTB Dashboard" onclick="ntb_mon2();"></td>
<td><input type="button" value="NTB Monitoring CSR" onclick="ntb_mon();"></td>
</tr>	

<tr>
<td><input type="button" value="Pending Follow Up Fix" onclick="pending_fix();"></td>
<td><input type="button" value="Customer Report" onclick="cx_report();"></td>
<td><input type="button" value="Bank wise Breakdown" onclick="client_wise();"></td>
<!--td><input type="button" value="Agent wise Breakdown" onclick="agent_wise();"></td-->
</tr>		
			
			</table>
			</div>
			
			
<body>			
</html>
