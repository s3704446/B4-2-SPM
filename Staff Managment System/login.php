<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
<?php
include'display/login-display.php';
?>
<form id="loginform" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='post'>
<h1>Login</h1>
<br>
<label>Username:</label>
<input class="loginput" type="text" name="username" required>
<br><br>
<label>password:</label>
<input class="loginput" type="password" name="password" required>
<br><br>
<input id="login" type="submit" name="login" value="login">
</form>
<?php
if(isset($_POST['login'])) {$username = $_POST['username'];
    $password = $_POST['password'];
	if(!empty($username)  || !empty($password))  {
	if ($user->checkLogin($username, $password)) {
	header('Location: staff-management.php');
	exit();
	} else {
	echo "Your username or password is incorrect";
	}
	}
	}
	?>
</body>
</html>