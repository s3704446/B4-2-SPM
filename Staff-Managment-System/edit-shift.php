<?php require_once('includes/functions.php'); ?>
<?php 
$user = getLoggedInUser();
$userStats = getUserStats($user['email']);
$StatsDetail=$userStats[$_GET['id']];
$staff = getStaff($user['email']);
?>
<?php
    $errors = [];
    if(isset($_POST['updateShift'])) {
        $errors = createActivity($_POST, $staff['email']);

        if(count($errors) === 0) {
            echo "<script>alert('Successful!');parent.location.href='manage-shift.php?email={$user['email']}';</script>";
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1 style="text-align: center;margin-top: 10px;">Update a Shift</h1>
                <form  method="post">
                <div>
                        <label for="id">Shift ID
                        </label>
                        <br> 
                        <input type="text" id="id" name="id" value="<?= $StatsDetail['id']; ?>" readonly="<?= $StatsDetail['id']; ?>"
                            <?php displayValue($_POST, 'id'); ?> />
                        <?php displayError($errors, 'id'); ?>
                    </div>

                <div>
                        <label for="date">
                            *Date
                            <small>
                                dd/mm/yyyy
                            </small>
                        </label>
                        <br>
                        <input type="text" id="date" name="date" value="<?= $StatsDetail['date']; ?>"
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
                        <input type="text" id="minutes" name="minutes" value="<?= $StatsDetail['minutes']; ?>"
                            <?php displayValue($_POST, 'minutes'); ?> />
                        <?php displayError($errors, 'minutes'); ?>
                    </div>

                    <div>
                        <label for="location">
                            *Location
                        </label>
                        <br>
                        <input type="text" id="location" name="location" value="<?= $StatsDetail['location']; ?>"
                            <?php displayValue($_POST, 'location'); ?> />
                        <?php displayError($errors, 'location'); ?>
                    </div>

                    

                    <button type="updateShift" class="updateShift" name="updateShift" value="updateShift">Update</button>
                </form>
</body>