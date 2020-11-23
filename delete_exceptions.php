<?php
session_start();
$mysql_host='192.168.1.180';
$mysql_user='prayadarshan';
$mysql_pw='ib1234';
$conn_err='Could not connect';
$mysql_db='otrs';


if(!@mysql_connect($mysql_host,$mysql_user,$mysql_pw) || !@mysql_select_db($mysql_db)) 
{
	die($conn_err);
}

echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600" integrity="sha384-SwJ8IKu+475JgxrHPUzIvbbV+++NEwuWjwVfKbFJd5Eeh4xURT0ipMWmJtTzKUZ+" crossorigin="anonymous">
 <link href="css/main3.css" rel="stylesheet">';

echo '<form method="POST" action="delete_exceptions.php">';
$query="select tn from exceptions";
$query_run=mysql_query($query);
echo '<p>Current Exception CSR List </p>';
echo '<table><tr>';
while($result=mysql_fetch_array($query_run))
{
	echo '<td>'.$result[0].'<td></tr>';
}
echo '</table><br>';


echo'Enter the CSR # to Delete: <input type="text" name="tn">';
echo '<input type="submit" value="Delete" name="submit" class="button"><br>';

if(isset($_POST['submit']) && isset($_POST['tn']))
{
	$tn=$_POST['tn'];
	$sql = "DELETE FROM exceptions WHERE tn='$tn'";
	$result = mysql_query($sql);

	echo "<script type='text/javascript'>alert('Successfully deleted from the exception list!');
window.location.href = 'delete_exceptions.php';
</script>";
	
}
?>