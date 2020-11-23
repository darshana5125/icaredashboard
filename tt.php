<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
// checking if a user is logged in
 // if (!isset($_SESSION['user_id'])) {
  // header('Location: index.php');
  //}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="brkdwn.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
</head>
<body>
<?php
$table_list="";

$table_list.='<table class="table table-fixed">

<thead>
<tr>
	<th class="col-xs-1">#</th>
  	<th class="col-xs-1">CSR #</th>
    <th class="col-xs-2">Cx ID</th>    
    <th class="col-xs-2">Create Time</th>
    <th class="col-xs-2">State</th>
    <th class="col-xs-2">Service</th>
	<th class="col-xs-2">Owner</th>
	</tr>
</thead>';



$table="select t.tn,t.customer_id,t.create_time,ts.name as state,ser.name as service,u.first_name as owner from sla_table s
left join ticket t
on s.tn=t.tn
join ticket_state ts
on t.ticket_state_id=ts.id
join service ser
on ser.id=t.service_id
join users u
on t.user_id=u.id
and t.create_time between '2017-12-01 00:00:00' and '2017-12-30 23:59:59'
where t.queue_id!=13";

$resultset_table=mysqli_query($connection,$table);
$counter=1;

while($result_table=mysqli_fetch_assoc($resultset_table)){

$table_list.='<tbody>
<tr><td >'.$counter.'</td>
<td >'.$result_table['tn'].'</td>
<td >'.$result_table['customer_id'].'</td>	
<td >'.$result_table['create_time'].'</td>
<td >'.$result_table['state'].'</td>
<td >'.$result_table['service'].'</td>
<td >'.$result_table['owner'].'</td></tr>';

$counter++;
}

$table_list.='</tbody> </table>';
echo $table_list;
?>

</body>

</html>