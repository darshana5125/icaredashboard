<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php


if($_POST['submit']=="Submit")
{
$redirect=$_POST['range'];
echo $redirect;

if ( isset($_POST['row'])){
	foreach ( $_POST['row'] as $row )
	
	{
		
		if ( isset($row['12']) && $row['12']=='true' )
		{
			//echo '</br> 1st escalation - '.$row['2'];
			$query="update servicelevel_view set 1st_esc=1 where tn='".$row['2']."'";
			echo '</br> '.$query;
			mysqli_query($connection,$query);			
		}
		
		if ( isset($row['13']) && $row['13']=='true' )
		{
			//echo '</br> 2nd escalation - '.$row['2'];
			$query2="update servicelevel_view set 2nd_esc=1 where tn='".$row['2']."'";
			echo  '</br> '.$query2;
			mysqli_query($connection,$query2);
		}	
		if ( isset($row['16'])){
			$query3="update servicelevel_view set remarks='".$row['16']."' where tn='".$row['2']."'";
			mysqli_query($connection,$query3);
			
		}
	}
	
}


if($_POST['range']=='2nd'){		
header("Location: https://192.168.47.25/icaredashboard/second_escalation_pending.php");
}
else if($_POST['range']=="1st"){
header("Location: https://192.168.47.25/icaredashboard/first_escalation_pending.php?mid=1");
}		
	
	else if($_POST['range']=="breached"){		
header("Location: https://192.168.47.25/icaredashboard/suspected_breach.php");
	}	
		else {		
header("Location: https://192.168.47.25/icaredashboard/sla_breached.php");
	}	
	
}

	
	


if($_POST['submit']=="ok"){
	if($_POST['range']=='2nd'){		
header('Location: https://192.168.47.25/icaredashboard/second_escalation_pending.php');
}
else if($_POST['range']=="1st"){
header("Location: https://192.168.47.25/icaredashboard/first_escalation_pending.php");
}

	
	else if($_POST['range']=="breached"){		
header("Location: https://192.168.47.25/icaredashboard/suspected_breach.php");
	}	
		
			
		else if($_POST['range']=="sla_breached") {		
header("Location: https://192.168.47.25/icaredashboard/sla_breached.php");
	}
	
	
}


if($_POST['submit']=="Generate Escalation Mail")
{
echo '<a href="#"  target="_blank"></a>';


if ( isset($_POST['row'])){
	
	foreach ( $_POST['row'] as $row)
	{
		
		if ( isset($row['0']) && $row['0']=='true' )
		{
			$queue=$row[1];
			$tn=$row[2];
			$owner=$row[3];
			$status=$row[4];
			$subject=$row[5];
			$create_time=$row[6];
			$priority=$row[7];
			$total_age=$row[8];
			$adjustments=$row[9];
			$actual_age_hrs=$row[10];
			$actual_age=$row[11];
			date_default_timezone_set('Asia/Colombo'); 
			$time=time();
			$low_sla=168;
			$Medium_sla=120;
			$high_sla=24;
			$critical_sla=2;
			$ndays=0;
			$hours=0;
			$minutes=0;
			$reduce=0;
			$we=0;
			

			
			if($priority=="3 Medium"){
			
			$time_remain_hrs=$Medium_sla-$actual_age_hrs;
			
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
			
			$time_remain_hrs=$high_sla-$actual_age_hrs;
			
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
			}else if ($priority=="1 Critical "){
			
			$time_remain_hrs=$critical_sla-$actual_age_hrs;
			
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
			else if($priority=="4 Low"){
					$time_remain_hrs=$low_sla-$actual_age_hrs;
			
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
			
				//$sla_breach_time=date("Y-M-d h:i A ",time()+$time_remain_hrs*3600);
				
				
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
				
				
				
						// $current_time=strtotime(date('Y-m-d H:i:s'));
						// $sla_breach_time_sec=strtotime($sla_breach_time);
						// $time_gap_days=($sla_breach_time_sec-$current_time)/(3600*24);
						
						
							// for($i=0;$i<$time_gap_days;$i++)
							// {

							// $day_check=date("N", $current_time);
							// if ($day_check==6)
							// {
								// $test=6;
							// $we++;
							// }
							// if ($day_check==7)
							// {
							// $we++;
							// $test=7;
							// }

							// $current_time=strtotime(date("m/d/Y h:i:s A ",$current_time + (24*3600*1)));

							
							// }
						
						
						// //$day_check=date("N", $sla_breach_time_sec);
						// //if ($day_check==6 || $day_check==7 ){	
							// if($we>0){
					// $sla_breach_time_ex_weekend=date("Y-M-d h:i A ",time()+($time_remain_hrs*3600)+(2*24*3600));
							// }else{
								// $sla_breach_time_ex_weekend=date("Y-M-d h:i A ",time()+($time_remain_hrs*3600));
							// }
		
		echo '<table border="1" bordercolor="#ccc" cellpadding="5" cellspacing="0" height="138" style="border-collapse:collapse;" width="1200">
	<tbody>
		<tr>
			<td><strong><span style="font-size:14px;">Queue</span></strong></td>
			<td><strong><span style="font-size:14px;">CSR#</span></strong></td>
			<td><strong><span style="font-size:14px;">Owner</span></strong></td>
			<td><strong><span style="font-size:14px;">Status</span></strong></td>
			<td><strong><span style="font-size:14px;">Description</span></strong></td>
			<td><strong><span style="font-size:14px;">Created date/time</span></strong></td>
			<td><strong><span style="font-size:14px;">Priority</span></strong></td>	
		
			<td><strong><span style="font-size:14px;">Remaining Time</span></strong></td>
			<td><strong><span style="font-size:14px;">SLA Breaches at</span></strong></td>
				<td><strong><span style="font-size:14px;">Remarks</span></strong></td>
		</tr>
		<tr>
			
			<td width="75"><span style="font-size:12px;">'.$queue.'</span></td>
			<td><span style="font-size:12px;">'.$tn.'</td>
			<td><span style="font-size:12px;">'.$owner.'</td>
			<td><span style="font-size:12px;">'.$status.'</td>
			<td width="250"><span style="font-size:12px;">'.$subject.'</td>
			<td><span style="font-size:12px;">'.$create_time.'</td>
			<td width="100"><span style="font-size:12px;">'.$priority.'</td>
			<td><span style="font-size:12px;">'.$time_remain.'</td>
			<td><span style="font-size:12px;">'.$sla_breach_time_ex_weekend.'</td>
	
			
		
			<td><span style="font-size:12px;">&nbsp;</td>
			
		</tr>
	</tbody>
</table>';

		}
		
	}


}
}
?>
