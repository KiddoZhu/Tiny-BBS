<?php

session_start();
if (!isset($_SESSION['user_ID']))
	exit("Illegal call to this page.");

function ShowUser()
{
	$username = $_SESSION['username'];
	echo("Identity: $username");
}

function ShowUserManagement($permission)
{
	if ($permission >= PERM_MODERATOR)
		echo("<a href=\"/user/manage.php\">User Manage</a>");
}

function GetPermission($user_ID, $board_ID)
{
	$query = "SELECT permission FROM rule WHERE (user_ID = '$user_ID' AND board_ID = '$board_ID')";
	$result = mysql_query($query) or die(mysql_error());
	$permission = mysql_fetch_array($result)['permission'];
	if (!$permission)
		$permission = $_SESSION['default_permission'];
	return $permission;
}

function GetBoardID($post_ID)
{
	$query = "SELECT board_ID FROM post WHERE post_ID = '$post_ID'";
	$result = mysql_query($query) or die(mysql_error());
	return mysql_fetch_array($result)['board_ID'];
}

function GetBoard_name($board_ID)
{
	$query = "SELECT board_name FROM board WHERE board_ID = '$board_ID'";
	$result = mysql_query($query) or die(mysql_error());
	return mysql_fetch_array($result)['board_name'];
}

function GetUsername($user_ID)
{
	$query = "SELECT username FROM user WHERE user_ID = '$user_ID'";
	$result = mysql_query($query) or die(mysql_error());
	return mysql_fetch_array($result)['username'];
}

?>
