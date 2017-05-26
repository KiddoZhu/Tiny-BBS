<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if ($_SESSION['default_permission'] < PERM_MODERATOR)
	exit('Not enough permission.');

$user_ID = $_GET['user_ID'];
$user_ID = addslashes($user_ID);
$board_ID = $_GET['board_ID'];
$board_ID = addslashes($board_ID);
	
$query = "DELETE FROM rule WHERE (user_ID = '$user_ID' and board_ID = '$board_ID')";
mysql_query($query) or die(mysql_error());

$last_page = $_SERVER["HTTP_REFERER"];
header("location:$last_page");
?>
