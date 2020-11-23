<?php session_start();?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php
//$user_query="select id,user_name from user_view";
$module_query="select * from modules_view";
//$user_query_run=mysqli_query($connection,$user_query);
$module_query_run=mysqli_query($connection,$module_query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
	
	
	<?php
	if(isset($_GET["id"])){
		$id=$_GET["id"];		
	}

	?>
	<?php
	$module_id="";
	if(isset($_GET['submit'])){
		 $module_ids=$_GET['chk'];
		foreach ($module_ids as $chk){ 
    	$module_id.= $chk.",";    	
    }	
    	$module_id=substr($module_id, 0, -1);    	
    	$user_id=$_GET['user_id'];

    	if(isset($_GET['m_ids']) && $_GET['m_ids']!='' ){
    		$deselect_mids=substr($_GET['m_ids'],0,-1);
    		$update_query2="update module_access_view set access=0 where user_id=$user_id and module_id in($deselect_mids)";
    		$update_query2_run=mysqli_query($connection,$update_query2);
    	}
   	
    		$update_query="update module_access_view set access=1 where user_id=$user_id and module_id in($module_id)";
    		$update_query_run=mysqli_query($connection,$update_query);
    	
    		?>
    		<script type="text/javascript">
    			alert("User access updated");
    			window.location="admin.php";
    		</script>
    	
	<?php }else{?>

<div id="wrapper">
	<form method="GET" action="admin2.php">
		<table class="table">
			<th colspan="2">Module</th>		
			<?php while($module_result=mysqli_fetch_array($module_query_run)){?>
			<tr>
			<?php $module_id="";?>
				<td><input type="hidden" value="<?php echo $module_id=$module_result['module_id']; ?>"><?php echo $module_result['module_name']; ?></td>
				<?php $module_select="select access from module_access_view where user_id=$id and module_id=$module_id"; 
					$module_select_run=mysqli_query($connection,$module_select);
					$access=0;
					while($module_select_result=mysqli_fetch_array($module_select_run)){
						$access=$module_select_result['access'];
						if($access==1){ ?>
						<td><input type="checkbox" id="ch" name="chk[]" value="<?php echo $module_id=$module_result['module_id']; ?>" checked></td>
						<?php }else{?>
						<td><input type="checkbox" name="chk[]" value="<?php echo $module_id;?>"></td>
						<?php }
					} ?>	

			</tr>
		<?php }?>
		</table>
		<input type="hidden" name="user_id" value="<?php echo $id; ?>">
		<input type="hidden" id="mid" name="m_ids">
		<input type="submit" name="submit" value="Submit" class="submit">
	</form>
</div>

	<script type="text/javascript">
		 $('input[type=checkbox]').click(function () {
	
	var mids=($(this).attr("value"));
	document.getElementById("mid").value+=mids+",";


	});
	</script>
	<?php }?>
	
 

</body>
</html>