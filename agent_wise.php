<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/icaredashboard/ums/inc/connection.php'); ?>
<?php

if(!isset($_SESSION['user_id'])){
header('Location:ums/index2.php');
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
	<title>Agent Wise</title>
	<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="\icaredashboard/libraries/cloudflare/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="\icaredashboard/css/agent_wise.css">
	<link rel="stylesheet" href="\icaredashboard\ums/css/main.css">
	<script src="\icaredashboard/js/jquery.aCollapTable.js"></script>	
	<style> 
		#loader { 
			border: 12px solid #f3f3f3; 
			border-radius: 50%; 
			border-top: 12px solid #841d5d; 
			width: 70px; 
			height: 70px; 
			animation: spin 1s linear infinite; 
		} 
		
		@keyframes spin { 
			100% { 
				transform: rotate(360deg); 
			} 
		} 
		
		.center { 
			position: relative; 
			top: 0; 
			bottom: 0; 
			left: 0; 
			right: 0; 
			margin: auto; 
		} 
	</style> 
</head>
<header>
	<div class="appname">iCare Dashboard</div>
	<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>

<body>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.collaptable').aCollapTable({

				// the table is collapased at start
				startCollapsed: true,

				// the plus/minus button will be added like a column
				addColumn: true,

				// The expand button ("plus" +)
				plusButton: '<span class="i"><img class="arrow" src="img/right-arrow.png"></span>',

				// The collapse button ("minus" -)
				minusButton: '<span class="i"><img class="arrow" src="img/down-arrow.png"></span>'

			});
		});
	</script>

	<div id="container" class="container">
		<div class="card">
			<div class="card-header btn btn-danger">
				<span>CSR count breakdown agent wise in terms of banks assigned</span>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-10">
						<div id="loader" class="center"></div>
						<div class="input-group date">
							<form action="agent_wise.php?mid=20" method="POST">
								<input type="date" id="cutoff_date" name="cutoff_date"
								value="<?php if (isset($_POST['cutoff_date']) && !empty($_POST['cutoff_date'])) {
								echo $date = $_POST['cutoff_date'];}
						?>">
								<input type="submit" id="submit" name="submit" value="GO" class="btn btn-warning submit">
							</form>
						</div>
						<?php
						
						if (isset($_POST['cutoff_date']) && !empty($_POST['cutoff_date'])) {
							$date = $_POST['cutoff_date'];
							$table="";
						
						$table.='<table class="collaptable table" id="table1">
							<thead>
								<tr class="main-heading">
									<th>Agent Name</th>
									<th>IBL Pending</th>
									<th>Info Pending</th>
									<th>Exp Given</th>
									<th>Fix Given</th>
								</tr>
							</thead>
							<tbody>';
																
								$cx_list = "'LKA-UNI','MDV-MIB','KHM-VAT','KHM-PPC','KHM-FTB','LKA-NDB','NPL-CBN','NPL-NMB','NPL-LXB','BGD-BRC','LKA-NTB','LKA-SMB','LKA-MCB','LKA-CBC','LKA-HDF'";
								$all_states="1,4,9,10,12,18,20,23,26,27,28,29,14,19,30,24,25";
								//support user ids
								$user_ids = "1,104,7,70,239,191,160,238,319,217,201,55,176,177,100,92,253,290,310,284,353,356";
								

								$first_view = "SELECT SUM(cu.open_count) AS open, 
						SUM(cu.info_count)        AS info, 
						SUM(cu.explanation_count) AS exp, 
						SUM(cu.uatfix_count)      AS fix, 
						a.name,a.agent_id
						 FROM   (SELECT issview.customer_id, 
								Coalesce(SUM(issview.open), 0)        AS open_count, 
								Coalesce(SUM(issview.info), 0)        AS Info_count, 
								Coalesce(SUM(issview.exp), 0) AS Explanation_count, 
								Coalesce(SUM(issview.fix), 0)      AS UATFix_count 
						 FROM   (SELECT iv.customer_id, 
										(case when ih.state_id=1 or ih.state_id=4 or ih.state_id=9
										or ih.state_id=10 or ih.state_id=12
										or ih.state_id=18 or ih.state_id=20
										or ih.state_id=23 or ih.state_id=26
										or ih.state_id=27 or ih.state_id=28
										or ih.state_id=29     
										then count(ih.ticket_id) end )as open,
										case when ih.state_id=14 or ih.state_id=19
										or ih.state_id=30 then count(ih.ticket_id) end as info,
										case when ih.state_id=24 then count(ih.ticket_id) end as exp,
										case when ih.state_id=25 then count(ih.ticket_id) end as fix 										
								 FROM   icaredashboard2.issue_view iv 
										inner join icaredashboard2.issuehis_view ih 
												ON ih.ticket_id = iv.id 
										inner join icaredashboard2.issuestate_view iss 
												ON ih.state_id = iss.id 
								 WHERE  iv.customer_id IN (".$cx_list.") 
										AND ih.change_time <'".$date."' 
										AND ih.id IN(SELECT Max(h.id) 
													 FROM   icaredashboard2.issuehis_view h 
													 WHERE  h.change_time <'".$date."' 
													 GROUP  BY h.ticket_id) 
								 GROUP  BY iv.customer_id, 
										   ih.state_id) issview 
						 GROUP  BY issview.customer_id) AS cu 
						inner join agents a 
								ON cu.customer_id = a.bank_code 
				 		GROUP  BY a.agent_id";
								$first_view_run = mysqli_query($connection, $first_view);
								$data_id = 1;
								$cx_id = 100;
								$support_id = 1000;
								$sup_ticket_id = 10000;
								$project_id = 100000;
								$project_ticket_id = 1000000;
								
								while ($result = mysqli_fetch_assoc($first_view_run)) {
									$agent_id = $result['agent_id'];
								
								$table.="<tr class= ".$result['name']." data-id=".$data_id." data-parent=''>
										<td>".$result['name']."</td>
										<td>".$result['open']."</td>
										<td>".$result['info']."</td>
										<td>".$result['exp']."</td>
										<td>".$result['fix']."</td>
									</tr>";
									
									$second_view = "SELECT issview.customer_id, 
						Coalesce(SUM(issview.open), 0)        AS open_count, 
						Coalesce(SUM(issview.info), 0)        AS info_count, 
						Coalesce(SUM(issview.exp), 0) AS explanation_count, 
						Coalesce(SUM(issview.fix), 0)      AS fix_count 
				 		FROM   (SELECT iv.customer_id,								 
										(case when ih.state_id=1 or ih.state_id=4 or ih.state_id=9
										or ih.state_id=10 or ih.state_id=12
										or ih.state_id=18 or ih.state_id=20
										or ih.state_id=23 or ih.state_id=26
										or ih.state_id=27 or ih.state_id=28
										or ih.state_id=29     
										then count(ih.ticket_id) end )as open,
										case when ih.state_id=14 or ih.state_id=19
										or ih.state_id=30 then count(ih.ticket_id) end as info,
										case when ih.state_id=24 then count(ih.ticket_id) end as exp,
										case when ih.state_id=25 then count(ih.ticket_id) end as fix
						 FROM   icaredashboard2.issue_view iv 
								inner join icaredashboard2.issuehis_view ih 
										ON ih.ticket_id = iv.id 
								inner join icaredashboard2.issuestate_view iss 
										ON ih.state_id = iss.id 
						 WHERE  iv.customer_id IN(SELECT bank_code 
												  FROM   agents 
												  WHERE  agent_id =".$agent_id.") 
								AND ih.change_time <'".$date."' 
								AND ih.id IN(SELECT Max(h.id) 
											 FROM   icaredashboard2.issuehis_view h 
											 WHERE  h.change_time <'".$date."' 
											 GROUP  BY h.ticket_id) 
						 GROUP  BY iv.customer_id, 
								   ih.state_id) issview 
				 		GROUP  BY issview.customer_id";
									$second_view_run = mysqli_query($connection, $second_view);

									while ($result2 = mysqli_fetch_assoc($second_view_run)) {
										$customer_id = $result2['customer_id'];
										//echo $cx_id.$data_id.'<br>';							
									
									$table.="<tr class='customer' data-id=".$cx_id." data-parent=".$data_id.">
											<td class='agent'>".$result2['customer_id']."</td>
											<td>".$result2['open_count']."</td>
											<td>".$result2['info_count']."</td>
											<td>".$result2['explanation_count']."</td>
											<td>".$result2['fix_count']."</td>
										</tr>";
										
										
										$third_view = "select issview.support,
										coalesce(sum(issview.Open),0) as open_count,
												coalesce(sum(issview.Info),0) as info_count,
												coalesce(sum(issview.Explanation),0) as explanation_count,
												coalesce(sum(issview.UATFix),0) as fix_count
										from
										(select 'Support',
										(case when ih.state_id=1 or ih.state_id=4 or ih.state_id=9
										or ih.state_id=10 or ih.state_id=12
										or ih.state_id=18 or ih.state_id=20
										or ih.state_id=23 or ih.state_id=26
										or ih.state_id=27 or ih.state_id=28
										or ih.state_id=29     
										then count(ih.ticket_id) end )as Open,
										case when ih.state_id=14 or ih.state_id=19
										or ih.state_id=30 then count(ih.ticket_id) end as Info,
										case when ih.state_id=24 then count(ih.ticket_id) end as Explanation,
										case when ih.state_id=25 then count(ih.ticket_id) end as UATFix
										from icaredashboard2.issue_view iv
										inner join icaredashboard2.issuehis_view ih
										on ih.ticket_id=iv.id
										inner join icaredashboard2.issuestate_view iss
										on ih.state_id=iss.id	                    
										  inner join intuser_view u
										on u.id=substring_index((select name
								  from issuehis_view
									where id =  (
									select max(id) from issuehis_view x where  x.history_type_id=34
									and date(x.change_time) <= '".$date."'                
									) ), '%', -1) 
									 inner join intuser_view u1 on iv.responsible_user_id=u1.id
									  and iv.responsible_user_id in (".$user_ids.")
										where iv.customer_id in('".$customer_id."') and ih.change_time<'".$date."' and 
										ih.id in (select max(y.id) from issuehis_view y where y.change_time<'".$date."'
										group by y.ticket_id)                                
										group by  iv.customer_id,ih.ticket_id,ih.state_id) issview";


										$third_view_run = mysqli_query($connection, $third_view);

										while ($result3 = mysqli_fetch_assoc($third_view_run)) {
											//echo $cx_id.'<br>';														
										
										$table.="<tr class='support' data-id=".$support_id." data-parent=".$cx_id.">
												<td class='agent'>".$result3['support']."</td>
												<td>".$result3['open_count']."</td>
												<td>".$result3['info_count']."</td>
												<td>".$result3['explanation_count']."</td>
												<td>".$result3['fix_count']."</td>
											</tr>";
											
											$fourth_view = "select iv.tn,iv.id as ticket_id,iss.name as state,iv.customer_id,u1.first_name as responsible,u2.first_name as owner,date_format(iv.create_time,'%Y-%m-%d') as create_date
											from issue_view iv
										   inner join issuehis_view ih
										   on ih.ticket_id=iv.id
										   inner join intuser_view u
										   on u.id=substring_index((select name
														 from issuehis_view
														   where id = (
														   select max(id) from issuehis_view x where  x.history_type_id=34
														   and date(x.change_time) <= '".$date."'                            
														   ) ), '%', -1) 
										   inner join issuestate_view iss
										   on ih.state_id=iss.id
											inner join intuser_view u1 on iv.responsible_user_id=u1.id
											inner join intuser_view u2
											on ih.owner_id=u2.id
															 and iv.responsible_user_id in (".$user_ids.")
										   where iv.customer_id in('".$customer_id."') and ih.change_time<'2020-12-31' and ih.state_id in(1,4,9,10,12,18,20,23,26,27,28,29,14,19,30,24,25) and
															   ih.id in (select max(y.id) from issuehis_view y where y.change_time<'".$date."'
										   group by y.ticket_id)
										   order by iss.name";

											$fourth_view_run = mysqli_query($connection, $fourth_view);
											
											$table.="<tr data-parent=".$support_id." class='sup-ticket sup-heading'><!--th>#</th--><th>CSR #</th><th>State</th><th>Create Date</th><th>Owner</th><th>Responsible</th>";		
											$sup_count=1;
											while ($result4 = mysqli_fetch_assoc($fourth_view_run)) {											
											$table.="<tr class='sup-ticket' data-id=".$sup_ticket_id." data-parent=".$support_id.">
													<!--td>".$sup_count."</td-->
													<td class='agent'><a href='https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=".$result4["ticket_id"]."'  target='_blank'>".$result4['tn']."</a></td>
													<td>".$result4['state']."</td>
													<td>".$result4['create_date']."</td>
													<td>".$result4['owner']."</td>
													<td>".$result4['responsible']."</td>
												</tr>";
												$sup_count++;											
												$sup_ticket_id++;
											}
											$support_id++;
										}
										$fifth_view = "select issview.project,
										coalesce(sum(issview.Open),0) as open_count,
												coalesce(sum(issview.Info),0) as info_count,
												coalesce(sum(issview.Explanation),0) as explanation_count,
												coalesce(sum(issview.UATFix),0) as fix_count
										from
										(select 'Project',
										(case when ih.state_id=1 or ih.state_id=4 or ih.state_id=9
										or ih.state_id=10 or ih.state_id=12
										or ih.state_id=18 or ih.state_id=20
										or ih.state_id=23 or ih.state_id=26
										or ih.state_id=27 or ih.state_id=28
										or ih.state_id=29     
										then count(ih.ticket_id) end )as Open,
										case when ih.state_id=14 or ih.state_id=19
										or ih.state_id=30 then count(ih.ticket_id) end as Info,
										case when ih.state_id=24 then count(ih.ticket_id) end as Explanation,
										case when ih.state_id=25 then count(ih.ticket_id) end as UATFix
										from icaredashboard2.issue_view iv
										inner join icaredashboard2.issuehis_view ih
										on ih.ticket_id=iv.id
										inner join icaredashboard2.issuestate_view iss
										on ih.state_id=iss.id	                    
										  inner join intuser_view u
										on u.id=substring_index((select name
								  from issuehis_view
									where id =  (
									select max(id) from issuehis_view x where  x.history_type_id=34
									and date(x.change_time) <= '".$date."'                
									) ), '%', -1) 
									 inner join intuser_view u1 on iv.responsible_user_id=u1.id
									  and iv.responsible_user_id not in (".$user_ids.")
										where iv.customer_id in('".$customer_id."') and ih.change_time<'".$date."' and 
										ih.id in (select max(y.id) from issuehis_view y where y.change_time<'".$date."'
										group by y.ticket_id)                                
										group by  iv.customer_id,ih.ticket_id,ih.state_id) issview";

										$fifth_view_run = mysqli_query($connection, $fifth_view);

										while ($result5 = mysqli_fetch_assoc($fifth_view_run)) {
											
										$table.="<tr class='project' data-id=".$project_id." data-parent=".$cx_id.">
												<td class='agent'>".$result5['project']."</td>
												<td>".$result5['open_count']."</td>
												<td>".$result5['info_count']."</td>
												<td>".$result5['explanation_count']."</td>
												<td>".$result5['fix_count']."</td>
											</tr>";
											
											$sixth_view = "select iv.tn,iv.id as ticket_id,iss.name as state,iv.customer_id,u1.first_name as responsible,u2.first_name as owner,date_format(iv.create_time,'%Y-%m-%d') as create_date
											 from issue_view iv
											inner join issuehis_view ih
											on ih.ticket_id=iv.id
											inner join intuser_view u
											on u.id=substring_index((select name
														  from issuehis_view
															where id = (
															select max(id) from issuehis_view x where  x.history_type_id=34
															and date(x.change_time) <= '".$date."'                            
															) ), '%', -1) 
											inner join issuestate_view iss
											on ih.state_id=iss.id
											 inner join intuser_view u1 on iv.responsible_user_id=u1.id
											 inner join intuser_view u2
                                             on ih.owner_id=u2.id
															  and iv.responsible_user_id not in (".$user_ids.")
											where iv.customer_id in('".$customer_id."') and ih.change_time<'2020-12-31' and ih.state_id in(1,4,9,10,12,18,20,23,26,27,28,29,14,19,30,24,25) and
																ih.id in (select max(y.id) from issuehis_view y where y.change_time<'".$date."'
											group by y.ticket_id)
											order by iss.name";

											$sixth_view_run = mysqli_query($connection, $sixth_view);

											$table.="<tr data-parent=".$project_id." class='sup-ticket pro-heading'><!--th>#</th--><th>CSR #</th><th>State</th><th>Create Date</th><th>Owner</th><th>Responsible</th>";
											$pro_count=1;
											while ($result6 = mysqli_fetch_assoc($sixth_view_run)) {
											
											$table.="<tr class='pro-ticket' data-id=".$project_ticket_id." data-parent=".$project_id.">
													<!--td>".$pro_count."</td-->
													<td class='agent'><a href='https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=".$result6["ticket_id"]."'  target='_blank'>".$result6['tn']."</a></td>
													<td>".$result6['state']."</td>
													<td>".$result6['create_date']."</td>
													<td>".$result6['owner']."</td>
													<td>".$result6['responsible']."</td>
												</tr>";
												$pro_count++;
												$project_ticket_id++;
											}
											$project_id++;
										}

										$cx_id++;
									}
									$data_id++;
								}
							echo $table;
							}
} 
								?>
					
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
<script> 
		document.onreadystatechange = function() { 
			if (document.readyState !== "complete") { 
				document.querySelector( 
				"body").style.visibility = "hidden"; 
				document.querySelector( 
				"#loader").style.visibility = "visible"; 
			} else { 
				document.querySelector( 
				"#loader").style.display = "none"; 
				document.querySelector( 
				"body").style.visibility = "visible"; 
			} 
		}; 
	</script> 

</html>