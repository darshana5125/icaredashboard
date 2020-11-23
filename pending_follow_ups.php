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
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 
<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="\icaredashboard/libraries/bootstrapcdn/font-awesome/4.3.0/css/font-awesome.min.css">

<script src="\icaredashboard/libraries/jquery/jquery-1.9.1.js"></script>

  <script src="\icaredashboard/libraries/jquery/ui/1.10.3/jquery-ui.js"></script>
  
 
  
<link rel="stylesheet" href="\icaredashboard/libraries/googleapis/css?family=Open+Sans:400,300,300italic,400italic,600">
 <link href="css/pending_follow_ups.css" rel="stylesheet" type="text/css">
<link rel='stylesheet' href='ums/css/main.css'>
 <script type='text/javascript'>
 $(document).ready(function(){
	  
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
    });

    $('.filterable .filters input').keyup(function(e){

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

</head>
<body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<div class="container">
<form method="POST" action="pending_follow_ups.php?mid=10" name="form1" id="form1" >
<div class="dropdown">
<button type="button" class="btn btn-default">Number of days</button>
<select  class="btn btn-primary dropdown-toggle" data-toggle="dropdown" onchange="this.form.submit()" name="days">
<?php
for ($x = 2; $x <= 30; $x++) {
    //echo '<option value="'.$x.'">'.$x.'</option>';
	
	if ($x == $_POST['days']){
$selected = "selected=\"selected\""; } else { $selected = ""; }
echo "<option value=\"$x\" $selected>$x</option>";

} 
?>
</select>
<span style="padding-left:50;"><input type="checkbox" name="onhold" value="13" <?php if(isset($_POST['onhold'])) echo "checked='checked'"; ?>
				onchange="document.getElementById('form1').submit()">On Hold</span>
</div>

</form>

 <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">

                <h3 class="panel-title">Pending Follow up CSR<span style="padding-left:720px;">Number of CSR:</span ><span id="test1" style="float:right; padding-right:100px;"></span> </h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
<table  class="table" cellpadding="0" cellspacing="0" border="0">
	
      <thead>
        <tr class="filters"  style="padding-top:10px; padding-bottom: 10px;">
		
          <th  width="4%"><input type="text" class="form-control" placeholder="No" disabled></th>
          <th width="8%"><input type="text" class="form-control" placeholder="Cx ID" disabled></th>
          <th width="8%"><input type="text" class="form-control" placeholder="CSR #" disabled></th>
          <th width="25%"><input type="text" class="form-control" placeholder="Subject" disabled></th>
          <th width="10%"><input type="text" class="form-control" placeholder="LU Date" disabled></th>
		  <th width="25%"><input type="text" class="form-control" placeholder="Last Note" disabled></th>		
		  <th width="10%"><input type="text" class="form-control" placeholder="State" disabled></th>	
		  <th width="10%"><input type="text" class="form-control" placeholder="Service" disabled></th>
        </tr>
      </thead>


	  <tbody>
	 <?php
	 
		 
		 function test_input($data) {
	  $data = trim($data);
	  $data=strip_tags($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}
	 $count=1;
	 if(isset($_POST['days']) )
{	
$days=$_POST['days'];
$days=test_input($days);
$state_id='7,17,24,25,16,5,10,13';
if(isset($_POST['onhold'])){
$state_id='7,17,24,25,16,5,10';
}
$query_pending="select t.tn,t.customer_id,t.title,a.article_type_id,a.id,a.a_body,a.ticket_id,t.ticket_state_id,a.create_time,s.name as service,
ts.name as state from note_view a
inner join
(select max(id) as maxid from note_view
where article_type_id in(1,2,9,10)
group by ticket_id
) maxart on maxart.maxid=a.id 
inner join issue_view t
on a.ticket_id=t.id 
inner join issuestate_view ts
on ts.id=t.ticket_state_id
inner join service_view s
on s.id=t.service_id
where t.ticket_state_id not in($state_id)  and t.create_time>'2014-11-10' and 
not (a.create_time>NOW() - INTERVAL $days DAY) order by t.tn desc";
}
else
{
	$state_id='7,17,24,25,16,5,10,13';
if(isset($_POST['onhold'])){
$state_id='7,17,24,25,16,5,10';
}
$query_pending="select t.tn,t.customer_id,t.title,a.article_type_id,a.id,a.a_body,a.ticket_id,t.ticket_state_id,a.create_time,s.name as service,
ts.name as state from note_view a
inner join
(select max(id) as maxid from note_view
where article_type_id in(1,2,9,10)
group by ticket_id
) maxart on maxart.maxid=a.id 
inner join issue_view t
on a.ticket_id=t.id 
inner join issuestate_view ts
on ts.id=t.ticket_state_id
inner join service_view s
on s.id=t.service_id
where t.ticket_state_id not in($state_id)  and t.create_time>'2014-11-10' and 
not (a.create_time>NOW() - INTERVAL 2 DAY) order by t.tn desc";	
}
$query_pending_run=mysqli_query($connection,$query_pending);
$num_rows=mysqli_num_rows($query_pending_run);
	  while($result=mysqli_fetch_array($query_pending_run)){
	 echo '<tr>
	  <td>'.$count.'</td>
	  <td>'.$result['customer_id'].'</td>
	  <td><a href="https://icare.interblocks.com/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$result['ticket_id'].'"  target="_blank"  rel = "noopener noreferrer">'.$result['tn'].'</a></td>
	  <td>'.substr($result['title'],0,75).'</td>
	  <td>'.date('Y-m-d', strtotime($result['create_time'])).'</td>
	  <td><div class="tooltip1"><span class="tooltiptext1">'.$result['a_body'].'</span>'.substr($result['a_body'],0,75).'</div></td>
	  <td>'.$result['state'].'</td>
	  <td>'.$result['service'].'</td>
	  </tr>';
	  $count++;
	  }
	  
	
	
?>
	  </tbody>

</table>

</div>
</div>
			<script type="text/javascript">
   var php_var = "<?php echo $num_rows; 
     //mysqli_close($link);
	 ?>";
   document.getElementById("test1").innerHTML =php_var;
   </script>
</body>
</html> 
<?php
}else{
  header('Location: index.php');
} 
?>



