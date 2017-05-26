<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');

$user_ID = $_SESSION['user_ID'];
$old_password = MD5($_POST['old_password']);
$new_password = MD5($_POST['new_password']);


$query = "SELECT * FROM user WHERE (user_ID = '$user_ID' AND password = '$old_password')";
$result = mysql_query($query) or die(mysql_error());
if ($result = mysql_fetch_array($result))
{
	$query = "UPDATE user SET password = '$new_password' WHERE user_ID = '$user_ID'";
	mysql_query($query) or die(mysql_error());
	$_SESSION['password'] = $new_password;
	echo <<< EOT
	<script>
		alert("Done.");
		window.history.go(-1);
	</script>		
EOT;
}
else
	echo <<< EOT
	<script>
		alert("Wrong password.");
		window.history.go(-1);
	</script>
EOT;

?>


