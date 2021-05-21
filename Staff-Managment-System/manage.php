<?php require_once('includes/authorise.php'); ?>
<?php
    $user = getLoggedInUser();
    $userStats = getUserStats($user['email']);


?>
<!DOCTYPE html>
<link rel="stylesheet" href="css/record.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/sys-calendar.js"></script>
<html lang="en">

<head>
    <style>
        .calendar-date .value{
            display: none;
        }
        .btn-group .btn{
            display: none;
        }
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
                <a href='edit-profile.php?email=<?=$user['email'];?>' >edit personal profiles</a>
                <a href='add-staff.php'>Add a staff</a>
                <h2>Manager</h2>
                <?php foreach(readUsers() as $key => $value) { ?>
                <div class="col-sm-6 col-md-4 col-lg-2">
				<p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
				
                    <p><?= $value['firstname']; ?> <?= $value['lastname']; ?></p> 
                    <a href='edit-profile.php?email=<?= $key; ?>'>edit</a>
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
            <?php }}else if($user['position']=="staff"){ ?>
                <a href='edit-profile.php?email=<?=$user['email'];?>' >edit personal profiles</a>
                        <a href='add-shift.php?email=<?=$user['email'];?>' >Add a working shift now!</a>
                
                       <?php if(count($userStats) !== 0){ ?>
                        
                        <p>You have <?= count($userStats);?> working shifts to finish:</p>
                        <table id="table-1" style="margin-left:20%">
                            <h2>Working Shift List:</h2>
                            <h2><a href='history-staff.php'>History</a></h2>


                                    <div id="calendar"></div>

                            </div>

                            <tr>
                                    <th> Date </th>
                                    <th> Working Minutes </th>
                                    <th> Location </th>
                                    <th> state </th>
                            </tr>
                            <?php

                            $data=[];
                            foreach($userStats as $value) {
                                list($day, $month, $year) = explode("/", $value['date']);
                                $ymd = "$year-$month-$day";
                                array_push( $data,  $ymd);
                                if(strtotime($ymd)>time('d-m-Y')){

                                    ?>
                            <tr>
                            
                                    <td><?= $value['date']; ?></td>
                                    <td><?= $value['minutes']; ?></td>
                                    <td><?= $value['location']; ?></td>
                                    <td><?= $value['state']==''?'Unread':$value['state']; ?></td>
                                    <td><a href='edit-shift.php?id=<?= $value['id']; ?>&email=<?=$user['email']?>'>edit</a></td>

                    
                    </tr>
                    <?php }  } ?>

                        </table>
                
            <?php }else{?>
                <p> You have no working shift</p>
            <?php }} ?>
        </div>

	
    </div>



    <script type="text/javascript">

                    //Calendar Method
                    var data = [];
                    var workdata=<?= json_encode($data); ?>;
                    var holidaydata = [];
                    $("#calendar").calendar({
                        data: data, //Recorded data
                        holiday: holidaydata, //Vacation planning time
                        work:workdata,//work time
                        mode: "month",
                        width:600,
                        cellClick: function(data, me, lay) {
                            var module = document.body.querySelector(".calendar-box");
                            module ? module.parentNode.removeChild(module) : "";
                            if(data == undefined) {
                                set.PromptBox("No history", 2, false);
                            } else {
                                var mun = data.length;
                                var box = document.createElement("div");
                                box.id = "calendar-box";
                                lay.el[0].appendChild(box).className = "calendar-box";
                                for(var i = 0; i < mun; i++) {
                                    var mousename = document.createElement("a");
                                    mousename.className = "record_info";
                                    mousename.href = "javascript:;";
                                    box.appendChild(mousename).innerHTML = data[i].name;
                                }
                                var laybox = $(lay.el[0]).outerWidth();
                                var objTop = lay.getOffsetTop(set.$('#calendar-box')); //Object x position
                                var objLeft =lay.getOffsetLeft(set.$('#calendar-box')); //Object y position
                                var mouseX = me.clientX + document.body.scrollLeft; //Mouse x position
                                var mouseY = me.clientY + document.body.scrollTop; //Mouse y position
                                var objX = mouseX - objLeft;
                                var objY = mouseY - objTop;
                                box.style.cssText = "display:block" + "; left:" + objX + "px" + ";" + "top:" + objY + "px";
                                var infoh = $(".record_info").outerHeight()+10 * mun;
                                var boxh = $(".calendar-box").outerHeight();
                                var boxgap = laybox - mouseX;
                                var boxw = $(box).outerWidth();
                                if(boxgap <= boxw) {
                                    box.style.cssText = "display:block" + "; left:" + (objX - boxw) + "px" + ";" + "top:" + objY + "px";
                                }
                                if(infoh < boxh) {
                                    box.style.cssText += 'height:' + infoh + 'px;';
                                } else {
                                    box.style.cssText += 'bottom:15px';
                                }
                            }
                        },
                        monthClick: function(e, nextMonth, opts, me) {
                            //First day of the starting month
                            var start = me._cloneDate(opts.newDate);
                            start.setDate(1);
                            // Get the last day of the current month
                            var date = new Date();
                            var nextMonthFirstDay = new Date(date.getFullYear(), nextMonth, 1);
                            var oneDay = 1000 * 60 * 60 * 24;
                            var end = new Date(nextMonthFirstDay - oneDay);
                            var startDate = me.transferDate(start); // Date change
                            var endDate = me.transferDate(end); // Date change
                            var cycleData = [{
                                'name': "145",
                                'startDate': "2020-2-09 15:31:29",
                                'type': "Phone number"
                            }, {
                                'name': "178956874",
                                'startDate': "2020-2-23 15:31:29",
                                'type': "Phone Number"
                            }]//
                            me._refreshCalendar(opts.newDate, cycleData);
                        }
                    });

    </script>
</body>
</html>
