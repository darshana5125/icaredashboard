<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php');?>
<?php
/*if(!isset($_SESSION['user_id'])){
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
	
if($access==1){*/
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

  <link href="\icaredashboard/libraries/cloudflare/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
<script src="\icaredashboard/libraries/cloudflare/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>  

</head>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header btn btn-danger">
				<span>CSR count breakdown agent wise in terms of banks assigned</span>
			</div>
			<div class="card-body">
		<div class="row">
			<div class="col-md-10">
				<table class="collaptable table" id="table1">
					<thead>
						<tr>
							
							<th id="col">Agent Name</th>
							<th id="col">IBL Pending</th>
							<th id="col">Info Pending</th>
							<th id="col">Fix Given</th>
							<th id="col">Exp Given</th>							
						</tr>						
					</thead>
					<tbody>
						<?php
						$date ="";
						$cx_list="'LKA-UNI','MDV-MIB','KHM-VAT','KHM-PPC','KHM-FTB','LKA-NDB','NPL-CBN','NPL-NMB','NPL-LXB','BGD-BRC','LKA-NTB','LKA-SMB','LKA-MCB','LKA-CBC','LKA-HDF'";	

						if(isset($_POST['submit'])){
							$date =$_POST['dp'];
						}else{
							$date = date('Y-m-d');
						}

							

						$query="CREATE TEMPORARY TABLE IF NOT EXISTS temp_agent_wise AS
							(select iv.customer_id,iss.name as state,count(ih.ticket_id) as count from issue_view iv
							inner join issuehis_view ih on ih.ticket_id=iv.id
							inner join issuestate_view iss on ih.state_id=iss.id
							where iv.customer_id in(".$cx_list.") and ih.change_time<'".$date."' and ih.id in(select max(h.id) from issuehis_view h
							where h.change_time<'".$date."' group by h.ticket_id)
							group by  iv.customer_id,ih.state_id)";
						$query_run=mysqli_query($connection,$query);						

						$query2="create TEMPORARY TABLE IF NOT EXISTS temp_agent_wise_extended as (
						  select
						    temp_agent_wise.customer_id,
						    case when state = 'Assigned' or state = 'new' or state = 'merged '
						    or state = 'Pending Deployment (QA/UAT)' or state = 'new-agent reported  '
						    or state = 'escalated' or state = 'Pending Site visit'
						    or state = 'QA / testing' or state = 'Pending PRD '
						    or state = 'Pending Clarification' or state = 'Time Line Given'
						    or state = 'Pending Permanent Fix'      
						    then count end as Open,
						    case when state = 'Info pending from bank ' or state = 'Pending Discussion'
						    or state = 'Pending Remote Session' then count end as Info,
						    case when state = 'Explanation given' then count end as Explanation,
						    case when state = 'Fix given for UAT' then count end as Fix
						  from temp_agent_wise
						)";
						$query2_run=mysqli_query($connection,$query2);

						$query3="create TEMPORARY TABLE IF NOT EXISTS temp_agent_wise_extended_pivot as (
						  select 
						    customer_id, 
						    sum(Open) as Open, 
						    sum(Info) as Info,
						    sum(Explanation) as Explanation, 
						    sum(Fix) as Fix
						  from temp_agent_wise_extended
						  group by customer_id
						)";
						$query3_run=mysqli_query($connection,$query3);

						$query4="create TEMPORARY TABLE IF NOT EXISTS temp_agent_wise_extended_pivot_pretty as (
						  select 
						    customer_id, 
						    coalesce(Open, 0) as Open, 
						    coalesce(Info, 0) as Info, 
						    coalesce(Explanation, 0) as 'Explanation given', 
						    coalesce(Fix, 0) as 'Fix given'
						  from temp_agent_wise_extended_pivot
						)";
						$query4_run=mysqli_query($connection,$query4);						

						$query4_table="select * from temp_agent_wise_extended_pivot_pretty";
						$query4_table_run=mysqli_query($connection,$query4_table);

						$query_responsible="CREATE TEMPORARY TABLE IF NOT EXISTS temp_responsible_wise AS
							(select iv.customer_id,iss.name as state,count(ih.ticket_id) as count,u.first_name from issue_view iv
							inner join issuehis_view ih on ih.ticket_id=iv.id
							inner join issuestate_view iss on ih.state_id=iss.id
							inner join intuser_view u on u.id=iv.responsible_user_id 
							where iv.customer_id in(".$cx_list.") and ih.change_time<'".$date."' and ih.id in(select max(h.id) from issuehis_view h
							where h.change_time<'".$date."' group by h.ticket_id)
							group by  iv.customer_id,u.first_name,ih.state_id)";

						$query_responsible_run=mysqli_query($connection,$query_responsible);

						$query2_responsible="create TEMPORARY TABLE IF NOT EXISTS temp_responsible_wise_extended as (
						  select
						    temp_responsible_wise.customer_id,first_name,
						    case when state = 'Assigned' or state = 'new' or state = 'merged '
						    or state = 'Pending Deployment (QA/UAT)' or state = 'new-agent reported  '
						    or state = 'escalated' or state = 'Pending Site visit'
						    or state = 'QA / testing' or state = 'Pending PRD '
						    or state = 'Pending Clarification' or state = 'Time Line Given'
						    or state = 'Pending Permanent Fix'      
						    then count end as Open,
						    case when state = 'Info pending from bank ' or state = 'Pending Discussion'
						    or state = 'Pending Remote Session' then count end as Info,
						    case when state = 'Explanation given' then count end as Explanation,
						    case when state = 'Fix given for UAT' then count end as Fix
						  from temp_responsible_wise
						)";

						$query2_responsible_run=mysqli_query($connection,$query2_responsible);

						$query3_responsible="create TEMPORARY TABLE IF NOT EXISTS temp_responsible_wise_extended_pivot as (
						  select 
						    customer_id,first_name, 
						    sum(Open) as Open, 
						    sum(Info) as Info,
						    sum(Explanation) as Explanation, 
						    sum(Fix) as Fix
						  from temp_responsible_wise_extended
						  group by customer_id,first_name
						)";

						$query3_responsible_run=mysqli_query($connection,$query3_responsible);

						$query4_responsible="create TEMPORARY TABLE IF NOT EXISTS temp_responsible_wise_extended_pivot_pretty as (
						  select 
						    customer_id,first_name, 
						    coalesce(Open, 0) as Open, 
						    coalesce(Info, 0) as Info, 
						    coalesce(Explanation, 0) as 'Explanation given', 
						    coalesce(Fix, 0) as 'Fix given'
						  from temp_responsible_wise_extended_pivot
						)";

						$query4_responsible_run=mysqli_query($connection,$query4_responsible);

						$query4_responsible_table="select * from temp_responsible_wise_extended_pivot_pretty";
						$query4_responsible_table_run=mysqli_query($connection,$query4_responsible_table);

						$uni_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-UNI')";
						$uni_query_run=mysqli_query($connection,$uni_query);
						
						$mib_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('MDV-MIB')";
						$mib_query_run=mysqli_query($connection,$mib_query);

						$ndb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-NDB')";
						$ndb_query_run=mysqli_query($connection,$ndb_query);

						$hdf_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-HDF')";
						$hdf_query_run=mysqli_query($connection,$hdf_query);

						$cbc_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-CBC')";
						$cbc_query_run=mysqli_query($connection,$cbc_query);

						$mcb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-MCB')";
						$mcb_query_run=mysqli_query($connection,$mcb_query);

						$smb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-SMB')";
						$smb_query_run=mysqli_query($connection,$smb_query);

						$ntb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-NTB')";
						$ntb_query_run=mysqli_query($connection,$ntb_query);

						$ntb2_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('LKA-NTB')";
						$ntb2_query_run=mysqli_query($connection,$ntb2_query);

						$brc_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('BGD-BRC')";
						$brc_query_run=mysqli_query($connection,$brc_query);

						$cbn_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('NPL-CBN')";
						$cbn_query_run=mysqli_query($connection,$cbn_query);

						$lxb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('NPL-LXB')";
						$lxb_query_run=mysqli_query($connection,$lxb_query);

						$nmb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('NPL-NMB')";
						$nmb_query_run=mysqli_query($connection,$nmb_query);

						$vat_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('KHM-VAT')";
						$vat_query_run=mysqli_query($connection,$vat_query);

						$ppc_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('KHM-PPC')";
						$ppc_query_run=mysqli_query($connection,$ppc_query);

						$ftb_query="select * from temp_responsible_wise_extended_pivot_pretty where customer_id in('KHM-FTB')";
						$ftb_query_run=mysqli_query($connection,$ftb_query);



						$john_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('KHM-VAT')";
						$john_query_run=mysqli_query($connection,$john_query);

						$john2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('KHM-PPC')";
						$john2_query_run=mysqli_query($connection,$john2_query);

						$john3_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('KHM-FTB')";
						$john3_query_run=mysqli_query($connection,$john3_query);

						$a_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('NPL-CBN')";
						$a_query_run=mysqli_query($connection,$a_query);

						$a2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('NPL-LXB')";
						$a2_query_run=mysqli_query($connection,$a2_query);

						$a3_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('NPL-NMB')";
						$a3_query_run=mysqli_query($connection,$a3_query);

						$sp_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-SMB')";
						$sp_query_run=mysqli_query($connection,$sp_query);

						$sp2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-NTB')";
						$sp2_query_run=mysqli_query($connection,$sp2_query);

						$s_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('BGD-BRC')";
						$s_query_run=mysqli_query($connection,$s_query);

						$s2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-NTB')";
						$s2_query_run=mysqli_query($connection,$s2_query);

						$d_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-NDB')";
						$d_query_run=mysqli_query($connection,$d_query);

						$d2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-HDF')";
						$d2_query_run=mysqli_query($connection,$d2_query);

						$d3_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-CBC')";
						$d3_query_run=mysqli_query($connection,$d3_query);

						$d4_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-MCB')";
						$d4_query_run=mysqli_query($connection,$d4_query);

						$p_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('LKA-UNI')";
						$p_query_run=mysqli_query($connection,$p_query);
						$p2_query="select * from temp_agent_wise_extended_pivot_pretty where customer_id in('MDV-MIB')";
						$p2_query_run=mysqli_query($connection,$p2_query);



						while ($result=mysqli_fetch_assoc($query4_table_run)) {
							?>
							<tr>								
								<td class="customer_id"><?php echo $result['customer_id'] ?></td>
								<td><?php echo $result['Open'] ?></td>
								<td><?php echo $result['Info'] ?></td>
								<td><?php echo $result['Fix given'] ?></td>
								<td><?php echo $result['Explanation given'] ?></td>
							</tr>
						<?php	
						}					
						?>
						<script type="text/javascript">
						$(document).ready(function(){								


						var customer_id="";
						var john_opn=0;
						var john_info=0;
						var john_fix=0;
						var john_exp=0;
						var a_opn=0;
						var a_info=0;
						var a_fix=0;
						var a_exp=0;
						var s_opn=0;
						var s_info=0;
						var s_fix=0;
						var s_exp=0;
						var sp_opn=0;
						var sp_info=0;
						var sp_fix=0;
						var sp_exp=0;
						var d_opn=0;
						var d_info=0;
						var d_fix=0;
						var d_exp=0;
						var p_opn=0;
						var p_info=0;
						var p_fix=0;
						var p_exp=0;
						var click=0;
						var responsible="";
			
						

						

						$('#table1 tr').each(function(){
							customer_id=$(this).find(".customer_id").html();
							if(customer_id=='KHM-VAT' || customer_id=='KHM-PPC' || customer_id=='KHM-FTB'){
								john_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								john_info+=parseInt($(this).children('td:nth-child(3)').text());  
								john_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								john_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}if(customer_id=='NPL-NMB' || customer_id=='NPL-LXB' || customer_id=='NPL-CBN'){
								a_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								a_info+=parseInt($(this).children('td:nth-child(3)').text());  
								a_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								a_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}if(customer_id=='LKA-NTB' || customer_id=='BGD-BRC'){
								s_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								s_info+=parseInt($(this).children('td:nth-child(3)').text());  
								s_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								s_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}if(customer_id=='LKA-NTB' || customer_id=='LKA-SMB'){
								sp_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								sp_info+=parseInt($(this).children('td:nth-child(3)').text());  
								sp_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								sp_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}if(customer_id=='LKA-MCB' || customer_id=='LKA-CBC' || customer_id=='LKA-HDF' || customer_id=='LKA-NDB'){
								d_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								d_info+=parseInt($(this).children('td:nth-child(3)').text());  
								d_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								d_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}if(customer_id=='LKA-UNI' || customer_id=='MDV-MIB'){
								 p_opn+=parseInt($(this).children('td:nth-child(2)').text()); 
								 p_info+=parseInt($(this).children('td:nth-child(3)').text());  
								 p_fix+=parseInt($(this).children('td:nth-child(4)').text());  
								 p_exp+=parseInt($(this).children('td:nth-child(5)').text()); 
								$(this).hide();  
							}
														 
						});
						$('#table1 tr:first').after('<tr id="john" data-id="1" data-parent=""><td>John</td><td>'+john_opn+'</td><td>'+john_info+'</td><td>'+john_fix+'</td><td>'+john_exp+'</td></tr><?php while ($result_john=mysqli_fetch_assoc($john_query_run)) {
							?><tr class="j" data-id="1b1" data-parent="1"><td><?php echo $result_john['customer_id'];?></td><td><?php echo $result_john['Open'];?></td><td><?php echo $result_john['Info'];?></td><td><?php echo $result_john['Fix given'];?></td><td><?php echo $result_john['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_vat=mysqli_fetch_assoc($vat_query_run)) {
							?><tr class="j" data-parent="1b1"><td class="responsible"><?php echo $result_vat['first_name'];?></td><td><?php echo $result_vat['Open'];?></td><td><?php echo $result_vat['Info'];?></td><td><?php echo $result_vat['Fix given'];?></td><td><?php echo $result_vat['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_john2=mysqli_fetch_assoc($john2_query_run)) {
							?><tr class="j" data-id="1b2" data-parent="1"><td><?php echo $result_john2['customer_id'];?></td><td><?php echo $result_john2['Open'];?></td><td><?php echo $result_john2['Info'];?></td><td><?php echo $result_john2['Fix given'];?></td><td><?php echo $result_john2['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_ppc=mysqli_fetch_assoc($ppc_query_run)) {
							?><tr class="j" data-parent="1b2"><td class="responsible"><?php echo $result_ppc['first_name'];?></td><td><?php echo $result_ppc['Open'];?></td><td><?php echo $result_ppc['Info'];?></td><td><?php echo $result_ppc['Fix given'];?></td><td><?php echo $result_ppc['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_john3=mysqli_fetch_assoc($john3_query_run)) {
							?><tr class="j" data-id="1b3" data-parent="1"><td><?php echo $result_john3['customer_id'];?></td><td><?php echo $result_john3['Open'];?></td><td><?php echo $result_john3['Info'];?></td><td><?php echo $result_john3['Fix given'];?></td><td><?php echo $result_john3['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_ftb=mysqli_fetch_assoc($ftb_query_run)) {
							?><tr class="j" data-parent="1b3"><td class="responsible"><?php echo $result_ftb['first_name'];?></td><td><?php echo $result_ftb['Open'];?></td><td><?php echo $result_ftb['Info'];?></td><td><?php echo $result_ftb['Fix given'];?></td><td><?php echo $result_ftb['Explanation given'];?></td></tr> <?php }?>');
						$('#table1 tr:first').after('<tr id="aathif" data-id="2" data-parent=""><td>Aathif</td><td>'+a_opn+'</td><td>'+a_info+'</td><td>'+a_fix+'</td><td>'+a_exp+'</td></tr><?php while ($result_a=mysqli_fetch_assoc($a_query_run)) {
							?><tr  class="a" data-id="2b1" data-parent="2"><td><?php echo $result_a['customer_id'];?></td><td><?php echo $result_a['Open'];?></td><td><?php echo $result_a['Info'];?></td><td><?php echo $result_a['Fix given'];?></td><td><?php echo $result_a['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_cbn=mysqli_fetch_assoc($cbn_query_run)) {
							?><tr  class="a" data-parent="2b1"><td class="responsible"><?php echo $result_cbn['first_name'];?></td><td><?php echo $result_cbn['Open'];?></td><td><?php echo $result_cbn['Info'];?></td><td><?php echo $result_cbn['Fix given'];?></td><td><?php echo $result_cbn['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_a2=mysqli_fetch_assoc($a2_query_run)) {
							?><tr  class="a" data-id="2b2" data-parent="2"><td><?php echo $result_a2['customer_id'];?></td><td><?php echo $result_a2['Open'];?></td><td><?php echo $result_a2['Info'];?></td><td><?php echo $result_a2['Fix given'];?></td><td><?php echo $result_a2['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_lxb=mysqli_fetch_assoc($lxb_query_run)) {
							?><tr  class="a" data-parent="2b2"><td class="responsible"><?php echo $result_lxb['first_name'];?></td><td><?php echo $result_lxb['Open'];?></td><td><?php echo $result_lxb['Info'];?></td><td><?php echo $result_lxb['Fix given'];?></td><td><?php echo $result_lxb['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_a3=mysqli_fetch_assoc($a3_query_run)) {
							?><tr  class="a" data-id="2b3" data-parent="2"><td><?php echo $result_a3['customer_id'];?></td><td><?php echo $result_a3['Open'];?></td><td><?php echo $result_a3['Info'];?></td><td><?php echo $result_a3['Fix given'];?></td><td>                          <?php echo $result_a3['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_nmb=mysqli_fetch_assoc($nmb_query_run)) {
							?><tr  class="a" data-parent="2b3"><td class="responsible"><?php echo $result_nmb['first_name'];?></td><td><?php echo $result_nmb['Open'];?></td><td><?php echo $result_nmb['Info'];?></td><td><?php echo $result_nmb['Fix given'];?></td><td><?php echo $result_nmb['Explanation given'];?></td></tr> <?php }?>');
						$('#table1 tr:first').after('<tr id="suga" data-id="3" data-parent=""><td>Suganthan</td><td>'+s_opn+'</td><td>'+s_info+'</td><td>'+s_fix+'</td><td>'+s_exp+'</td></tr><?php while ($result_s=mysqli_fetch_assoc($s_query_run)) {
							?><tr class="s" data-id="3b1" data-parent="3"><td><?php echo $result_s['customer_id'];?></td><td><?php echo $result_s['Open'];?></td><td><?php echo $result_s['Info'];?></td><td><?php echo $result_s['Fix given'];?></td><td><?php echo $result_s['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_brc=mysqli_fetch_assoc($brc_query_run)) {
							?><tr  class="sp" data-parent="3b1"><td class="responsible"><?php echo $result_brc['first_name'];?></td><td><?php echo $result_brc['Open'];?></td><td><?php echo $result_brc['Info'];?></td><td><?php echo $result_brc['Fix given'];?></td><td><?php echo $result_brc['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_s2=mysqli_fetch_assoc($s2_query_run)) {
							?><tr class="s" data-id="3b2" data-parent="3"><td><?php echo $result_s2['customer_id'];?></td><td><?php echo $result_s2['Open'];?></td><td><?php echo $result_s2['Info'];?></td><td><?php echo $result_s2['Fix given'];?></td><td><?php echo $result_s2['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_ntb=mysqli_fetch_assoc($ntb_query_run)) {
							?><tr  class="sp" data-parent="3b2"><td class="responsible"><?php echo $result_ntb['first_name'];?></td><td><?php echo $result_ntb['Open'];?></td><td><?php echo $result_ntb['Info'];?></td><td><?php echo $result_ntb['Fix given'];?></td><td><?php echo $result_ntb['Explanation given'];?></td></tr> <?php }?>');
						$('#table1 tr:first').after('<tr id="shanaka" data-id="4" data-parent=""><td>Shanaka</td><td>'+sp_opn+'</td><td>'+sp_info+'</td><td>'+sp_fix+'</td><td>'+sp_exp+'</td></tr><?php while ($result_sp=mysqli_fetch_assoc($sp_query_run)) {
							?><tr  class="sp" data-id="4b1" data-parent="4"><td><?php echo $result_sp['customer_id'];?></td><td><?php echo $result_sp['Open'];?></td><td><?php echo $result_sp['Info'];?></td><td><?php echo $result_sp['Fix given'];?></td><td><?php echo $result_sp['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_smb=mysqli_fetch_assoc($smb_query_run)) {
							?><tr  class="sp" data-parent="4b1"><td class="responsible"><?php echo $result_smb['first_name'];?></td><td><?php echo $result_smb['Open'];?></td><td><?php echo $result_smb['Info'];?></td><td><?php echo $result_smb['Fix given'];?></td><td><?php echo $result_smb['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_sp2=mysqli_fetch_assoc($sp2_query_run)) {
							?><tr class="sp" data-id="4b2" data-parent="4"><td><?php echo $result_sp2['customer_id'];?></td><td><?php echo $result_sp2['Open'];?></td><td><?php echo $result_sp2['Info'];?></td><td><?php echo $result_sp2['Fix given'];?></td><td><?php echo $result_sp2['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_ntb2=mysqli_fetch_assoc($ntb2_query_run)) {
							?><tr class="sp" data-parent="4b2"><td class="responsible"><?php echo $result_ntb2['first_name'];?></td><td><?php echo $result_ntb2['Open'];?></td><td><?php echo $result_ntb2['Info'];?></td><td><?php echo $result_ntb2['Fix given'];?></td><td><?php echo $result_ntb2['Explanation given'];?></td></tr> <?php }?>');
						$('#table1 tr:first').after('<tr id="damith" data-id="5" data-parent=""><td>Damith</td><td>'+d_opn+'</td><td>'+d_info+'</td><td>'+d_fix+'</td><td>'+d_exp+'</td></tr><?php while ($result_d=mysqli_fetch_assoc($d_query_run)) {
							?><tr class="d" data-id="5b1" data-parent="5"><td><?php echo $result_d['customer_id'];?></td><td><?php echo $result_d['Open'];?></td><td><?php echo $result_d['Info'];?></td><td><?php echo $result_d['Fix given'];?></td><td><?php echo $result_d['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_ndb=mysqli_fetch_assoc($ndb_query_run)) {
							?><tr  class="d" data-parent="5b1"><td class="responsible"><?php echo $result_ndb['first_name'];?></td><td><?php echo $result_ndb['Open'];?></td><td><?php echo $result_ndb['Info'];?></td><td><?php echo $result_ndb['Fix given'];?></td><td><?php echo $result_ndb['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_d2=mysqli_fetch_assoc($d2_query_run)) {
							?><tr class="d" data-id="5b2" data-parent="5"><td><?php echo $result_d2['customer_id'];?></td><td><?php echo $result_d2['Open'];?></td><td><?php echo $result_d2['Info'];?></td><td><?php echo $result_d2['Fix given'];?></td><td><?php echo $result_d2['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_hdf=mysqli_fetch_assoc($hdf_query_run)) {
							?><tr  class="d" data-parent="5b2"><td class="responsible"><?php echo $result_hdf['first_name'];?></td><td><?php echo $result_hdf['Open'];?></td><td><?php echo $result_hdf['Info'];?></td><td><?php echo $result_hdf['Fix given'];?></td><td><?php echo $result_hdf['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_d3=mysqli_fetch_assoc($d3_query_run)) {
							?><tr class="d" data-id="5b3" data-parent="5"><td><?php echo $result_d3['customer_id'];?></td><td><?php echo $result_d3['Open'];?></td><td><?php echo $result_d3['Info'];?></td><td><?php echo $result_d3['Fix given'];?></td><td><?php echo $result_d3['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_cbc=mysqli_fetch_assoc($cbc_query_run)) {
							?><tr  class="d" data-parent="5b3"><td class="responsible"><?php echo $result_cbc['first_name'];?></td><td><?php echo $result_cbc['Open'];?></td><td><?php echo $result_cbc['Info'];?></td><td><?php echo $result_cbc['Fix given'];?></td><td><?php echo $result_cbc['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_d4=mysqli_fetch_assoc($d4_query_run)) {
							?><tr class="d" data-id="5b4" data-parent="5"><td><?php echo $result_d4['customer_id'];?></td><td><?php echo $result_d4['Open'];?></td><td><?php echo $result_d4['Info'];?></td><td><?php echo $result_d4['Fix given'];?></td><td><?php echo $result_d4['Explanation given'];?></td></tr> <?php }?>
							<?php while ($result_mcb=mysqli_fetch_assoc($mcb_query_run)) {
							?><tr  class="d" data-parent="5b4"><td class="responsible"><?php echo $result_mcb['first_name'];?></td><td><?php echo $result_mcb['Open'];?></td><td><?php echo $result_mcb['Info'];?></td><td><?php echo $result_mcb['Fix given'];?></td><td><?php echo $result_mcb['Explanation given'];?></td></tr> <?php }?>');
						$('#table1 tr:first').after('<tr id="priya" data-id="6" data-parent=""><td>Priyadarshana</td><td>'+p_opn+'</td><td>'+p_info+'</td><td>'+p_fix+'</td><td>'+p_exp+'</td></tr><?php while ($result_p=mysqli_fetch_assoc($p_query_run)) {
							?><tr  class="p" data-id="6b1" data-parent="6"><td><?php echo $result_p['customer_id'];?></td><td><?php echo $result_p['Open'];?></td><td><?php echo $result_p['Info'];?></td><td><?php echo $result_p['Fix given'];?></td><td><?php echo $result_p['Explanation given'];?></td></tr> <?php }?>
						<?php while ($result_uni=mysqli_fetch_assoc($uni_query_run)) {
							?><tr  class="p" data-parent="6b1"><td class="responsible"><?php echo $result_uni['first_name'];?></td><td><?php echo $result_uni['Open'];?></td><td><?php echo $result_uni['Info'];?></td><td><?php echo $result_uni['Fix given'];?></td><td><?php echo $result_uni['Explanation given'];?></td></tr> <?php }?>
						<?php while ($result_p2=mysqli_fetch_assoc($p2_query_run)) {
							?><tr  class="p" data-id="6b2" data-parent="6"><td><?php echo $result_p2['customer_id'];?></td><td><?php echo $result_p2['Open'];?></td><td><?php echo $result_p2['Info'];?></td><td><?php echo $result_p2['Fix given'];?></td><td><?php echo $result_p2['Explanation given'];?></td></tr> <?php }?>
						<?php while ($result_mib=mysqli_fetch_assoc($mib_query_run)) {
							?><tr  class="p" data-parent="6b2"><td class="responsible"><?php echo $result_mib['first_name'];?></td><td><?php echo $result_mib['Open'];?></td><td><?php echo $result_mib['Info'];?></td><td><?php echo $result_mib['Fix given'];?></td><td><?php echo $result_mib['Explanation given'];?></td></tr> <?php }?>
							</tbody></table>');


			



						//$('td.responsible').each(function(){
						//responsible=$(this).find(".responsible").html();
						//$(this).hide();
						//$this = $(this);
						//var value = $this.find(".responsible").html();
						//alert(value);
						//alert('ok');
						

						//$(this).parent().find("tr").hide();
					

						//});
				
							
						
						$('.collaptable').aCollapTable({ 

// the table is collapased at start
startCollapsed: true,

// the plus/minus button will be added like a column
addColumn: true, 

// The expand button ("plus" +)
plusButton: '<span class="i">+</span>', 

// The collapse button ("minus" -)
minusButton: '<span class="i">-</span>' 
  
});

						
						//$('#table1 tr.p:first').after('<tr data-parent="6b1"><td>'+uni_opn+'</td><td>'+uni_opn+'</td><td>'+uni_opn+'</td><td>'+uni_opn+'</td></tr>');


			
	$.fn.datepicker.defaults.format = "yyyy-mm-dd";
	$('#datepicker').datepicker();


	


		



	
//$('#table1 tr.p:first').after('<tr data-parent="6b1"><td>'+uni_opn+'</td><td>'+uni_opn+'</td><td>'+uni_opn+'</td><td>'+uni_opn+'</td></tr>');
	



			
});	



			
			

	

		
		


	
	

					
	</script>

			</div>
		</div>
		
		<form action="agent_wise3.php?mid=20" method="post">
			<div class="input-group date">
	      		<input type="text" class="form-control col-md-2" id="datepicker" placeholder="yyyy-mm-dd" name="dp"
	      		value="<?php if(isset($_POST['submit'])){echo $_POST['dp'];}else{echo date('Y-m-d');}?>">
	      		<input type="submit" name="submit" value="GO" class="btn btn-warning">
	      		
	  		</div>
	  		
  		</form>		
  		</div>
  	</div>
	</div>
	
</body>
</html>

<script type="text/javascript">
	
	


	</script>
<?php
//}
?>