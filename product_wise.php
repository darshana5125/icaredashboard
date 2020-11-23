<?php
session_start();
$mysql_host='192.168.1.25';
$mysql_user='priyadarshana';
$mysql_pw='priy@7otrc';
$conn_err='Could not connect';
$mysql_db='otrs';

echo '<form method="post" action="product_wise.php"/>';
if(!@mysql_connect($mysql_host,$mysql_user,$mysql_pw) || !@mysql_select_db($mysql_db)) 
{
	die(mysql_error());
}
$query_cx="select distinct(cx_id) from temp2_view order by cx_id asc";
$query="select distinct(s_name) from temp2_view where s_name!='' order by s_name asc";
echo '<label id="icon" for="name">Select Year </label> <select name="year" id="year">
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	<option value="2017">2017</option>
	<option value="2018">2018</option>
	<option value="2019">2019</option>
	<option value="2020">2020</option>
	<option value="2021">2021</option>
	<option value="2022">2022</option>
	</select><br>';
echo '<label id="icon" for="name">Select Service </label> <select name="service" id="service">';
	$query_run=mysql_query($query);
	
while($result=mysql_fetch_assoc($query_run))
{	
	
	
	$sname=$result['s_name'];
	echo '<option value="'.$sname.'">'.$sname.'</option>';
		
			
}
echo '</select><br/>';

echo '<label id="icon" for="name">Select Customer</label>   <select name="cx[]" multiple="multiple" size="4" id="cx">';
	$query_run=mysql_query($query_cx);

while($result=mysql_fetch_assoc($query_run))
{	
	$cx=$result['cx_id'];
	echo '<option value="'.$cx.'">'.$cx.'</option>';
		
			
}
echo '</select><br/>';



echo '<input type="submit" value="ok" />
<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
<th>Customer</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th><th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th>
	
	<tbody>';
//$count=0;
$cx="";
$cx1="";
$row_count=0;
//$query2="select distinct count(tn) as cnt,DATE_FORMAT(create_time,'%b') from temp2_view where s_name in(";
$query3="select distinct cx_id from temp2_view where cx_id in(";
if(isset($_POST['cx']))
{
foreach($_POST['cx'] as $cx1)
{
	$cx1=$cx1."'".$cx1."'".',';

}
$query3=$query3.$cx1;
$query3=substr($query3,0,-1);
$query3=$query3.")";
}

//echo $query3 .'<br>';
if(isset($_POST['service']) && isset($_POST['cx']) && isset($_POST['year']))
{
 $sname=$_POST['service'];
 $year=$_POST['year'];
// foreach($_POST['service'] as $service)
// {
	// $sn=$sn."'".$service."'".',';
// }
// $query2=$query2.$sn;
// $query2=substr($query2,0,-1);
// $query2=$query2.")";
// $row_count=$row_count+1;

// $query2=$query2." and cx_id='$cx' and create_time between '2015-01-01' and '2016-01-01' group by s_name,month(create_time) ";
// echo $query2;
// $query2_run=mysql_query($query2);
// $num_rows=mysql_num_rows($query2_run);

$query3_run=mysql_query($query3);
//$num_rows=mysql_num_rows($query3_run);

foreach($_POST['cx'] as $cx){
	$query4="select count(distinct tn) as cnt,DATE_FORMAT(create_time,'%b') as month from temp2_view where cx_id in('$cx') and s_name='$sname' and create_time between '2015-01-01' and '2016-01-01' group by month(create_time)";

//$query4_run=mysql_query($query4);
//echo '<tr><td>Month</td>';
// while($result4=mysql_fetch_assoc($query4_run)) {
	// echo'<td>'.$result4['month'].'</td>';
// }
echo '</tr>';
$query3="select distinct cx_id from temp2_view where cx_id in('$cx')";	
$query3_run=mysql_query($query3);
while($result3=mysql_fetch_assoc($query3_run)){
	echo'<tr>
	<td>'.$result3['cx_id'].'</td>';
// select Months.id AS `month` ,count(distinct tn) as cnt,DATE_FORMAT(create_time,'%b') from(
  // SELECT 1 as ID UNION SELECT 2 as ID UNION  SELECT 3 as ID UNION SELECT 4 as ID 
  // UNION  
  // SELECT 5 as ID UNION SELECT 6 as ID UNION SELECT 7 as ID UNION SELECT 8 as ID 
  // UNION  
  // SELECT 9 as ID UNION SELECT 10 as ID UNION SELECT 11 as ID UNION SELECT 12 as ID
// ) as Months
// left join temp2_view on Months.id=month(temp2_view.create_time)
// and s_name in('iATMClient') and cx_id='KHM-VAT' and create_time between '2015-01-01' and '2016-01-01' GROUP BY Months.id ORDER BY Months.id ASC;

$query2="select Months.id AS `month`,count(distinct tn) as cnt from(
  SELECT 1 as ID UNION SELECT 2 as ID UNION  SELECT 3 as ID UNION SELECT 4 as ID 
  UNION  
  SELECT 5 as ID UNION SELECT 6 as ID UNION SELECT 7 as ID UNION SELECT 8 as ID 
  UNION  
  SELECT 9 as ID UNION SELECT 10 as ID UNION SELECT 11 as ID UNION SELECT 12 as ID
) as Months
left join temp2_view on Months.id=month(temp2_view.create_time)
and cx_id in('$cx') and s_name='$sname' and create_time between '$year-01-01' and '$year-12-31'GROUP BY Months.id ORDER BY Months.id ASC";
//echo $query2.'<br>';
$query2_run=mysql_query($query2);
while($result2=mysql_fetch_assoc($query2_run)) {


			echo'<td>'.$result2['cnt'].'</td>';
}
echo '</tr>';
}
}
	
	

}

		
		
	echo'</tbody>
</table>
</form>';
echo '<script type="text/javascript">
  document.getElementById("year").value = "454";


</script>';
