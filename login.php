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

		<?php require_once("includes/head.php"); ?>
		<link rel="stylesheet" href="css/styles.css">
        <!-- jQuery CDN -->
</head>
<body>

	<!-- call header here  -->
	<?php require_once("includes/header.php"); ?>
	
	<br><br>
	<!-- call navbar here  -->
    <?php require_once("includes/navbar.php"); ?>
	<br>

    <div class="container">
        <div class="row">
                <form method="post">
                    <div class="user">
                <label for="secondname">Email</label>
                <input type="text" class="form" id="email" name="email"
                <?php displayValue($_POST, 'email'); ?> />
                <?php displayError($errors, 'email'); ?>
                </div>
					<!-- Verify email and password  -->
                <div class="user">
                <label for="phone">Password</label>
                <input type="password" class="form" id="password" name="password" />
                <?php displayError($errors, 'password'); ?>
                </div>
                <button type="submit" class="btnlogin" name="login" value="login">Login</button>
            </form>
        </div>
		
			<!-- call footer here  -->
        <?php require_once('includes/footer.php'); ?>
    </div>
</body>
</html>
