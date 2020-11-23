<?php

session_start();
$mysql_host='192.168.1.25';
$mysql_user='priyadarshana';
$mysql_pw='priy@7otrc';
$conn_err='Could not connect';
$mysql_db='otrs';
$cx_err="Error: You have to select at least one customer";
$no_rec="Sorry! No records found :(";


if(!@mysql_connect($mysql_host,$mysql_user,$mysql_pw) || !@mysql_select_db($mysql_db)) 
{
	die(mysql_error());
}




echo '<link rel="stylesheet" type="text/css" href="table_style.css"/> 
<div id="box"><table id="tablestyle"><th>Number</th><th>CustomerID</th><th>CSR#</th><th>Title</th><th>Created</th><th>Changed</th><th>Close Time</th>
<th>Queue</th><th>State</th><th class="pri">Priority</th><th>Service</th><th>Agent/Owner</th>';


$query="select distinct * from temp2_view where exception=1";

$query_run=mysql_query($query);
$count=1;

while($result2=mysql_fetch_assoc($query_run)) 
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

?>