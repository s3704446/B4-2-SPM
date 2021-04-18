<?php require_once('includes/functions.php'); ?>
<?php
    $errors = [];
    if(isset($_POST['register'])) {
        $errors = registerUser($_POST);

        if(count($errors) === 0) {
            header('Location: login.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
        <title>Register</title>
        <link rel="stylesheet" href="css/breadcrumbs.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="javaScript/jquery.breadcrumbs-generator.js"></script>
        <script>
            $(function() {
              $('#breadcrumbs').breadcrumbsGenerator();
            });
            </script>
</head>
<body>
    <!--header-->
        
            <!--registeration form-->
                <div id="register-content">
                <h1 style="text-align: center;margin-top: 10px;">Register Now!</h1>
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

                    

                    <button type="submit" class="submit" name="register" value="register">Register</button>
                </form>
        </div>

            <!--footer-->

         
</body>
</html>
