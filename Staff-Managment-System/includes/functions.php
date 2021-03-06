<?php
    const USERS_PATH = 'data/users.json';
    const USER_STATS_PATH = 'data/user_stats.json';
    const CATEGORIES_PATH = 'data/category.json';
    const STAFF_PATH = 'data/staff.json';

    const USER_SESSION_KEY = 'user';
    const STAFF_SESSION_KEY = 'user';

    const MINUTES_MINIMUM = 1;
    const MINUTES_MAXIMUM = 2400;

    const DATE_FORMAT = 'd/m/Y';
    error_reporting(E_ERROR); 
    ini_set("display_errors","Off");


    session_start();

    //JSON files settings
    function readJsonFile($path) {
        $json = file_get_contents($path);

        return json_decode($json, true);
    }

    function updateJsonFile($data, $path) {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($path, $json, LOCK_EX);
    }
    function deleteJsonFile($data, $path) {
        $json = file_get_contents($path);
        $json = json_decode($json,true);

        if  (!empty($json[$data['email']])){
            unset($json[$data['email']]);
        }
        $json = json_encode($json, JSON_PRETTY_PRINT);
        file_put_contents($path, $json, LOCK_EX);
    }

    //根据 id 删除  user_status
    function deleteJsonFileUserStatus($id,$path,$email){
        $json = file_get_contents($path);
        $json = json_decode($json,true);
        if  (!empty($json[$email][$id])){
            unset($json[$email][$id]);
        }
        $json = json_encode($json, JSON_PRETTY_PRINT);
        file_put_contents($path, $json, LOCK_EX);
    }
    //display error settings
    function displayError($errors, $name) {
        if(isset($errors[$name]))
            echo "<div class='text-danger' style='text-align:center;color:red'>{$errors[$name]}</div>";
    }
    //display value
    function displayValue($form, $name) {
        if(isset($form[$name]))
            echo 'value="' . htmlspecialchars($form[$name]) . '"';
    }


    function generatePasswordHash($password, $salt = null) {
        if($salt === null)
            $salt = bin2hex(openssl_random_pseudo_bytes(10));
        $blowfish_salt = '$2y$10$' . $salt;

        return crypt($password, $blowfish_salt);
    }


    function verifyPasswordHash($password, $hash) {
        $tokens = explode('$', $hash);
        $salt = $tokens[3];
        return $hash === generatePasswordHash($password, $salt);
    }

    //date validation
    function isValidDate($date, $format = DATE_FORMAT)
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }
    //catecory settings
    function readCategories() {
        return readJsonFile(CATEGORIES_PATH);
    }

    function getCategory($category) {
        $categories = readCategories();

        return isset($categories[$category]) ? $categories[$category] : null;
    }

    //user stats settings
    function readUserStats() {
        return readJsonFile(USER_STATS_PATH);
    }

    function updateUserStats($userStats) {
        updateJsonFile($userStats, USER_STATS_PATH);
    }

    function getUserStats($email) {
        $userStats = readUserStats();

        return isset($userStats[$email]) ? $userStats[$email] : [];
    }

 

    function getUserStatsForCategory($email) {
        $userStats = getUserStats($email);


        return isset($userStats[$category]) ? $userStats[$category] : [];
    }

    //update user activities
    function updateActivity($form,$email)
    {
        $userStats = readUserStats();

        if (!empty($userStats[$email][$form['id']])){
            $userStats[$email][$form['id']] = $form;
        }
        updateUserStats($userStats);
    }

    //user create activities
    function createActivity($form, $email) {
        $errors = [];

        //validate information
        $key = 'date';
        if(!isset($form[$key]) || !isValidDate($form[$key]))
            $errors[$key] = implode(['Please enter a date before ',date(DATE_FORMAT)]);

        $key = 'minutes';
        if(!isset($form[$key]) || filter_var($form[$key], FILTER_VALIDATE_INT,
            ['options' => ['min_range' => MINUTES_MINIMUM, 'max_range' => MINUTES_MAXIMUM]]) === false)
        {
            $errors[$key] =
                implode(['Minutes is required and must be between ', MINUTES_MINIMUM, ' and ', MINUTES_MAXIMUM, '.']);
        }

        $key = 'location';
        if(!isset($form[$key]) || preg_match('/^\s*$/', $form[$key]) === 1)
            $errors[$key] = 'Please enter your working location.';
        

        else
            $form[$key] = (int) $form[$key];

        if(count($errors) === 0) {

            $activity = [
                'id' => uniqid(),
                'date' => htmlspecialchars(trim($form['date'])),
                'minutes' => $form['minutes'],
                'location' => htmlspecialchars(trim($form['location'])),
                'state' => htmlspecialchars(trim($form['state']))
            ];

            $userStats = readUserStats();
            $userStats[$email][$activity['id']] = $activity;

            updateUserStats($userStats);
        }

        return $errors;
    }
    //user settings
    function readUsers() {
        return readJsonFile(USERS_PATH);
    }

    function updateUsers($users) {
        updateJsonFile($users, USERS_PATH);
    }

    function getUser($email) {
        $users = readUsers();

        return isset($users[$email]) ? $users[$email] : null;
    }
    //login settings
    function isUserLoggedIn() {
        return isset($_SESSION[USER_SESSION_KEY]);
    }

    function getLoggedInUser() {
        return isUserLoggedIn() ? $_SESSION[USER_SESSION_KEY] : null;
    }
    

    //user login
    function loginUser($form) {
        $errors = [];

        //validate email and password
        $key = 'email';
        if(!isset($form[$key]) || filter_var($form[$key], FILTER_VALIDATE_EMAIL) === false)
            $errors[$key] = 'Email is invalid.';

        $key = 'password';
        if(!isset($form[$key]) || preg_match('/^\s*$/',$form[$key])===1)
            $errors[$key] = 'Password Error!';
            

        if(count($errors) === 0) {
            $user = getUser($form['email']);



            if($user !== null && verifyPasswordHash($form['password'], $user['password-hash']))

                $_SESSION[USER_SESSION_KEY] = $user;
            else
                $errors[$key] = 'Sorry, your email, password or position is incorrect. Please try again.';
        }

        return $errors;
    }

    //user log out
    function logoutUser() {
        session_unset();

    }

    //register user
    function registerUser($form) {
        $errors = [];

        //validate information
        $key = 'firstname';
        if(!isset($form[$key]) || preg_match('/^\s*$/', $form[$key]) === 1)
            $errors[$key] = 'Please enter your first name.';

        $key = 'lastname';
        if(!isset($form[$key]) || preg_match('/^\s*$/', $form[$key]) === 1)
            $errors[$key] = 'Please enter your last name.';

        $key = 'email';
        if(!isset($form[$key]) || filter_var($form[$key], FILTER_VALIDATE_EMAIL) === false)
            $errors[$key] = 'Please enter a valid email.';
        else if(getUser($form[$key]) !== null)
            $errors[$key] = 'Email is already registered.';


        $key = 'password';
        if(!isset($form[$key]) || preg_match('/^\s*$/',$form[$key])===1)
            $errors[$key] = 'Please enter your password';

        $key = 'confirmPassword';
        if(isset($form['password']) && (!isset($form[$key]) || $form['password'] !== $form[$key]))
            $errors[$key] = 'Passwords do not match.';

        if(count($errors) === 0) {

            $user = [
                'firstname' => htmlspecialchars(trim($form['firstname'])),
                'lastname' => htmlspecialchars(trim($form['lastname'])),
                'email' => htmlspecialchars(trim($form['email'])),
                'position' => 'manager',
                'password-hash' => generatePasswordHash($form['password'])
            ];
            $users = readUsers();
            $users[$user['email']] = $user;
            updateUsers($users);
        }

        return $errors;
    }


    function readStaff() {
        return readJsonFile(STAFF_PATH);
    }

    function updateStaff($Staff) {
        updateJsonFile($Staff, STAFF_PATH);
    }

    function getStaff($email) {
        $Staff = readStaff();

        return isset($Staff[$email]) ? $Staff[$email] : null;
    }
    function deleteStaff($form){
        deleteJsonFile($form, STAFF_PATH);
    }
    function deleteUserStatus($form,$email){
        deleteJsonFileUserStatus($form['id'], USER_STATS_PATH,$email);
    }
    //add staff
    function addStaff($form) {
        $errors = [];

        //validate information
        $key = 'firstname';
        if(!isset($form[$key]) || preg_match('/^\s*$/', $form[$key]) === 1)
            $errors[$key] = 'Please enter your first name.';

        $key = 'lastname';
        if(!isset($form[$key]) || preg_match('/^\s*$/', $form[$key]) === 1)
            $errors[$key] = 'Please enter your last name.';

        $key = 'email';
        if(!isset($form[$key]) || filter_var($form[$key], FILTER_VALIDATE_EMAIL) === false)
            $errors[$key] = 'Please enter a valid email.';
        else if(getUser($form[$key]) !== null)
            $errors[$key] = 'Email is already registered.';


        $key = 'password';
        if(!isset($form[$key]) || preg_match('/^\s*$/',$form[$key])===1)
            $errors[$key] = 'Please enter your password';

        $key = 'confirmPassword';
        if(isset($form['password']) && (!isset($form[$key]) || $form['password'] !== $form[$key]))
            $errors[$key] = 'Passwords do not match.';

        if(count($errors) === 0) {

            $staff = [
                'firstname' => htmlspecialchars(trim($form['firstname'])),
                'lastname' => htmlspecialchars(trim($form['lastname'])),
                'email' => htmlspecialchars(trim($form['email'])),
                'position' => 'staff',
                'password-hash' => generatePasswordHash($form['password'])
            ];
            $Staff = readStaff();
            $Staff[$staff['email']] = $staff;
            updateStaff($Staff);
        }

        return $errors;
    }

    function isStaffLoggedIn() {
        return isset($_SESSION[STAFF_SESSION_KEY]);
    }

    function getLoggedInStaff() {
        return isStaffLoggedIn() ? $_SESSION[STAFF_SESSION_KEY] : null;
    }

    function loginStaff($form) {
        $errors = [];

        //validate email and password
        $key = 'email';
        if(!isset($form[$key]) || filter_var($form[$key], FILTER_VALIDATE_EMAIL) === false)
            $errors[$key] = 'Email is invalid.';

        $key = 'password';
        if(!isset($form[$key]) || preg_match('/^\s*$/',$form[$key])===1)
            $errors[$key] = 'Password Error!';
            

        if(count($errors) === 0) {
            $staff = getStaff($form['email']);


             if($staff !== null && verifyPasswordHash($form['password'], $staff['password-hash']))

            $_SESSION[STAFF_SESSION_KEY] = $staff;
            else
                $errors[$key] = 'Sorry, your email or password is incorrect. Please try again.';
        }

        return $errors;
    }

