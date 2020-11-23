<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); 
// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sla.css">
	<link rel="stylesheet" href="ums/css/main.css">
</head>
<body>
<header>
		<div class="appname">iCare Dashboard</div>
		<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<div class="container">
  <table class="striped">
    <thead>
      <tr>
        <th data-field="id" style="background-color: #f39c12;padding: 10px 0px 10px 0px;"></th>
        <th data-field="id"  style="background-color: #f39c12;padding: 10px 0px 10px 0px;">Name</th>
        <th data-field="id"  style="background-color: #f39c12;padding: 10px 0px 10px 0px;">Count</th>    

      </tr>
    </thead>
	<tbody>
  
     <?php
          $num=1;
     $row_query="select u.id as id,u.first_name from user u
				inner join sla_table s
				on u.id=s.updated_by
				group by s.updated_by order by first_name";
	$result_set=mysqli_query($connection,$row_query);
		while($result=mysqli_fetch_assoc($result_set)){
			$name=ucfirst($result['first_name']);
			$id=$result['id'];
			?>
			<tr>
        	<td><a href="#" id="show_<?php echo $num;?>"<i class="ion-plus"></i></a></td>
	        <?php
			$query_count="select u.first_name,count(s.updated_by) as count from user u
			inner join sla_table s
			on u.id=s.updated_by
			where u.first_name='$name'
			group by s.updated_by";
			$result_set2=mysqli_query($connection,$query_count);
			while($result2=mysqli_fetch_assoc($result_set2)){
			?>
				 <td style="padding: 10px 0px 10px 0px;"><?php echo ucfirst($result2['first_name']);?></td>
				 <td style="padding: 10px 0px 10px 0px;"><?php echo $result2['count']?></td>
			</tr>

			 <tr>
        <td colspan="3">
          <div id="extra_<?php echo $num;?>" style="display: none;" >
            
              <div >
               <table class="table table-fixed">
                  <tr><thead><th style="font-size: 14px;">CSR</th>
                    <th style="font-size: 14px;">Cx</th>
                    <th style="font-size: 14px;">State</th>
                    <th style="font-size: 14px;">Create Time</th>
                    <th style="font-size: 14px;">SLA State</th>
                    <th style="font-size: 14px;">Update Time</th></thead>
                  </tr><tbody >
              <?php

              $query="select t.tn,t.customer_id,ts.name as state,date(t.create_time) as create_time,if(s.sla_state=1,'Met','Not Met') as sla_state,s.update_time from ticket t
						inner join sla_table s
						on t.tn=s.tn
						inner join user u
						on u.id=s.updated_by
                        inner join ticket_state ts
                        on t.ticket_state_id=ts.id
						where s.updated_by=$id";
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



