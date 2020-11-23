<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
$user_query="select id,user_name from user_view where user_name!=''";
//$module_query="select * from modules_view";
$user_query_run=mysqli_query($connection,$user_query);
//$module_query_run=mysqli_query($connection,$module_query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
	<div id="wrapper">
		<table class="table">
			<th>Username</th>		
			<?php while($user_result=mysqli_fetch_array($user_query_run)){?>
			<tr>	
				<td><input type="hidden" value="<?php echo $user_result['id']; ?>" width="0px">
					<a href="./admin2.php?id=<?php echo $user_result['id']; ?>"><?php echo $user_result['user_name'];?></a></td>
			</tr>
		<?php }?>
		</table>
	</div>
</body>
</html>
