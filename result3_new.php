<?php session_start();?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>

<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}


$q_name="";
$cx_id="";
$s_name="";
$owner="";
$responsible="";
$priority="";
$state="";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['customer']) || isset($_POST['queue']) || isset($_POST['service']) || isset($_POST['state']) || isset($_POST['owner']) || isset($_POST['priority'])
|| isset($_POST['responsible']))
 {
	 
		 // if(isset($_POST['customer']))
		  //@$cx_id=$_POST['customer'];
	  
	  if( isset($_POST['customer'])){
	foreach($_POST['customer'] as $cx_id)
	{
	
	@$cx=$cx."'".$cx_id."'".',';
	}
	$cx=rtrim($cx,',');
	test_input($cx);
	}
	
	
		
	 // else
		// $cx_id="";
	
		// if(isset($_POST['queue']))
		  //@$q_name=$_POST['queue'];
	  
	  	  if( isset($_POST['queue'])){
	foreach($_POST['queue'] as $q_id)
	{
	
	@$q_name=$q_name."'".$q_id."'".',';
	}
	$q_name=rtrim($q_name,',');
	
	}
	
	  
	  
	  
		// else
			// $q_name="";
	 
		// if(isset($_POST['service']))
		  //@$s_name=mysql_real_escape_string(test_input($_POST['service']));
	  
	  	  	  if( isset($_POST['service'])){
	foreach($_POST['service'] as $s_id)
	{
	
	@$s_name=$s_name."'".$s_id."'".',';
	}
	$s_name=rtrim($s_name,',');
	
	}
	  
		// else
			// $s_name="";
		
		// if(isset($_POST['state']))
		//@$state=mysql_real_escape_string(test_input($_POST['state']));
	
	  	  	  if( isset($_POST['state'])){
	foreach($_POST['state'] as $s)
	{
	
	@$state=$state."'".$s."'".',';
	}
	$state=rtrim($state,',');
	
	}
	  
	 // else
		 // $state="";
	 
		// if(isset($_POST['owner']))
		  //@$owner=mysql_real_escape_string(test_input($_POST['owner']));
	  
	   	  	  if( isset($_POST['owner'])){
	foreach($_POST['owner'] as $o)
	{
	
	@$owner=$owner."'".$o."'".',';
	}
	$owner=rtrim($owner,',');
	
	}
	  
	  
	 // else
		 // $owner="";
		
		// if(isset($_POST['priority']))
		 //@$priority=mysql_real_escape_string(test_input($_POST['priority']));
	 	   	  	  if( isset($_POST['priority'])){
	foreach($_POST['priority'] as $p)
	{
	
	@$priority=$priority."'".$p."'".',';
	}
	$priority=rtrim($priority,',');
	
	}
	 
	 // else
		 // $priority="";
		 //@$responsible=mysql_real_escape_string(test_input($_POST['responsible']));
		 	 	   	  	  if( isset($_POST['responsible'])){
	foreach($_POST['responsible'] as $res)
	{
		
	@$responsible=$responsible."'".$res."'".',';
	}
	$responsible=rtrim($responsible,',');
	
	}
		 
		 
		 @$exception=$_POST['exception'];
		 

	
	// $pw=$_POST['password'];
// $fname=$_POST['firstname'];
// $value=$_POST['users'];

// if($pw=="All")
// {
// $query2=$query2. "password is not null and ";
		 
// }
		
if($exception=="true")
{
		$query2="select distinct view_temp2.*,intuser_view.first_name as res from view_temp2 join issue_view join intuser_view on view_temp2.tn=issue_view.tn and issue_view.responsible_user_id=intuser_view.id where exception in(0,1) ";
}
else
{
$query2="select distinct view_temp2.*,intuser_view.first_name as res from view_temp2 join issue_view join intuser_view on view_temp2.tn=issue_view.tn and issue_view.responsible_user_id=intuser_view.id where exception in(0) ";	
}



if($q_name=="" || $q_name=="'All'" )
{
	$query2.=" ";
}
else if($q_name!="'All'")
{
$query2=$query2. " and view_temp2.q_name in (";

$qn="";
foreach($_POST['queue'] as $qname)
{
$qn=$qn."'".$qname."'".',';
}
$query2=$query2.$qn;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}


if ($cx_id=="" || $cx_id=="All" )
{	
	$query2.=" ";
}
else if($cx_id!="'All'")
{	
$query2=$query2. " and view_temp2.cx_id in (";
$col="";
foreach($_POST['customer'] as $cx)
{
$col=$col."'".$cx."'".',';
}
$query2=$query2.$col;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}
else
{
die($cx_err);	
}

// if($fname=="All")
// {
// $query2=$query2. "firstname is not null and ";
// }



// if($value=="All")
// {
// $query2=$query2. "username is not null ";
// }
if($s_name=="" || $s_name=="'All'" )
{
	$query2.=" ";
}
else if($s_name!="'All'")
{
$query2=$query2. " and view_temp2.s_name in (";
$sn="";
foreach($_POST['service'] as $sname)
{
$sn=$sn."'".$sname."'".',';
}
$query2=$query2.$sn;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}

if($state=="" || trim($state)=="'All'")
{
	$query2.=" ";
}
else if($state!="'All'")
{
$query2=$query2. " and view_temp2.ts_name in (";
$ts="";
foreach($_POST['state'] as $tsname)
{
$ts=$ts."'".$tsname."'".',';
}
$query2=$query2.$ts;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}

if($owner=="" || $owner=="'All'")
{
$query2.=" ";
}
else if ($owner!="'All'")
{
$query2=$query2. " and view_temp2.first_name in (";
$fn="";
foreach($_POST['owner'] as $fname)
{
$fn=$fn."'".$fname."'".',';
}
$query2=$query2.$fn;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}

if($responsible=="" || $responsible=="'All'")
{
$query2.=" ";
}
else if ($responsible!="'All'")
{
$query2=$query2. " and issue_view.responsible_user_id in (";
$ru="";
foreach($_POST['responsible'] as $res)
{
$ru=$ru."'".$res."'".',';
}
$query2=$query2.$ru;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}


if($priority=="" || $priority=="'All'")
{
	$query2.=" ";
}
else if ($priority!="'All'")
{
$query2=$query2. " and view_temp2.tp_name in (";
$tp="";
foreach($_POST['priority'] as $tpname)
{
$tp=$tp."'".$tpname."'".',';
}
$query2=$query2.$tp;
$query2=substr($query2,0,-1);
$query2=$query2.")";
}
$query2 .=" order by view_temp2.tn";

//echo $query2.'<br>';




$query2_run=mysqli_query($connection,$query2);
$num_rows=mysqli_num_rows($query2_run);
if($num_rows!=0)
	
{
	// echo'<script>
	// function myFunction() {
		// style="visibility:hidden";
    // window.print();
	
// }</script>
	// <button name="print" onclick="myFunction()">Print</button>';	
	
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
 
<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" integrity="sha384-yNuQMX46Gcak2eQsUzmBYgJ3eBeWYNKhnjyiBqLd1vvtE9kuMtgw6bjwN8J0JauQ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js" integrity="sha384-Kv4u0J/5Vhwb62xGQP6LXO686+cmeHY3DPXG9uf265EghKCn2SRAKu9hcHb2FS+L" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" integrity="sha384-Pn+PczAsODRZ2PiGg0IheRROpP7lXO1NTIjiPo6cca8TliBvaeil42fobhzvZd74" crossorigin="anonymous"></script>


  
	<link rel="stylesheet" type="text/css" href="excel/all_min.css" />
<script type="text/javascript" src="excel/all_min.js"></script>
<script type="text/javascript" src="excel/min.js"></script>

  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script> 
  <link rel="stylesheet" href="/resources/demos/style.css" />
  
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/pending_follow_ups.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="ums/css/main.css">
 <script type='text/javascript'>

 
 $(document).ready(function(){
	 

        $(".hide").hide();

       
	
        $("#btnExport").click(function () {
			
            // parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create({
                data: "#exportTable",
                schema: {
                    type: "table",
                    fields: {
                        Cx_ID: { type: String },
                        CSR: { type: String },
                        Subject: {type:String},
						Create_Time: { type: String },
                        Queue: { type: String },
						State: { type: String },
                        Priority: { type: String },
                        Service: { type: String },
						Owner: { type: String },
						Responsible: { type: String }
                 
                    }
                }
            });

            // when parsing is done, export the data to Excel
            dataSource.read().then(function (data) {
				 new shield.exp.OOXMLWorkbook({
                    author: "Data_Filter",
                    worksheets: [
                        {
                            name: "Report",
                            rows: [
                                {
                                    cells: [
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Cx_ID"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "CSR"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Subject"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Create_Time"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Queue"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "State"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Priority"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Service"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Owner"
                                        },
										{
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "Responsible"
                                        }
                                    ]
                                }
                            ].concat($.map(data, function(item) {
                                return {
                                    cells: [
                                        { type: String, value: item.Cx_ID },
                                        { type: String, value: item.CSR },
                                        { type: String, value: item.Subject },
										 { type: String, value: item.Create_Time },
                                        { type: String, value: item.Queue },
                                        { type: String, value: item.State },
										 { type: String, value: item.Priority },
                                        { type: String, value: item.Service },
                                        { type: String, value: item.Owner },
										 { type: String, value: item.Responsible }
                                                 
                                    ]
                                };
                            }))
                        }
                    ]
                }).saveAs({
                    fileName: "Report_Filter"
                });
            });
        });
   


        


 


 	 $("#exportTable").tablesorter(); 

	  
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }

        var php_var = "<?php echo $num_rows; ?>";
   document.getElementById("test1").innerHTML =php_var;
    });

    $('.filterable .filters input').keyup(function(e){
    	  $(".filters").show();

        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
		document.getElementById("test1").innerHTML =$rows.length-$filteredRows.length;	
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {			
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }        

    });
$('#example').DataTable();

	});
	
	
</script>





<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
  <div class="container">

  <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">

                <h3 class="panel-title">Report Filter<span style="padding-left:600px;">Number of CSR:</span ><span id="test1" style="float:right; padding-right:300px;"></span> 
              
                </h3>


                <div class="pull-right">
                     <button  style="float:left;margin-right: 20;" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                    
                   <button style="padding:0; width:120px;" id="btnExport" data-toggle="modal" data-target="#squarespaceModal"  class="btn btn-primary center-block"> Export to Excel</button>
                </div>
            </div>

<div id="table_wrapper">
<table class="table" id="exportTable" ><thead>
<tr class="filters"  style="padding-top:10px; padding-bottom: 10px;">
<th style="font-size:1px;color:#fff;">Cx_ID<input type="text" class="form-control" placeholder="Cx_ID" disabled></th><th style="font-size:1px;color:#fff;" >CSR<input type="text" class="form-control" placeholder="CSR" disabled></th><th style="font-size:1px;color:#fff;">Subject<input type="text" class="form-control" placeholder="Subject" disabled></th><th style="font-size:1px;color:#fff;">Create_Time<input type="text" class="form-control" placeholder="Create_Time" disabled></th>
<th style="font-size:1px;color:#fff;">Queue<input type="text" class="form-control" placeholder="Queue" disabled></th><th style="font-size:1px;color:#fff;">State<input type="text" class="form-control" placeholder="State" disabled></th><th style="font-size:1px;color:#fff;" class="pri">Priority<input type="text" class="form-control" placeholder="Priority" disabled></th><th style="font-size:1px;color:#fff;">Service<input type="text" class="form-control" placeholder="Service" disabled></th><th style="font-size:1px;color:#fff;">Owner<input type="text" class="form-control" placeholder="Owner" disabled></th><th style="font-size:1px;color:#fff;">Responsible<input type="text" class="form-control" placeholder="Responsible" disabled></th></tr></thead>



<tbody>

<?php
$count=1;

while($result2=mysqli_fetch_assoc($query2_run)) 
{
	if($result2['sla_state']==1)
	{
	echo '<tr>
	<td>'.$result2['cx_id'].'</td>'	;
	echo'<td>'.$result2['tn'].'</td>
	<td>'.$result2['title'].'</td>
	<td width="10%">'.date("Y-m-d",strtotime($result2['create_time'])).'</td>	
	<td> '.$result2['q_name'].'</td>
	<td><font color="green"> '.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td> '.$result2['s_name'].'</td> 
	<td> '.$result2['first_name'].'</td>
	<td> '.$result2['res'].'</td>
	
	</tr>'; 
	
$count++;
	}
	if($result2['sla_state']==2)
	{
	echo '<tr>
	<td>'.$result2['cx_id'].'</td>'	;
	echo'<td>'.$result2['tn'].'</td>
	<td>'.$result2['title'].'</td>
	<td class="time">'.date("Y-m-d",strtotime($result2['create_time'])).'</td>
	<td> '.$result2['q_name'].'</td>
	<td> <font color="blue">'.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td> '.$result2['s_name'].'</td> 
	<td> '.$result2['first_name'].'</td>
	<td> '.$result2['res'].'</td>
	

	</tr>'; 
	
$count++;	
	}
	if($result2['sla_state']==3)
	{
	echo '<tr>
	<td>'.$result2['cx_id'].'</td>'	;
	echo'<td>'.$result2['tn'].'</td>
	<td>'.$result2['title'].'</td>
	<td class="time">'.date("Y-m-d",strtotime($result2['create_time'])).'</td>	
	<td> '.$result2['q_name'].'</td>
	<td> <font color="red">'.$result2['ts_name'].'</font></td>
	<td> '.$result2['tp_name'].'</td>
	<td> '.$result2['s_name'].'</td> 
	<td> '.$result2['first_name'].'</td>
	<td> '.$result2['res'].'</td>
	
	
	</tr>'; 
	
$count++;	
	}
	if($result2['sla_state'] == null)
	{
	echo '<tr>
	<td>'.$result2['cx_id'].'</td>'	;
	echo'<td>'.$result2['tn'].'</td>
	<td>'.$result2['title'].'</td>
	<td class="time">'.date("Y-m-d",strtotime($result2['create_time'])).'</td>
	<td> '.$result2['q_name'].'</td>
	<td> '.$result2['ts_name'].'</td>
	<td> '.$result2['tp_name'].'</td>
	<td> '.$result2['s_name'].'</td> 
	<td> '.$result2['first_name'].'</td>
	<td> '.$result2['first_name'].'</td>
	<td> '.$result2['res'].'</td>
	
	
	</tr>'; 
	
$count++;	
	}
	
}
}
else
{
	echo "<script type='text/javascript'>alert('No records found!');
	
	</script>";
	
//	die();
	
}
 }
 
 // else{
	// echo "<script type='text/javascript'>alert('You have to select at least one option from each list!');
	// close();
// </script>"; 
 // }
 echo '</tbody></table>
 </div></div></div></div>';

 
?>
	<script type="text/javascript">
   var php_var = "<?php echo $num_rows;?>";
   document.getElementById("test1").innerHTML =php_var;
   </script>
