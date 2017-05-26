<?php

include('../utils/constants.php');
include('../utils/connect.php');
include('../utils/general.php');
	
$user_ID = $_SESSION['user_ID'];
$username = $_SESSION['username'];
$permission = $_SESSION['default_permission'];
$registration_time = $_SESSION['registration_time'];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>tiny bbs - <?php echo($username); ?></title>
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
			<h1 class="page-title"><?php echo($username); ?></h1>
			<p>
				Registration time : <?php echo($registration_time); ?>
			</p>
			<p>
				Default permission : <?php echo($perm_text[$permission]); ?>
			</p>
			<h2>Change password</h2>
			<form method="post" action="change_password.php" onSubmit="return InputCheck()">
				<p>
					<label for="old_password">Old password :</label>
					<input class="form-control" id="old_password" name="old_password" type="password" />
				</p>
				<p>
					<label for="new_password">New password :</label>
					<input class="form-control" id="new_password" name="new_password" type="password" />
				</p>
				<p>
					<label for="confirm">Confirm password :</label>
					<input class="form-control" class="form-control" id="confirm" type="password" />
				</p>
				<input class="btn" type="submit" name="submit" value="Change" />
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
	old_password = document.getElementById("old_password");
	new_password = document.getElementById("new_password");
	confirm = document.getElementById("confirm");
	if (old_password.value && new_password.value && (new_password.value == confirm.value))
		return true;
	if (!old_password.value)
		alert("Old password should not be empty.");
	if (!new_password.value)
		alert("New password should not be empty.");
	if (new_password.value != confirm.value)
		alert("Passwords should be consistent.");
	old_password.value = "";
	new_password.value = "";
	confirm.value = "";
	old_password.focus();
	return false;
}
</script>
