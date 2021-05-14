<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
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

        <a href='add-staff.php'>Add a staff</a>
        <a href='logout.php'>Logout</a>

		<!-- Show 3 kinds of myFitness -->
        <div class="row">
            <?php if($user['position']="manager"){?>
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
            <?php }}else{ ?>
                <p>no record</p>
            <?php } ?>
        </div>

	
    </div>
</body>
</html>
