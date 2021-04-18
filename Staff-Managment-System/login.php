<?php require_once('includes/functions.php'); ?>
<?php
    $errors = [];
    if(isset($_POST['login'])) {
        $errors = loginUser($_POST);

        if(count($errors) === 0) {
	echo "<script>alert('Login success');parent.location.href='manage.php';</script>";
            exit();
        }
    }
?>
<!DOCTYPE html><html lang="en">
<head>

</head>
<body>


    <div class="container">
    <h1>Login</h1>
        <div class="row">
                <form method="post">
                    <div class="user">
                <label for="secondname">Email</label>
                <input type="text" id="email" name="email"
                <?php displayValue($_POST, 'email'); ?> />
                <?php displayError($errors, 'email'); ?>
                </div>
					<!-- Verify email and password  -->
                <div class="user">
                <label>Password</label>
                <input type="password"id="password" name="password" />
                <?php displayError($errors, 'password'); ?>
                </div>
                <button type="submit" class="btnlogin" name="login" value="login">Login</button>
                
            </form>
        </div>
        <a href="register.php"><button type="submit" name="register" value="register">Register Now</button></a>
		
    </div>
</body>
</html>
