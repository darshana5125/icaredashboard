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

<script type="text/javascript" src="\icaredashboard/libraries/jquery/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/cloudflare/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.print.min.js"></script>

<script type="text/javascript" src="\icaredashboard/libraries/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="\icaredashboard/libraries/datatables/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
 
<link href="\icaredashboard/libraries/cloudflare/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet" type="text/css" > 
<link href="\icaredashboard/libraries/datatables/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" > 
<link href="\icaredashboard/libraries/datatables/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" > 
<link href="\icaredashboard\css\table.css" rel="stylesheet" type="text/css" > 
<script type="text/javascript">

   $(document).ready( function(){
	   var customerId="";
	   var owner="";
	   var atm=0;
	   var cs=0;
	   var cs_in=0;
	   var cs_logs=0;
	   var sdi=0;
	   var cs2=0;
	   var sdi2=0;
	   var bank=0;
	   var ass="";
	   var state="";

$('#1st tr.st td').each(function() {
state=$(this).text(); 
//alert(state);
if(state=="Assigned"){
	$(this).parent().css('background-color','#ff8080');
}
else if(state=="Closed"){
	$(this).parent().css('background-color','#808080');
}
else if(state=="Explanation given"){
	$(this).parent().css('background-color','#b86fdc');
}
else if(state=="Fix given for UAT"){
	$(this).parent().css('background-color',' #eea891');
}
else if(state=="Info pending from bank "){
	$(this).parent().css('background-color','#ffc966');
}
else if(state=="Time Line Given"){
	$(this).parent().css('background-color','#ffbab3');
}
else if(state=="new"){
	$(this).parent().css('background-color','#D0FA58');
}
else if(state=="Pending Closure "){
	$(this).parent().css('background-color','#58ACFA');
}
else if(state=="Scheduled Release"){
	$(this).parent().css('background-color','#F781F3');
}
else if(state=="Under Observation"){
	$(this).parent().css('background-color','#F3F781');
}
});


$('#example4 tr.st td').each(function() {
state=$(this).text(); 

if(state=="Assigned"){
	$(this).parent().css('background-color','#ff8080');
}
else if(state=="Closed"){
	$(this).parent().css('background-color','#808080');
}
else if(state=="Explanation given"){
	$(this).parent().css('background-color','#b86fdc');
}
else if(state=="Fix given for UAT"){
	$(this).parent().css('background-color',' #eea891');
}
else if(state=="Info pending from bank "){
	$(this).parent().css('background-color','#ffc966');
}
else if(state=="Time Line Given"){
	$(this).parent().css('background-color','#ffbab3');
}
else if(state=="new"){
	$(this).parent().css('background-color','#D0FA58');
}
});

	   
$('#example tr').each(function() {	
    owner = $(this).find(".own").html(); 
	ass= $(this).find(".state").html();
	if (ass=="Assigned"){
		
     if(owner=="Lahiru" || owner=="Nalin" || owner=="Dilantha" || owner=="Samira" || owner=="Dilan" || owner=="Udara"
	 || owner=="Geehan"){

      atm+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  $(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 
	 else if(owner=="Shanaka" || owner=="John" || owner=="Aathif" || owner=="Priyadarshana"
	 || owner=="Suganthan" || owner=="Chamila" || owner=="Interblocks"){

      cs+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }
		
	 else if(owner=="Prabath" || owner=="Sanjaya"){

      cs_in+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }

	 else if(owner=="CS-logs"){

      cs_logs+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 
	 else if(owner=="Udul" || owner=="Sujith" ){

      sdi+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	}
	
	else if (ass=="Info pending from bank "){
				
	if(owner=="Interblocks"){

      bank+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  $(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 
	 else if(owner=="Shanaka" || owner=="Prabath" || owner=="Sanjaya" || owner=="John" || owner=="Aathif" || owner=="Priyadarshana"
	 || owner=="Suganthan" || owner=="Chamila" || owner=="Interblocks"){

      cs2+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }	 
	 else if(owner=="Udul" || owner=="Sujith" ){

      sdi2+=parseInt($(this).children('td:nth-child(3)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }

	
	}
	 });
	 
	
	 
	 $('#example tr:last').after('<tr><td rowspan="6" style="background-color:#ff8080;">Assigned</td></tr><tr><td style="background-color:#c9d7e8;">ATM</td><td style="background-color:#c9d7e8;">'+atm+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#b5fcb5;">CS-Logs</td><td style="background-color:#b5fcb5;">'+cs_logs+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#b5fcb5;">CS-Infra</td><td style="background-color:#b5fcb5;">'+cs_in+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#b5fcb5;">CS-Helpdesk</td><td style="background-color:#b5fcb5;">'+cs+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#7b97ea;">SDI</td><td style="background-color:#7b97ea;">'+sdi+'</td></tr>');
	 
	 $('#example tr:last').after('<tr><td rowspan="5" style="background-color:#ffc966">Info Pending</td></tr><tr><td style="background-color:#ffec80;">Bank</td><td style="background-color:#ffec80;">'+bank+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#b5fcb5;">CS</td><td style="background-color:#b5fcb5;">'+cs2+'</td></tr>');
	 $('#example tr:last').after('<tr><td style="background-color:#7b97ea;">SDI</td><td style="background-color:#7b97ea;">'+sdi2+'</td></tr>'); 
	 
});

</script>	  

<link rel="stylesheet" href="\icaredashboard/ums/css/main.css">
<!--header>
			<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header-->
<?php

$table="";

$table.="<body><div class='wrapper'>
<div id='header'><p>NTB MONITORING ISSUES - JANUARY 2019 ONWARDS - SUMMARY</p></div>
<table id='1st'><thead><tr><th colspan='2' style='background-color:#cccccc;text-align: center;font-size:20px;'> All Tickets </th></tr></thead>";

$query="select tv.ts_name,count(distinct tv.tn) as count from view_temp2 tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
group by tv.ts_name";

$query_run=mysqli_query($connection,$query);
while($result=mysqli_fetch_array($query_run)){
$table.="<tr class='st'><td>".$result['ts_name']."</td>
		<td>".$result['count']."</td></tr>";
}
$table.="
    </table>";

echo $table;


$table2="";

$query2="select tv.first_name,tv.ts_name, count(distinct tv.tn) as count from view_temp2 tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
and tv.ts_name like '%info pending%'
group by tv.ts_name,tv.first_name
union (select tv.first_name,tv.ts_name, count(distinct tv.tn) as count from view_temp2 tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
and tv.ts_name like 'Assigned'
group by tv.ts_name,tv.first_name)";

$query2_run=mysqli_query($connection,$query2);



//$query3_run=mysqli_query($connection,$query3);


$table2.="<table class='2nd' id='example'>

<thead><tr><th colspan='3' style='background-color:#cccccc;text-align: center;font-size:20px;'> Status Breakup </th></tr></thead>
";
while($result=mysqli_fetch_array($query2_run)){
$table2.="<tr><td class='state'>".$result['ts_name']."</td>
	<td class='own'>".$result['first_name']."</td>
		<td>".$result['count']."</td></tr>";
}
$table2.="</table>";
	echo $table2;

$table4="";
$table4.="<table id='example4'>
<thead><tr><th style='background-color:#cccccc;text-align: center;font-size:20px;'>Date</th><th style='background-color:#cccccc;text-align: center;font-size:20px;'>State</th><th style='background-color:#cccccc;text-align: center;font-size:20px;'>Count</th></tr></thead>";

$query_today="select tv.ts_name,count(distinct tv.tn) as count from view_temp2 tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and date(tv.create_time)=curdate()
group by tv.ts_name";

$query_today_run=mysqli_query($connection,$query_today);

$table4.="<tr><td rowspan='15' style='background-color:#F7BE81;'>".date('Y/m/d')."</td></tr>";
while($result_today=mysqli_fetch_array($query_today_run)){
$table4.="<tr class='st'><td>".$result_today['ts_name']."</td>
		<td>".$result_today['count']."</td></tr>";
}
$table4.="</table></div></body>";
echo $table4;	
}else{
	header('Location: index.php');
}	


?>






