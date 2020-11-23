<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
			<!--link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"-->
			<link href="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!--script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script-->
<script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--script src="//code.jquery.com/jquery-1.11.1.min.js"></script-->
<script src="\icaredashboard/libraries/jquery/jquery-1.9.1.js"></script>

<link href="\icaredashboard/csr_age/css/csr_age.css" rel="stylesheet">
<script src="\icaredashboard/js/csr_age.js"></script>

<script src='\icaredashboard/jquery/jquery.js'></script>
	<script src='\icaredashboard/jquery/jquery.dataTables.min.js'></script>
	<link rel='stylesheet' type='text/css' href='\icaredashboard/css/jquery.css'>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    
    
        <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">CSR remaining time as per the SLA</h3>
                
            </div>
            <table class="table" id="myTable">
                <thead>
                    <tr class="filters">
                        <!--th width="2%"><input type="text" class="form-control" placeholder="^" disabled></th-->
                        <th width="6%"><input type="text"  class="form-control" placeholder="Cx_ID" disabled></th>
                        <th width="6%"><input type="text" class="form-control" placeholder="CSR #" disabled></th>
                        <th width="18%"><input type="text" class="form-control" placeholder="Subject" disabled></th>
                        <th width="8%"><input type="text" class="form-control" placeholder="Priority" disabled></th>
						<th width="8%"><input type="text" class="form-control" placeholder="Create Time" disabled></th>
						

						<th width="10%"><input type="text" class="form-control" placeholder="Time Elapsed" disabled></th>
                        <th width="10%"><input type="text" class="form-control" placeholder="Remaining Time" disabled></th>
						<th width="7%"><input type="text" class="form-control" placeholder="State" disabled></th>
                        <th width="7%"><input type="text" class="form-control" placeholder="Service" disabled></th>
                        <th width="7%"><input type="text" class="form-control" placeholder="Owner" disabled></th>
                        <th width="7%"><input type="text" class="form-control" placeholder="Responsible" disabled></th>
						<th width=".1%"><input type="text" class="form-control" placeholder="Age" disabled></th>
						
						<!--th>Cx_ID</th>
                        <th>CSR £</th>
                        <th>Subject</th>
                        <th>Priority</th>
						<th>Create Time</th>
						<th>Time Elapsed</th>
                        <th>Remaining Time</th>
                        <th>Owner</th>
                        <th>Respnsible</th>
						<th>Age</th-->
                    </tr>
                </thead>
                <tbody>
<?php
date_default_timezone_set('Asia/Colombo');

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

		

		
	//for($a=0;$a<$result2['count'];$a++)
		$rownum=0;
	while($result2=mysqli_fetch_assoc($query_rows_run))
	{
		
		// $query="SELECT  issue_view.tn,issuehis_view.state_id,issuehis_view.change_time,issue_view.create_time from
		// issuehis_view join issue_view join issuehistype_view
		// on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id
		// where issue_view.create_time>'2014-11-10 00:00:00' and issuehis_view.history_type_id=27
		// and issue_view.tn='$result2[tn]'";
		
		
		$query="SELECT  distinct issue_view.tn,issue_view.id as ticket_id,enduser_view.customer_id AS cx_id,u.first_name AS first_name,
		issuestate_view.name AS ts_name,issue_view.title AS title,issue_view.create_time,issuelevel_view.name AS tp_name,		
		issuehis_view.state_id,issuehis_view.change_time,issue_view.create_time, u2.first_name as responsible,service_view.name as service from intuser_view u2 join
		issuehis_view join issue_view join issuehistype_view join enduser_view join intuser_view u join issuestate_view join issuelevel_view join service_view		
		on issuehis_view.ticket_id=issue_view.id and issuehis_view.history_type_id= issuehistype_view.id and issuestate_view.id = issue_view.ticket_state_id
		and issue_view.user_id = u.id and issue_view.responsible_user_id=u2.id and issuelevel_view.id = 
		issue_view.ticket_priority_id and enduser_view.customer_id = issue_view.customer_id and 
		issue_view.service_id=service_view.id
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
 $service="";
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
			$responsible=$result['responsible'];
			$service=$result['service'];
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
		
							
			if($laststate=='4' ){
				
				 date_default_timezone_set('Asia/Colombo'); 
					//echo $ticket_no.'--------- '.date("m/d/Y h:i:s",$lastchangetime).'<br>';
				 
				$ip_flag2="0";
				$ip_flag="0";
			}
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
							
		?>
			<tr class="data">
			<!--td width="2%"><?php echo round(($init/10000),1); ?></td-->
			<td width="6%"><?php echo $cx_id; ?></td>
			<td width="6%"><?php echo $ticket_no; ?></td>
			<td width="18%"><?php echo $title; ?></td>
			<td width="8%"><?php echo $priority; ?></td>
			<td width="8%"><?php echo $create_time; ?></td>			
			<td width="10%"><?php echo $Acual_age_show; ?></td>
			<td width="10%"><?php echo $time_remain; ?></td>
			<td width="7%"><?php echo $state; ?></td>
			<td width="7%"><?php echo $service; ?></td>
			<td width="7%"><?php echo $owner; ?></td>
			<td width="7%"><?php echo $responsible; ?></td>
			<td width=".1%" hidden><?php echo round($Acual_age,1);?></td>
						
			</tr>              
					
			
							
	<?php
	}				
?>

                </tbody>
            </table>
        </div>
    </div>
</div>	
<script type='text/javascript'>
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
		
        var min = parseInt( .1, 10 );
        var max = parseInt( 120, 10 );
		
		var minh = parseInt( .1, 10 );
        var maxh = parseInt( 24, 10 );
		
		var minc = parseInt( .1, 10 );
        var maxc = parseInt( 4, 10 );
		
        var age = parseFloat( data[11] ) || 0; // use data for the age column
		
		
		 var priority = parseFloat( data[3] ) || 0;
		 
		
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
	 
	'order': [[ 10, 'asc' ]]});

 
	
	 // Add event listeners to the two range filtering inputs
      $('#myTable td:nth-child(4)').each(function () {
				 
				 var a=$(this).text();
								
        if( a == '1 Critical ') {
			
            $(this).parent('tr').css('background-color', '#FF5733');
        }
		 if( a == '2 High') {
			
            $(this).parent('tr').css('background-color', '#FFC300');
        }
		 if( a == '3 Medium') {
			
            $(this).parent('tr').css('background-color', '#BC4DD7');
        }
		 if( a == '4 Low') {
			
            $(this).parent('tr').css('background-color', '#479E29');
        }
    });
  

    
} );
 
     $('#myTable td:nth-child(4)').each(function () {
				 
				 var a=$(this).text();
								
        if( a == '1 Critical ') {
			
            $(this).parent('tr').css('background-color', '#FF5733');
        }
		 if( a == '2 High') {
			
            $(this).parent('tr').css('background-color', '#FFC300');
        }
		 if( a == '3 Medium') {
			
            $(this).parent('tr').css('background-color', '#BC4DD7');
        }
		 if( a == '4 Low') {
			
            $(this).parent('tr').css('background-color', '#479E29');
        }
    });
  



</script>

