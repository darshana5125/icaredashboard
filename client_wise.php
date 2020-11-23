<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php');?>
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
	
<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="\icaredashboard/libraries/cloudflare/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/client_wise.css">
  <link rel="stylesheet" href="\icaredashboard\ums/css/main.css">

   <script src="\icaredashboard/js/jquery.aCollapTable.js"></script>
	

  	<meta charset="UTF-8">
	<title>Client Wise</title>
	<script type="text/javascript">
	$(function(){
    //Listen for a click on any of the dropdown items
    $(".thenumbers li").click(function(){
        //Get the value
        var value = $(this).attr("value");
        //Put the retrieved value into the hidden input
        $("input[name='result']").val(value);
        $("#myButton").text(value);
    });
});

	var names_arr = ['Dulan','Don','Ashan','Hareen','Nimnaz','Chintaka','Praveen','Duminda','Meena','Bhanuka','Sanesh','Geehan'];
	var names_arr2 = ['Samira','Interblocks','Sanjaya','Suganthan','Priyadarshana','John','Prabhath','Shanaka','Aathif','Damith','Roshan','Viraj'];
	var pro_click=0;
	var sup_click=0;
	var table3=0;
	var table4=0;
	var table5=0;	
	var table6=0;

	  $.fn.myFunction = function(){ 
	  	if(pro_click==1){
         	names_arr.length=0;
            var all_pro_names= $("#project").val();
       		var arr = all_pro_names.split(',');
       		//alert(arr.length);
       		for(var i=0;i<arr.length;i++){
       		names_arr.push(arr[i]);
       		} 
       	}

       	if(sup_click==1){
         	names_arr2.length=0;
            var all_sup_names= $("#support").val();
       		var arr2 = all_sup_names.split(',');
       		//alert(arr2.length);
       		for(var i=0;i<arr2.length;i++){
       		names_arr2.push(arr2[i]);
       		} 
       	}

			var responsible="";
			var ass="";
			var sup=0;
			var pro=0;
			var sup_inf=0;
			var pro_inf=0;
			var pro_names="";


		$('#table2 tr').each(function() {	
	    responsible = $(this).find(".res").html(); 
		ass= $(this).find(".state").html();
		if (ass=="Assigned"){
		for(var i=0; i<names_arr2.length; i++){
	 		 	var name2 = names_arr2[i];
	 		 	if(name2==responsible){  
      			sup+=parseInt($(this).children('td:nth-child(3)').text());    
                $(this).hide();
  				}
		} 
	 		for(var i=0; i<names_arr.length; i++){
	 		 	var name = names_arr[i];
	 		 	if(name==responsible){
      			pro+=parseInt($(this).children('td:nth-child(3)').text());        
      			$(this).hide();	  
	 			} 
	
			}
		}	
	else if (ass=="Info pending from bank "){

			for(var i=0; i<names_arr2.length; i++){
	 		 	var name2 = names_arr2[i];
	 		 	if(name2==responsible){  
      			sup_inf+=parseInt($(this).children('td:nth-child(3)').text()); 

                $(this).hide();
  				}
			} 
	 		for(var i=0; i<names_arr.length; i++){
	 		 	var name = names_arr[i];
	 		 	if(name==responsible){
      			pro_inf+=parseInt($(this).children('td:nth-child(3)').text());        
      			$(this).hide();	  
	 			} 
	
			}	 		
	}
	});


	 $('#table2 tr:last').after('<tr class="group"><td rowspan="3" class="tb2-assign">Assigned</td></tr><tr class="group"><td style="background-color:#c9d7e8;">Support</td><td style="background-color:#c9d7e8;">'+sup+'</td></tr>');
	 $('#table2 tr:last').after('<tr class="group"><td style="background-color:#b5fcb5;">Project</td><td style="background-color:#b5fcb5;">'+pro+'</td></tr>');
	 
	 
	 $('#table2 tr:last').after('<tr class="group"><td rowspan="3" class="tb2-info">Info Pending</td></tr><tr class="group"><td style="background-color:#c9d7e8;">Support</td><td style="background-color:#c9d7e8;">'+sup_inf+'</td></tr>');
	 $('#table2 tr:last').after('<tr class="group"><td style="background-color:#b5fcb5;">Project</td><td style="background-color:#b5fcb5;">'+pro_inf+'</td></tr>');
    }


    $.fn.myFunction2 = function(){ 
		$('#table3 tr td.responsible').each(function() {
			var res=$(this).text();
			$(this).parents("tr").hide();  
			for(var i=0; i<names_arr2.length; i++){
	 		 	var name3 = names_arr2[i];
	 		 	if(res==name3 ){
				$(this).parents("tr").show();    	
				}	 		 	 
	 		 }			
		});
	}

	 $.fn.myFunction3 = function(){ 
		$('#table5 tr td.responsible').each(function() {
			var res=$(this).text();
			$(this).parents("tr").hide();  
			for(var i=0; i<names_arr.length; i++){
	 		 	var name3 = names_arr[i];
	 		 	if(res==name3 ){
				$(this).parents("tr").show();    	
				}	 		 	 
	 		 }			
		});
	}

	 $.fn.myFunction4 = function(){ 
		$('#table6 tr td.responsible').each(function() {
			var res=$(this).text();
			$(this).parents("tr").hide();  
			for(var i=0; i<names_arr.length; i++){
	 		 	var name3 = names_arr[i];
	 		 	if(res==name3 ){
				$(this).parents("tr").show();    	
				}	 		 	 
	 		 }			
		});
	}
	
	$(document).ready(function(){
		$("#project").val(names_arr);
		$("#support").val(names_arr2);
			$.fn.myFunction();
		 $("#btn-pro").click(function () {
		 	pro_click=1;
		 		$('#table2 tr.group').each(function() {
		 			$(this).remove();
		 		});	 	
	 	   $.fn.myFunction();
	 	   $.fn.myFunction3();
	 	   $.fn.myFunction4();
		}); 

		$("#btn-sup").click(function () {
		 	sup_click=1;
		 		$('#table2 tr.group').each(function() {
		 			$(this).remove();
		 		});	 	
	 	   $.fn.myFunction();
	 	   $.fn.myFunction2();

		});

		$('#table3 tr td.state').each(function() {
			$(this).hide();		
		});
		

		$.fn.myFunction2();
		$.fn.myFunction3();
		$.fn.myFunction4();

		$('#table3 tr td.responsible').each(function() {
			$(this).hide();		
		});

		$('#table4 tr td.responsible').each(function() {
			$(this).hide();		
		});

		$('#table4 tr td.state').each(function() {
			$(this).hide();		
		});

		$('#table5 tr td.responsible').each(function() {
			$(this).hide();		
		});

		$('#table6 tr td.responsible').each(function() {
			$(this).hide();		
		});

		

		$("#table3").dblclick(function () {
			if(table3==0){
			$('#table3 tr td.responsible').each(function() {
			$(this).show();	
			table3=1;	
		});
			
		}else{
			$('#table3 tr td.responsible').each(function() {
			$(this).hide();	
			table3=0;	
		});
		}
		});

		$("#table4").dblclick(function () {
			if(table4==0){
			$('#table4 tr td.responsible').each(function() {
			$(this).show();	
			table4=1;	
		});
			
		}else{
			$('#table4 tr td.responsible').each(function() {
			$(this).hide();	
			table4=0;	
		});
		}
		});

		$("#table5").dblclick(function () {
			if(table5==0){
			$('#table5 tr td.responsible').each(function() {
			$(this).show();	
			table5=1;	
		});
			
		}else{
			$('#table5 tr td.responsible').each(function() {
			$(this).hide();	
			table5=0;	
		});
		}
		});

		$("#table6").dblclick(function () {
			if(table6==0){
			$('#table6 tr td.responsible').each(function() {
			$(this).show();	
			table6=1;	
		});
			
		}else{
			$('#table6 tr td.responsible').each(function() {
			$(this).hide();	
			table6=0;	
		});
		}
		});



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


	});
</script>
</head>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<body>
	<div class="container">
		<form method="post" action="client_wise.php?mid=19">
			<div class="dropdown">
		    <button type="button" id="myButton" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		      Select Customer
		    </button>
		    <ul class="dropdown-menu thenumbers">
		    <?php
				$cx_query="select distinct(cx_id) from view_temp2 order by cx_id asc";
				$cx_query_run=mysqli_query($connection,$cx_query);
				while($cx_result=mysqli_fetch_assoc($cx_query_run)){
			?>
		      <li class="dropdown-item" value="<?php echo $cx_result['cx_id']?>"><?php echo $cx_result['cx_id']?></li>    
		    <?php
		      }
		    ?>    
		    </ul>
		    <input id="submit" type="submit" name="submit" value="GO" class="btn btn-warning">
		  	</div>
		  	<input type="hidden" name="result" value="<?php echo (isset($_POST['submit']))?$_POST['result']:'';?>">
		  	<div class="row">

			  	<div class="col-md-6">
				  	<input type="text" name="project" id="project" size=100 class="form-control">
				  	<input type="button" value="Add/Remove Project Members" id="btn-pro" class="btn btn-danger">	  	
			  	</div>
			  	<div class="col-md-6">
				  	<input type="text" name="support" id="support" size=100 class="form-control">
				  	<input type="button" value="Add/Remove Support Members" id="btn-sup" class="btn btn-success" >
			  	</div>
		  	</div>

	  	</form>
	  	<?php
	  		if(isset($_POST['submit'])){
	  			$cx_id=$_POST['result'];
	  	?>

	  			<script type="text/javascript">
	  			var cx_name=$("input[name='result']").val();
        		$("#myButton").text(cx_name);
        		</script>
	  	<div class="card">
	  		<div class="card-header">
	  			<span class="cx">Customer: <?php echo $cx_id;?></span><span class="date">Date: <?php date_default_timezone_set("Asia/Colombo"); echo date('Y-m-d'); echo date(" h:ia");
?></span>
	  		</div>
	  		<div class="card-body">
	  	<div class="row">
	  		<div class="col-md-3">
	  			<table class="table table-success">
				    <thead>
				    	<tr>
				      		<th colspan="2"><span>All Tickets from:</span><span id="rdate">2014-11-10</span></th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state="select tv.ts_name as state,count(distinct tv.tn) as count from 				view_temp2 tv
									where tv.cx_id='".$cx_id."' and tv.create_time>='2014-11-10'
									group by tv.ts_name";
						$query_state_run=mysqli_query($connection,$query_state);
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	<tr>
				    		<td><?php echo $query_state_result['state'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php
				    		}
				    	?>
				    </tbody>
				</table>
	  		</div>

	  		<div  class="col-md-3">
	  			<table id="table2" class="table table table-warning">
				    <thead>
				    	<tr>
				      		<th colspan="3">Status Breakup</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state2="select u.first_name as reponsible,tv.ts_name as state, count(distinct tv.tn) as count from view_temp2 tv
					inner join issue_view iv on iv.tn=tv.tn inner join intuser_view u on
					u.id=iv.responsible_user_id
					where tv.cx_id='".$cx_id."' and tv.create_time>='2014-11-10'
					and tv.ts_name like '%info pending%'
					group by tv.ts_name,u.first_name
					union (select u.first_name as reponsible,tv.ts_name, count(distinct tv.tn) as count from view_temp2 tv
					inner join issue_view iv on iv.tn=tv.tn inner join intuser_view u on
					u.id=iv.responsible_user_id
					where tv.cx_id='".$cx_id."' and tv.create_time>='2014-11-10'
					and tv.ts_name like 'Assigned'
					group by tv.ts_name,u.first_name)";
						$query_state2_run=mysqli_query($connection,$query_state2);
						while($query_state2_result=mysqli_fetch_assoc($query_state2_run)){
				    	?>
				    	<tr>
				    		<td class="state"><?php echo $query_state2_result['state'];?></td>
				    		<td class="res"><?php echo $query_state2_result['reponsible'];?></td>
				    		<td><?php echo $query_state2_result['count'];?></td>
				    	</tr>
				    	<?php
				    		}
				    	?>
				    </tbody>
				</table>
	  		</div>

	  		<div  class="col-md-3">
	  			<table id="table3" class="collaptable table table-danger">
				    <thead>
				    	<tr>
				      		<th colspan="4">Support - Assigned</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$sup_mem=$_POST['support'];
				    	$split_sup_mem = explode(",", $sup_mem);
						$s_members = "'" . implode("', '", $split_sup_mem) ."'";
				    	$query_state="select u.first_name as responsible,iss.name as state,sv.name as service,count(iv.id) as count from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id=4 and 
							u.first_name in(".$s_members.") group by u.first_name,iv.service_id";
						$query_state_run=mysqli_query($connection,$query_state);
						$data_id=1;
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	<tr data-id="<?php echo $data_id; ?>" data-parent="">
				    		<td class="state"><?php echo $query_state_result['state'];?></td>
				    		<td class="responsible"><?php echo $query_state_result['responsible'];?></td>
				    		<td><?php echo $query_state_result['service'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php
				    	
				    	 $sup_ass="select u.first_name as responsible,iss.name as state,sv.name as service,iv.tn as tn,iv.id from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id=4 and sv.name='".$query_state_result['service']."' and 
							u.first_name in('".$query_state_result['responsible']."')";
						$sup_ass_run=mysqli_query($connection,$sup_ass);
							$data_parent=$data_id;
							while ($sup_ass_result=mysqli_fetch_assoc($sup_ass_run)) {
							?>
							<tr data-parent="<?php echo $data_parent; ?>">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_ass_result['id'];?>" target="_blank"><?php echo $sup_ass_result['tn'];?></a></td>
								<td><?php echo $sup_ass_result['responsible'];?></td>
							</tr>
							<?php							
							}
							$data_id++;
				    	}

				    	?>
				    </tbody>
				</table>
	  		</div>
	  		<div class="col-md-3 sup" >
	  			<table id="table4" class="collaptable table table-info">
				    <thead>
				    	<tr>
				      		<th colspan="4">Support - Info Pending</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state="select u.first_name as responsible,iss.name as state,sv.name as service,count(iv.id) as count from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id in(14,30) and 
							u.first_name in(".$s_members.") 
		                    group by u.first_name,iv.service_id";
						$query_state_run=mysqli_query($connection,$query_state);
						$data_id2=1;
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	   	<tr data-id="<?php echo $data_id2; ?>" data-parent="">
				    		<td class="state"><?php echo $query_state_result['state'];?></td>
				    		<td class="responsible"><?php echo $query_state_result['responsible'];?></td>
				    		<td class="service"><?php echo $query_state_result['service'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php
				    	$sup_inf="select u.first_name as responsible,iss.name as state,sv.name as service,iv.tn as tn,iv.id from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id in(14,30) and sv.name='".$query_state_result['service']."' and 
							u.first_name in('".$query_state_result['responsible']."')";

							$sup_inf_run=mysqli_query($connection,$sup_inf);
							$data_parent=$data_id2;
							while ($sup_inf_result=mysqli_fetch_assoc($sup_inf_run)) {
							?>
							<tr data-parent="<?php echo $data_parent; ?>">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $sup_inf_result['id'];?>" target="_blank"><?php echo $sup_inf_result['tn'];?></a></td>
								<td><?php echo $sup_inf_result['responsible'];?></td>
							</tr>
							<?php							
							}
				    	$data_id2++;	
				    	}
				    	?>
				    </tbody>
				</table>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-6">
	  		</div>
	  		<div class="col-md-3">
	  			<table id="table5" class="collaptable table table-danger">
				    <thead>
				    	<tr>
				      		<th colspan="3">Project - Assigned</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$pro_mem=$_POST['project'];
				    	$split_pro_mem = explode(",", $pro_mem);
						$p_members = "'" . implode("', '", $split_pro_mem) ."'";

				    	$query_state="select u.first_name as responsible,iss.name as state,sv.name as service,count(iv.id) as count from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id=4 and 
							u.first_name in(".$p_members.") 
		                    group by u.first_name,iv.service_id";
						$query_state_run=mysqli_query($connection,$query_state);
						$data_id3=1;
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	<tr data-id="<?php echo $data_id3; ?>" data-parent="">
				    		<!--td class="state"><?php echo $query_state_result['state'];?></td-->
				    		<td class="responsible"><?php echo $query_state_result['responsible'];?></td>
				    		<td><?php echo $query_state_result['service'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php				    	
				    	$pro_ass="select u.first_name as responsible,iss.name as state,sv.name as service,iv.tn as tn,iv.id from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id in(4) and sv.name='".$query_state_result['service']."' and 
							u.first_name in('".$query_state_result['responsible']."')";

							$pro_ass_run=mysqli_query($connection,$pro_ass);
							$data_parent=$data_id3;
							while ($pro_ass_result=mysqli_fetch_assoc($pro_ass_run)) {
							?>
							<tr data-parent="<?php echo $data_parent; ?>">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $pro_ass_result['id'];?>" target="_blank"><?php echo $pro_ass_result['tn'];?></a></td>
								<td><?php echo $pro_ass_result['responsible'];?></td>
							</tr>
							<?php							
							}
				    	$data_id3++;	
				    	}
				    	?>
				    		
				    	</tbody>
				</table>
	  		</div>
	  		<div class="col-md-3">
	  			<table id="table6" class="collaptable table table-info">
				    <thead>
				    	<tr>
				      		<th colspan="4">Project - Info Pending</th>
				  		</tr>
				    </thead>
				    <tbody>
				    	<?php
				    	$query_state="select u.first_name as responsible,iss.name as state,sv.name as service,count(iv.id) as count from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id in(14,30) and 
							u.first_name in(".$p_members.")
		                    group by u.first_name,iv.service_id";
						$query_state_run=mysqli_query($connection,$query_state);
						$data_id4=1;
						while($query_state_result=mysqli_fetch_assoc($query_state_run)){
				    	?>
				    	<tr data-id="<?php echo $data_id4; ?>" data-parent="">
				    		<!--td class="state"><?php echo $query_state_result['state'];?></td-->
				    		<td class="responsible"><?php echo $query_state_result['responsible'];?></td>
				    		<td class="service"><?php echo $query_state_result['service'];?></td>
				    		<td><?php echo $query_state_result['count'];?></td>
				    	</tr>
				    	<?php				    	
				    	$pro_inf="select u.first_name as responsible,iss.name as state,sv.name as service,iv.tn as tn,iv.id from issuestate_view iss
							inner join issue_view iv on iv.ticket_state_id=iss.id inner join intuser_view u on
							u.id=iv.responsible_user_id inner join service_view sv on sv.id=iv.service_id
							where iv.customer_id='".$cx_id."' and iv.create_time>='2014-11-10'
							and iv.ticket_state_id in(14,30) and sv.name='".$query_state_result['service']."' and 
							u.first_name in('".$query_state_result['responsible']."')";

							$pro_inf_run=mysqli_query($connection,$pro_inf);
							$data_parent=$data_id4;
							while ($pro_inf_result=mysqli_fetch_assoc($pro_inf_run)) {
							?>
							<tr data-parent="<?php echo $data_parent; ?>">
								<td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=<?php echo $pro_inf_result['id'];?>" target="_blank"><?php echo $pro_inf_result['tn'];?></a></td>
								<td><?php echo $pro_inf_result['responsible'];?></td>
							</tr>
							<?php							
							}
							$data_id4++;
				    	}
				    	?>
				    </tbody>
				</table>
	  		</div>
	  	</div>
	  </div>
	</div>
	  	<?php
		  }
		?>
	</div>
</body>
</html>
<?php
}
?>