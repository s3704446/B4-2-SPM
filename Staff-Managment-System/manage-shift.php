<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
    $userStats = getUserStats($_GET['email']);
    $staff = getStaff($_GET['email']);
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

    <!--categories-->
        <div style="text-align:center">

            <a href="add-shift.php?email=<?= $staff['email']; ?>">
                Add Shift
            </a>
            <a href="manage.php" class="fitness-button-grey">Back</a>

            </div>
            <!--display recorded activities-->
        
            <table style="margin-left:20%">
            <h2>Shift:</h2> 
            <tr>
                    <th> Date </th>
                    <th> Minutes </th>
                    <th> Location </th>
            </tr>
            <?php if(count($userStats) !== 0) { ?>
            <?php foreach($userStats as $value) { ?>
            <tr>
            
                    <td><?= $value['date']; ?></td>
                    <td><?= $value['minutes']; ?></td>
                    <td><?= $value['location']; ?></td>
                    <td><a href='edit-shift.php?id=<?= $value['id']; ?>'>edit</a></td>

                    
                    </tr>
                    <?php } ?>

            </table>
        <?php } else { ?>
            <p>You have not recorded any shift.</p>
        <?php } ?>
 
        </body>
        </html>