<?php session_start(); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/icaredashboard/ums/inc/connection.php'); ?>
<?php

/*if(!isset($_SESSION['user_id'])){
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
	
if($access==1){*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/agent_wise.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<header>
	<div class="appname">iCare Dashboard</div>
	<div class="loggedin">Welcome <?php echo ucfirst($_SESSION['first_name']); ?>! <a href="ums/logout.php">Log Out</a></div>
</header>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header btn btn-danger">
                <span>CSR count breakdown agent wise in terms of banks assigned</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group date">
                            <form id="subform" autocomplete="off">
                                <input type="date" id="cutoff_date" name="cutoff_date">
                                <input type="submit" name="submit" id="submit" value="GO" class="btn btn-warning">
                            </form>
                        </div>
                        <div id="test">
                            jjk
                            <div id="processing">
                                <img src="img/processing.gif" id="image">
                                <p>Processing....</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        $(document).ready(function(){
            $("#processing").addClass("hidden");
            $("#submit").click(function(event){
                event.preventDefault();
                //$("#processing").removeClass("hidden");
                var formData=$("#subform").serialize();
                //console.log("formData");
                $.post(
                    "ajax2.php",
                    //formData,  
                    {cdate:$("#cutoff_date").val()},                  
                    function(data,status){
                        if(status=="success"){
                            //console.log('ok');
                           
                        }
                    }
                );
                $("#test").load("ajax2.php",function(data,status){
                                if(status=="success"){
                                   // $("#processing").addClass("hidden");
                                    console.log(status+2); 
                                }
                            });
                //$("#test").load("agent_wise.php",function(data,status){
                //if(status=="success"){
                   // $("#processing").addClass("hidden");
               // }
           // });
            })         
        });
    
    </script>
</html>