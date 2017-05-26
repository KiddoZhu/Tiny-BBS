<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');
	
$post_ID = $_POST['post_ID'];
$post_ID = addslashes($post_ID);
$board_ID = GetBoardID($post_ID);
$user_ID = $_SESSION['user_ID'];
$permission = GetPermission($user_ID, $board_ID);
if ($permission < PERM_USER)
	exit('Not enough permission.');

$content = $_POST['content'];
$content = addslashes($content);
$now = date('Y-m-d H:i:s', time());
$query = "INSERT INTO post_reply(user_ID, post_ID, create_time, content) ";
$query .= "VALUES ('$user_ID', '$post_ID', '$now', '$content')";
mysql_query($query) or die(mysql_error());

$query = "UPDATE post SET last_update = '$now' WHERE post_ID = '$post_ID'";
mysql_query($query) or die(mysql_error());

header("location:post.php?post_ID=$post_ID");
?>


