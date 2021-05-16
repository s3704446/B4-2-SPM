<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
    $userStats = getUserStats($user['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
		    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
   

	<!-- Welcome message  -->
    <div class="container">
        <div class="mb-3">
            <h1 class="display-1">Staff Management System</h1>
			<p></p>
			<p id="welcome">Hello, <?= $user['firstname']; ?><!  Welcome to Staff Management System !!</p>
            <p class="lead">How's your day?</p>
        </div>

        
        <a href='logout.php'>Logout</a>

		<!-- Show 3 kinds of myFitness -->
        <div class="row">
            <?php if($user['position']=='manager'){?>
                <a href='add-staff.php'>Add a staff</a>
                <h2>Manager</h2>
                <?php foreach(readUsers() as $key => $value) { ?>
                <div class="col-sm-6 col-md-4 col-lg-2">
				<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
				
                    <p><?= $value['firstname']; ?> <?= $value['lastname']; ?></p> 
                    <a href='edit-staff.php?email=<?= $key; ?>'>edit</a>
                </div>
            <?php }?>
                <h2>Staff</h2>
            <?php foreach(readStaff() as $key => $value) { ?>
                <div class="col-sm-6 col-md-4 col-lg-2">
				<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
				
                    <p><?= $value['firstname']; ?> <?= $value['lastname']; ?></p> 
                    <a href='manage-shift.php?email=<?= $key; ?>'>manage</a>
                    <a href='edit-staff.php?email=<?= $key; ?>'>edit</a>
                </div>
            <?php }}else if($user['position']=="staff"){ 
                        if(count($userStats) !== 0){ ?>
                        <a href='edit-staff.php?email=<?=$user['email'];?>' >edit personal profiles</a>
                        <a href='add-shift.php?email=<?=$user['email'];?>' >Add a working shift now!</a>
                        <p>You have <?= count($userStats);?> working shifts to finish:</p>
                        <table style="margin-left:20%">
                            <h2>Working Shift List:</h2> 
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
                                    <td><a href='edit-shift.php?id=<?= $value['id']; ?>&email=<?=$user['email']?>'>edit</a></td>

                    
                    </tr>
                    <?php } ?>

                        </table>
                
            <?php }else{?>
                <p> You have no working shift</p>
            <?php }} ?>
        </div>

	
    </div>
</body>
</html>
