<?php require_once('includes/functions.php'); ?>
<?php
    $errors = [];
    if(isset($_POST['position'])) {
        if ($_POST['position'] == 'User') {
            $errors = loginUser($_POST);
        }
        else if ($_POST['position'] == 'Staff'){
            $errors = loginStaff($_POST);
        }

        if(count($errors) === 0) {
            echo "<script>alert('Login success');parent.location.href='manage.php';</script>";
            exit();
        }
    }
?>
<!DOCTYPE html><html lang="en">
<head>
        <link rel="stylesheet" href="css/styles.css">
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
                    <div class="user">
                        <label>Position</label>
                        <input style="    /* width: 20%; */
    padding: 12px 20px;
    /* margin: 4px 0; */
    box-sizing: border-box;
    border: 2px solid black;
    border-radius: 4px;
    margin-left: 550px;" type="radio" name="position" value="User" />Manager
                        <input type="radio" name="position" value="Staff" />Staff
                    </div>
                <button type="submit" class="btnlogin" name="login" value="login">Login</button>
                
            </form>
        </div>
        <a href="register.php"><button type="submit" name="register" value="register">Manager Register Now</button></a>
		
    </div>
</body>
</html>
