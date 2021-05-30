<?php require_once('includes/functions.php'); ?>
<?php 
$user = getUser($_GET['email']);
?>
<?php
    $errors = [];
    if(isset($_POST['updateUser'])) {
        $errors = registerUser($_POST);

        if(count($errors) === 0) {
            echo "<script>alert('Successful!');parent.location.href='manage.php';</script>";
            exit();
        }
    }else if(isset($_POST['removeUser'])){
        deleteStaff($_POST);
        echo "<script>alert('Successful!');parent.location.href='manage.php';</script>";
        exit();
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
<h1 style="text-align: center;margin-top: 10px;">Edit User</h1>

                <form class="registration_form" method="post">

                <div>
                        <label>Email: cannot change</label> 
                        <input type="text" id="email" name="email" value="<?= $user['email']; ?>" readonly="<?= $user['email']; ?>"
                            <?php displayValue($_POST, 'email'); ?>  >
                    </div>

                    <div>
                        <label for="firstname">First name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?= $user['firstname']; ?>"
                         <?php displayValue($_POST, 'firstname'); ?> />
                         <?php displayError($errors, 'firstname'); ?>
                    </div>

                    <div>
                        <label>Last name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?= $user['lastname']; ?>"
                            <?php displayValue($_POST, 'lastname'); ?> />
                            <?php displayError($errors, 'lastname'); ?>
                    </div>


                    

                    <div>
                        <label>Password:</label>
                        <input type="password" id="password" name="password" value="<?= $user['password-hash']; ?>"/>
                        <?php displayError($errors, 'password'); ?>
                    </div>

                    <div>
                        <label>Confirm password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="<?= $user['password-hash']; ?>"/>
                        <?php displayError($errors, 'confirmPassword'); ?>
                    </div>


                    

                    <button type="updateUser" class="updateUser" name="updateUser" value="updateUser">Update</button>
                </form>

                <a href='manage.php'>Back</a>

                </body>
                </html>
