<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php

// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrapcdn/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="googleapis/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
  <script src="bootstrapcdn/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
 
<link href="css/jquery-ui_themes_smoothness.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="bootstrapcdn/font-awesome/4.3.0/css/font-awesome.min.css" integrity="sha384-yNuQMX46Gcak2eQsUzmBYgJ3eBeWYNKhnjyiBqLd1vvtE9kuMtgw6bjwN8J0JauQ" crossorigin="anonymous">

<script src="jquery/jquery-1.9.1.js" integrity="sha384-+GtXzQ3eTCAK6MNrGmy3TcOujpxp7MnMAi6nvlvbZlETUcZeCk7TDwvlCw9RiV6R" crossorigin="anonymous"></script>

  <script src="jquery.com/ui/1.10.3/jquery-ui.js" integrity="sha384-Kv4u0J/5Vhwb62xGQP6LXO686+cmeHY3DPXG9uf265EghKCn2SRAKu9hcHb2FS+L" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="/resources/demos/style.css" />
  
<link rel="stylesheet" href="googleapis/font.css" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
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
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form1" id="form1" >
<div class="dropdown">
<button type="button" class="btn btn-default">Number of days</button>
<select  style="background:#45B649;" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" onchange="this.form.submit()" name="days">
<?php
for ($x = 2; $x <= 30; $x++) {
    //echo '<option value="'.$x.'">'.$x.'</option>';
	
	if ($x == $_POST['days']){
$selected = "selected=\"selected\""; } else { $selected = ""; }
echo "<option value=\"$x\" $selected>$x</option>";

} 
?>
</select>
</div>
</form>
 <div class="row">
        <div class="panel panel-primary filterable">
            <div style="background:#45B649;" class="panel-heading">

                <h3  class="panel-title">Pending Follow up CSR <span style=" padding-left:715px;">Number of CSR:</span ><span id="test1" style="float:right; padding-right:100px;"></span></h3>

                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
<table style="border: .25px solid #45B649;" class="table" cellpadding="0" cellspacing="0" border="0">
	
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
$query_pending="select t.tn,t.customer_id,t.title,a.article_type_id,a.id,a.a_body,a.ticket_id,t.ticket_state_id,a.create_time,s.name as service,
ts.name as state from article a
inner join
(select max(id) as maxid from article
where article_type_id in(1,2,9,10)
group by ticket_id
) maxart on maxart.maxid=a.id 
inner join ticket t
on a.ticket_id=t.id 
inner join ticket_state ts
on ts.id=t.ticket_state_id
inner join service s
on s.id=t.service_id
where t.ticket_state_id in(7,24,25,5,10) and t.customer_id not in('phl-ubp','swe-win') and t.create_time>'2014-11-10' and 
not (a.create_time>NOW() - INTERVAL $days DAY) order by t.tn desc";
}
else
{
$query_pending="select t.tn,t.customer_id,t.title,a.article_type_id,a.id,a.a_body,a.ticket_id,t.ticket_state_id,a.create_time,s.name as service,
ts.name as state from article a
inner join
(select max(id) as maxid from article
where article_type_id in(1,2,9,10)
group by ticket_id
) maxart on maxart.maxid=a.id 
inner join ticket t
on a.ticket_id=t.id 
inner join ticket_state ts
on ts.id=t.ticket_state_id
inner join service s
on s.id=t.service_id
where t.ticket_state_id in(7,24,25,15,10) and t.customer_id not in('phl-ubp','swe-win') and t.create_time>'2014-11-10' and 
not (a.create_time>NOW() - INTERVAL 2 DAY) order by t.tn desc";	
}
$query_pending_run=mysqli_query($connection,$query_pending);
$num_rows=mysqli_num_rows($query_pending_run);
	  while($result=mysqli_fetch_array($query_pending_run)){
	 echo '<tr>
	  <td>'.$count.'</td>
	  <td>'.$result['customer_id'].'</td>
	  <td><a href="https://127.0.0.1/otrs/index.pl?Action=AgentTicketZoom;TicketID='.$result['ticket_id'].'"  target="_blank"  rel = "noopener noreferrer">'.$result['tn'].'</a></td>
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



