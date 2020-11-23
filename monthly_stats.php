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



echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
 <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<link rel="stylesheet" href="\icaredashboard/ums/css/main.css">
<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>

<link href="\icaredashboard/libraries/cloudflare/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet" type="text/css" > 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" />
<link href="\icaredashboard/libraries/datatables/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link href="\icaredashboard/libraries/datatables/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css" />
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<link href="\icaredashboard/css/monthly_stats.css" rel="stylesheet" type="text/css" />';
?>

<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
$frm_date=date('d/m/Y');
$frm_date;

echo '<div id="container" style="font-family:arial;font-size:11px;">
<div style="margin-top:-30px;">
<form action="monthly_stats.php?mid=21" method="POST">
<label style="display:inline;margin-left:250px;color:#fff;">From</label>';
?>
<input type="date" id="frm_date" name="frm_date" style="margin-left:20px; display:inline;" 
value="<?php if (isset($_POST["frm_date"]) && !empty($_POST["frm_date"])) {
    echo $frm_date = $_POST["frm_date"];}else{  echo date('Y-m-d');}?>">
<?php
echo'<label style="display:inline;margin-left:50px;color:#fff;">To</label>'
?>
<input type="date" id="to_date" name="to_date" style="margin-left:20px; display:inline;" 
value="<?php if (isset($_POST["to_date"]) && !empty($_POST["to_date"])) {
    echo $to_date = $_POST["to_date"];}else{  echo date('Y-m-d');}?>">
<input type="submit" id="submit" name="submit" value="GO" class="btn btn-warning submit" style="margin-left:20px;margin-top:-10px;" >
<?php
echo'</form>
</div>';
?>
<?php
    if(isset($_POST["frm_date"]) && isset($_POST["to_date"]) && isset($_POST["submit"]) ){
    echo'<table style="width: 1%;font-family:arial;font-size:11px;width:98%;margin: 0 auto;" id="example" class="table table-sm table-bordered" x><thead class="thead-dark"> <tr><th>Number</th><th>CustomerID</th><th>CSR#</th><th>Title</th><th>Created</th>
<th>Queue</th><th>State</th><th>SLA</th><th class="pri">Priority</th><th>Service Category</th><th>Service</th><th>Owner</th>
<th>Responsible</th><th>CSR Type</tr></thead><tbody>';


/*$query="select distinct * from view_temp2 where create_time>='2016-04-01' and exception=0 and q_name!='Change Request Queue' and q_name  !='NDB - Live Issues'
 and q_name!='DELETED_TICKETS'
union(
select distinct * from view_temp2 where q_name  ='NDB - Live Issues' and create_time>'2015-11-05 00:00:00')
order by tn desc";*/

    $query="select * from(
    select distinct vt.*,iv.id as ticket_id,u.first_name as responsible from view_temp2 vt
    inner join issue_view iv on vt.tn=iv.tn
    inner join intuser_view u on u.id=iv.responsible_user_id
    where vt.q_name not like '%_UAT%' and vt.create_time>='$frm_date' and vt.create_time<='$to_date'and vt.exception=0 and  
    vt.q_name not in ('Change Request Queue','NDB - Live Issues','DELETED_TICKETS','CRB_Projects','Change Request_Queue::Vattanac_CR Queue',
    'Philippines::Union Bank Of The Philippines::UBP Cyber_Prod','Sri Lanka::Nations Trust Bank::Record Room','TEST_supp_group') 
    union(select distinct vt2.*,iv2.id as ticket_id,u2.first_name as responsible from view_temp2 vt2
    inner join issue_view iv2 on vt2.tn=iv2.tn
    inner join intuser_view u2 on u2.id=iv2.responsible_user_id
    where vt2.q_name  ='NDB - Live Issues' and vt2.create_time>'2015-11-05 00:00:00')) as i
    order by create_time desc";




$query_run=mysqli_query($connection,$query);
$count=1;

while($result2=mysqli_fetch_assoc($query_run)) 
{
	if($result2['sla_state']==1)
	{
	echo '<tr><td class="no">'.$count.'</td>
    <td class="cx">'.$result2['cx_id'].'</td>';
    ?>
	<td class="csr"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $result2["ticket_id"];?> " target="_blank"><?php echo $result2['tn'];?></a></td>
    <?php
    echo'<td class="subject">'.substr($result2['title'],0,100).'</td>
	<td class="time">'.$result2['create_time'].'</td>	
	<td class="queue"> '.$result2['q_name'].'</td>
    <td class="state">'.$result2['ts_name'].'</font></td>
    <td>SLA Met</td>
    <td> '.$result2['tp_name'].'</td>
    <td></td>
    <td class="service"> '.$result2['s_name'].'</td>     
	<td class="owner"> '.$result2['first_name'].'</td>
    <td class="owner">'.$result2['responsible'].'</td>
    <td>&nbsp;</td>
	</tr>'; 
	
$count++;
	}
	if($result2['sla_state']==2 || $result2['sla_state']=="" )
	{
        echo '<tr><td class="no">'.$count.'</td>
        <td class="cx">'.$result2['cx_id'].'</td>';
        ?>
        <td class="csr"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $result2["ticket_id"];?>" target="_blank"><?php echo $result2['tn'];?></a></td>
        <?php
        echo'<td class="subject">'.substr($result2['title'],0,100).'</td>
        <td class="time">'.$result2['create_time'].'</td>	
        <td class="queue"> '.$result2['q_name'].'</td>
        <td class="state"> '.$result2['ts_name'].'</font></td>
        <td>Within SLA</td>
        <td> '.$result2['tp_name'].'</td>
        <td></td>
        <td class="service"> '.$result2['s_name'].'</td>         
        <td class="owner"> '.$result2['first_name'].'</td>
        <td class="owner">'.$result2['responsible'].'</td>
        <td>&nbsp;</td>
        </tr>'; 
	
$count++;	
	}
	if($result2['sla_state']==3)
	{
        echo '<tr><td class="no">'.$count.'</td>
        <td class="cx">'.$result2['cx_id'].'</td>';
        ?>
        <td class="csr"><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $result2["ticket_id"];?>" target="_blank"><?php echo $result2['tn'];?></a></td>
        <?php
        echo'<td class="subject">'.substr($result2['title'],0,100).'</td>
        <td class="time">'.$result2['create_time'].'</td>	
        <td class="queue"> '.$result2['q_name'].'</td>
        <td class="state"> '.$result2['ts_name'].'</font></td>
        <td>SLA Not Met</td>
        <td> '.$result2['tp_name'].'</td>
        <td></td>
        <td class="service"> '.$result2['s_name'].'</td>         
        <td class="owner"> '.$result2['first_name'].'</td>
        <td class="owner">'.$result2['responsible'].'</td>
        <td>&nbsp;</td>
        </tr>'; 
	
$count++;	
	}
}
echo'</tbody></table></div>';
}
?>
<script type="text/javascript">
	$(document).ready(function() 
    {    
       
       // alert('ok');
        var service="";
        var hod=""; 	
        //$("#example").tablesorter(); 
        $('#example tr').each(function(){
            service=$(this).children('td:nth-child(11)').text();
            hod=$(this).children('td:nth-child(13)').text();
            if(hod == "Samira" || hod == "Ashan" || hod == "Roshen" || hod == "Venura" || hod == "Nimnaz" ||
                hod == "Roshan" || hod == "Viraj" || hod == "Damith" || hod == "Priyadarshana" || hod == "Aathif" ||
                hod == "Suganthan" || hod == "John" || hod == "Shanaka" || hod == "Interblocks" || hod == "Manjula"
                || hod == "Elite Shree"){
                    $(this).children('td:nth-child(14)').html('Support');
                }
                else if(hod == "Dinusha" || hod == "Wyndel" || hod == "Leojino" ||
                        hod == "Rameez " || hod == "Lahiru" || hod == "Omar" || hod == "Abigail" ||
                        hod == "John Robin" || hod == "Francis" || hod == "Kanchana             " || hod == "Lean" || hod == "Joseph" ||
                        hod == "Rolimer" || hod == "Mark" || hod == "Madushanka" || hod == "MegaLink" ||
                        hod == "John Paolo" || hod == "Dunhill" || hod == "Jake" || hod == "Jessa" ||
                        hod == "Arnie" ){
                            $(this).children('td:nth-child(14)').html('PHL');  
                        }
                else if(hod == "Sanath" || hod == "Hareen" || hod == "Thilini " || hod == "Chintaka" ||
                        hod == "Supun" || hod == "Hashani" || hod == "Isuru" ||
                        hod == "Thulith" || hod == "Thilanchana" || hod == "Geehan" ||
                        hod == "Bhanuka" || hod == "Don" || hod == "Mauran" || hod == "Minura" ||
                        hod == "Meena" || hod == "Sanesh"){
                            $(this).children('td:nth-child(14)').html('PMO');  
                        }
                else if(hod == "Udul"){
                            $(this).children('td:nth-child(14)').html('SDI'); 
                }


            if (service.indexOf("NTB Monitoring") >= 0){
                //alert(service);
                if(service==" NTB Monitoring::iClient"){                    
                    $(this).children('td:nth-child(10)').html('iClient');
                }
                else if(service==" NTB Monitoring::iSwitch"){
                    $(this).children('td:nth-child(10)').html('iSwitch');
                }
                else if(service==" NTB Monitoring::iPay"){
                    $(this).children('td:nth-child(10)').html('iPay');
                }
                else if(service==" NTB Monitoring::iRemit"){
                    $(this).children('td:nth-child(10)').html('iRemit');
                }
                else if(service==" NTB Monitoring::iAdmin"){
                    $(this).children('td:nth-child(10)').html('iAdmin');
                }
                else if(service==" NTB Monitoring::iNet"){
                    $(this).children('td:nth-child(10)').html('iNet');
                }
                else if(service==" NTB Monitoring::Service Request"){
                    $(this).children('td:nth-child(10)').html('Service Request');
                }
                else if(service==" NTB Monitoring::CR Processing"){
                    $(this).children('td:nth-child(10)').html('CR Processing');
                }else{
                    $(this).children('td:nth-child(10)').html('Manage Services');
                }                
            }else{
               $(this).children('td:nth-child(10)').html(service);
            }

    });

    var table=  $('#example').DataTable( {        
           dom: 'Bfrtip',
           
               
       lengthMenu: [
           [ 20, 50, 100, -1 ],
           [ '20 rows', '50 rows', '100 rows', 'Show all' ]
       ],
             
      buttons: [ 'pageLength',
           {
               extend: 'excelHtml5',
               filename: 'Daily_Report',
               title:'Daily Report'					
           }
       ]
      });
      table.page.len( -1 ).draw();
}); 
</script>
<?php
}else{
    header('Location: index.php');
}
?>
