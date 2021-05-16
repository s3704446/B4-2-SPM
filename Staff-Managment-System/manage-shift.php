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

            <a href="add-shift.php?email=<?= $_GET['email']; ?>">
                Add Shift
            </a>
            <a href="manage.php" class="fitness-button-grey">Back</a>

            </div>
            <!--display recorded activities-->
        
            <table style="margin-left:20%">
            <h2>Shift of <?= $staff['firstname'];?> <?= $staff['lastname'];?>:</h2> 
            
            <?php if(count($userStats) !== 0) { ?>
                <tr>
                    <th> Date </th>
                    <th> Working Minutes </th>
                    <th> Location </th>
            </tr>
            <?php foreach($userStats as $value) { ?>
            <tr>
            
                    <td><?= $value['date']; ?></td>
                    <td><?= $value['minutes']; ?></td>
                    <td><?= $value['location']; ?></td>
                    <td><a href='edit-shift.php?id=<?= $value['id']; ?>&email=<?=$_GET['email']?>'>edit</a></td>

                    
                    </tr>
                    <?php } ?>

            </table>
        <?php } else { ?>
            <p>You have not recorded any shift.</p>
        <?php } ?>
 
        </body>
        </html>