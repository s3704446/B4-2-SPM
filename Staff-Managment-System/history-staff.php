<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
    $userStats = getUserStats($user['email']);
?>
<!DOCTYPE html>
<html lang="en">
<style>
    a{text-decoration:none}
    .calendar{
        position: fixed; z-index: 0; top:0px; right: 10px;
    }
    /* Border styles */
    #table-1 thead, #table-1 tr {
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: #a8bfde;
    }
    #table-1 {
        border-bottom-width: 0px;
        border-bottom-style: solid;
        border-bottom-color: #a8bfde;
        font-size: 16px;
    }

    /* Padding and font style */
    #table-1 td, #table-1 th {
        padding: 5px 10px;
        font-size: 12px;
        font-family: Verdana;
        color: #5b7da3;
    }

    /* Alternating background colors */
    #table-1 tr:nth-child(even) {
        background: #d3dfed
    }
    #table-1 tr:nth-child(odd) {
        background: #FFF
    }
</style>
<head>
	

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
                        <table id="table-1" style="margin-left:20%">
                            <h2>History Shift List:</h2>
                            <h2><a href='manage.php'>Back</a></h2>
                            <tr>
                                    <th> Date </th>
                                    <th> Working Minutes </th>
                                    <th> Location </th>
                                    <th> state </th>
                            </tr>
                            <?php foreach($userStats as $value) {
                                list($day, $month, $year) = explode("/", $value['date']);
                                $ymd = "$year-$month-$day";
                                if(strtotime($ymd)<time('Y-m-d')){

                                ?>

                            <tr>
                            
                                    <td><?= $value['date']; ?></td>
                                    <td><?= $value['minutes']; ?></td>
                                    <td><?= $value['location']; ?></td>
                                    <td><?= $value['state']==''?'Unread':$value['state']; ?></td>
                                    <td><a href='edit-shift.php?id=<?= $value['id']; ?>&email=<?=$user['email']?>'>edit</a></td>

                    
                    </tr>
                    <?php
                                } } ?>

                        </table>
                
            <?php }else{?>
                <p> You have no working shift</p>
            <?php }} ?>
        </div>

	
    </div>
</body>
</html>
