<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_POST['submit']))
	exit('Illegal call to this page.');
	
$board_ID = $_POST['board_ID'];
$board_ID = addslashes($board_ID);
$user_ID = $_SESSION['user_ID'];
$permission = GetPermission($user_ID, $board_ID);
if ($permission < PERM_USER)
	exit('Not enough permission.');

$post_name = $_POST['title'];
$post_name = addslashes($post_name);
$content = $_POST['content'];
$content = addslashes($content);
$now = date('Y-m-d H:i:s', time());
$query = "INSERT INTO post(user_ID, board_ID, post_name, create_time, content) ";
$query .= "VALUES ('$user_ID', '$board_ID', '$post_name', '$now', '$content')";

mysql_query($query) or die(mysql_error());
$result = mysql_query('SELECT last_insert_id()');
$post_ID = mysql_fetch_array($result)['last_insert_id()'];

header("location:post.php?post_ID=$post_ID");
?>


