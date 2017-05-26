<?php

include("utils/constants.php");

$options = '';
for ($i = 1; $i < count($perm_text); $i++)
	if ($i == 2)
		$options .= "<option value=$i selected=\"selected\">${perm_text[$i]}</option>\n";
	else
		$options .= "<option value=$i>${perm_text[$i]}</option>\n";
?>

<!DOCTYPE html>
<html>
	<meta charset="utf8">
	<head>
		<title>tiny bbs - register</title>
		<link href="/css/style.css" rel="stylesheet" />
	</head>
	<body onLoad="PermissionText(document.getElementById('permission'))">
		<header class="masthead">
			<div class="container">
				<div class="masthead-logo">
					tiny bbs
				</div>
				<nav class="masthead-nav">
					<a href="/index.html">Back</a>
				</nav>
			</div>
		</header>
		
		<div class="container markdown-body">
			<h1 class="page-title">Register a new account</h1>
			<form method="post" action="_register.php" onSubmit="return InputCheck()">
				<p>
					<label for="username">Username :</label>
					<input class="form-control" id="username" name="username" type="text" />
				</p>
				<p>
					<label for="password">Password :</label>
					<input class="form-control" id="password" name="password" type="password" />
				</p>
				<p>
					<label for="confirm">Confirm password :</label>
					<input class="form-control" class="form-control" id="confirm" type="password" />
				</p>
				<p>
					<label for="permission">Default permission :</label>
					<select class="form-control" id="permission" name="permission" autoComplete="off" onChange="PermissionText(this)">
						<?php echo($options); ?>
					</select>
				</p>
				<p><div id="describe"></div></p>
				<input class="btn" type="submit" name="submit" value="Register" />
			</form>
			<footer class="footer">
				Designed by Kiddo Zhu
			</footer>
		</div>
	</body>
</html>
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
<script>
function InputCheck()
{
	username = document.getElementById("username");
	password = document.getElementById("password");
	confirm = document.getElementById("confirm");
	if (!username.value)
	{
		alert("User name should not be empty.");
		username.focus();
		return false;
	}
	if (!password.value)
	{
		alert("Password should not be empty.");
		password.value = "";
		confirm.value = "";
		password.focus();
		return false;
	}
	if (password.value != confirm.value)
	{
		alert("Passwords should be consistent.");
		password.value = "";
		confirm.value = "";
		password.focus();
		return false;
	}
	return true;
}

function PermissionText(select)
{
	perm2text = new Array();
	perm2text[0] = "A tourist can only read posts.";
	perm2text[1] = "A user can read, create posts, but cannot delete posts of others.";
	perm2text[2] = "A moderator can read, create and delete posts.";
	perm2text[3] = "An administrator can read, create and delete posts. \
					An administrator can also manage the status of others.";
	document.getElementById("describe").innerHTML = perm2text[select.selectedIndex];
}
</script>
