<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');
if ($_SESSION['default_permission'] < PERM_MODERATOR)
	exit('Not enough permission.');

$user_ID = $_POST['user_ID'];
$user_ID = addslashes($user_ID);
$board_ID = $_POST['board_ID'];
$board_ID = addslashes($board_ID);
$permission = $_POST['permission'];
$permission = addslashes($permission);

$query = "INSERT INTO rule VALUES('$user_ID', '$board_ID', '$permission') ";
mysql_query($query) or die(mysql_error());

$last_page = $_SERVER["HTTP_REFERER"];
header("location:$last_page");
?>
