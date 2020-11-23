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
<style>
#example tr:hover td,
#example tr:hover td.highlight
{
    background:#ff8080;
}
</style>
<link rel="stylesheet" href="\icaredashboard/ums/css/main.css">
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

<style>
  button {
        font-size: 8px;
  }
  
  .test{
	   font-size: 12px;
  }
  
  .test a{
	   font-size: 12px;
  }
  </style>

<script type="text/javascript">
$(document).ready(function() {
	
		// variable n using to irrerate through each row
			//var n=1; 
	      /* $('#example td:nth-child(6)').each(function () {
				 
				 var age=$(this).text().substring(0, 2);;
				 var state=$('#example').find("tr:eq("+n+")").find("td:eq(0)").text();
				 var st_code=state.substring(0, 3);
				 var st1_sla=1;
				 var st2_sla=2;
				 var st3_sla=3;
				 var st4_sla=4;
				 var st5_sla=7;
				 var st6_sla=8;
				 var st7_sla=9;
				 var st8_sla=10;
				 var st9_sla=11;
				 var st10_sla=12;
				 
				 function colorrows($color){
					$('#example').find("tr:eq("+n+")").find("td:eq(0)").css('background-color', $color); 
					$('#example').find("tr:eq("+n+")").css('background-color', $color); 
				 }
				 
				 if(st_code=="01 "){
					 colorrows('#A3E4D7');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("1 day");
				 }	
					
				 if(st_code=="02 "){
					 colorrows('#85C1E9');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("2 days");
				 }				 
				 
				  if(st_code=="03 "){
					 colorrows('#F9E79F');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("3 days");
				 }				 
				 
				  if(st_code=="04 "){
					 colorrows('#F5B7B1');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("4 days");
				 }				 
				 
				  if(st_code=="05 "){
					 colorrows('#AED6F1');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("7 days");
				 }
					
				 if(st_code=="06a"){
					 colorrows('#C39BD3');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("8 days");
				 }	
				 
				  if(st_code=="06b"){
					 colorrows('#884EA0');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("8 days");
				 }	
				  if(st_code=="07 "){
					 colorrows('#D4AC0D');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("9 days");
					
				 }	
				  if(st_code=="08 "){
					 colorrows('#922B21');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("10 days");
				 }	
				  if(st_code=="09a"){
					 colorrows('#BA4A00');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("11 days");
				 }	
				  if(st_code=="09b"){
					 colorrows('#E59866');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("11 days");
				 }	
				  if(st_code=="10 "){
					 colorrows('#85929E');
					 $('#example').find("tr:eq("+n+")").find("td:eq(4)").text("12 days");
				 }	
				 				 
				 
				 
				 
				 if((st_code=="01 ") && (age>st1_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st1_sla+" day/s");
				 }
				 
				 if((st_code=="02 ") && (age>st2_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st2_sla+" day/s");
				 }
				 
				 if((st_code=="03 ") && (age>st3_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st3_sla+" day/s");
				 }
				 
				 if((st_code=="04 ") && (age>st4_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st4_sla+" day/s");
				 }
				 
				 if((st_code=="05 ") && (age>st5_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st5_sla+" day/s");
				 }
				 
				 if((st_code=="06a"  ) && (age>st6_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st6_sla+" day/s");
				 }
				 
				 if((st_code=="06b"  ) && (age>st6_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st6_sla+" day/s");
				 }
				 
				 if((st_code=="07 ") && (age>st7_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st7_sla+" day/s");
				 }
				 
				 if((st_code=="08 ") && (age>st8_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st8_sla+" day/s");
				 }
				 
				 if((st_code=="09a") && (age>st9_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st9_sla+" day/s");
				 }
				 
				 if((st_code=="09b") && (age>st9_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st9_sla+" day/s");
				 }
				 
				 if((st_code=="10 ") && (age>st10_sla) ){
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").css('background-color', '#F75D59');
					 $('#example').find("tr:eq("+n+")").find("td:eq(6)").text(age-st10_sla+" day/s");
				 }				 
								 
				 n++; 
				
    });
	 */
	
	
	
	  var table=  $('#example').DataTable( {
		   
		    dom: 'Bfrtip',
        		
		lengthMenu: [
            [ 20, 50, 100, -1 ],
            [ '20 rows', '50 rows', '100 rows', 'Show all' ]
        ],
       	   
	   buttons: [ 'pageLength',
            {
                extend: 'excelHtml5',
                filename: 'NTB data export',
				title:''					
            },
            {
                extend: 'pdfHtml5',
                filename: 'NTB data export',
				title:''
            },'copy','csv'
        ]
	   });
	   
	   $( "button" ).addClass( "test" );
	   $( "div" ).addClass( "test" );
	   
	   
	   
	table.buttons().container()
        .appendTo( '#example.col-md-6:eq(0)' );
		
		   $('#example tfoot th.search').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" style="margin:0px; padding:0px;white-space: nowrap;width: 100%;" placeholder="'+title+'"/>' );
    } );
 
   
   
	
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
	
   
		
} );
</script>



<header>
			<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<?php
//get current month for example
/*if(!isset($_GET['from'])) {
    $beginday=date("Y-m-01");
} else {
    $beginday=date($_GET['from']);
}
if(!isset($_GET['to'])) {
    $lastday=date("Y-m-01");
} else {
    $lastday=date($_GET['to']);
}*/
//date_default_timezone_set('Asia/Colombo'); 

$beginday='2019-01-01';
$lastday =date('Y-m-d');


//echo $nr_work_days.'<br>';

 function getWorkingDays($startDate, $endDate){
 $begin=strtotime($startDate);
 $end=strtotime($endDate);
 if($begin>$end){//check if the end date is beyond begin date
  echo "startdate is in the future! <br />";
  return 0;
 }else{
   $no_days=0;
   $weekends=0;
  while($begin<$end){
    $no_days++; // no of days in the given interval
    $what_day=date("N",$begin);
     if($what_day>5) { // 6 and 7 are weekend days
          $weekends++;
     };
    $begin+=86400; // +1 day
  };
  $working_days=$no_days-$weekends;
  $holidays=array("2019-01-15","2019-02-04","2019-02-19","2019-03-20","2019-04-15","2019-04-19","2019-05-01","2019-05-17",
  "2019-06-16","2019-07-15","2019-07-16","2019-08-14","2019-09-13","2019-10-09","2019-11-12","2019-12-11","2019-12-25");
   foreach($holidays as $holiday){	 
    $time_stamp=strtotime($holiday);
    //If the holiday doesn't fall in weekend
    if ($startDate <= $holiday && $holiday <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7){
	 $working_days--;
	 }  
}
// in case after deducting public holidays if the working days count comes to a minus figure, then it will return 0 as the number of working days.
  if($working_days>0){
	return $working_days;
  }
  else{
	return 0;  
  }
 }
} 

$nr_work_days = getWorkingDays($beginday,$lastday);

$table="";
?>
<body><div style='font-family:arial;font-size:11px;width:95%;margin: 0 auto;'>
<?php
$table.="<table style='white-space: nowrap; width: 1%;font-family:arial;font-size:10px;width:90%;margin: 0 auto;' id='example' class='table table-sm table-bordered' x>
<thead class='thead-dark'><tr><th>#</th><th>CSR #</th><th>Subject</th><th>Create Date</th><th>Age(days)</th><th>Queue</th><th>State</th><th>Priority</th><th>Owner</th><th>Responsible</th></tr>
</thead>
<tbody>";
$query="select distinct t.id as ticket_id,tv.tn,tv.title,tv.create_time,tv.q_name as queue,tv.ts_name as service,
tv.tp_name as priority,tv.first_name as owner,u.first_name as responsible
from view_temp2 tv join issue_view t
on tv.tn=t.tn join intuser_view u
on t.responsible_user_id=u.id 
where tv.q_name like '%Sri Lanka::Nations Trust Bank::Monitoring%' and tv.create_time>='2019-01-01' order by tv.tn desc";

$count=1;
$query_run=mysqli_query($connection,$query);
while($result=mysqli_fetch_array($query_run)){
	$create_date=strtotime($result['create_time']);
	$beginday=date('Y-m-d',$create_date);
	$lastday =date('Y-m-d');
	$nr_work_days = getWorkingDays($beginday,$lastday);
	$table.="<tr><td>".$count."</td><td>
	<a style='color: black; text-decoration: none;font-size:10;font-family:arial;' href=https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID=".$result['ticket_id']."  target='_blank' >".$result['tn'].'</td><td>'.substr($result['title'],0,100)."</td>
	<td>".$result['create_time']."</td><td>".$nr_work_days."</td><td>".$result['queue']."</td><td>".$result['service']."</td><td>".$result['priority']."</td><td>".$result['owner']."</td>
	<td>".$result['responsible']."</td></tr>";
	$count++;
}
$table.="</tbody><tfoot><tr><th>#</th><th class='search'>CSR #</th><th class='search'>Subject</th><th class='search'> Create Date</th><th class='search'>Age(days)</th><th class='search'> Queue</th><th class='search'> State</th><th class='search'> Priority</th><th class='search'> Owner</th><th class='search'>Responsible</th></tr>
        </tfoot>
    </table>";
	
echo $table;
?>
</div></body>
<?php
}
?>
?>
