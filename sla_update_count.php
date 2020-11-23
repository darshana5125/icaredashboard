<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); 
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
	<title>Document</title>
<!--link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css"-->
	<link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/ionicframework/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/bootstrapcdn/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="\icaredashboard/libraries/cloudflare/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="\icaredashboard/libraries/cloudflare/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sla.css">
	<link rel="stylesheet" href="ums/css/main.css">
	<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/jquery/1/jquery.min.js"></script>

<!--script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/momentjs/latest/moment.min.js"></script>


<!--link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css"-->
<link rel="stylesheet" type="text/css" href="\icaredashboard/libraries/jsdelivr/bootstrap/3/css/bootstrap.css"-->

 
<!-- Include Date Range Picker -->
<!--script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script-->
<script type="text/javascript" src="\icaredashboard/libraries/jsdelivr/bootstrap.daterangepicker/2/daterangepicker.js"></script>


<!--link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"-->
<link rel="stylesheet" type="text/css" href="\icaredashboard\libraries/jsdelivr/bootstrap.daterangepicker/2/daterangepicker.css">




  
    <script src="\icaredashboard/sorter/sorter.js"></script>
    <link href="\icaredashboard/sorter/sorter.css" rel="stylesheet">
</head>
<body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>





<form action="sla_update_count.php?mid=12" method="post">

<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
    <span name="report></span> <b class="caret"></b>
</div>
<input type="hidden" id="test1" name="startdate">
<input type="hidden" id="test2" name="enddate">
<input type="submit" name="submit" value="OK" class="btn btn-secondary">

</form>

<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    var fulldate="";
    var sdate="";
    var edate="";

    function cb(start, end) {
        fulldate=$('#reportrange span').html(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        sdate=fulldate.html().slice(0, 10);
        edate=fulldate.html().slice(14, 24);
          $("#test1").val(sdate); 
          $("#test2").val(edate);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }


    }, cb);

    cb(start, end);

   
    
});

</script>

<?php
	 
	 if(isset($_POST['submit'])){
?>
<div>
  <table style="width:80%; margin:0 auto;">
    <thead>
      <tr>
        <th  style="background-color: #f39c12;padding: 10px 0px 10px 0px;"></th>
        <th   style="background-color: #f39c12;padding: 10px 0px 10px 0px;">Name</th>
        <th   style="background-color: #f39c12;padding: 10px 0px 10px 0px;">Count</th>    

      </tr>
    </thead>
	<tbody>
  
 <?php    
  //echo "test";
  $s_date=$_POST['startdate'];
  $e_date=$_POST['enddate'];
	 
  
          $num=1;
     $row_query="select u.id as id,u.first_name from user_view u
				inner join servicelevel_view s
				on u.id=s.updated_by
				group by s.updated_by order by first_name";
	$result_set=mysqli_query($connection,$row_query);
	?>
			 <script>
        $(function() {
			 
			$('.tablesorter').tablesorter(); 
				
        });
			</script>
			
			<?php
		while($result=mysqli_fetch_assoc($result_set)){
			$name=ucfirst($result['first_name']);
			$id=$result['id'];
			?>
			
		
			<tr>
        	<td><a href="#" id="show_<?php echo $num;?>"<i class="ion-plus"></i></a></td>
	        <?php
			$query_count="select u.first_name,count(s.updated_by) as count from user_view u
			inner join servicelevel_view s
			on u.id=s.updated_by
			where u.first_name='$name' 
			and s.update_time between '$s_date 00:00:00' and '$e_date 23:59:59'
			group by s.updated_by";
			$result_set2=mysqli_query($connection,$query_count);
			?>
			
			<?php
			while($result2=mysqli_fetch_assoc($result_set2)){
			?>
		
				 <td style="padding: 10px 0px 10px 0px;"><?php echo ucfirst($result2['first_name']);?></td>
				 <td style="padding: 10px 0px 10px 0px;"><?php echo $result2['count']?></td>
			</tr>

			 <tr>
        <td colspan="3">
          <div id="extra_<?php echo $num;?>" style="display: none;" >
            
              <div >
			   		
               <table class="tablesorter table table-fixed">
                  <tr><thead><th style="font-size: 14px;">CSR</th>
                    <th style="font-size: 14px;">Cx</th>
                    <th style="font-size: 14px;">State</th>
                    <th style="font-size: 14px;">Create Time</th>
                    <th style="font-size: 14px;">SLA State</th>
                    <th style="font-size: 14px;">Update Time</th></thead>
                  </tr><tbody >
              <?php

              $query="select t.tn,t.customer_id,ts.name as state,date(t.create_time) as create_time,if(s.sla_state=1,'Met','Not Met') as sla_state,s.update_time from issue_view t
						inner join servicelevel_view s
						on t.tn=s.tn
						inner join user_view u
						on u.id=s.updated_by
                        inner join issuestate_view ts
                        on t.ticket_state_id=ts.id
						where s.updated_by=$id and s.update_time between '$s_date 00:00:00' and '$e_date 23:59:59'
						order by s.update_time desc";
				$result_set3=mysqli_query($connection,$query);
				while($result3=mysqli_fetch_assoc($result_set3)){
				?>
               
                  <tr>
                	 <td style="font-size: 12px;"><?php echo $result3['tn']?></td>
                	 <td style="font-size: 12px;"><?php echo $result3['customer_id']?></td>
                	 <td style="font-size: 12px;"><?php echo $result3['state']?></td>
                	 <td style="font-size: 12px;"><?php echo $result3['create_time']?></td>
                	 <td style="font-size: 12px;"><?php echo $result3['sla_state']?></td>
                	 <td style="font-size: 12px;"><?php echo $result3['update_time']?></td>
                
                  </tr>
                  <?php
              		}
                  ?>
                  </tbody>
                </table>
								
              </div>
              
              
            </div>


          
        </td>
      </tr>         


	        <?php
			
			}

			?>    
             
           <?php
           $num++;
		   
		}
	 }
     ?>
     </tbody>

  </table>
</div>
  
      


<script type="text/javascript">
$("a[id^=show_]").click(function(event) {
 $("#extra_" + $(this).attr('id').substr(5)).slideToggle("slow");
 event.preventDefault();
})
</script>
</body>
</html>
<?php
}else{
  header('Location: index.php');
} 
?>



