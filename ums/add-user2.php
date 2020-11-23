<?php session_start(); 

ini_set('display_errors',1);
error_reporting(-1);
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/connection.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/icaredashboard/ums/inc/functions.php'); ?>
<?php 



	// checking if a user is logged in
	// if (!isset($_SESSION['user_id'])) {
		// header('Location: index.php');
	// }

	$errors = array();
	$first_name = '';
	$user_name = '';
	$email = '';
	$password = '';


	if (isset($_POST['submit'])) {


		
		$first_name = $_POST['first_name'];
		$user_name = $_POST['user_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// checking required fields
		$req_fields = array('first_name', 'user_name', 'email', 'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'user_name' =>100, 'email' => 100, 'password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM user_view WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($errors)) {



			
			// no errors found... adding new record
			$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
			$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			// email address is already sanitized
			$hashed_password = sha1($password);

			$query = "INSERT INTO user_view ( ";
			$query .= "first_name, user_name, email, password, is_deleted";
			$query .= ") VALUES (";
			$query .= "'{$first_name}', '{$user_name}', '{$email}', '{$hashed_password}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

echo "<script type='text/javascript'>
window.onload = function()
{
    if (window.jQuery)
    {
        $('#thankyouModal').modal('show');
    }
    
}
</script>";


			if ($result) {
   

				// query successful... redirecting to users page
				//header('Location: add-user2.php?user_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
			}


		}



	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New User</title>
	 
	<link href="\icaredashboard/libraries/cloudflare/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet" type="text/css" > 
	<script src="\icaredashboard/libraries/googleapis/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<link rel="stylesheet" href="css/main.css">



</head>
<body>


	<main>
		<h2 align="center">Add New User<span> <a href="index2.php">< Back</a></span></h2><br>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		
			
			<div class="container">
			  <form class="form-horizontal" role="form" action="add-user2.php" method="post">
                <div class="form-group">
                    <label for="firstName" class="col-sm-3 control-label">First Name</label>
                    <div class="col-sm-4">
                        <input type="text" id="firstName" name="first_name" placeholder="First Name" class="form-control" autofocus>                        
                    </div>
                </div>
               <div class="form-group">
                    <label for="userName" class="col-sm-3 control-label">User Name</label>
                    <div class="col-sm-4">
                        <input type="text" id="userName" name="user_name" placeholder="Last Name" class="form-control" autofocus>                        
                    </div>
                </div>
               <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" id="email" name="email" placeholder="Email" class="form-control" autofocus>                        
                    </div>
                </div>
               <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-4">
                        <input type="password" id="password" name="password" placeholder="Password" class="form-control" autofocus>                        
                    </div>
                </div>
               
               
                
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign up</button>
                    </div>
                </div>
            </form> <!-- /form -->
        </div> <!-- ./container -->



<div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Sign up Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Sign up Successful! Click back to Sign in</p>                     
            </div>    
        </div>
    </div>
</div>


		
		
	</main>
</body>
</html>
