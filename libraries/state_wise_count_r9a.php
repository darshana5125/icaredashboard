<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/variables.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="bootstrapcdn/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="googleapis/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
  <script src="bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
  
<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="bootstrapcdn/font-awesome/4.3.0/css/font-awesome.min.css" integrity="sha384-yNuQMX46Gcak2eQsUzmBYgJ3eBeWYNKhnjyiBqLd1vvtE9kuMtgw6bjwN8J0JauQ" crossorigin="anonymous">
  <script src="jquery/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
  <script src="jquery/ui/1.10.3/jquery-ui.js" integrity="sha384-Kv4u0J/5Vhwb62xGQP6LXO686+cmeHY3DPXG9uf265EghKCn2SRAKu9hcHb2FS+L" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
<link rel="stylesheet" href="googleapis/font.css" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/main6.css" rel="stylesheet" type="text/css">
<link rel='stylesheet' href='ums/css/main.css'>
</head>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>

<div class="wrapper">
<div class="form-style-3">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<script type='text/javascript'>
$(window).on("load resize ", function() {
  var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
  $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
function from() {	
		 document.getElementById('datepicker').style.display = 'inline';
		 document.getElementById('datepicker').style.display = 'inline';
		 
		 
		 $(document).ready(function() {
    $( '#datepicker' ).datepicker({ minDate: -1800, maxDate: '3Y+1M+7D',
	
	changeMonth: true, changeYear: true,
	numberOfMonths:1,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	dateFormat:'yy/mm/dd',

	showAnim:'fold'});//fold, slide, blind, bounce, slideDown, show, fadeIn, clip.
  });
	}

function to() {	
		 document.getElementById('datepicker2').style.display = 'inline';
		 document.getElementById('datepicker2').style.display = 'inline';
		 
		 $(document).ready(function() {
    $( '#datepicker2' ).datepicker({ minDate: -1800, maxDate: '3Y+1M+7D',
	changeMonth: true, changeYear: true,
	numberOfMonths:1,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	dateFormat:'yy/mm/dd',
	
	showAnim:'fold'});//fold, slide, blind, bounce, slideDown, show, fadeIn, clip.
  });
	}
</script>
<table class="data" border="0">	
<tr>
<td style="padding-top:55px;padding-left:50px;" width="20%" rowspan="2"><label>Select Date Range</label></td>
<td align="center"><label>From</label></td><td align="center"><label>To</label></td>
</tr>
<tr>
<td align="center"><input type="text" value="<?php if(isset($_POST['datepicker'])) {echo $_POST['datepicker'];} ?>" id="datepicker"  name="datepicker"  onmouseover="from();"></td>
<td align="center"><input type="text" value="<?php if(isset($_POST['datepicker2'])) {echo $_POST['datepicker2'];} ?>" id="datepicker2"  name="datepicker2"  onmouseover="to();"></td>
</tr>
<tr>
<td style="padding-left:50px;" width="60%" ><label>Select Responsible</label></td>

<?php
$from="";
$count="";
$stvalue="";
$cx="";
$to="";

?>

<td style="padding-top:10px;" align="right"><select name="res[]" multiple="multiple" size="5" id="res">
<?php
$query_res="select distinct users.first_name,users.id  from users join ticket on users.id=ticket.responsible_user_id order by users.first_name asc";
$query_res_run=mysqli_query($connection,$query_res);
while($result_res=mysqli_fetch_assoc($query_res_run))
{
	$res=$result_res['first_name'];
	$res_id=$result_res['id'];
	echo '<option value="'.$res_id.'">'.$res.'</option>';
}
?>
</select>
</td>
<td style="padding-left:50px;" width="60%" ><label>Select Customer</label></td>
<td>
<select name="cx[]" multiple="multiple" size="5" id="cx">
<?php
$query_cx="select distinct customer_id from ticket where customer_id is not null and customer_id!=''";
$querycx_run=mysqli_query($connection,$query_cx);
while($result2=mysqli_fetch_assoc($querycx_run))
{
	$name=$result2['customer_id'];
	$cxid=$result2['customer_id'];
	echo '<option value="'.$name.'">'.$name.'</option>';
}
?>
</select>
</td>

<td><input style="background: #6a5750;
  
    border: 1px solid #b5a397;
    padding: 5px 15px 5px 15px;
    color: #c7ad88;
    box-shadow: inset 1px 1px 4px #b5a397;
    -moz-box-shadow: inset 1px 1px 4px #b5a397;
    -webkit-box-shadow: inset 1px 1px 4px #b5a397;
    border-radius: 3px;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;    
    font-weight: bold;
	font-size: 16px;" type="submit" value="Search" name="sumbit"></td>
</tr>
</table>
</form>
</div>

<?php
$count="";
$cx="";
$bf_count="";
$bf_fix_num="";
$in_count="";
$in_fix="";
$bl_count="";
$bl_fix="";
$res="";

function test_input($data) {
  $data = trim($data);
  $data=strip_tags($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST['datepicker']) && isset($_POST['datepicker2']) )
{
	$from=(test_input($_POST['datepicker']));
	$to=(test_input($_POST['datepicker2']));
	
	if( isset($_POST['cx'])){
	foreach($_POST['cx'] as $cx_id)
	{
	
	$cx=$cx."'".$cx_id."'".',';
	}
	$cx=rtrim($cx,',');
	test_input($cx);
	}
	
	
		
	if( isset($_POST['res'])){
	foreach($_POST['res'] as $res_id)
	{
	
	$res=$res."'".$res_id."'".',';
	}
	$res=rtrim($res,',');
	test_input($res);
	}
	
	

$bf_count="";	

if (isset($_POST['cx']) && isset($_POST['res'])){
$query="select th.ticket_id,t.tn,ts.name,u.login,th.change_time,th.state_id,t.customer_id,t.title,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10' 
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join users u on u.id = th.owner_id
inner join service s on s.id=t.service_id
inner join users u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','5','10','17','16','7') and t.customer_id in($cx) and t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)
order by th.ticket_id desc";


}
else if(isset($_POST['cx'])){
	$query="select th.ticket_id,t.tn,ts.name,u.login,th.change_time,th.state_id,t.customer_id,t.title,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10' 
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join users u on u.id = th.owner_id
inner join service s on s.id=t.service_id
inner join users u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','5','10','17','16','7') and t.customer_id in($cx) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)
order by th.ticket_id desc";


	
}else if(isset($_POST['res'])){
$query="select th.ticket_id,t.tn,ts.name,u.login,th.change_time,th.state_id,t.customer_id,t.title,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10' 
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join users u on u.id = th.owner_id
inner join service s on s.id=t.service_id
inner join users u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','5','10','17','16','7') and t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)
order by th.ticket_id desc";


}
else{
$query="select th.ticket_id,t.tn,ts.name,u.login,th.change_time,th.state_id,t.customer_id,t.title,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10' 
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join users u on u.id = th.owner_id
inner join service s on s.id=t.service_id
inner join users u1 on t.responsible_user_id=u1.id
where th.state_id not in ('24','25','5','10','17','16','7') and t.customer_id not in($cx_list) and t.queue_id not in($q_list)
order by th.ticket_id desc";	


}

$query_run=mysqli_query($connection,$query);






if (isset($_POST['cx']) && isset($_POST['res'])){
$query2="select t.id,t.tn,ts.name,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id in($cx) and t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
)";



$query2_state_wise="select t.id,t.tn,ts.name,count(th.state_id) as count,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id in($cx) and t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
) group by th.state_id";



}
else if((isset($_POST['cx']))){
$query2="select t.id,t.tn,ts.name,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id in($cx) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
)";	



$query2_state_wise="select t.id,t.tn,ts.name,count(th.state_id) as count,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id in($cx) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
) group by th.state_id";



}
else if((isset($_POST['res']))){
$query2="select t.id,t.tn,ts.name,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
)";	



$query2_state_wise="select t.id,t.tn,ts.name,count(th.state_id) as count,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and t.responsible_user_id in($res) and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
) group by th.state_id";


}

else{
$query2="select t.id,t.tn,ts.name,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
)";	



$query2_state_wise="select t.id,t.tn,ts.name,count(th.state_id) as count,u.login,th.change_time,t.title,t.customer_id,s.name as sname,u1.first_name
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
    inner join ticket ti
    on h.ticket_id=ti.id
where date(h.change_time) < '$from' 	and
	date(h.change_time) >= '2014-11-10'
	and h.history_type_id = '27'
	
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
inner join service s on t.service_id=s.id
inner join users u1 on t.responsible_user_id=u1.id

inner join users u on u.id = th.owner_id
where  th.state_id in( '24','25','10','17','7','16') and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.state_id not in( '5') and th.ticket_id in (
	select th.ticket_id
	from ticket_history th 
	inner join (
		select min(h.id) as max_hist, h.ticket_id
		from ticket_history h
		where date(h.change_time) <= '$to'
		and date(h.change_time) >= '$from'
		and h.history_type_id = '27'
		and h.state_id not in ('24','25','5','10','17','16','7') 
		group by h.ticket_id
	) open_tickets on open_tickets.max_hist = th.id
) group by th.state_id";


	
}
$query2_run=mysqli_query($connection,$query2);
$query2_state_wise_run=mysqli_query($connection,$query2_state_wise);




if (isset($_POST['cx']) && isset($_POST['res'])){

$query3= "select t.id,t.tn,t.customer_id,t.title,ts.name,s.name as sname,u.login, u1.first_name,t.create_time
from ticket t
inner join ticket_state ts on t.ticket_state_id=ts.id
inner join service s on t.service_id=s.id
inner join users u on t.user_id=u.id
inner join users u1 on t.responsible_user_id=u1.id
where date(t.create_time)<='$to' and 
t.create_time>='$from' and t.customer_id in($cx) and t.responsible_user_id in($res)";


}
else if((isset($_POST['cx']))){
$query3= "select t.id,t.tn,t.customer_id,t.title,ts.name,s.name as sname,u.login, u1.first_name,t.create_time
from ticket t
inner join ticket_state ts on t.ticket_state_id=ts.id
inner join service s on t.service_id=s.id
inner join users u on t.user_id=u.id
inner join users u1 on t.responsible_user_id=u1.id
where date(t.create_time)<='$to' and 
t.create_time>='$from' and t.customer_id in($cx)";


}
else if((isset($_POST['res']))){
$query3= "select t.id,t.tn,t.customer_id,t.title,ts.name,s.name as sname,u.login, u1.first_name,t.create_time
from ticket t
inner join ticket_state ts on t.ticket_state_id=ts.id
inner join service s on t.service_id=s.id
inner join users u on t.user_id=u.id
inner join users u1 on t.responsible_user_id=u1.id
where date(t.create_time)<='$to' and 
t.create_time>='$from' and t.responsible_user_id in($res)";	


}
else{
$query3="select t.id,t.tn,t.customer_id,t.title,ts.name,s.name as sname,u.login, u1.first_name,t.create_time
from ticket t
inner join ticket_state ts on t.ticket_state_id=ts.id
inner join service s on t.service_id=s.id
inner join users u on t.user_id=u.id
inner join users u1 on t.responsible_user_id=u1.id
where date(t.create_time)<='$to' and 
t.create_time>='$from' and  t.customer_id not in($cx_list) and t.queue_id not in($q_list)";


	
}
$query3_run=mysqli_query($connection,$query3);

$bf_count=mysqli_num_rows($query_run);
$bf_fix_num=0;
$in_count=mysqli_num_rows($query3_run);
$in_fix=0;
$bl_count=mysqli_num_rows($query2_run);
$bl_fix=0;

$bl_count_closed=mysqli_num_rows($query2_run);

?>
<body>

 <ul class="list-group">
            <li style="background-color:#c7ad88;" class="list-group-item">
			
 <div class="row toggle" data-toggle="collapse" data-target="#demo" id="test" >
 <div style="color:#fff;" class="col-xs-10"><strong>B/F CSR</strong></div>
			<div class="col-xs-2"><i style="color:#fff;" class="fa fa-chevron-down pull-right"></i></div>
			</div>
			

 
    <div id="demo" class="collapse" >
    <table  width="100%" class="bf" cellpadding="0" cellspacing="0" border="0">
	
      <thead class="header" >
        <tr  style="padding-top:10px; padding-bottom: 10px; background:#6a5750;">
		
          <th  width="4%">No</th>
          <th width="8%">Customer ID</th>
          <th width="8%">CSR #</th>
          <th width="25%">Subject</th>
          <th width="10%">State as at <?php echo $from?></th>
		  <th width="10%">Fixes Given from <?php echo $from?> to <?php echo $to?></th>		
		  <th width="10%">State as at <?php echo $to?></th>	
		  <th width="10%">Service</th>
		  <th width="7.5%">Owner</th>
		  <th width="7.5%">Responsible</th>
        </tr>
      </thead> 



 

	<?php
	
	//$res=mysqli_fetch_array($query_run);
	
	$row_num=mysqli_num_rows($query_run)+1;
	 echo' <tbody class="content" style="overflow-x:auto;
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
background: #262216;">';
	


	while($result=mysqli_fetch_array($query_run))
{	$count++;

$inter="";
$final="";
$fix_time="";

$ticket_id=$result['ticket_id'];

$bf_fix="select th.ticket_id,t.tn,ts.name as inter,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' 	and
	date(h.change_time) >= '$from' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where th.state_id in ('24','25','17','7','16') and   t.customer_id not in($cx_list) and t.queue_id not in($q_list) and
th.ticket_id=$ticket_id
order by th.ticket_id desc";






$final_state="select th.ticket_id,t.tn,ts.name as final,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where   t.customer_id not in($cx_list) and t.queue_id not in($q_list)and th.ticket_id=$ticket_id 
order by th.ticket_id desc";

$bf_fix_run=mysqli_query($connection,$bf_fix);



$final_state_run=mysqli_query($connection,$final_state);



 while ($result_fix=mysqli_fetch_array($bf_fix_run))
{
	$inter=$result_fix['inter'];
	$bf_fix_num++;
	$fix_time=$result_fix['change_time'];
	
}

 while ($result_final=mysqli_fetch_array($final_state_run))
{
	$final=$result_final['final'];
	
}






//echo $inter;
//echo $ticket_id;

	echo '<tr style="background:#262216;">	
	<td style="width:4%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$count.'</td>';
	echo '<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result['customer_id'].'</td>';
	echo'<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$result['ticket_id'].'"  target="_blank"  rel = "noopener noreferrer">'.$result['tn'].'</a></td>';
	echo '<td  width="400" style="text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result['title'].'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result['name'].'</td>';
	
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);"><div class="tooltip1"><span class="tooltiptext1">'.date("Y-m-d",strtotime($fix_time)).'</span>'.$inter.'</div></td>';
	

	
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$final.'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result['sname'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result['login'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);text-transform: capitalize;">'.$result['first_name'].'</td></tr>';

}



echo '</tbody></table>';
echo '<div align="center" class="alert alert-success" style="background:#6a5750;">
    <span style="padding-right:20px;color:#262216;" ><strong>B/F Count</strong></span><span class="badge">' .$bf_count.'</span>
	<span style="padding-left:100px;padding-right:20px;color:#262216;" ><strong>Fix Count</strong></span><span class="badge">' .$bf_fix_num.'</span></div>
	</div>

</li>';



if($in_count>0){
	
 echo '<li style="background-color:#6a5750;" class="list-group-item">
 <div class="row toggle" data-toggle="collapse" data-target="#demo1" id="test2" >
 <div  style="color:#fff;" class="col-xs-10"><strong>NEW CSR</strong></div>
 <div class="col-xs-2"><i style="color:#fff;" class="fa fa-chevron-down pull-right"></i></div>
 </div>

   
	<div id="demo1" class="collapse" >
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <thead class="header">
        <tr style="padding-top:10px; padding-bottom: 10px; background:#7d4627;">
		
          <th  width="4%">No</th>
          <th width="8%">Customer ID</th>
          <th width="8%">CSR #</th>
          <th width="25%">Subject</th>
          <th width="10%">Create Date<br>'.$from.'</th>
		  <th width="10%">Fixes Given from &nbsp;'.$from .'to<br/>'.$to.'</th>		
		  <th width="10%">State as at &nbsp;'. $to.'</th>	
		  <th width="10%">Service</th>
		  <th width="7.5%">Owner</th>
		  <th width="7.5%">Responsible</th>
        </tr>
      </thead>';

	  
$row_num2=mysqli_num_rows($query3_run)+1;
	 echo'  <tbody width="100%" class="content" style="overflow-x:auto;
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
  background:#312c32;>';

while($result3=mysqli_fetch_array($query3_run))
{	
$count++;
$inter1="";
$final1="";
$ticket_id=$result3['id'];
$fix_time2="";

$bf_fix="select th.ticket_id,t.tn,ts.name as inter,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' 	and
	date(h.change_time) >= '$from' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where th.state_id in ('24','25','17','7','16')  
and  t.customer_id not in($cx_list) and t.queue_id not in($q_list) and th.ticket_id=$ticket_id
order by th.ticket_id desc";

$final_state="select th.ticket_id,t.tn,ts.name as final,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where  t.customer_id not in($cx_list) and t.queue_id not in($q_list) and th.ticket_id=$ticket_id
order by th.ticket_id desc";

$bf_fix_run=mysqli_query($connection,$bf_fix);

$final_state_run=mysqli_query($connection,$final_state);


	 while ($result_fix=mysqli_fetch_array($bf_fix_run))
{
	$inter1=$result_fix['inter'];
	$in_fix++;
	$fix_time2=$result_fix['change_time'];
	
}

	 while ($result_final=mysqli_fetch_array($final_state_run))
{
	$final1=$result_final['final'];
	
}


	echo '<tr style="background:#312c32;">	
	<td style="width:4%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$count.'</td>';
	echo '<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result3['customer_id'].'</td>';
	echo'<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$ticket_id.'"  target="_blank"  rel = "noopener noreferrer">'.$result3['tn'].'</a></td>';
	echo '<td  width="400px" style="text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result3['title'].'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.date("Y-m-d",strtotime($result3['create_time'])).'</td>';	
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px
	rgba(255,255,255,0.1);">
	<div class="tooltip1"><span class="tooltiptext1">'.date("Y-m-d",strtotime($fix_time2)).'</span>'.$inter1.'</div></td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$final1.'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result3['sname'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result3['login'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);text-transform: capitalize;">'.$result3['first_name'].'</td></tr>';
	
	
}

echo '</tbody></table>
<div align="center" class="alert alert-success" style="background:#7d4627;">
    <span style="padding-right:20px;color:#312c32;" ><strong>IN Count</strong></span><span class="badge">' .$in_count.'</span>
	<span style="padding-left:100px;padding-right:20px;color:#312c32;" ><strong>Fix Count</strong></span><span class="badge">' .$in_fix.'</span></div>
	</div></li>';
}

if($bl_count>0){
 echo '<li style="background-color:#856046;" class="list-group-item">
 <div class="row toggle" data-toggle="collapse" data-target="#demo2" id="test3" >
  <div  style="color:#fff;" class="col-xs-10"><strong>RE-OPEN CSR</strong></div>
     <div class="col-xs-2"><i style="color:#fff;" class="fa fa-chevron-down pull-right"></i></div>
  </div>
 
    <div id="demo2" class="collapse">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead class="header" >
        <tr style="padding-top:10px; padding-bottom: 10px; background:#6a5750;">
		
          <th  width="4%">No</th>
          <th width="8%">Customer ID</th>
          <th width="8%">CSR #</th>
          <th width="25%">Subject</th>
          <th width="10%">State as at &nbsp;'. $from.'</th>
		  <th width="10%">Fixes Given from &nbsp;'. $from. '&nbsp;to &nbsp;' .$to.'</th>		
		  <th width="10%">State as at &nbsp;'. $to.'</th>	
		  <th width="10%">Service</th>
		  <th width="7.5%">Owner</th>
		  <th width="7.5%">Responsible</th>
        </tr>
      </thead>';
	   


$row_num3=mysqli_num_rows($query2_run)+1;
	 echo' 
	<tbody class="content" style="overflow-x:auto;
  margin-top: 0px;
  border-bottom: 1px solid rgba(255,255,255,0.3);
  background:#49412c;">';

while($result2=mysqli_fetch_array($query2_run))
{	$count++;

$inter2="";
$final2="";
$fix_time3="";
$ticket_id=$result2['id'];

$bf_fix="select th.ticket_id,t.tn,ts.name as inter,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' 	and
	date(h.change_time) >= '$from' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where th.state_id in ('24','25','17','7','16') and 
 t.customer_id not in($cx_list) and t.queue_id not in($q_list) and th.ticket_id=$ticket_id
order by th.ticket_id desc";
$bf_fix_run=mysqli_query($connection,$bf_fix);

$final_state="select th.ticket_id,t.tn,ts.name as final,th.change_time
from ticket_history th 
inner join (
	select max(h.id) as max_hist, h.ticket_id
	from ticket_history h
	inner join ticket ti
	on h.ticket_id=ti.id	
	where date(h.change_time) <= '$to' and
	 h.history_type_id = '27'
	group by h.ticket_id
) open_tickets on open_tickets.max_hist = th.id
inner join ticket t on t.id = th.ticket_id
inner join ticket_state ts on ts.id = th.state_id
where  t.customer_id not in($cx_list) and t.queue_id not in($q_list) and th.ticket_id=$ticket_id
order by th.ticket_id desc";
$final_state_run=mysqli_query($connection,$final_state);

 while ($result_fix=mysqli_fetch_array($bf_fix_run))
{
	$inter2=$result_fix['inter'];
	$fix_time3=$result_fix['change_time'];
	$bl_fix++;
	
}

 while ($result_final=mysqli_fetch_array($final_state_run))
{
	$final2=$result_final['final'];
	
}
	
	echo '<tr style="background:#49412c;">	
	<td style="width:4%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$count.'</td>';
	echo '<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result2['customer_id'].'</td>';
	echo'<td style="width:8%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$result2['id'].'"  target="_blank"  rel = "noopener noreferrer">'.$result2['tn'].'</a></td>';
	echo '<td  width="400px" style="text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result2['title'].'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result2['name'].'</td>';
	
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px 
	rgba(255,255,255,0.1);""><div class="tooltip1"><span class="tooltiptext1">'.date("Y-m-d",strtotime($fix_time3)).'</span>'.$inter2.'</div></td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$final2.'</td>';
	echo '<td style="width:10%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result2['sname'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);">'.$result2['login'].'</td>';
	echo '<td style="width:7.5%; text-align: left; vertical-align:middle;font-weight: 300; font-size: 12px; color: #fff;border-bottom: solid 1px rgba(255,255,255,0.1);text-transform: capitalize;">'.$result2['first_name'].'</td></tr>';
	
	
}
echo '</tbody></table>
<div align="center" class="alert alert-success" style="background:#6a5750;">
    <span style="padding-right:20px;color:#3b3a36;" ><strong>B/L Count</strong></span><span class="badge">' .$bl_count.'</span>
	<span style="padding-left:100px;padding-right:20px;color:#3b3a36;" ><strong>Fix Count</strong></span><span class="badge">' .$bl_fix.'</span></div>
</div></li>';
}

echo '</ul>';

@$bf_bal=$bf_count-$bf_fix_num;
@$in_bal=$in_count-$in_fix;
@$sub_total=$bf_count+$in_count;
@$sub_fix=$in_fix+$bf_fix_num;
@$sub_bal=$bf_bal+$in_bal;
@$bl_bal=$bl_count-$bl_fix;
@$grand_count=$bf_count+$in_count+$bl_count;
@$grand_fix=$bf_fix_num+$in_fix+$bl_fix;
@$grand_bal=$grand_count- $grand_fix;

echo '<div align="center" style="padding-bottom:200px;">
<div style="width:600px;" align="center"   >
	
	<table style="padding-left:20px; width:500px;" class="info">
  <tr bgcolor="#49412c">
    <td style="width:30%;color:#fff;font-size:90%;"><strong>CAT</strong></th>
    <td style="color:#fff;font-size:90%;"><strong>COUNT</strong></th>
    <td style="color:#fff; font-size:90%;"><strong>FIXES</strong></th>
    <td style="color:#fff; font-size:90%;"><strong>PENDING</strong></th>
	 <td style="color:#fff; font-size:90%;"><strong>FIX %</strong></th>
  </tr>
  <tr bgcolor="#c7ad88">
    <td style="width:30%;color:#fff;font-size:80%;"><strong>B/F</strong></td>
    <td><span style="font-size:130%;"  class="badge">'.$bf_count.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$bf_fix_num.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$bf_bal.'</span></td>
	 <td><span style="font-size:130%;"  class="badge">';if($bf_fix_num>0){echo round(@$bf_fix_num*100/@$bf_count,2);}echo '%</span></td>
  </tr>
  <tr bgcolor="#6a5750">
    <td style="width:30%;color:#fff;font-size:80%;"><strong>NEW CSR</strong></td>
    <td><span style="font-size:130%;"  class="badge">'.$in_count.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$in_fix.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$in_bal.'</span></td>
	<td><span style="font-size:130%;"  class="badge">';if($in_fix>0){echo round(@$in_fix*100/@$in_count,2);}echo '%</span></td>
  </tr>
  <tr bgcolor="#30231d">
    <td style="width:30%;color:#fff;font-size:80%;"><strong>SUB TOTAL</strong></td>
    <td><span style="font-size:130%;"  class="badge">'.$sub_total.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$sub_fix.'</span></td>
    <td><span style="font-size:130%;"  class="badge">'.$sub_bal.'</span></td>
	<td><span style="font-size:130%;"  class="badge">';if($sub_fix>0){echo round(@$sub_fix*100/@$sub_total,2);}echo '%</span></td>
  </tr>
   
  <tr bgcolor="#856046">
    <td style="width:30%;color:#fff;font-size:70%;"><div class="row toggle" data-toggle="collapse" data-target="#demo_bl" id="test2" >
	<div class="col-xs-8"><strong>RE-OPEN CSR</strong></div><div class="col-xs-2"><i style="color:#fff;" class="fa fa-chevron-down pull-right"></i></div></div>
	<div id="demo_bl" class="collapse" >
	<table>';
	while($result_bl=mysqli_fetch_array($query2_state_wise_run)){
	echo'<tr>
	<td>'.$result_bl['name'].'</td>
	<td><span style="font-size:100%;" class="badge">'.$result_bl['count'].'</span></td>
	</tr>';
	}
	echo '</table>
	</div></td>
    <td><span style="font-size:130%;position:relative;"  class="badge">'.$bl_count.'</span></td>
    <td><span style="font-size:130%;position:relative;" class="badge">'.$bl_fix.'</span></td>
    <td><span style="font-size:130%;position:relative;" class="badge">'.$bl_bal.'</span></td>
	<td><span style="font-size:130%;position:relative;"  class="badge">';if($bl_fix>0){echo round(@$bl_fix*100/@$bl_count,2);}echo '%</span>		
	</td>
  </tr>
 
  <tr bgcolor="#49412c">
    <td style="width:30%;color:#fff;font-size:80%;"><strong>WITH RE-OPEN CSR</strong></td>
    <td><span style="font-size:130%;" class="badge">'.$grand_count.'</span></td>
    <td><span style="font-size:130%;" class="badge">'.$grand_fix.'</span></td>
    <td><span style="font-size:130%;" class="badge">'.$grand_bal.'</span></td>
	<td><span style="font-size:130%;"  class="badge">';if($grand_fix>0){echo round(@$grand_fix*100/@$grand_count,2);}echo '%</span></td>
  </tr>
 
</table></div></div>';
}


//mysqli_close($link);
?>




	
	</div>

	
	
	
	</body>
	</html>
