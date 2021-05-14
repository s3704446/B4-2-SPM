<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
    $userStats = getUserStats($user['email']);
    $staff = getStaff($_GET['email']);

    $errors = [];
    if(isset($_POST['addShift'])) {
        $errors = createActivity($_POST, $_GET['email']);

        if(count($errors) === 0) {
            header("Location: manage-shift.php?email={$_GET['email']}");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1 style="text-align: center;margin-top: 10px;">Add a Shift</h1>
                <form  method="post">
                <div>
                        <label for="date">
                            *Date
                            <small>
                                dd/mm/yyyy
                            </small>
                        </label>
                        <br>
                        <input type="text" id="date" name="date"
                            <?php displayValue($_POST, 'date'); ?> />
                        <?php displayError($errors, 'date'); ?>
                    </div>

                    <div>
                        <label for="minutes">
                            *Duration (minutes)
                            <small>
                                maximum <?= MINUTES_MAXIMUM; ?> minutes
                            </small>
                        </label>
                        <br>
                        <input type="text" id="minutes" name="minutes"
                            <?php displayValue($_POST, 'minutes'); ?> />
                        <?php displayError($errors, 'minutes'); ?>
                    </div>

                    <div>
                        <label for="location">
                            *Location
                        </label>
                        <br>
                        <input type="text" id="location" name="location"
                            <?php displayValue($_POST, 'location'); ?> />
                        <?php displayError($errors, 'location'); ?>
                    </div>

                    

                    <button type="addShift" class="addShift" name="addShift" value="addShift">Submit</button>
                </form>

                </body>
                </html>