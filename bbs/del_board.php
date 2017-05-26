<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!($_SESSION['default_permission'] >= PERM_ADMINISTRATOR))
	exit('Not enough permission.');

$board_ID = $_GET['board_ID'];
$board_ID = addslashes($board_ID);

$query = "SELECT post_ID FROM post WHERE board_ID = '$board_ID'";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($result))
{
	$post_ID = $row['post_ID'];
	$query = "DELETE FROM post_reply WHERE post_ID = '$post_ID'";
	mysql_query($query) or die(mysql_error());
}

$query = "DELETE FROM post WHERE board_ID = '$board_ID'";
mysql_query($query) or die(mysql_error());

$query = "DELETE FROM board WHERE board_ID = '$board_ID'";
mysql_query($query) or die(mysql_error());

$last_page = $_SERVER["HTTP_REFERER"];
header("location:$last_page");
?>
