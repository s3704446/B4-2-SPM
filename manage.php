<?php require_once('includes/authorise.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
		<?php require_once("includes/head.php"); ?>
		    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php require_once('includes/header.php'); ?>
	<br>
    <?php require_once('includes/navbar.php'); ?>
	<br>

	<!-- Welcome message  -->
    <div class="container">
        <div class="mb-3">
            <h1 class="display-1">Staff Management System</h1>
			<p></p>
			<p id="welcome">You have logged in successfully! Welcome to Staff Management System !!</p>
            <p class="lead">How's your day</p>
        </div>

		<!-- Show 3 kinds of myFitness -->
        <div class="row">
            <?php foreach(readCategories() as $key => $value) { ?>
                <div class="col-sm-6 col-md-4 col-lg-2">
				<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
				<br>
                    <a href="category.php?category=<?= $key; ?>">
                        <img class="options" src="assets/<?= $value['image-name']; ?>" />
                    </a>
                    <p id="p2"><?= $value['name']; ?></p>
                </div>
            <?php } ?>
        </div>

	<!-- call footer here  -->
        <?php require_once('includes/footer.php'); ?>
    </div>
</body>
</html>
