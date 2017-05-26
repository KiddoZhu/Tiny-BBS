<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if (!isset($_GET['post_ID']))
	exit('Illegal call to this page.');

$post_ID = $_GET['post_ID'];
$post_ID = addslashes($post_ID);
$user_ID = $_SESSION['user_ID'];
$query = "SELECT * FROM post WHERE post_ID = '$post_ID'";
$result = mysql_query($query) or die(mysql_error());
if ($result = mysql_fetch_array($result))
{
	$board_ID = $result['board_ID'];
	$post_name = $result['post_name'];
	$content = $result['content'];
	$create_time = $result['create_time'];
	$post_user_ID = $result['user_ID'];
}
else
	exit("No board found for PID=$post_ID.");
$permission = GetPermission($user_ID, $board_ID);

function PrintReply($author_ID, $create_time, $content, $user_ID, $permission, $reply_ID=0)
{
	global $post_user_ID;
	static $count = 0;
	
	$author_name = GetUsername($author_ID);
	if ($count == 0)
		$id = "Host &nbsp;";
	else if ($count == 1)
		$id = "$count<sup>st</sup> floor &nbsp;";
	else if ($count == 2)
		$id = "$count<sup>nd</sup> floor &nbsp;";
	else if ($count == 3)
		$id = "$count<sup>rd</sup> floor &nbsp;";
	else
		$id = "$count<sup>th</sup> floor &nbsp;";
	if ($count and ($author_ID == $post_user_ID))
		$prefix = "[Host] ";
	if ($reply_ID and (($permission >= PERM_MODERATOR) or ($user_ID == $author_ID)))
		$control = "<button style=\"float:right\" class=\"btn btn-sm btn-danger\" onClick=\"ConfirmDelete($reply_ID)\">Delete</button>";
	echo <<< EOT
	<p class="lead">
		$id $prefix$author_name &nbsp;&nbsp;&nbsp;&nbsp; $create_time
		$control
	</p>
	<p>
		$content
	</p>
EOT;
	$count++;
}

function ShowReplies($post_ID, $user_ID, $permission)
{
	$query = "SELECT * FROM post_reply WHERE post_ID = '$post_ID' ORDER BY create_time";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result))
	{
		echo("<h2></h2>\n");
		PrintReply($row['user_ID'], $row['create_time'], $row['content'], $user_ID, $permission, $row['reply_ID']);
	}
}

function ShowReplyInput($post_ID, $permission)
{
	if ($permission >= PERM_USER)
		echo <<< EOT
		<h2>Reply</h2>
		<form method="post" action="add_reply.php" onSubmit="return InputCheck()">
			<input type="hidden" name="post_ID" value=$post_ID />
			<p>
				<textarea class="form-control input-block" id="content" name="content" rows=6></textarea>
			</p>
			<input class="btn btn-primary" type="submit" name="submit" value="Post!">
		</form>
EOT;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>tiny bbs - <?php echo($post_name); ?></title>
		<link href="/css/style.css" rel="stylesheet" />
	</head>
	<body>
		<header class="masthead">
			<div class="container">
				<div class="masthead-logo">
					tiny bbs
				</div>
				<nav class="masthead-nav">
					<a href="/bbs/home.php">Home</a>
					<?php ShowUserManagement($_SESSION['default_permission']); ?>
					<a href="/user/user_info.php"><?php ShowUser(); ?></a>
					<a href="/logout.php">Log out</a>
				</nav>
			</div>
		</header>
		
		<div class="container markdown-body">
			<h1 class="page-title"><?php echo($post_name); ?></h1>
			<?php PrintReply($post_user_ID, $create_time, $content, $user_ID, $permission); ?>
			<?php ShowReplies($post_ID, $user_ID, $permission); ?>
			<?php ShowReplyInput($post_ID, $permission); ?>
			<footer class="footer">
				Designed by Kiddo Zhu
			</footer>
		</div>
	</body>
</html>

<script>
function ConfirmDelete(reply_ID)
{
	if (confirm("Do you really want to delete this reply?"))
		window.location.href = "del_reply.php?reply_ID=" + reply_ID;
}

function InputCheck()
{
	content = document.getElementById("content");
	if (!content.value)
	{
		alert("Content should not be empty.");
		content.focus();
		return false;
	}
	return true;
}
</script>
