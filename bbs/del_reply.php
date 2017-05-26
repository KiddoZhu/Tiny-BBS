<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

$reply_ID = $_GET['reply_ID'];
$reply_ID = addslashes($reply_ID);
$query = "SELECT * FROM post_reply WHERE reply_ID = '$reply_ID'";
$result = mysql_query($query) or die(mysql_error());
$result = mysql_fetch_array($result);
$post_ID = $result['post_ID'];
$author_ID = $result['user_ID'];
$user_ID = $_SESSION['user_ID'];
$board_ID = GetBoardID($post_ID);
$permission = GetPermission($user_ID, $board_ID);
if (($permission < PERM_MODERATOR) and ($user_ID != $author_ID))
	exit('Not enough permission.');
	
$query = "DELETE FROM post_reply WHERE reply_ID = '$reply_ID'";
mysql_query($query) or die(mysql_error());

$last_page = $_SERVER["HTTP_REFERER"];
header("location:$last_page");
?>
