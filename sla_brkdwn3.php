<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
// checking if a user is logged in
 // if (!isset($_SESSION['user_id'])) {
  // header('Location: index.php');
  //}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


</head>
<body style="margin: auto; width: 80%;">



<form action="sla_brkdwn3.php" method="post">

<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
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
  
  
  $count="select count(t.tn) as count from ticket t
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'";
$result_set1=mysqli_query($connection,$count);




//echo $result1['count'];




$query="select distinct s.sla_state,count(t.tn) as count from sla_table s
left join ticket t
on s.tn=t.tn
and t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
group by s.sla_state
order by sla_state";
$result_set=mysqli_query($connection,$query);


?>
<table class="table table-bordered" style="margin: auto; width: 60%;">
<thead>
  <tr>
	<th>Date Range</th>
    <th>Reported #</th>    
    <th>SLA Met</th>
    <th>Within SLA</th>
    <th>Breached</th>
</thead>
  
  </tr>
  <tr>
  <td rowspan=2 style="vertical-align: middle;"><?php echo $s_date;?> to <?php echo $e_date;?></td>
  <?php
  
  $total=0;
  while($result1=mysqli_fetch_assoc($result_set1)){
	  ?>
	<td><?php echo $total=$result1['count'];?></td>
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


<?php  
$count2="select ser.id as id,ser.name as service, count(t.tn) as count from ticket t
inner join service ser
on t.service_id=ser.id
where t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
group by ser.id";
$result_set2=mysqli_query($connection,$count2);




//echo $result2['count'];




?>
<table class="table table-bordered" style="margin: auto; width: 50%;">
<thead>
  <tr>
	
	<th>Service</th>
    <th>Reported #</th>    
    <th>SLA Met</th>
    <th>Within SLA</th>
    <th>Breached</th>
</thead>  
  </tr>
  
<?php	
while($result2=mysqli_fetch_assoc($result_set2)){
$service=$result2['id'];
?>	
	<td><?php echo $result2['service'];?></td>
    <td><?php echo $result2['count'];?></td> 
<?php
$query2="select ser.name as service,s.sla_state,count(t.tn) as count from sla_table s
left join ticket t
on s.tn=t.tn
inner join service ser
on t.service_id=ser.id
where ser.id=$service and t.create_time between '$s_date 00:00:00' and '$e_date 23:59:59'
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
<td><?php echo $met1;?></td>
<td><?php echo $within1;?></td>
<td><?php echo $not1;?></td>
</tr>	
  
<?php	
}
}
?>
</tr>
</table> 

</body>
</html>


