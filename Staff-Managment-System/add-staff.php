<?php require_once('includes/authorise.php'); ?>
<?php
    $errors = [];
    if(isset($_POST['addStaff'])) {
        $errors = addStaff($_POST);

        if(count($errors) === 0) {
            echo "<script>alert('Successful!');parent.location.href='manage.php';</script>";
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="taiji">
		</div>
	<br>
<h1 style="text-align: center;margin-top: 10px;">Add a staff</h1>
                <form class="registration_form" method="post">
                    <div>
                        <label for="firstname">First name:</label>
                        <input type="text" id="firstname" name="firstname"
                            <?php displayValue($_POST, 'firstname'); ?> />
                        <?php displayError($errors, 'firstname'); ?>
                    </div>

                    <div>
                        <label>Last name:</label>
                        <input type="text" id="lastname" name="lastname"
                            <?php displayValue($_POST, 'lastname'); ?> />
                        <?php displayError($errors, 'lastname'); ?>
                    </div>


                    <div>
                        <label>Email:</label>
                        <input type="text" id="email" name="email"
                            <?php displayValue($_POST, 'email'); ?> />
                        <?php displayError($errors, 'email'); ?>
                    </div>

                    <div>
                        <label>Password:</label>
                        <input type="password" id="password" name="password" />
                        <?php displayError($errors, 'password'); ?>
                    </div>

                    <div>
                        <label>Confirm password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" />
                        <?php displayError($errors, 'confirmPassword'); ?>
                    </div>

                    

                    <button type="addStaff" class="addStaff" name="addStaff" value="addStaff">Submit</button>
                </form>
                <a href='manage.php'>Back</a>

                </body>
                </html>