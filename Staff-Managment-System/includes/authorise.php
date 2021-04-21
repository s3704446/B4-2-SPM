<?php
    require_once('functions.php');

    if(!isUserLoggedIn()) {
        header('Location: login.php');
        exit();
    }
    ?>
