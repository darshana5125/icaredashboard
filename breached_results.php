<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	//if (!isset($_SESSION['user_id'])) {
		//header('Location: index.php');
	//}
	//?>


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
	
			  var table=  $('#example').DataTable( {
		   
		    dom: 'Bfrtip',
        		
		lengthMenu: [
            [ 20, 50, 100, -1 ],
            [ '20 rows', '50 rows', '100 rows', 'Show all' ]
        ],
       	   
	   buttons: [ 'pageLength',
            {
                extend: 'excelHtml5',
                filename: 'Breached CSR list',
				title:''					
            },
            {
                extend: 'pdfHtml5',
                filename: 'Breached CSR list',
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





<!--header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header-->

<?php 
 echo'<body>';
 
 function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
	}
 
		 if(isset($_POST['ok']) ){
			 $date1=test_input($_POST['datepicker1']);
			 $date2=test_input($_POST['datepicker2']);
	
	 echo'&nbsp &nbsp <a href="https://192.168.47.25/icaredashboard/breached_list.php">Back</a>&nbsp &nbsp &nbsp &nbsp &nbsp'; 
	 
		 
			 
	print "Breached issue list from " ; print $date1; print '  to  '; print $date2; 
			 
			 
			
			echo ' 
<div id="box"><table style="white-space: nowrap;
	 width: 1%;font-family:arial;font-size:10px;width:90%;margin: 0 auto;" id="example" class="table table-sm table-bordered" x><thead class="thead-dark"><tr><th>Number</th><th>CustomerID</th><th>CSR#</th><th>Title</th>
	 <th>Service</th><th>Created</th><th>Breached </th><th>State</th><th>Responsible</th></tr></thead><tbody>';


$query="select distinct t.customer_id as cx_id,t.tn as tn,t.title as title,ser.name as service,t.create_time as create_time ,s.breached_time as breached_time,isv.name as state,u.first_name as responsible from 
issue_view t join servicelevel_view s on
t.tn=s.tn
join service_view ser
on t.service_id=ser.id 
join issuestate_view isv
on t.ticket_state_id=isv.id
join intuser_view u
on t.responsible_user_id=u.id 
where sla_state='3' and breached_time between '$date1' and '$date2'
order by breached_time desc";


$query_run=mysqli_query($connection,$query);
$count=1;

while($result2=mysqli_fetch_assoc($query_run)) 
{
	
	echo '<tr><td >'.$count.'</td>
	<td >'.$result2['cx_id'].'</td>'	;
	echo'<td >'.$result2['tn'].'</td>
	<td >'.$result2['title'].'</td>
	<td >'.$result2['service'].'</td>
	<td >'.$result2['create_time'].'</td>
	<td > '.$result2['breached_time'].'</td>
	<td >'.$result2['state'].'</td>
	<td >'.$result2['responsible'].'</td>

	
	</tr>';  
			 
			 
		$count++;
		 
		
			 
			 
		 }
	
}
	
	
echo' </tbody><tfoot><tr><th class="search">Number</th><th class="search">CustomerID</th><th class="search">CSR#</th><th class="search">Title</th><th class="search">Service</th><th class="search">Created</th><th class="search">Breached </th><th class="search">State</th><th class="search">Responsible</th></tr>
        </tfoot>

<table></html>';
 
 //mysqli_close($link);
 
 ?>
