<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php //include($_SERVER['DOCUMENT_ROOT'].'/inc/connection.php'); ?>
<?php
 //checking if a user is logged in
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <!-- Include Required Prerequisites -->
<!--script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/jquery/1/jquery.min.js"></script>

<!--script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/momentjs/latest/moment.min.js"></script>


<!--link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /-->
<link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/jsdelivr/bootstrap/3/css/bootstrap.css" />

 
<!-- Include Date Range Picker -->
<!--script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/bootstrap.daterangepicker/2/daterangepicker.js"></script>


<!--link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /-->
<link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/jsdelivr/bootstrap.daterangepicker/2/daterangepicker.css" />
<!--link rel="stylesheet" type="text/css" href="brkdwn.css" /-->
<link rel="stylesheet" href="ums/css/main.css">


</head>
<body >
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>



<form action="sla_brkdwn.php?mid=13" method="post">

<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin: auto; width: 100%;">
    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
    <span name="report></span> <b class="caret"></b>
</div>
<input type="hidden" id="test1" name="startdate">
<input type="hidden" id="test2" name="enddate">
<input type="submit" name="submit" value="OK" class="btn btn-secondary">

</form>

<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    var fulldate="";
    var sdate="";
    var edate="";

    function cb(start, end) {
        fulldate=$('#reportrange span').html(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        sdate=fulldate.html().slice(0, 10);
        edate=fulldate.html().slice(14, 24);
          $("#test1").val(sdate); 
          $("#test2").val(edate);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }


    }, cb);

    cb(start, end);

   
    
});

</script>
  
<?php
if(isset($_POST['submit'])){
  //echo "test";
  $s_date=$_POST['startdate'];
  $e_date=$_POST['enddate'];
  
  
  $count="select count(t.tn) as count from issue_view t
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
and t.customer_id not like '%@%' and t.customer_id !=''";
$result_set1=mysqli_query($connection,$count);




//echo $result1['count'];




$query="select distinct s.sla_state,count(t.tn) as count from servicelevel_view s
left join issue_view t
on s.tn=t.tn
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59' 
and t.customer_id not like '%@%' and t.customer_id !=''
group by s.sla_state
order by sla_state";
$result_set=mysqli_query($connection,$query);


$service_blank="select t.tn,t.id from issue_view t
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
and t.queue_id!=84 and t.customer_id not like '%@%' 
and t.service_id is null";
$service_blank_result_set=mysqli_query($connection,$service_blank);
$num_rec=mysqli_num_rows($service_blank_result_set);
if($num_rec>0){
	echo '<br><p style="background-color:yellow; color:red; text-align:center;">Can not create the report. Beacuse the service not been updated in below CSR. Update the service filed in iCare and re-run the report.</p>';
while($result_blank=mysqli_fetch_assoc($service_blank_result_set)){
	echo '<td><a style="padding-left:50px;color: black; text-decoration: none;" href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$result_blank['id'].'" target="_blank">'.$result_blank['tn'].'</a></td><br/>';	
}
}
else{
?>
<table id="parent" style="margin: auto; width: 50%;" >
<tr><td>
<table class="table table-bordered" style="margin: auto; width: 100%;">
<thead>
  <tr>
	<th bgcolor="#000099" style="color:white;">Date Range</th>
    <th bgcolor="#000099" style="color:white;">Reported #</th>   
    <th bgcolor="#00B050">SLA Met</th>
    <th bgcolor="#FFFF00">Within SLA</th>
    <th bgcolor="#FF0001">Breached</th>
</thead>
  
  </tr>
  <tr>
  <td rowspan=2 style="vertical-align: middle;"><?php echo $s_date;?> to <?php echo $e_date;?></td>
  <?php  
  $total=0;
  while($result1=mysqli_fetch_assoc($result_set1)){
	  $total=$result1['count'];	  
	  ?>
	<td><?php echo $total; ?></td>
<?php	
	}
	
	
	$met=0;
	$not=0;
	$within=0;
while($result=mysqli_fetch_assoc($result_set)){
	if($result['sla_state']==1){
	$met=$result['count'];
	}
	else if($result['sla_state']==2){
	$within=$result['count'];
	}
	else if($result['sla_state']==3){
	$not=$result['count'];
	}
?>
   
    <td><?php echo $result['count'];?></td> 
  
<?php
}
$met_per=round(($met/$total)*100,2);
$within_per=round(($within/$total)*100,2);
$not_per=round(($not/$total)*100,2);

?>
</tr>
<tr><td>%</td><td><?php echo $met_per.'%';?></td><td><?php echo $within_per.'%';?></td><td><?php echo $not_per.'%';?></td></tr>
</table>
</td></tr>
<tr><td colspan="4" bgcolor="#FFC001">&nbsp;</td></tr>


<?php  
$count2="select ser.id as id,ser.name as service, count(t.tn) as count from issue_view t
left join service_view ser
on t.service_id=ser.id
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
and t.queue_id!=84 and t.customer_id not like '%@%'
group by ser.id order by count desc;";
$result_set2=mysqli_query($connection,$count2);

?>
<tr><td>
<table id="example" class="table table-bordered" style="margin: auto; width: 100%;">
<thead>
  <tr class="titlerow">
	
	<th bgcolor="#000099" style="color:white;">Service</th>
    <th bgcolor="#000099" style="color:white;">Reported #</th>   
    <th bgcolor="#00B050">SLA Met</th>
    <th bgcolor="#FFFF00">Within SLA</th>
    <th bgcolor="#FF0001">Breached</th>
</thead>  
  </tr>
  
<?php	
while($result2=mysqli_fetch_assoc($result_set2)){
if($result2['id']!=''){
$service=$result2['id'];
}
?>	
	<td ><?php echo $result2['service'];?></td>
    <td class="rowDataSd"><?php echo $result2['count'];?></td> 
<?php
$query2="select ser.name as service,s.sla_state,count(t.tn) as count from servicelevel_view s
left join issue_view t
on s.tn=t.tn
inner join service_view ser
on t.service_id=ser.id
where ser.id=$service and t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
and t.customer_id not like '%@%' and t.customer_id !=''
group by s.sla_state
order by sla_state";
$result_set3=mysqli_query($connection,$query2);
	$met1=0;
	$not1=0;
	$within1=0;
if($service!=''){
while ($result3=mysqli_fetch_assoc($result_set3)){
if($result3['sla_state']==1){
	$met1=$result3['count'];

	}
	else if($result3['sla_state']==2){
	$within1=$result3['count'];

	}
	else if($result3['sla_state']==3){
	$not1=$result3['count'];

	}
}
}
?>
<td class="rowDataSd"><?php echo $met1;?></td>
<td class="rowDataSd"><?php echo $within1;?></td>
<td class="rowDataSd"><?php echo $not1;?></td>
</tr>	
  
<?php	
$service="";
}

?>
</tr>
</table>
</td></tr>
<tr><td colspan="4" bgcolor="#FFC001">&nbsp;</td></tr>

<?php  
$count2="select t.customer_id as cx,count(t.tn) as count from issue_view t
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
and t.customer_id not like '%@%' and t.customer_id !=''
group by t.customer_id order by count desc";
$result_set2=mysqli_query($connection,$count2);

?>
<tr><td>
<table class="table table-bordered" id="example2" style="margin: auto; width: 100%;">
<thead>
  <tr class="titlerow">
	
	<th bgcolor="#000099" style="color:white;">Customer</th>
    <th bgcolor="#000099" style="color:white;">Reported #</th>   
    <th bgcolor="#00B050">SLA Met</th>
    <th bgcolor="#FFFF00">Within SLA</th>
    <th bgcolor="#FF0001">Breached</th>
</thead>  
  </tr>
  
<?php	
while($result2=mysqli_fetch_assoc($result_set2)){
$cx=$result2['cx'];
?>	
	<td><?php echo $result2['cx'];?></td>
    <td class="rowDataSd2"><?php echo $result2['count'];?></td> 
<?php
$query2="select s.sla_state,count(t.tn) as count from servicelevel_view s
left join issue_view t
on s.tn=t.tn
where t.customer_id='$cx'and t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
group by s.sla_state
order by sla_state";

$result_set3=mysqli_query($connection,$query2);
	$met1=0;
	$not1=0;
	$within1=0;
while ($result3=mysqli_fetch_assoc($result_set3)){
if($result3['sla_state']==1){
	$met1=$result3['count'];

	}
	else if($result3['sla_state']==2){
	$within1=$result3['count'];

	}
	else if($result3['sla_state']==3){
	$not1=$result3['count'];

	}
}
?>
<td class="rowDataSd2"><?php echo $met1;?></td>
<td class="rowDataSd2"><?php echo $within1;?></td>
<td class="rowDataSd2"><?php echo $not1;?></td>
</tr>	
  
<?php	
}
}
?>
</tr>
</table> 
</td></tr>
<tr><td colspan="4" bgcolor="#FFC001">&nbsp;</td></tr>
</table>


</body>

</html>
<script type="text/javascript">
$(document).ready( function(){
	//get the total number for each colum in service wise table
	$('#example').append('<tr class="totalColumn"><td style="font-weight:bold">Total</td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td></tr>');
var totals=[0,0,0,0];
$(document).ready(function(){

    var $dataRows=$("#example tr:not('.titlerow')");
    
    $dataRows.each(function() {
        $(this).find('.rowDataSd').each(function(i){        
            totals[i]+=parseInt( $(this).html());
        });
    });
    $("#example td.totalCol").each(function(i){  
        $(this).html(totals[i]);
    });

});

	$('#example2').append('<tr class="totalColumn"><td style="font-weight:bold">Total</td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td><td style="font-weight:bold" class="totalCol"></td></tr>');
var totals2=[0,0,0,0];

    var $dataRows=$("#example2 tr:not('.titlerow')");
    
    $dataRows.each(function() {
        $(this).find('.rowDataSd2').each(function(i){        
            totals2[i]+=parseInt( $(this).html());
        });
    });
    $("#example2 td.totalCol").each(function(i){  
        $(this).html(totals2[i]);
    });


	
$('#example tr').each(function(i) {
	// blank service coloum make it red
    var column2cell = $($(this).children('td')[0]);
    if ($.trim(column2cell.text()).length <1) {
		column2cell.css('background-color', 'red'); 			
    }
});
});
</script>
<?php
}
}else{
  header('Location: index.php');
} 
?>
