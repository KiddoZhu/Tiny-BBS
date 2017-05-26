<?php

include('utils/constants.php');
include('utils/connect.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');

$username = $_POST['username'];
$username = addslashes($username);
$password = MD5($_POST['password']);

$query = "SELECT * FROM user WHERE (username = '$username' AND password = '$password')";
$result = mysql_query($query) or die(mysql_error());
if ($result = mysql_fetch_array($result))
{
	session_start();
	$_SESSION = $result;
	header('location:/bbs/home.php');
}
else
	echo <<< EOT
	<script>
		alert("Wrong user or password.");
		window.history.go(-1);
	</script>
EOT;
?>
