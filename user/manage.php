<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');

if ($_SESSION['default_permission'] < PERM_MODERATOR)
	exit('Not enough permission.');

function ShowRules($permission)
{
	global $perm_text;
	
	if ($permission >= PERM_MODERATOR)
	{
		$query = "SELECT * FROM rule ORDER BY user_ID, board_ID";
		$result = mysql_query($query) or die(mysql_error());
		echo <<< EOT
		<h1>Rule manage</h1>
		<table>
			<tr>
				<td>User ID</td> <td>User name</td> <td>Board ID</td> <td>Board name</td> <td>Permission</td> <td></td>
			</tr>
EOT;
		while ($row = mysql_fetch_array($result))
		{
			$user_ID = $row['user_ID'];
			$username = GetUsername($user_ID);
			$board_ID = $row['board_ID'];
			$board_name = GetBoard_name($board_ID);
			$permission = $perm_text[$row['permission']];
			echo <<< EOT
			<tr>
				<td>$user_ID</td> <td>$username</td> <td>$board_ID</td> <td>$board_name</td> <td>$permission</td>
				<td><button class="btn" onClick="window.location.href='del_rule.php?user_ID=$user_ID&board_ID=$board_ID'">Delete</button></td>
			</tr>
EOT;
		}
		echo("</table>");
	}
}

function ShowRuleInput($permission)
{	
	if ($permission >= PERM_MODERATOR)
	{
		global $perm_options;
	
		$query = "SELECT * FROM user ORDER BY user_ID";
		$result = mysql_query($query) or die(mysql_error());
		$user_options = '';
		while ($row = mysql_fetch_array($result))
		{
			$user_ID = $row['user_ID'];
			$username = $row['username'];
			$user_options .= "<option value=$user_ID>$username</option>\n";
		}
	
		$query = "SELECT * FROM board ORDER BY board_ID";
		$result = mysql_query($query) or die(mysql_error());
		$board_options = '';
		while ($row = mysql_fetch_array($result))
		{
			$board_ID = $row['board_ID'];
			$board_name = $row['board_name'];
			$board_options .= "<option value=$board_ID>$board_name</option>\n";
		}
		
		echo <<< EOT
		<h2>New rule</h2>
		<form method="post" action="add_rule.php" onSubmit="return InputCheck()">
			<label for="username">Username :</label>
			<select class="form-control" id="username" name="user_ID">
				$user_options
			</select>&nbsp;&nbsp;
			<label for="board_name">Board name :</label>
			<select class="form-control" id="board_name" name="board_ID">
				$board_options
			</select>&nbsp;&nbsp;
			<label for="permission">Permission :</label>
			<select class="form-control" id="permission" name="permission">
				$perm_options
			</select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="btn" type="submit" name="submit" value="Add" />
		</form>
EOT;
	}
}

function ShowUsers($permission)
{
	global $perm_text;

	if ($permission >= PERM_ADMINISTRATOR)
	{
		echo <<< EOT
		<h1>User manage</h1>
		<table>
			<tr>
				<td>User ID</td> <td>User name</td> <td>Registration time</td> <td>Default permission</td>
				<td><button class="btn" onClick="window.location.href=window.location.href">Restore</button></td>
			</tr>
EOT;
		$query = "SELECT * FROM user ORDER BY user_ID";
		$result = mysql_query($query) or die(mysql_error());
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			$user_ID = $row['user_ID'];
			$username = $row['username'];
			$registration_time = $row['registration_time'];
			$permission = $row['default_permission'];
			$i++;
			$options = '';
			for ($j = 1; $j < count($perm_text); $j++)
				if ($j == $permission)
					$options .= "<option value=$j selected=\"selected\">${perm_text[$j]}</option>\n";
				else
					$options .= "<option value=$j>${perm_text[$j]}</option>\n";
			echo <<< EOT
			<tr>
				<form method="post" action="change_permission.php">
					<input type="hidden" name="user_ID" value=$user_ID />
					<td>$user_ID</td> <td>$username</td> <td>$registration_time</td>
					<td>
						<select class="form-control" id="permission_$i" name="permission" autoComplete="off" onChange="document.getElementById('submit_$i').disabled=false">
							$options
						</select>
					</td>
					<td><button class="btn" id="submit_$i" name="submit" disabled=true>Commit</button></td>
				</form>
			</tr>
EOT;
		}
		echo("</table>");
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>tiny bbs - user manage</title>
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
			<?php ShowRules($_SESSION['default_permission']); ?>
			<?php ShowRuleInput($_SESSION['default_permission']); ?>
			<?php ShowUsers($_SESSION['default_permission']); ?>			
			<footer class="footer">
				Designed by Kiddo Zhu
			</footer>
		</div>
	</body>
</html>
