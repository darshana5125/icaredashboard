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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Calculation</title>
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script--> 
<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<link rel="stylesheet" href="\icaredashboard/ums/css/main.css">
<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<!--script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<!--script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.flash.min.js"></script>
<!--script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script-->


<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.html5.min.js"></script>
<!--script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.print.min.js"></script>
<!--script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!--script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<!--script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script-->

<link href="\icaredashboard/libraries/cloudflare/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet" type="text/css" > 
<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" /-->
<link href="\icaredashboard/libraries/datatables/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" >
<!--link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" /-->
<link href="\icaredashboard/libraries/datatables/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" >
<!--link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css" /-->
<link rel="stylesheet" href="css/time_calculation.css" />
<link rel="stylesheet" href="css/fonts.css" />
<!--link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet"/-->

<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script-->
</head>
<body>    
    <div class="container">        
        <!--start of container-->
        <div class="row">
            <div class="col-md-12">
                <form action="time_calculation.php?mid=22" method="POST">
                    <div class="row">
                        <div class="col-md-6 bg-primary top_bar">
                            <div class="offset-2">
                            <label style="display:inline;margin-left:0px;color:#000;">CSR Create Date Range</label><br/>
                            <label style="display:inline;margin-left:0px;color:#000;">From</label><input type="date" id="create_frm_date" 
                            name="create_frm_date" style="margin-left:10px; display:inline;" 
                            value="<?php if (isset($_POST["create_frm_date"]) && !empty($_POST["create_frm_date"])) {
                                echo $create_frm_date = $_POST["create_frm_date"];}else{  echo date('Y-m-d');}?>">
                            <label style="display:inline;margin-left:20px;color:#000;">To</label>
                            <input type="date" id="create_to_date" name="create_to_date" style="margin-left:10px; display:inline;" 
                            value="<?php if (isset($_POST["create_to_date"]) && !empty($_POST["create_to_date"])) {
                            echo $create_to_date = $_POST["create_to_date"];}else{  echo date('Y-m-d');}?>">
                            </div>
                        </div>                
                        <div class="col-md-6 mx-auto bg-warning top_bar"> 
                            <div class="offset-2">
                            <label style="display:inline;margin-left:0px;color:#000;">CSR Close Date Range</label><br/>                   
                            <label style="display:inline;margin-left:0px;color:#000;">From</label><input type="date" id="close_frm_date" 
                            name="close_frm_date" style="margin-left:10px; display:inline;" 
                            value="<?php if (isset($_POST["close_frm_date"]) && !empty($_POST["close_frm_date"])) {
                                echo $close_frm_date = $_POST["close_frm_date"];}else{  echo date('Y-m-d');}?>">
                            <label style="display:inline;margin-left:20px;color:#000;">To</label>
                            <input type="date" id="close_to_date" name="close_to_date" style="margin-left:10px; display:inline;" 
                            value="<?php if (isset($_POST["close_to_date"]) && !empty($_POST["close_to_date"])) {
                                echo $close_to_date = $_POST["close_to_date"];}else{  echo date('Y-m-d');}?>">
                            <input type="submit" id="submit" name="submit" value="GO" class="btn btn-danger submit" 
                            style="margin-left:10px;margin-top:-10px;" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-1">  
                            <div class="row">
                                <div class="col-md-1 offset-2">
                                    <label style="margin-left:0px;color:#000;">Customer</label>
                                </div>
                                <script language="JavaScript">
                                    //function to select all check boxes at once
                                    function togglecustomer(source) {
                                        checkboxes = document.getElementsByName('customer[]');
                                        for(var i=0, n=checkboxes.length;i<n;i++) {
                                            checkboxes[i].checked = source.checked;
                                        }
                                    }

                                    function toggleservice(source) {                                        
                                        checkboxes = document.getElementsByName('service[]');
                                        for(var i=0, n=checkboxes.length;i<n;i++) {
                                            checkboxes[i].checked = source.checked;
                                        }
                                    }
                                </script>
                                <?php
                                $customer_query="select distinct customer_id from issue_view where customer_id!=''
                                and customer_id not like '%@%' and customer_id not like'%PHL%'";
                                $customer_query_run=mysqli_query($connection,$customer_query);
                                ?>
                                <div class="mx-auto customer col-md-6">  
                                    <input type="checkbox" name="customer[]" id="customer[]" onClick="togglecustomer(this)" /> Select All<br/>                                    
                                    <?php
                                        $cx1="";
                                        while($customer_result=mysqli_fetch_array($customer_query_run)){
                                            $cx1=$customer_result['customer_id'];
                                    ?>                                             
                                    <input type="checkbox" name="customer[]" id="customer[]" value="<?php echo $cx1;?>" 
                                         <?php  if(isset($_POST['customer'])){                                                
                                             foreach($_POST['customer'] as $cx){                                             
                                                if(isset($cx1)){ 
                                                      if($cx1==$cx){ 
                                                        echo 'checked';
                                                    }                                                    
                                                  }
                                                }                                                
                                             }
                                             ?>                                      
                                        />                           
                                        <?php echo $customer_result['customer_id'];?><br />
                                    <?php
                                    }
                                    ?>                                    
                                </div>                                
                            </div>                      
                        
                        </div>
                        <div class="col-md-6 mt-1">  
                            <div class="row">
                                <div class="col-md-1 offset-2">
                                    <label style="margin-left:20px;color:#000;">Service</label>
                                </div>
                                <?php
                                $service_query="select distinct id,name as service from service_view where name!=''";
                                $service_query_run=mysqli_query($connection,$service_query);
                                ?>
                                <div class="mx-auto service col-md-6">  
                                    <input type="checkbox" name="service[]" id="service[]" onClick="toggleservice(this)" /> Select All<br/>                                    
                                    <?php
                                        $product_id="";
                                        while($service_result=mysqli_fetch_array($service_query_run)){
                                            $product_id=$service_result['id'];
                                    ?>                                             
                                    <input type="checkbox" name="service[]" id="service[]" value="<?php echo 
                                        $service_result['id'];?>"
                                        <?php  if(isset($_POST['service'])){                                                
                                             foreach($_POST['service'] as $service_id){                                             
                                                if(isset($product_id)){ 
                                                      if($product_id==$service_id){ 
                                                        echo 'checked';
                                                    }
                                                  }
                                                }                                                
                                             }
                                             ?>                              
                                        
                                        /> <?php echo $service_result['service'];?><br />
                                    <?php
                                    }
                                    ?>                                    
                                </div>                                 
                            </div>                      
                        
                        </div>
                    </div>
                </form>
            </div>            
        </div>
        
        <div class="row" style="margin-top:20px;">
                <div class="col-md-6">                                
                    <div class="tile wide resource">
                        <div class="header c_header">
                            <div class="c_priority">Critical Priority</div>
                            <div class="left">
                                <div class="count" id="critical_csr_count">&nbsp;</div>
                                <div class="title">CSR Count</div>
                            </div>
                            <div class="right">
                                <div class="count" id="critical_avg_tot" style="padding:30px 0 10px;">&nbsp;</div>
                                <div class="title" style="padding:0px 0 10px;">Avg Resolution Time</div>
                            </div>
                        </div>
                        <div class="main">
                            <div class="c_hd">Avg HD Time</div>
                            <div class="critical_hd_time" id="critical_hd_time"> &nbsp;</div>
                            <div class="c_tech">Avg Tech Time</div>
                            <div class="critical_tech_time" id="critical_tech_time">&nbsp;</div>
                            <div class="c_cx" >Avg Cx Time</div>
                            <div class="critical_cx_time" id="critical_cx_time">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">                                
                    <div class="tile wide resource">
                        <div class="header h_header">
                            <div class="h_priority">High Priority</div>
                            <div class="left">
                                <div class="count" id="high_csr_count">&nbsp;</div>
                                <div class="title">CSR Count</div>
                            </div>
                            <div class="right">
                                <div class="count" id="high_avg_tot" style="padding:30px 0 10px;">&nbsp;</div>
                                <div class="title" style="padding:0px 0 10px;">Avg Resolution Time</div>
                            </div>
                        </div>
                        <div class="main">
                            <div class="h_hd">Avg HD Time</div>
                            <div class="high_hd_time" id="high_hd_time"> &nbsp;</div>
                            <div class="h_tech">Avg Tech Time</div>
                            <div class="high_tech_time" id="high_tech_time">&nbsp;</div>
                            <div class="h_cx" >Avg Cx Time</div>
                            <div class="high_cx_time" id="high_cx_time">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-6">                                
                    <div class="tile wide resource">
                        <div class="header m_header">
                            <div class="m_priority">Medium Priority</div>
                            <div class="left">
                                <div class="count" id="medium_csr_count">&nbsp;</div>
                                <div class="title">CSR Count</div>
                            </div>
                            <div class="right">
                                <div class="count" id="medium_avg_tot" style="padding:30px 0 10px;">&nbsp;</div>
                                <div class="title" style="padding:0px 0 10px;">Avg Resolution Time</div>
                            </div>
                        </div>
                        <div class="main">
                            <div class="m_hd">Avg HD Time</div>
                            <div class="medium_hd_time" id="medium_hd_time"> &nbsp;</div>
                            <div class="m_tech">Avg Tech Time</div>
                            <div class="medium_tech_time" id="medium_tech_time">&nbsp;</div>
                            <div class="m_cx" >Avg Cx Time</div>
                            <div class="medium_cx_time" id="medium_cx_time">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">                                
                    <div class="tile wide resource">
                        <div class="header l_header">
                            <div class="l_priority">Low Priority</div>
                            <div class="left">
                                <div class="count" id="low_csr_count">&nbsp;</div>
                                <div class="title">CSR Count</div>
                            </div>
                            <div class="right">
                                <div class="count" id="low_avg_tot" style="padding:30px 0 10px;">&nbsp;</div>
                                <div class="title" style="padding:0px 0 10px;">Avg Resolution Time</div>
                            </div>
                        </div>
                        <div class="main">
                            <div class="l_hd">Avg HD Time</div>
                            <div class="low_hd_time" id="low_hd_time"> &nbsp;</div>
                            <div class="l_tech">Avg Tech Time</div>
                            <div class="low_tech_time" id="low_tech_time">&nbsp;</div>
                            <div class="l_cx" >Avg Cx Time</div>
                            <div class="low_cx_time" id="low_cx_time">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
            
    <?php
    $table="";
    if (isset($_POST["create_frm_date"]) && isset($_POST["create_to_date"]) && isset($_POST["close_frm_date"]) && 
    isset($_POST["close_to_date"])){ 
    ?>  

      
    <table style="font-family:arial;font-size:11px;margin: 0 auto;" id="example" class="table table-sm table-bordered" x>
        <thead class="thead-dark"> <tr><th>Number</th><th>CustomerID</th><th>CSR#</th><th>Title</th><th>Created</th><th>Service</th>
        <th class="pri">Priority</th><th>HD Time</th><th>Tech Time</th><th>Cx Time</th></tr></thead><tbody>
    
    <?php 
    //function only supports php7
    /*function secondsToTime($seconds) {
    if($seconds>86400){
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%adays %hhrs %imints');
    }else{
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%hhrs %imints');
    }
}*/

$count=1;
$temp_max_id_query="create TEMPORARY TABLE IF NOT EXISTS temp_max_id as (select th.id as maxid,change_time,ticket_id,
                    state_id from issuehis_view th
                    where th.id in(select max(id) from issuehis_view
                    where change_time between '".$create_frm_date."' and '".$create_to_date."'
                    and history_type_id=27
                    group by ticket_id)
                    and th.state_id not in(17,24,25,7)
                    and th.history_type_id=27)";
$temp_max_id_query_run=mysqli_query($connection,$temp_max_id_query);

$temp_max_id2_query="create TEMPORARY TABLE IF NOT EXISTS temp_max_id2 as (select th.id ,change_time,ticket_id,state_id 
                    from issuehis_view th
                    where th.state_id in(17,24,25,7)
                    and th.history_type_id=27
                    and th.change_time between '".$close_frm_date."' and '".$close_to_date."'
                    group by th.ticket_id)";
$temp_max_id2_query_run=mysqli_query($connection,$temp_max_id2_query);

$temp_max_id3_query="create TEMPORARY TABLE IF NOT EXISTS temp_max_id3 as(select yy.ticket_id from temp_max_id2 xx
                    inner join temp_max_id yy on
                    xx.ticket_id=yy.ticket_id)";
$temp_max_id3_query_run=mysqli_query($connection,$temp_max_id3_query);

$ticket_no_list_query="";

if(isset($_POST['customer']) && isset($_POST['service'])){
    $cx_list='';
    $customers = $_POST['customer'];
    foreach ($customers as $customer){
        if($customer!='on'){ 
            $cx_list.= "'".$customer."',";
        }
    }
    $cx_list=rtrim($cx_list,",");
    $service_list='';
    $services = $_POST['service'];
    foreach ($services as $service){
        if($service!='on'){ 
            $service_list.= $service.",";
        }
    }
    $service_list=rtrim($service_list,",");

    $ticket_no_list_query="select xxx.ticket_id,t.customer_id,t.tn,t.title,t.create_time,t.service_id,
                        tp.name as priority,s.name as service from temp_max_id3 xxx
                        inner join issue_view t on
                        xxx.ticket_id=t.id
                        inner join issuelevel_view tp on
                        t.ticket_priority_id=tp.id
                        inner join service_view s on
                        t.service_id=s.id
                        where t.customer_id in (".$cx_list.") and t.service_id in (".$service_list.") and 
                        t.customer_id not like'%PHL%' and t.create_time between '".$create_frm_date."' and '".$create_to_date."'";
}else if(isset($_POST['customer'])){
    $cx_list='';
    $customers = $_POST['customer'];
    foreach ($customers as $customer){
        if($customer!='on'){ 
            $cx_list.= "'".$customer."',";
        }
    }
    $cx_list=rtrim($cx_list,",");
    
    $ticket_no_list_query="select xxx.ticket_id,t.customer_id,t.tn,t.title,t.create_time,t.service_id,
                        tp.name as priority,s.name as service from temp_max_id3 xxx
                        inner join issue_view t on
                        xxx.ticket_id=t.id
                        inner join issuelevel_view tp on
                        t.ticket_priority_id=tp.id
                        inner join service_view s on
                        t.service_id=s.id
                        where t.customer_id in (".$cx_list.") and
                        t.customer_id not like'%PHL%' and t.create_time between '".$create_frm_date."' and '".$create_to_date."'";

}else if(isset($_POST['service'])){
    $service_list='';
    $services = $_POST['service'];
    foreach ($services as $service){
        if($service!='on'){ 
            $service_list.= $service.",";
        }
    }
    $service_list=rtrim($service_list,",");

    $ticket_no_list_query="select xxx.ticket_id,t.customer_id,t.tn,t.title,t.create_time,t.service_id,
                        tp.name as priority,s.name as service from temp_max_id3 xxx
                        inner join issue_view t on
                        xxx.ticket_id=t.id
                        inner join issuelevel_view tp on
                        t.ticket_priority_id=tp.id
                        inner join service_view s on
                        t.service_id=s.id
                        where t.service_id in (".$service_list.") and 
                        t.customer_id not like'%PHL%' and t.create_time between '".$create_frm_date."' and '".$create_to_date."'";    
}else{        
$ticket_no_list_query="select xxx.ticket_id,t.customer_id,t.tn,t.title,t.create_time,t.service_id,
                        tp.name as priority,s.name as service from temp_max_id3 xxx
                        inner join issue_view t on
                        xxx.ticket_id=t.id
                        inner join issuelevel_view tp on
                        t.ticket_priority_id=tp.id
                        inner join service_view s on
                        t.service_id=s.id
                        where t.customer_id not like'%PHL%' and t.create_time between '".$create_frm_date."' and '".$create_to_date."'";
}
//echo $ticket_no_list_query;
$ticket_no_list_query_run=mysqli_query($connection,$ticket_no_list_query);

//start of finding the ticket age of a given ticket

//$working_time_in_seconds = strtotime('2019-10-24 12:48:29') - strtotime('2019-10-24 11:48:29');
//echo gmdate('H:i:s', $working_time_in_seconds);
$ticket_create_time=0;
$first_responsible_change_time=0;
//start of ticket list

while($ticket_no_list_query_result=mysqli_fetch_array($ticket_no_list_query_run)){
    $hd_time_in_seconds=0;
    $tech_time_in_seconds=0;
    $cx_time_in_seconds=0;
    $ticket_id=$ticket_no_list_query_result['ticket_id'];
$query="select * from issue_view where id=".$ticket_id;
$query_run=mysqli_query($connection,$query);
while($result=mysqli_fetch_array($query_run)){
//getting ticket create time
$ticket_create_time= $result['create_time'];
//echo $ticket_create_time.'<br>';
}


$query2="select change_time,substring_index(name,'%',-1) as res_id,state_id from issuehis_view where id in(
    select min(id) from issuehis_view where
    history_type_id in (34) and ticket_id=".$ticket_id.")";
    $query2_run=mysqli_query($connection,$query2);
    while($result2=mysqli_fetch_array($query2_run)){
        $responsible_id=$result2['res_id'];
        $state_id=$result2['state_id'];
        if($responsible_id==104 || $responsible_id==7 || $responsible_id==70 || $responsible_id==239 || $responsible_id==238 || $responsible_id==191 
        ||$responsible_id==160 ||$responsible_id==217 ||$responsible_id==201 || $responsible_id==176 || $responsible_id==348){
            //if($state_id==14){
                $first_responsible_change_time= $result2['change_time'];
                //echo '1st responsible change'.$first_responsible_change_time.'<br>';  
            //}
        }else{
            //if($state_id!=14){
                $first_responsible_change_time= $result2['change_time'];
                //echo '1st responsible change'.$first_responsible_change_time.'<br>';  
           // }
        }
    //getting first responsible change time apart from HD person
    //$first_responsible_change_time= $result2['change_time'];
    //echo '1st responsible change'.$first_responsible_change_time.'<br>';
    }
    //helpdesk time to assign the ticket to it's first responsible(non HD person)
    if(strtotime($first_responsible_change_time)>0){
    $hd_time_in_seconds+=strtotime($first_responsible_change_time) - strtotime($ticket_create_time);
    //echo $hd_time_in_seconds.'<br>';
    //echo gmdate('H:i:s', $hd_time_in_seconds);
    }
    
    //to get the all records of responsible change and state change upto first closing state(exp,fix given etc..)
    $query3="select id,substring_index(name,'%',-1) as res_id,change_time,state_id,history_type_id,change_by from issuehis_view where id <=(
            select min(id) from issuehis_view
            where state_id in(17,24,25,7)
            and ticket_id=".$ticket_id. "
            order by change_time asc)
            and history_type_id in(27,34) and
            ticket_id=".$ticket_id."
            order by id asc";
    $query3_run=mysqli_query($connection,$query3);
    $hd_assign_time=0;
    $hd_unassign_time=0;
    $tech_assign_time=0;
    $tech_unassign_time=0;
    $cx_assign_time=0;
    $cx_unassign_time=0;
    $change_by=0;
    $hd_assign_flag=0;
    $tech_assign_flag=0;
    $cx_assign_flag=0;
    $id=0;
    $info_recvd_flag=0;
    $info_req_flag=0;
    $hd_1st=1;
    $change_time="";
/*new line*/ $reponsible_to_tech_flag=0;
/*new line*/ $reponsible_to_hd_flag=0;

    while($result3=mysqli_fetch_array($query3_run)){
        $responsible_id=$result3['res_id'];    
        $state_id=$result3['state_id']; 
        $history_type_id=$result3['history_type_id']; 
        $change_by=$result3['change_by']; 
        $id=$result3['id']; 
        $state_id2="";
        if($history_type_id==34){        
            //HD responsible person
            if($responsible_id==104 || $responsible_id==7 || $responsible_id==70 || $responsible_id==239 || $responsible_id==238 || $responsible_id==191 
            ||$responsible_id==160 ||$responsible_id==217 ||$responsible_id==201 || $responsible_id==176 || $responsible_id==348){ 
                //this is when 1st responsible update been to HD person. To avoid double calculation. In above we calculate the time from ticket
                //create time to ticket 1st assign time to a non HD person. Here also it will again calculate from 1st HD assign person to next non HD
                //responsible update if we dont use this $hd_1st flag.
                $hd_assign_flag=1;
                $hd_assign_time=$result3['change_time'];
                //echo 'HD assign time 55555'.$hd_assign_time.'<br>';
                if($hd_1st!=1){
                    $id=$id+1;
                    //echo $id.'<br>';
                    $query4="select state_id from issuehis_view where id=".$id." and history_type_id=27"; 
                    $query4_run=mysqli_query($connection,$query4);            
                    while($result4=mysqli_fetch_array($query4_run)){
                        $state_id2=$result4['state_id'];
                    }
                    //Reponsible upto HD without an state update
                    /* new line*/if( $hd_assign_flag!=1){ 
                    $hd_assign_flag=1;
                    $hd_assign_time=$result3['change_time'];
                    //echo 'HD assign time 2222 '.$hd_assign_time.'<br>'; 
                     /* new line*/}
    
                    
                    if($tech_assign_flag==1){
                        $tech_unassign_time=$result3['change_time'];
                        //echo 'Tech unassign time 1 '.$tech_unassign_time.'<br>';               
                        //echo 'Tech assign time '.$tech_assign_time.'<br>';                
                        $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                        //echo 'Tech time '.$tech_time_in_seconds.'<br>';
                        $tech_assign_flag=0;
                        //echo gmdate('H:i:s', $hd_time_in_seconds).'<br>';                  
                    } 
    
                    if(!($state_id2=="" || $state_id2==14 || $state_id2==13 || $state_id2==30)){
                    //mark in when assign to HD
                        $hd_assign_flag=1;          
                        $hd_assign_time=$result3['change_time'];
                        //echo 'HD assign time 3333 '.$hd_assign_time.'<br>';                 
                        if($tech_assign_flag==1){
                            $tech_unassign_time=$result3['change_time'];
                            //echo 'Tech unassign time '.$tech_unassign_time.'<br>';
                            //echo 'Tech assign time '.$tech_assign_time.'<br>';                    
                            $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                            //echo'Tech time '. $tech_time_in_seconds.'<br>';
                            $tech_assign_flag=0;
                        } 
                        if($cx_assign_flag==1){
                            $cx_unassign_time=$result3['change_time'];
                            //echo 'cx unassign time '.$cx_unassign_time.'<br>';
                            //echo 'cx assign time '.$cx_assign_time.'<br>';                    
                            $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
                            //echo'cx time '. $cx_time_in_seconds.'<br>';
                            $cx_assign_flag=0;
                        } 
                    } 
                    if($state_id2==14 || $state_id2==13 || $state_id2==30){
                        //echo $info_req_flag.'xxx';
                        //mark in when assign to Cx
                        $cx_assign_flag=1; 
                        if($info_req_flag==0){
                            //echo 'yyy';         
                            $cx_assign_time=$result3['change_time'];
                            //echo 'Cx assign time '.$cx_assign_time.'<br>'; 
                            $info_req_flag=1;                    
                        }                
                        if($hd_assign_flag==1){
                            $hd_unassign_time=$result3['change_time'];
                            //echo 'HD unassign time 111 '.$hd_unassign_time.'<br>';
                            //echo 'HD assign time 6666'.$hd_assign_time.'<br>';                    
                            $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
                            //echo 'HD time '.$hd_time_in_seconds.'<br>';
                            $hd_assign_flag=0;
                        }                 
                        if($tech_assign_flag==1){
                            $tech_unassign_time=$result3['change_time'];
                            //echo 'Tech unassign time '.$hd_unassign_time.'<br>';
                            //echo 'Tech assign time '.$tech_assign_time.'<br>';                    
                            //$tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                            //echo 'Tech time '.$tech_time_in_seconds.'<br>';
                            $tech_assign_flag=0;
                        } 
                    }                
                }
                //$hd_1st=0;                    
            }else{
                /*new line*/ $reponsible_to_tech_flag=1;
                $hd_1st=0;
                $id=$id+1;
                //echo $id.'<br>';
                $query4="select state_id from issuehis_view where id=".$id." and history_type_id=27"; 
                $query4_run=mysqli_query($connection,$query4);            
                while($result4=mysqli_fetch_array($query4_run)){
                    $state_id2=$result4['state_id'];
                } 
                //echo 'state'.$state_id2;
                //mark when assign to tech team(other than HD persons)
                    if($tech_assign_flag==0){
                    $tech_assign_flag=1;
                    $tech_assign_time=$result3['change_time'];
                    //echo 'Tech assign time 11111'.$tech_assign_time.'<br>'; 
                    }
                
                
                if($hd_assign_flag==1){  
                    $hd_unassign_time=$result3['change_time'];                
                    //echo 'HD assign time 77777'.$hd_assign_time.'<br>';
                    //echo 'HD unassign time '.$hd_unassign_time.'<br>';              
                    $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
                    //echo 'HD time '.$hd_time_in_seconds.'<br>';
                    $hd_assign_flag=0;
                    //echo gmdate('H:i:s', $hd_time_in_seconds).'<br>';                  
                }
                
                 /*new*/ if($cx_assign_flag==1){  
                    $cx_unassign_time=$result3['change_time'];                
                    //echo 'Cx assign time 77777'.$cx_assign_time.'<br>';
                    //echo 'cx unassign time '.$cx_unassign_time.'<br>';              
                    $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
                    //echo 'cx time '.$cx_time_in_seconds.'<br>';
                    $cx_assign_flag=0;                                 
                } /*new*/
                //echo  $state_id2.'xxx';     
                if($state_id2==14 || $state_id2==13 || $state_id2==30){ 
                                          
                    if($tech_assign_flag==1){                    
                        $tech_unassign_time=$result3['change_time'];
                        //echo 'Tech unassign time 2222'.$tech_unassign_time.'<br>';
                        //echo 'Tech assign time '.$tech_assign_time.'<br>';                   
                        $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time); 
                        //echo 'Tech time '. $tech_time_in_seconds.'<br>';
                        $tech_assign_flag=0;
                    }  
                    $Cx_assign_flag=1;
                    if($info_req_flag==0){                                         
                        $cx_assign_time=$result3['change_time'];
                        //echo 'Cx assign time '.$cx_assign_time.'<br>'; 
                        $info_req_flag=1;
                    }              
                } 
                if(!($state_id2=="" || $state_id2==14 || $state_id2==13 || $state_id2==30)){
                    $tech_assign_flag=1;          
                    $tech_assign_time=$result3['change_time'];
                    //echo 'Tech assign time 22222'.$tech_assign_time.'<br>';  
                }                   
            }
            
        }        
        if($history_type_id==27 && $change_by==1 && $state_id==4){
            if($cx_assign_flag==1){ 
                //echo 'hhh';  
                'Cx unassign time '.$cx_unassign_time=$result3['change_time'];
                //echo 'Cx assign time '.$cx_assign_time.'<br>';
                //echo 'Cx unassign time '.$cx_unassign_time.'<br>';
                $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time); 
                //echo 'Cx time '.$cx_time_in_seconds.'<br>';
                $cx_assign_flag=0;
                $info_recvd_flag=1;
                $info_req_flag=0;
            }
    
            /*edit line*/ if($hd_assign_flag==0 && $reponsible_to_tech_flag!=1){
                $hd_assign_flag=1;
                $hd_assign_time=$result3['change_time'];
                //echo 'HD assign time 11111'.$hd_assign_time.'<br>';            
            }
            /*edit line*/ if($tech_assign_flag==0 && $reponsible_to_tech_flag==1){
                $tech_assign_flag=1;
                $tech_assign_time=$result3['change_time'];
                //echo 'Tech assign time 3333 '.$tech_assign_time.'<br>';
            }
                             
        } 
        if(($state_id==14 || $state_id==13 || $state_id==30) && $history_type_id==27){
            $cx_assign_flag=1;
                   
            if($info_req_flag==0){
                $cx_assign_time=$result3['change_time'];
                //echo 'cx assign timebb '.$cx_assign_time.'<br>';
                $info_req_flag=1;
                //$hd_assign_flag=0;
                //$tech_assign_flag=0;
            }
            if($hd_assign_flag==1){
                $hd_unassign_time=$result3['change_time'];
                //echo 'hd unassign //time '.$hd_unassign_time.'<br>';
                //echo 'hd assign //time '.$hd_assign_time.'<br>';
                //echo strtotime($hd_assign_time).'<br>';
                //echo strtotime($hd_unassign_time).'<br>';
                $hd_time_in_seconds+= strtotime($hd_unassign_time)- strtotime($hd_assign_time);
                //echo $hd_time_in_seconds.'<br>';
                $hd_assign_flag=0;
            }
            if($tech_assign_flag==1){
                $tech_unassign_time=$result3['change_time'];
                //echo 'tech unassign time '.$tech_unassign_time.'<br>';
                //echo 'tech assign time '.$tech_assign_time.'<br>';
                $tech_time_in_seconds+= strtotime($tech_unassign_time)-strtotime($tech_assign_time);
                //echo $tech_time_in_seconds.'<br>';
                $tech_assign_flag=0;
            }
        }
        
        if(($state_id==17 || $state_id==24 || $state_id==25 || $state_id==7) && $history_type_id==27){
            if($tech_assign_flag==1){
                $tech_unassign_time=$result3['change_time'];
                //echo 'Tech unassign time '.$tech_unassign_time.'<br>';
                //echo 'Tech assign time '.$tech_assign_time.'<br>';                    
                $tech_time_in_seconds+=strtotime($tech_unassign_time) - strtotime($tech_assign_time);
                //echo 'Tech time '.$tech_time_in_seconds.'<br>';
                $tech_assign_flag=0;
            }
            if($hd_assign_flag==1){
                $hd_unassign_time=$result3['change_time'];
                //echo 'HD unassign time '.$hd_unassign_time.'<br>';
                //echo 'HD assign time 888'.$hd_assign_time.'<br>';                    
                $hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
                //echo 'HD time '.$hd_time_in_seconds.'<br>';
                $hd_assign_flag=0;
            }
            if($cx_assign_flag==1){
                //echo 'ooo';
                $cx_unassign_time=$result3['change_time'];
                //echo 'Cx unassign time '.$cx_unassign_time.'<br>'; 
                //echo 'Cx assign time '.$cx_assign_time.'<br>';                   
                $cx_time_in_seconds+=strtotime($cx_unassign_time) - strtotime($cx_assign_time);
                //echo 'Cx time '.$cx_time_in_seconds.'<br>';
                $cx_assign_flag=0;
            }
        }
            
        //$hd_time_in_seconds+=strtotime($hd_unassign_time) - strtotime($hd_assign_time);
        //echo $hd_time_in_seconds.'<br>';
    }
    // end of finding the ticket age of a given ticket
    ?>
    
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $ticket_no_list_query_result['customer_id']?></td>
            <td><a href='https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $ticket_no_list_query_result['ticket_id'];?>' target='_blank'><?php echo $ticket_no_list_query_result['tn'];?></a></td>
            <td><?php echo substr($ticket_no_list_query_result['title'],0,100);?></td>
            <td><?php echo date('Y:m:d', strtotime($ticket_no_list_query_result['create_time']));?></td>
            <td><?php echo $ticket_no_list_query_result['service'];?></td>
            <td><?php echo $ticket_no_list_query_result['priority']?></td>
            <td style="text-align:center"><input type='hidden' value='<?php echo $hd_time_in_seconds;?>'>&nbsp;</td>
            <td style="text-align:center"><input type='hidden' value='<?php echo $tech_time_in_seconds;?>'>&nbsp;</td>
            <td style="text-align:center"><input type='hidden' value='<?php echo $cx_time_in_seconds;?>'>&nbsp;</td>
            
        </tr>  
    
<?php
$count++;
}
//end of ticket list
//}
?>
            </tbody>
        </table>

    <!--end of continer class-->
    </div>
    </body>
    
</html>


<script type="text/javascript">
	$(document).ready(function(){   
    var table=  $('#example').DataTable( {        
           dom: 'Bfrtip',   
           lengthMenu: [
           [ 20, 50, 100, -1 ],
           [ '20 rows', '50 rows', '100 rows', 'Show all' ]
       ],             
      buttons: [ 'pageLength',
           {
               extend: 'excelHtml5',
               filename: 'Time_Calculation',
               title:'Time Calculation'					
           }
       ]
      });
      var tot_critical_hd_time=0;
      var tot_high_hd_time=0;
      var tot_medium_hd_time=0;
      var tot_low_hd_time=0;
      var tot_critical_tech_time=0;
      var tot_high_tech_time=0;
      var tot_medium_tech_time=0;
      var tot_low_tech_time=0;
      var tot_critical_cx_time=0;
      var tot_high_cx_time=0;
      var tot_medium_cx_time=0;
      var tot_low_cx_time=0;
      var priority="";
      var critical_count=0;
      var high_count=0;
      var medium_count=0;
      var low_count=0;
      var hd_critical_avg=0;
      var hd_high_avg=0;
      var hd_medium_avg=0;
      var hd_low_avg=0;
      var tech_critical_avg=0;
      var tech_high_avg=0;
      var tech_medium_avg=0;
      var tech_low_avg=0;
      var cx_critical_avg=0;
      var cx_high_avg=0;
      var cx_medium_avg=0;
      var cx_low_avg=0;
      var critical_tot_csr_time=0;
      var high_tot_csr_time=0;
      var medium_tot_csr_time=0;
      var low_tot_csr_time=0;
      var critical_avg_csr_time=0;
      var high_avg_csr_time=0;
      var medium_avg_csr_time=0;
      var low_avg_csr_time=0;

      //sets to intial row count
      table.page.len( -1 ).draw();

      function secondsToHms(d) {
        d = Number(d);

        if(d<60){
        //var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : ""; 
        return '-'; 
        }
        var days = Math.floor(d / 86400);
        var h = Math.floor(d % 86400 / 3600);
        var m = Math.floor(d % 86400 % 3600 / 60);
        var s = Math.floor(d % 86400 % 3600 % 60);

        var dDisplay = days > 0 ? days + (days == 1 ? " day " : " days ") : "";
        var hDisplay = h > 0 ? h + (h == 1 ? " hr " : " hrs ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " mint " : " mints ") : "";
        //var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
        
        return dDisplay + hDisplay + mDisplay; 
    } 
        var hdsec=0;
        var techsec=0;
        var cxsec=0;
      $('#example tr').each(function(){        
        priority=$(this).children('td:nth-child(7)').text();
        //alert(priority.substring(1));
        if(priority.indexOf('Critical')!=-1){ 
            critical_count++;          
            tot_critical_hd_time+=parseInt($(this).find("td:eq(7) input[type='hidden']").val());
            tot_critical_tech_time+=parseInt($(this).find("td:eq(8) input[type='hidden']").val());
            tot_critical_cx_time+=parseInt($(this).find("td:eq(9) input[type='hidden']").val());             
        }
        if(priority.indexOf('High')!=-1){ 
            high_count++;           
            tot_high_hd_time+=parseInt($(this).find("td:eq(7) input[type='hidden']").val()); 
            tot_high_tech_time+=parseInt($(this).find("td:eq(8) input[type='hidden']").val());
            tot_high_cx_time+=parseInt($(this).find("td:eq(9) input[type='hidden']").val());             
        } 
        if(priority.indexOf('Medium')!=-1){
            medium_count++;            
            tot_medium_hd_time+=parseInt($(this).find("td:eq(7) input[type='hidden']").val()); 
            tot_medium_tech_time+=parseInt($(this).find("td:eq(8) input[type='hidden']").val());
            tot_medium_cx_time+=parseInt($(this).find("td:eq(9) input[type='hidden']").val());             
        }
        if(priority.indexOf('Low')!=-1){ 
            low_count++;           
            tot_low_hd_time+=parseInt($(this).find("td:eq(7) input[type='hidden']").val());
            tot_low_tech_time+=parseInt($(this).find("td:eq(8) input[type='hidden']").val());
            tot_low_cx_time+=parseInt($(this).find("td:eq(9) input[type='hidden']").val());              
        }
        hdsec=$(this).find("td:eq(7) input[type='hidden']").val();
        techsec=$(this).find("td:eq(8) input[type='hidden']").val();
        cxsec=$(this).find("td:eq(9) input[type='hidden']").val();
        $(this).children('td:eq(7)').text(secondsToHms(hdsec));
        $(this).children('td:eq(8)').text(secondsToHms(techsec));
        $(this).children('td:eq(9)').text(secondsToHms(cxsec));

      });
      hd_critical_avg=parseInt(tot_critical_hd_time)/parseInt(critical_count);
      hd_high_avg=parseInt(tot_high_hd_time)/parseInt(high_count);
      hd_medium_avg=parseInt(tot_medium_hd_time)/parseInt(medium_count);
      hd_low_avg=parseInt(tot_low_hd_time)/parseInt(low_count);
      tech_critical_avg=parseInt(tot_critical_tech_time)/parseInt(critical_count);
      tech_high_avg=parseInt(tot_high_tech_time)/parseInt(high_count);
      tech_medium_avg=parseInt(tot_medium_tech_time)/parseInt(medium_count);
      tech_low_avg=parseInt(tot_low_tech_time)/parseInt(low_count);
      cx_critical_avg=parseInt(tot_critical_cx_time)/parseInt(critical_count);
      cx_high_avg=parseInt(tot_high_cx_time)/parseInt(high_count);
      cx_medium_avg=parseInt(tot_medium_cx_time)/parseInt(medium_count);
      cx_low_avg=parseInt(tot_low_cx_time)/parseInt(low_count);

      critical_tot_csr_time=parseInt(tot_critical_hd_time)+parseInt(tot_critical_tech_time)+parseInt(tot_critical_cx_time);
      high_tot_csr_time=parseInt(tot_high_hd_time)+parseInt(tot_high_tech_time)+parseInt(tot_high_cx_time);
      medium_tot_csr_time=parseInt(tot_medium_hd_time)+parseInt(tot_medium_tech_time)+parseInt(tot_medium_cx_time);
      low_tot_csr_time=parseInt(tot_low_hd_time)+parseInt(tot_low_tech_time)+parseInt(tot_low_cx_time);

      critical_avg_csr_time=parseInt(critical_tot_csr_time)/parseInt(critical_count);
      high_avg_csr_time=parseInt(high_tot_csr_time)/parseInt(high_count);
      medium_avg_csr_time=parseInt(medium_tot_csr_time)/parseInt(medium_count);
      low_avg_csr_time=parseInt(low_tot_csr_time)/parseInt(low_count); 

     
    //alert(secondsToHms(90080)); 
    //document.getElementById('xxx').value=secondsToHms(90080);
    $('div #critical_avg_tot').text(secondsToHms(critical_avg_csr_time)); 
    $('div #critical_hd_time').text(secondsToHms(hd_critical_avg)); 
    $('div #critical_tech_time').text(secondsToHms(tech_critical_avg));
    $('div #critical_cx_time').text(secondsToHms(cx_critical_avg));
    $('div #critical_csr_count').text(critical_count);

    $('div #high_avg_tot').text(secondsToHms(high_avg_csr_time)); 
    $('div #high_hd_time').text(secondsToHms(hd_high_avg)); 
    $('div #high_tech_time').text(secondsToHms(tech_high_avg));
    $('div #high_cx_time').text(secondsToHms(cx_high_avg));
    $('div #high_csr_count').text(high_count);

    $('div #medium_avg_tot').text(secondsToHms(medium_avg_csr_time)); 
    $('div #medium_hd_time').text(secondsToHms(hd_medium_avg)); 
    $('div #medium_tech_time').text(secondsToHms(tech_medium_avg));
    $('div #medium_cx_time').text(secondsToHms(cx_medium_avg));
    $('div #medium_csr_count').text(medium_count);

    $('div #low_avg_tot').text(secondsToHms(low_avg_csr_time)); 
    $('div #low_hd_time').text(secondsToHms(hd_low_avg)); 
    $('div #low_tech_time').text(secondsToHms(tech_low_avg));
    $('div #low_cx_time').text(secondsToHms(cx_low_avg));
    $('div #low_csr_count').text(low_count);        

}); 

</script>
<?php
    }    
}else{
	header('Location: index.php');
}
?>