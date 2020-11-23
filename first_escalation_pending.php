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
echo'<script type="text/javascript">

  document.getElementById("year").value = "<?php echo $_POST["year"];?>";
</script>



</script>';


 date_default_timezone_set('Asia/Colombo'); 
$time=time();

echo "<head>
<link rel='stylesheet' href='ums/css/main.css'>
<link rel='stylesheet' type='text/css' href='css/jquery.css'/>
	
	<script src='jquery/jquery.js'></script>
	<script src='jquery/jquery.dataTables.min.js'></script>
</head>
<body onLoad='loadtext()'>";
?>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
echo "<form action='ticket_escalation2.php' method='POST' id='form1' target='_self'>
<p id='time' align='right'>Report runs at ".date("m/d/Y h:i A ",$time).'<p/>';
echo'<select id="range" name="range">

<option value="1st" selected>1st Escalation Pending</option>
<option value="2nd" >2nd Escalation Pending</option>
<option value="breached" >Suspected Breach</option>
<option value="sla_breached">SLA Breached</option>
</select>
<input type="submit" value="ok" name="submit">
<br>





<input type="submit" value="Generate Escalation Mail" name="submit">


<input type="hidden" id="min" value=36 /><br>
<input type="hidden" id="max" value=83/>
<input type="hidden" id="minh" value=3.5/><br>
<input type="hidden" id="maxh" value=7/>
<input type="hidden" id="minc" value=0.5/><br>
<input type="hidden" id="maxc" value=1/>';

//$link=mysqli_connect($mysqli_host,$mysqli_user,$mysqli_pw);


 date_default_timezone_set('Asia/Colombo');  
//echo time().'<br>';
//echo $time = date("m/d/Y h:i:s A T",time()).'<br>';

//echo'<a href="mailto:priyadarshana@interblocks.com?subject=Feedback for webdevelopersnotes.com&body=<table><th>test</th></table>">Send me an email</a>';
//echo'<a href="mailto:toid@example.com?Subject=subject here&Body=bodytext">
    //Link display text
//</a>';

//this was the original query with history_type_id=27---- $query_rows="SELECT  distinct count(issue_view.tn) as count,issue_view.tn as tn,issuehis_view.state_id,issuehis_view.change_time from
// issuehis_view join issue_view join issuehistype_view
// on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id
// where  issuehis_view.history_type_id=27 group by issue_view.tn";
$query_rows="SELECT  distinct count(issue_view.tn) as count,issue_view.tn as tn,issuehis_view.state_id,issuehis_view.change_time,servicelevel_view.1st_esc,servicelevel_view.2nd_esc
from issuehis_view join issue_view join issuehistype_view join servicelevel_view
on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id and issue_view.tn=servicelevel_view.tn
where issue_view.create_time>'2014-11-10 00:00:00'
and issue_view.ticket_state_id in(1,4,9,12,13,20,23,28,29) and issue_view.queue_id not in(7,13)and issue_view.customer_id not in( 'PHL-UCP') and issuehis_view.history_type_id=27 
group by issue_view.tn order by issue_view.tn desc";



$query_rows_run=mysqli_query($connection,$query_rows);
$query_rows_num=mysqli_num_rows($query_rows_run);
//$result2=mysqli_fetch_assoc($query_rows_run);

//echo $query_rows_num.'<br/>';
$tomorrow = strtotime('tomorrow');
$add_days = 1;
$date1 = date("m/d/Y h:i:s A T",strtotime('tomorrow') + (24*3600*$add_days));


//echo $date1.'<br>';

//echo date("m/d/Y h:i:s A T",$tomorrow).'<br>';


//echo $result2['count'].'<br/>';


//for($i=0;$i<$query_rows_num;$i++)
//{			

		

			echo '<div class="CSSTableGenerator" >
			<table class="display" id="myTable">
		
			<thead><tr><th></th><th>Queue ID</th><th>CSR #</th><th>Owner</th><th>Status</th><th>Description</th>
			<th>Create Time</th><th>Priority</th><th>Time Remaining</th><th>SLA Breached Time</th><th>Actual_Age</th><th>Total Age </th><th>Adjustments</th><th>Actual Age(hrs)</th>
			<th>1st Ecs</th><th>2nd Esc</th></tr></thead>
			<tfoot><tr><th></th><th>Queue ID</th><th>CSR #</th><th>Owner</th><th>Status</th><th>Description</th>
			<th>Create Time</th><th>Priority</th><th>Time Remaining</th><th>SLA Breached Time</th><th>Actual_Age</th><th>Total_Age </th><th>Adjustments</th><th>Actual Age(hrs)</th>
			<th><p>1st Ecs</p></th><th><p>2nd Esc<p></th></tr></tfoot>
			<tbody>';
	//for($a=0;$a<$result2['count'];$a++)
		$rownum=0;
	while($result2=mysqli_fetch_assoc($query_rows_run))
	{
		
		// $query="SELECT  issue_view.tn,issuehis_view.state_id,issuehis_view.change_time,issue_view.create_time from
		// issuehis_view join issue_view join issuehistype_view
		// on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id
		// where issue_view.create_time>'2014-11-10 00:00:00' and issuehis_view.history_type_id=27
		// and issue_view.tn='$result2[tn]'";
		
		
		$query="SELECT  distinct issue_view.tn,issue_view.id as ticket_id,enduser_view.customer_id AS cx_id,intuser_view.first_name AS first_name,
		issuestate_view.name AS ts_name,issue_view.title AS title,issue_view.create_time,issuelevel_view.name AS tp_name,		
		issuehis_view.state_id,issuehis_view.change_time,issue_view.create_time from
		issuehis_view join issue_view join issuehistype_view join enduser_view join intuser_view join issuestate_view join issuelevel_view		
		on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id and issuestate_view.id = issue_view.ticket_state_id
		and issue_view.user_id = intuser_view.id and issuelevel_view.id = issue_view.ticket_priority_id and enduser_view.customer_id = issue_view.customer_id
		where issue_view.create_time>'2014-11-10 00:00:00' and issuehis_view.history_type_id=27
		and issue_view.ticket_state_id in(1,4,14,9,12,13,20,23,28,29) and issue_view.queue_id not in(7,13) and
		issue_view.tn='$result2[tn]'";

		//--Original query with history_type_id=27---- $query="SELECT  issue_view.tn,issuehis_view.state_id,issuehis_view.change_time,issue_view.create_time from
		// issuehis_view join issue_view join issuehistype_view
		// on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id
		// where  issuehis_view.history_type_id=27 and issue_view.tn='$result2[tn]'";
		
		
		$query_run=mysqli_query($connection,$query);

		$time1=0;
		$time3=0;
		$time6=0;
		$time4=0;
		$time5=0;
		$time7=0;

		$count1=0;
		$time2=0;
		$laststate="";
		$lastchangetime="";
		 $workingDays=0;
		 $no_remaining_days=0;
		  $remainh=0;
		   $remainm=0;
		    $remains=0;
			$remainsh=0;
			$remainsm=0;
			$remainss=0;
			$remainshs=0;
			$remainsms=0;
			$remainsss=0;
			
		$no_full_weeks=0;

$the_first_day_of_week ="";
$the_last_day_of_week="";
$weekend="";
$current_time="";
$reduce=0;
$reduce2=0;
 $Acual_age=0;
 $ticket_no="";
 $day_check="";
 $test=0;
 $test2=0;
 $pending_days2=0;
 $counter=0;
 $cx_id="";
 $state="";
 $title="";
 $create_time="";
 $priority="";
 $owner="";
 $days=0;
 $Acual_age_show="";
 $Total_age_show="";
 $adjustments="";
 
 $endDate="";
$holidays=array("2015-11-25");
$h_day="";
$h_month="";
$holi="";
$ip_flag="0";
$ip_flag2="0";
$ticket_no="";	
$startDate="";
$ticket_id="";	
$result="";
$low_sla=168;
			$Medium_sla=120;
			$high_sla=24;
			$critical_sla=2;
$time_remain="";

		foreach($holidays as $holiday)
		{
	while($result=mysqli_fetch_assoc($query_run))
		{
			$ticket_no=$result['tn'];
			$cx_id=$result['cx_id'];
			$state=$result['ts_name'];
			$title=$result['title'];
			$create_time=$result['create_time'];
			$priority=$result['tp_name'];	
			$owner=$result['first_name'];
			$ticket_id=$result['ticket_id'];
			$rownum++;
			
			
			$startDate = strtotime($result['create_time']);
			$endDate = time(); 
			$hr=date("H",$endDate);
			$mi=date("i",$endDate);
			$d=Date("N",$endDate);
		if($d==6){
			$hr_bal=23-$hr;
			$min_bal=60-$mi;
			$tot_bal=$hr_bal*3600+$min_bal*60;
			$endDate=$endDate+(24*3600)+$tot_bal;
		}
		
		else if($d==7){
			
			$hr_bal=23-$hr;
			$min_bal=60-$mi;
			$tot_bal=$hr_bal*3600+$min_bal*60;
			$endDate=$endDate+$tot_bal;
		}
		
		
		
		
		
		// $shr=date("H",$startDate);
			// $smi=date("i",$startDate);
			// $sd=Date("N",$startDate);
		// if($sd==6){
			// $hsr_bal=23-$shr;
			// $smin_bal=60-$smi;
			// $stot_bal=$shr_bal*3600+$smin_bal*60;
			// $startDate=$startDate+(24*3600)+$stot_bal;
		// }
		
		// else if($sd==7){
			
			// $shr_bal=23-$shr;
			// $smin_bal=60-$smi;
			// $stot_bal=$shr_bal*3600+$smin_bal*60;
			// $startDate=$startDate+$stot_bal;
		// }
			
			
			
			
			//echo "startdate". date("m/d/Y h:i:s A T",$startDate).'<br>';
			//echo "End date". date("m/d/Y h:i:s A T",$endDate).'<br>';


			//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
			//We add one to inlude both dates in the interval.
			$days = ($endDate - $startDate) /(3600*24);
			
			
			$tage= ($endDate - $startDate)/60;
			$tdays=floor($tage/(60*24));
				$thours = floor($tage / 60)%24;
				$tminutes =$tage% 60;
				
				if($tdays==0){
				$Total_age_show= "$thours hrs:$tminutes mints";	
				}
				else if($tdays==1){
				$Total_age_show ="$tdays day:$thours hrs:$tminutes mints";
				}
				else{	
				$Total_age_show= "$tdays days:$thours hrs:$tminutes mints";
				}
				
				
			
			//echo "total Complete days".$days.'<br>';

			$no_full_weeks = floor($days / 7);
			//echo "weeks". $no_full_weeks.'<br>';
			$no_remaining_days = fmod($days, 7);
			//echo "remaining days" .$no_remaining_days.'<br>';

			//It will return 1 if it's Monday,.. ,7 for Sunday
			$the_first_day_of_week = date("N", $startDate);
			//echo     $the_first_day_of_week.'<br>';
			$the_last_day_of_week = date("N", $endDate);

			//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
			//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
			if ($the_first_day_of_week <= $the_last_day_of_week) {
				if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
				if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) 
				{
					
						//$time_start = date("m/d/Y h:i:s A ",$time1 + (24*3600*$add_days));
						//$time_we=strtotime($time_start);
						 // $remainsh=date("H",$startDate).'<br>';
						 // $remainsm=date("i",$startDate).'<br>';
						 // $remainss=date("s",$startDate).'<br>';
						 
						 // $Total_sec=($remainsh*3600+$remainsm*60+$remainss)/3600;
						 // echo "Total hrs in sunday". $Total_sec.'<br>';
						 
						 // $actual_start = date("m/d/Y h:i:s A ",$time_we - ($remainh*3600+$remainm*60+$remains));
						// $time1=strtotime($actual_start);
				

				
				$no_remaining_days--;
				}
				//newly added --- on 07/10/2015
		if($the_first_day_of_week == $the_last_day_of_week) 
				{
				if($days<7){
					//$no_remaining_days -= 2;
					$start_day=date("j",$startDate);
						$start_month=date("n",$startDate);
							$end_day=date("j",$endDate);
						$end_month=date("n",$endDate);
						if($start_day!=$end_day)
						{
					$no_remaining_days -= 2;
						}
						}
				}
				
				
			}
			else {
				// (edit by Tokes to fix an edge case where the start day was a Sunday
				// and the end day was NOT a Saturday)

				// the day of the week for start is later than the day of the week for end
				if ($the_first_day_of_week == 7) {
					// if the start date is a Sunday, then we definitely subtract 1 day
					$no_remaining_days--;
					
					$remainsh=date("H",$startDate);
						 $remainsm=date("i",$startDate);
						 $remainss=date("s",$startDate);
						 
						 $Total_sec=($remainsh*3600+$remainsm*60+$remainss)/(3600*24);
						 //echo "Total hrs in sunday". $Total_sec.'<br>';
						 $no_remaining_days=$no_remaining_days+$Total_sec;
					
					

					if ($the_last_day_of_week == 6) 
					{
						// if the end date is a Saturday, then we subtract another day
						$no_remaining_days--;
						
						$remainshs=date("H",$endDate);
						 $remainsms=date("i",$endDate);
						 $remainsss=date("s",$endDate);
						 
						 $Total_sec2=($remainshs*3600+$remainsms*60+$remainsss)/(3600*24);
						 //echo "Total hrs in saturday". $Total_sec2.'<br>';
						 $no_remaining_days=$no_remaining_days+$Total_sec2;
						
						
						
						
						
					}
				}
				else {
					// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
					// so we skip an entire weekend and subtract 2 days
					
					
					if ($the_first_day_of_week == 6)
					{
						$no_remaining_days -= 2;
					$remainsh2=date("H",$startDate);
						 $remainsm2=date("i",$startDate);
						 $remainss2=date("s",$startDate);
						 
						 $Total_sec3=($remainsh2*3600+$remainsm2*60+$remainss2)/(3600*24);
						 //echo "Total hrs in sunday". $Total_sec.'<br>';
						 $no_remaining_days=$no_remaining_days+$Total_sec3;
					
					
					
				}else{
			
	
					$no_remaining_days -= 2;
				}
				
				}
				
			}
			//echo "Number of remaing days after deducting weekends of the last week". $no_remaining_days.'<br>';

			//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
		//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
		   $workingDays = $no_full_weeks * 5;
		   //echo "Total working days after deduting all weekends".$total_workingdays=$workingDays+$no_remaining_days.'<br>';
		   $total_workingdays=$workingDays+$no_remaining_days;
			// if ($no_remaining_days > 0 )
			// {
			  // $workingDays += $no_remaining_days*24;
			// }
			if($no_full_weeks<1)
			{
				$workingDays=$no_remaining_days*24;
			}
			else
			{
				$workingDays = ($workingDays+$no_remaining_days)*24;
			}
			
			
			
			//no_holidays=count($holidays);
			
			
			
			//echo "total Working hrs".$workingDays.'<br>';

			//We subtract the holidays
			// foreach($holidays as $holiday){
				// $time_stamp=strtotime($holiday);
				// //If the holiday doesn't fall in weekend
				// if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
					// $workingDays--;
			// }

			
			
			
			
			
			
			
			
				//echo $result['tn'].'<br>';
		
			if($result['state_id']=='14' || $result['state_id']=='13' || $result['state_id']=='30')
				{	
				 date_default_timezone_set('Asia/Colombo');  
				$time1=strtotime($result['change_time']);
				$current_time=$result['change_time'];
				$weekend = date("N", $time1);
				//echo "weekend is".$weekend.'<br>';
				if($weekend==6)
					{
						 date_default_timezone_set('Asia/Colombo');  
						$add_days = 2;
						//$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
								$time_start = date("m/d/Y h:i:s A ",$time1 + (24*3600*$add_days));
						$time_we=strtotime($time_start);
						 $remainh=date("H",$time1);
						 $remainm=date("i",$time1);
						 $remains=date("s",$time1);
						 //$time_start.'<br>';
						$actual_start = date("m/d/Y h:i:s A ",$time_we - ($remainh*3600+$remainm*60+$remains));
						$time1=strtotime($actual_start);
						//echo'info pending time start time due to weekend'. $time44 = date("m/d/Y h:i:s A ",$time1).'<br>';
						$count1=1;
					}
				else if($weekend==7)
					{
						$add_days = 1;		
						$time_start = date("m/d/Y h:i:s A",$time1 + (24*3600*$add_days));
						$time_we=strtotime($time_start);
						 $remainh=date("H",$time1);
						 $remainm=date("i",$time1);
						 $remains=date("s",$time1);
						 //$time_start.'<br>';
						 $actual_start = date("m/d/Y h:i:s A ",$time_we - ($remainh*3600+$remainm*60+$remains));
						 $time1=strtotime($actual_start);
						 //echo'info pending time start time due to weekend'. $time45 = date("m/d/Y h:i:s A ",$time1).'<br>';
						$count1=1;
					}
				else
					{
						$holi=strtotime($holiday);
						$ip_day=date("j",$time1);
						$ip_month=date("n",$time1);
						$h_day=date("j",$holi);
						$h_month=date("n",$holi);
						
						if($ip_day==$h_day && $ip_month==$h_month)
						{
						$time_start = date("m/d/Y h:i:s A",$time1 + (24*3600*1));
						$time_we=strtotime($time_start);
						 $remainh=date("H",$time1);
						 $remainm=date("i",$time1);
						 $remains=date("s",$time1);
						 //$time_start.'<br>';
						 $actual_start = date("m/d/Y h:i:s A ",$time_we - ($remainh*3600+$remainm*60+$remains));
						 $time1=strtotime($actual_start);	
						}
						
						
						
						
						
						 date_default_timezone_set('Asia/Colombo'); 
						//echo "info pending time". $time1=strtotime($result['change_time']).'<br>';
						//echo "info pending time start time". $timep = date("m/d/Y h:i:s A T",$time1).'<br>';
						$count1=1;
						
					}
					
				$laststate=$result['state_id'];
				  $lastchangetime=strtotime($result['change_time']);	
				 }
				
				 //echo $time1.'<br>';
				 //$count1=1;
				 // $laststate=$result['state_id'];
				 // $lastchangetime=strtotime($result['change_time']);
				 
				
			if(!($result['state_id']=='14' || $result['state_id']=='13' || $result['state_id']=='30') and $count1==1)
			{			
			$time2=strtotime($result['change_time']);
			$weekend = date("N", $time2);
			
			
			if($time1 <= $holi && $holi <= $time2){
				
				$ip_flag2="1";
			}
			
					
			if($weekend==6)
					{
						 date_default_timezone_set('Asia/Colombo');  
						$add_days = 1;
						//$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
								$time_start_rx = date("m/d/Y h:i:s A ",$time2 - (24*3600*$add_days));
						$time_we_rx=strtotime($time_start_rx);
						 $remainh_rx=date("H",$time2);
						 $remainm_rx=date("i",$time2);
						 $remains_rx=date("s",$time2);
						 //$time_start.'<br>';
						$actual_start_rx = date("m/d/Y h:i:s A ",$time_we_rx + ((3600*24)-($remainh_rx*3600+$remainm_rx*60+$remains_rx)));
						$time2=strtotime($actual_start_rx);
						//echo'info recived time due to weekend'. $time48 = date("m/d/Y h:i:s A ",$time2).'<br>';
						$count1=0;
					}
				else if($weekend==7)
					{
						$add_days = 2;		
						$time_start_rx= date("m/d/Y h:i:s A",$time2 -(24*3600*$add_days));
						$time_we_rx=strtotime($time_start_rx);
						 $remainh_rx=date("H",$time2);
						 $remainm_rx=date("i",$time2);
						 $remains_rx=date("s",$time2);
						 //$time_start.'<br>';
						 $actual_start_rx = date("m/d/Y h:i:s A ",$time_we_rx + ((3600*24)-($remainh_rx*3600+$remainm_rx*60+$remains_rx)));
						 $time2=strtotime($actual_start_rx);
						 //echo'info recived time due to weekend'. $time45 = date("m/d/Y h:i:s A ",$time2).'<br>';
						$count1=0;
					}
				else
					{
						//just to check the weekend days during info peinding period
							$pending_begin = $time1;
							$pending_end=$time2;

							$pending_days = ($pending_end - $pending_begin) /(3600*24);
							//echo "for loop peding days".$pending_days.'<br>';
							//$no_full_weeks = floor($pending_days / 7);
							//$no_remaining_days = fmod($pending_days, 7);

							
							for($i=0;$i<$pending_days;$i++)
							{

							$day_check=date("N", $pending_begin);
							if ($day_check==6)
							{
								$test=6;
							$reduce++;
							}
							if ($day_check==7)
							{
							$reduce++;
							$test=7;
							}

							$pending_begin=strtotime(date("m/d/Y h:i:s A ",$pending_begin + (24*3600*1)));

							
							}
							//echo "number of weekend days during info pending period".$reduce.'<br>';
							
							$holi=strtotime($holiday);
						$ir_day=date("j",$time2);
						$ir_month=date("n",$time2);
						$h_day=date("j",$holi);
						$h_month=date("n",$holi);
						
						if($ir_day==$h_day && $ir_month==$h_month)
						{
						$time_start_rx= date("m/d/Y h:i:s A",$time2 - (24*3600*1));
						$time_we_rx=strtotime($time_start_rx);
						  $remainh_rx=23-(date("H",$time2));
						 $remainm_rx=59-(date("i",$time2));
						 $remains_rx=60-(date("s",$time2));
						 //$time_start.'<br>';
						 $actual_start_rx = date("m/d/Y h:i:s A ",$time_we_rx +($remainh_rx*3600+$remainm_rx*60+$remains_rx));
						 $time2=strtotime($actual_start_rx);
						}
							
							
						
						 date_default_timezone_set('Asia/Colombo'); 
						//echo "info pending time". $time1=strtotime($result['change_time']).'<br>';
						//echo "info recived time". $timer = date("m/d/Y h:i:s A T",$time2).'<br>';
						$count1=0;
						
					}
			
			
			//echo "info received time". $timer = date("m/d/Y h:i:s A T",$time2).'<br>';
			  //echo $result['tn'].'<br>';
			  //$count1=0;
			$laststate=$result['state_id'];
				 $lastchangetime=strtotime($result['change_time']);
			}
						if ($result['state_id']=='4' and $count1==0){
							
							$laststate=$result['state_id'];
							$lastchangetime=strtotime($result['change_time']);
						}
			
			
			
				
			if($time2>$time1)
			{
			$time3=$time3+($time2-$time1)/3600;
			

			//echo "accumaalitive info pending as loop runs".$time3.'<br>';
				if ($time3!=0)
				{
						$time1=0;
						$time2=0;
				}
			//echo $time3.'<br>';
			}
			else{
				//echo "time2 is smaller".'<br>';
			}
		
		//echo $time3.'<br>';
				 // $ticket_no=$result['tn'];
				//echo $result['state_id'];
				// if($laststate=='14')
				// {
					// date_default_timezone_set('Asia/Colombo');
					// $time4=$lastchangetime;
					// $weekend = date("N", $time4);
					
					// if($weekend==6)
							// {
								 // date_default_timezone_set('Asia/Colombo');  
								// $add_days = 2;
								// //$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
										// $time_start_lwe = date("m/d/Y h:i:s A ",$time4 + (24*3600*$add_days));
								// $time_lwe=strtotime($time_start_lwe);
								 // $remainh_lwe=date("H",$time4).'<br>';
								 // $remainm_lwe=date("i",$time4).'<br>';
								 // $remains_lwe=date("s",$time4).'<br>';
								 // //$time_start.'<br>';
								// $actual_start_lwe = date("m/d/Y h:i:s A ",$time_lwe - ($remainh_lwe*3600+$remainm_lwe*60+$remains_lwe));
								// $time4=strtotime($actual_start_lwe);
								// //echo'Age calculation start date due to weekend'. $time46 = date("m/d/Y h:i:s A ",$time4).'<br>';
								// //$count1=1;
							// }
						// else if($weekend==7)
							// {
								// $add_days = 1;
								// //$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
										// $time_start_lwe = date("m/d/Y h:i:s A ",$time4 + (24*3600*$add_days));
								// $time_lwe=strtotime($time_start_lwe);
								 // $remainh_lwe=date("H",$time4).'<br>';
								 // $remainm_lwe=date("i",$time4).'<br>';
								 // $remains_lwe=date("s",$time4).'<br>';
								 // //$time_start.'<br>';
								// $actual_start_lwe = date("m/d/Y h:i:s A ",$time_lwe - ($remainh_lwe*3600+$remainm_lwe*60+$remains_lwe));
								// $time4=strtotime($actual_start_lwe);
								// //echo'Age calculation start date due to weekend'. $time46 = date("m/d/Y h:i:s A ",$time4).'<br>';
								// //$count1=1;
							// }
						// else
							// {
								
								// //just to check the weekend days during info peinding period
									// $pending_begin = $time4;
									// $pending_end=strtotime(date('Y-m-d H:i:s'));

							// $pending_days = ($pending_end - $pending_begin) /(3600*24);
							// //echo "for loop peding days".$pending_days.'<br>';
							// //$no_full_weeks = floor($pending_days / 7);
							// //$no_remaining_days = fmod($pending_days, 7);

							
							// for($i=0;$i<$pending_days;$i++)
							// {

							// $day_check=date("N", $pending_begin);
							// if ($day_check==6)
								// $test2=$day_check;
							// {
							// $reduce++;
							// }
							// if ($day_check==7)
							// {
							// $reduce++;
							// }

							// $pending_begin=strtotime(date("m/d/Y h:i:s A ",$pending_begin + (24*3600*1)));

							
							// }
							// //echo "number of weekend days during info pending period".$reduce.'<br>';
						 // date_default_timezone_set('Asia/Colombo'); 
						// //echo "info pending time". $time1=strtotime($result['change_time']).'<br>';
						// //echo "info pending time start time". $timex = date("m/d/Y h:i:s A T",$time4).'<br>';
						// //$count1=1;
						
					// }
					
				 
			
			
			
			
			
					// //echo $time22 = date("m/d/Y h:i:s A T",$lastchangetime).'<br>';
					// $time5=strtotime(date('Y-m-d H:i:s'));
					// //echo $time23 = date("m/d/Y h:i:s A T",$time5).'<br>';
					// //echo $time5.'<br>';
					// $time6=(($time5-$time4)/3600);
				// }
				// else
				// {
				// $time6=0;	
				// }
				
				
				
				
				//echo $lastgap=($time5-$time4)/3600;
				//echo'<br>';
				
		}
		
		
		
		
		if($laststate=='14' || $laststate=='13' || $laststate=='30')
				{
					date_default_timezone_set('Asia/Colombo');
					$time4=$lastchangetime;
					$weekend = date("N", $time4);
					
					if ($time4<= $holi && $holi <= $endDate ){
					$ip_flag="1";
					}
					
					if($weekend==6)
							{
								 date_default_timezone_set('Asia/Colombo');  
								$add_days = 2;
								//$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
										$time_start_lwe = date("m/d/Y h:i:s A ",$time4 + (24*3600*$add_days));
								$time_lwe=strtotime($time_start_lwe);
								 $remainh_lwe=date("H",$time4);
								 $remainm_lwe=date("i",$time4);
								 $remains_lwe=date("s",$time4);
								 //$time_start.'<br>';
								$actual_start_lwe = date("m/d/Y h:i:s A ",$time_lwe - ($remainh_lwe*3600+$remainm_lwe*60+$remains_lwe));
								$time4=strtotime($actual_start_lwe);
								//echo'Age calculation start date due to weekend'. $time46 = date("m/d/Y h:i:s A ",$time4).'<br>';
								//$count1=1;
							}
						else if($weekend==7)
							{
								$add_days = 1;
								//$time1 = date("m/d/Y h:i:s A T",$time1 + (24*3600*$add_days));
										$time_start_lwe = date("m/d/Y h:i:s A ",$time4 + (24*3600*$add_days));
								$time_lwe=strtotime($time_start_lwe);
								 $remainh_lwe=date("H",$time4);
								 $remainm_lwe=date("i",$time4);
								 $remains_lwe=date("s",$time4);
								 //$time_start.'<br>';
								$actual_start_lwe = date("m/d/Y h:i:s A ",$time_lwe - ($remainh_lwe*3600+$remainm_lwe*60+$remains_lwe));
								$time4=strtotime($actual_start_lwe);
								
								
								
								
								//echo'Age calculation start date due to weekend'. $time46 = date("m/d/Y h:i:s A ",$time4).'<br>';
								//$count1=1;
							}
						else
							{
								
								//just to check the weekend days during info peinding period
									$pending_begin = $time4;
									$pending_end=strtotime(date('Y-m-d H:i:s'));

							$pending_days2 = ($pending_end - $pending_begin) /(3600*24);
							//echo "for loop peding days".$pending_days.'<br>';
							//$no_full_weeks = floor($pending_days / 7);
							//$no_remaining_days = fmod($pending_days, 7);

							
							for($i=0;$i<$pending_days2;$i++)
							{

							$day_check=date("N", $pending_begin);
							$test2=$day_check;
							if ($day_check==6)
							
							{
							$reduce++;
							}
							if ($day_check==7)
							{
								
							$reduce++;
							}

							$pending_begin=strtotime(date("m/d/Y h:i:s A ",$pending_begin + (24*3600*1)));

							$counter++;
							}
							//echo "number of weekend days during info pending period".$reduce.'<br>';
						 date_default_timezone_set('Asia/Colombo'); 
						//echo "info pending time". $time1=strtotime($result['change_time']).'<br>';
						//echo "info pending time start time". $timex = date("m/d/Y h:i:s A T",$time4).'<br>';
						//$count1=1;
						
					}
					
				 
			
			
			
			
			
					//echo $time22 = date("m/d/Y h:i:s A T",$lastchangetime).'<br>';
					$time5=strtotime(date('Y-m-d H:i:s'));
					//echo $time23 = date("m/d/Y h:i:s A T",$time5).'<br>';
					//echo $time5.'<br>';
					$time6=(($time5-$time4)/3600);
					
					
				}
				else
				{
				$time6=0;	
				}
				
				//if($laststate=='4' && $lastchangetime>= $holi ){ 

					
			//echo $ticket_no.'--------- '.date("m/d/Y h:i:s",$lastchangetime).'<br>';
		
							
			//if($laststate=='4' && $lastchangetime<= ($holi+84000) && $holi<=$endDate ){
				
				 //date_default_timezone_set('Asia/Colombo'); 
					//echo $ticket_no.'--------- '.date("m/d/Y h:i:s",$lastchangetime).'<br>';
				 
				//$ip_flag2="0";
				//$ip_flag="0";
			//}
			//}
		
				
				$time7=$time3+$time6-($reduce*24);
				
				
				$aage= $time7*60;
			$adays=floor($aage/(60*24));
				$ahours = floor($aage / 60)%24;
				$aminutes =$aage% 60;
				
				if($adays==0){
				$adjustments= "$ahours hrs:$aminutes mints";	
				}
				else if($adays==1){
				$adjustments ="$adays day:$ahours hrs:$aminutes mints";
				}
				else{	
				$adjustments= "$adays days:$ahours hrs:$aminutes mints";
				}
				
				//echo "Total info pending hrs".$time7.'<br>';
				//echo "Total woking hrs".$workingDays.'<br>';
				
				if($workingDays<$time7)
				{
				//echo "Actual age".  $Acual_age=$workingDays.'<br>';
				//$Acual_age=$workingDays;
				}
				else
				{
				//echo "Actual age".  $Acual_age=$workingDays-$time7.'<br>';
				$Acual_age=$workingDays-$time7;
				
				if ($startDate <= $holi && $holi <= $endDate )
				
				 {
					 if($ip_flag=="0" && $ip_flag2=="0"){				
				 $Acual_age=$Acual_age-24;
					 }
				 }
				}
				//2015-12-29 to deduct holidays
				//$Acual_age=$Acual_age-48;
				//--------------------
				$init=($Acual_age)*60;
				
				$ndays=floor($init/(60*24));
				$hours = floor($init / 60)%24;
				$minutes =$init% 60;
				
				if($ndays==0){
				$Acual_age_show= "$hours hrs:$minutes mints";	
				}
				else if($ndays==1){
				$Acual_age_show= "$ndays day:$hours hrs:$minutes mints";
				}
				else{	
				$Acual_age_show= "$ndays days:$hours hrs:$minutes mints";
				}
				}
				
				// foreach($holidays as $holiday){
				// $time_stamp=strtotime($holiday);
				// //If the holiday doesn't fall in weekend
				
			
				if($priority=="3 Medium"){
			
			$time_remain_hrs=$Medium_sla-$Acual_age;
			
			$init=($time_remain_hrs)*60;
				
				$ndays=floor($init/(60*24));
				$hours = floor($init / 60)%24;
				$minutes =($init% 60);
				
				if($ndays==0){
				$time_remain= "$hours hrs:$minutes mints";	
				}
				else if($ndays==1){
				$time_remain= "$ndays day:$hours hrs:$minutes mints";
				}
				else{	
				$time_remain= "$ndays days:$hours hrs:$minutes mints";
				}
			}else if ($priority=="2 High"){
			
			$time_remain_hrs=$high_sla-$Acual_age;
			
			$init=($time_remain_hrs)*60;
				
				$ndays=floor($init/(60*24));
				$hours = floor($init / 60)%24;
				$minutes =$init% 60;
				
				if($ndays==0){
				$time_remain= "$hours hrs:$minutes mints";	
				}
				else if($ndays==1){
				$time_remain= "$ndays day:$hours hrs:$minutes mints";
				}
				else{	
				$time_remain= "$ndays days:$hours hrs:$minutes mints";
				}
			}else if ($priority=="1 Critical"){
			
			$time_remain_hrs=$critical_sla-$Acual_age;
			
			$init=($time_remain_hrs)*60;
				
				$ndays=floor($init/(60*24));
				$hours = floor($init / 60)%24;
				$minutes =$init% 60;
				
				if($ndays==0){
				$time_remain= "$hours hrs:$minutes mints";	
				}
				else if($ndays==1){
				$time_remain= "$ndays day:$hours hrs:$minutes mints";
				}
				else{	
				$time_remain= "$ndays days:$hours hrs:$minutes mints";
				}
				}
			else{
					$time_remain_hrs=$low_sla-$Acual_age;
			
			$init=($time_remain_hrs)*60;
				
				$ndays=floor($init/(60*24));
				$hours = floor($init / 60)%24;
				$minutes =$init% 60;
				
				if($ndays==0){
				$time_remain= "$hours hrs:$minutes mints";	
				}
				else if($ndays==1){
				$time_remain= "$ndays day:$hours hrs:$minutes mints";
				}
				else{	
				$time_remain= "$ndays days:$hours hrs:$minutes mints";
				}
				}
			
			
			$sla_breach_time=date("Y-M-d h:i A ",time()+$time_remain_hrs*3600);
				
						$current_time=strtotime(date('Y-m-d H:i:s'));
						$sla_breach_time_sec=strtotime($sla_breach_time);
						$time_gap_days=($sla_breach_time_sec-$current_time)/(3600*24);
						
						
						$day_check=date("N", $sla_breach_time_sec);
						if ($day_check==6 || $day_check==7 ){								
					$sla_breach_time_ex_weekend=date("Y-M-d h:i A ",time()+($time_remain_hrs*3600)+(2*24*3600));
							}else{
								$sla_breach_time_ex_weekend=date("Y-M-d h:i A ",time()+($time_remain_hrs*3600));
							}
				
				
				
		

		echo '<tr><td><input type="checkbox" name="row['.$rownum.'][0]" value="true" >
		<td><input type="hidden" name="row['.$rownum.'][1]" value="'.$cx_id.'" />'.$cx_id.'</td>
		  <td><input type="hidden" name="row['.$rownum.'][2]" value="'.$ticket_no.'" /><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$ticket_id.'"  target="_blank"  rel = "noopener noreferrer">'.$ticket_no.'</a></td>
		 <td class="name"><input type="hidden" name="row['.$rownum.'][3]" value="'.$owner.'" />'.$owner.' </td>
		 <td><input type="hidden" name="row['.$rownum.'][4]" value="'.$state.'" />'.$state.'</td>
		 <td><textarea rows="2" cols="30" readonly style=" overflow:auto;resize:none; border: none; font-family:Times New Roman; overflow:hidden; color: black; background-color: transparent;" name="row['.$rownum.'][5]" value="'.$title.'" />'.$title.'</textarea></td>
		 <td><input type="hidden" name="row['.$rownum.'][6]" value="'.$create_time.'" />'.$create_time.'</td>
		 <td><input type="hidden" name="row['.$rownum.'][7]" value="'.$priority.'" />'.$priority.'</td>
		 <td ><input type="hidden" name="row['.$rownum.'][14]" value="'.$time_remain.'" />'.$time_remain.'</td>
		  	  <td ><input type="hidden" name="row['.$rownum.'][15]" value="'.$sla_breach_time_ex_weekend.'" />'.$sla_breach_time_ex_weekend.'</td>
			  <td><input type="hidden" name="row['.$rownum.'][11]" value="'.$Acual_age_show.'" />'.$Acual_age_show. '</td>
		 <td><input type="hidden" name="row['.$rownum.'][8]" value="'.$Total_age_show.'" />'.$Total_age_show. '</td>
		 <td><input type="hidden" name="row['.$rownum.'][9]" value="'.$adjustments.'" />'.$adjustments. '</td>
		 <td ><input type="hidden" name="row['.$rownum.'][10]" value="'.round($Acual_age,4).' hrs" />'.round($Acual_age,1). '</td>';
		 if($result2['1st_esc']=='1'){
		
		   echo'<td><input type="checkbox"  disabled="disabled" checked="checked" name="row['.$rownum.'][12]" value="true">1st</td>';
	}
	else{
		echo '<td><input type="checkbox" name="row['.$rownum.'][12]" value="true">1st</td>';
	}
		  if($result2["2nd_esc"]=="1"){
		   echo'<td><input type="checkbox" disabled="disabled" checked="checked" name="row['.$rownum.'][13]" value="true">2nd</td>';
	}
	else{
		echo '<td><input type="checkbox" name="row['.$rownum.'][13]" value="true"> 2nd </td>';
	}		 		 	
		echo '</tr>';
		
			
	}
	echo '</tbody></table></div>
	<input type="submit" value="Submit" name="submit"/>';
		//echo $time_stamp=strtotime($holiday);
		// $startDate1='2015-09-23 20:18:18'
		// $time_stamp1=strtotime($holiday);
	
		// if ($startDate1<= $time_stamp && $time_stamp1 <= $endDate && date("N",$time_stamp1) != 6 && date("N",$time_stamp1) != 7)
				// {	
				// $workingDays--;
				
				// }
	
	echo '</form> </body>';
	

	
//}

		
			
	
	echo"<script type='text/javascript'>
	
	$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
		
        var min = parseInt( $('#min').val(), 10 );
        var max = parseInt( $('#max').val(), 10 );
		
		var minh = parseInt( $('#minh').val(), 10 );
        var maxh = parseInt( $('#maxh').val(), 10 );
		
		var minc = parseInt( $('#minc').val(), 10 );
        var maxc = parseInt( $('#maxc').val(), 10 );
		
        var age = parseFloat( data[13] ) || 0; // use data for the age column
		
		
		 var priority = parseFloat( data[7] ) || 0;
		 
		
		if(priority =='3' || priority =='4' ){
		
		
			if ( ( isNaN( min ) && isNaN( max) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
		}
		
		else if(priority =='2'){
			if ( ( isNaN( minh ) && isNaN( maxh) ) ||
             ( isNaN( minh ) && age <= maxh ) ||
             ( minh <= age   && isNaN( maxh ) ) ||
             ( minh <= age   && age <= maxh ) )
        {
            return true;
        }
        return false;
		}
		else {
				if ( ( isNaN( minc ) && isNaN( maxc) ) ||
             ( isNaN( minc ) && age <= max ) ||
             ( minc <= age   && isNaN( maxc ) ) ||
             ( minc <= age   && age <= maxc ) )
        {
            return true;
        }
        return false;
			
		}
		
	}
	
			
		
    
);
	
	$(document).ready(function() {
    var table = $('#myTable').DataTable({
	'order': [[ 13, 'asc' ]]});

 
	
	 // Add event listeners to the two range filtering inputs
      $('#myTable td:nth-child(8)').each(function () {
				 
				 var a=$(this).text();
								
        if( a == '1 Critical ') {
			
            $(this).parent('tr').css('background-color', '#F75D59');
        }
		 if( a == '2 High') {
			
            $(this).parent('tr').css('background-color', '#FFA62F');
        }
		 if( a == '3 Medium') {
			
            $(this).parent('tr').css('background-color', '#9E7BFF');
        }
		 if( a == '4 Low') {
			
            $(this).parent('tr').css('background-color', '#6CBB3C');
        }
    });
  
 
    
} );






 	function print()	{
		var form = document.getElementById('form1');
	
var elements = form.elements;
for (var i = 0, len = elements.length; i < len; ++i) {
    elements[i].hidden = true;

}
document.getElementById('all').style.visibility = 'hidden';
document.getElementById('time').style.visibility = 'hidden';
document.getElementById('nav').style.visibility = 'hidden';
		
	}
	
			
</script>";

	

	
		
	//$time3=($time2-	$time1)/3600;
	 
//echo $time3;
	
	
	
//}

//echo $time3;

//mysqli_close($link);
}else{
	header('Location: index.php');
}
?>
