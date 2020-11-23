<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); 
$table="";

$table.="<body><div style='font-family:arial;font-size:15px;width:95%;margin: 0 auto;'><table style='font-family:arial;font-size:15px;width:25%;margin: 20 10;' id='example2' class='table table-sm table-bordered' x>
<thead class='thead-dark'><tr><th colspan='2'> All Tickets </th></tr>";

$query="select tv.ts_name,count(tv.tn) as count from temp2_view tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
group by tv.ts_name";

$query_run=mysqli_query($connection,$query);
while($result=mysqli_fetch_array($query_run)){
$table.="<tr><td>".$result['ts_name']."</td>
		<td>".$result['count']."</td></tr>";
}
$table.="</tbody>
    </table></div></body>";

echo $table;


$table2="";

$query2="select tv.first_name,tv.ts_name, count(tv.tn) as count from temp2_view tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
and tv.ts_name like '%Assigned%' 
group by tv.first_name,tv.ts_name";

$query2_run=mysqli_query($connection,$query2);

$query3="select tv.first_name,tv.ts_name, count(tv.tn) as count from temp2_view tv
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01'
and tv.ts_name like '%Info pending from bank %' 
group by tv.first_name,tv.ts_name";

$query3_run=mysqli_query($connection,$query3);


$table2.="<body><div style='font-family:arial;font-size:15px;width:95%;margin: 0 auto;'><table id='example' style='width:25%;margin: 20 10; table-layout: fixed;'  class='table table-sm table-bordered' x>
<thead class='thead-dark'><tr><th colspan='3'> Status Breakup </th></tr>
<tr><td rowspan='4' >Assigned</td>";
while($result=mysqli_fetch_array($query2_run)){
$table2.="<tr><td class='own'>".$result['first_name']."</td>
		<td>".$result['count']."</td></tr>";
}
$table2.="</tbody>
    </table></div>";
	echo $table2;
	
$table3="";
	
$table3.="<table id='example3' style='font-family:arial;font-size:15px;width:25%;margin: -20 45; table-layout: fixed;'  class='table table-sm table-bordered' x>

<tr><td rowspan='4' >Info Pending</td>";
while($result=mysqli_fetch_array($query3_run)){
$table3.="<tr ><td class='own'>".$result['first_name']."</td>
		<td  >".$result['count']."</td></tr>";
}
$table3.="</tbody>
    </table></body>";
	echo $table3;

    
	


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

<script type="text/javascript">

   $(document).ready( function(){
	   var customerId="";
	   var owner="";
	   var atm=0;
	   var cs=0;
	   var sdi=0;
	   var cs2=0;
	   var sdi2=0;
	   var bank=0;
	   
$('#example tr').each(function() {
    owner = $(this).find(".own").html(); 
     if(owner=="Lahiru" || owner=="Nalin" || owner=="Dilantha" || owner=="Samira" || owner=="Dilan" || owner=="Udara"
	 || owner=="Geehan"){

      atm+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  $(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 
	 else if(owner=="Shanaka" || owner=="Prabath" || owner=="Sanjaya" || owner=="John" || owner=="Aathif" || owner=="Priyadarshana"
	 || owner=="Suganthan" || owner=="Chamila" || owner=="Interblocks"){

      cs+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }	 
	 else if(owner=="Udul" || owner=="Sujith" ){

      sdi+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 });
	 
	 
	 $('#example3 tr').each(function() {
    owner = $(this).find(".own").html(); 
     if(owner=="Interblocks"){

      bank+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  $(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 
	 else if(owner=="Shanaka" || owner=="Prabath" || owner=="Sanjaya" || owner=="John" || owner=="Aathif" || owner=="Priyadarshana"
	 || owner=="Suganthan" || owner=="Chamila" || owner=="Interblocks"){

      cs2+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }	 
	 else if(owner=="Udul" || owner=="Sujith" ){

      sdi2+=parseInt($(this).children('td:nth-child(2)').text());  
     
      //$('myTable td').attr('id', 'test');
	  //$(this).attr('id','test');
      
      $(this).hide();
	  
	 }
	 });
	 
	 $('#example tr:last').after('<tr><td>ATM</td><td>'+atm+'</td></tr>');
	 $('#example tr:last').after('<tr><td>CS</td><td>'+cs+'</td></tr>');
	 $('#example tr:last').after('<tr><td>SDI</td><td>'+sdi+'</td></tr>');
	 
	 $('#example3 tr:last').after('<tr><td>Bank</td><td>'+bank+'</td></tr>');
	 $('#example3 tr:last').after('<tr><td>CS</td><td>'+cs2+'</td></tr>');
	 $('#example3 tr:last').after('<tr><td>SDI</td><td>'+sdi2+'</td></tr>');
	 
	 
});

</script>	  


