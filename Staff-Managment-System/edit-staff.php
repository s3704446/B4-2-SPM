
<?php require_once('includes/functions.php'); ?>
<?php 
$staff = getStaff($_GET['email']);
?>
<?php
    $errors = [];
    if(isset($_POST['updateStaff'])) {
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
</head>
<body>
<h1 style="text-align: center;margin-top: 10px;">Edit staff</h1>

                <form class="registration_form" method="post">

                <div>
                        <label>Email: cannot change</label> 
                        <input type="text" id="email" name="email" value="<?= $staff['email']; ?>" readonly="<?= $staff['email']; ?>"
                            <?php displayValue($_POST, 'email'); ?>  >
                    </div>

                    <div>
                        <label for="firstname">First name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?= $staff['firstname']; ?>"
                         <?php displayValue($_POST, 'firstname'); ?> />
                         <?php displayError($errors, 'firstname'); ?>
                    </div>

                    <div>
                        <label>Last name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?= $staff['lastname']; ?>"
                            <?php displayValue($_POST, 'lastname'); ?> />
                            <?php displayError($errors, 'lastname'); ?>
                    </div>


                    

                    <div>
                        <label>Password:</label>
                        <input type="password" id="password" name="password" value="<?= $staff['password-hash']; ?>"/>
                        <?php displayError($errors, 'password'); ?>
                    </div>

                    <div>
                        <label>Confirm password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="<?= $staff['password-hash']; ?>"/>
                        <?php displayError($errors, 'confirmPassword'); ?>
                    </div>


                    

                    <button type="updateStaff" class="updateStaff" name="updateStaff" value="updateStaff">Submit</button>
                    <button type="removeStaff" class="removeStaff" name="removeStaff" value="removeStaff">Remove</button>
                </form>

                </body>
                </html>