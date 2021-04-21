<?php require_once('includes/authorise.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	
		    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
   

	<!-- Welcome message  -->
    <div class="container">
        <div class="mb-3">
            <h1 class="display-1">Staff Management System</h1>
			<p></p>
			<p id="welcome">Hello, <?= getLoggedInUser()['firstname']; ?>!  Welcome to Staff Management System !!</p>
            <p class="lead">How's your day?</p>
        </div>

        <a href='add-staff.php'>Add a staff</a>
        <a href='logout.php'>Logout</a>

		<!-- Show 3 kinds of myFitness -->
        <div class="row">
            <?php if(getLoggedInUser()['position']="manager"){?>
                <h2>Staff</h2>
            <?php foreach(readStaff() as $key => $value) { ?>
                <div class="col-sm-6 col-md-4 col-lg-2">
				<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
				
                    <p><?= $value['firstname']; ?> <?= $value['lastname']; ?></p> 
                    <a href='edit-staff.php?email=<?= $key; ?>'>edit</a>
                </div>
            <?php }} ?>
        </div>

	
    </div>
</body>
</html>
