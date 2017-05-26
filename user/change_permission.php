<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');
if ($_SESSION['default_permission'] < PERM_ADMINISTRATOR)
	exit('Not enough permission.');

$user_ID = $_POST['user_ID'];
$user_ID = addslashes($user_ID);
$permission = $_POST['permission'];
$permission = intval($permission);
if (!$permission)
	exit('Illegal call to this page.');	

$query = "UPDATE user SET default_permission = '$permission' WHERE user_ID = '$user_ID'";
mysql_query($query) or die(mysql_error());

$last_page = $_SERVER["HTTP_REFERER"];
header("location:$last_page");
?>
