<?php require_once('includes/functions.php'); ?>
<?php 
$user = getLoggedInUser();
$userStats = getUserStats($_GET['email']);
$StatsDetail=$userStats[$_GET['id']];
$staff = getStaff($_GET['email']);
?>
<?php
    $errors = [];
    if(isset($_POST['updateShift'])) {
        $errors = updateActivity($_POST, $_GET['email']);

        if(count($errors) === 0) {
            if($user['position']=='manager'){
            echo "<script>alert('Successful!');parent.location.href='manage-shift.php?email={$_GET['email']}';</script>";
            exit();
            }else if($user['position']=='staff'){
                echo "<script>alert('Successful!');parent.location.href='manage.php';</script>";
            exit();
            }
        }
    }else if(isset($_POST['removeShift'])){
        if($user['position']=='manager'){
        deleteUserStatus($_POST, $_GET['email']);
        echo "<script>alert('Successful!');parent.location.href='manage-shift.php?email={$_GET['email']}';</script>";
        exit();
        }else if($user['position']=='staff'){
            deleteUserStatus($_POST, $_GET['email']);
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

                    <div>
                        <label for="state">

                            <small>
                                state
                            </small>
                        </label>
                        <br>
                        <select name="state" id="state">
                            <option checked="<?= $StatsDetail['state']; ?>=='Unread'" value="Unread">Unread</option>
                            <option checked="<?= $StatsDetail['state']; ?>=='Agree'" value="Agree">Agree</option>
                            <?php if($user['position']=='manager'){?>
                            <option checked="<?= $StatsDetail['state']; ?>=='Absence'" value="Absence">Absence</option>
                            <?php }?>
                        </select>


                    </div>

                    <button type="updateShift" class="updateShift" name="updateShift" value="updateShift">Update</button>
                    <button type="removeShift" class="removeShift" name="removeShift" value="removeShift">Remove</button>
                </form>
                <?php if($user['position']=="manager"){?>
                    <a href='manage-shift.php?email=<?= $_GET['email'];?>'>Back</a>
                <?php }else if($user['position']=="staff"){?>
                    <a href='manage.php'>Back</a>
                    <?php }?>
</body>