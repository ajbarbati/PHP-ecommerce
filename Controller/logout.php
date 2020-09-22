
<?php
    include 'database.php';
    include '../Model/user.php';
    $database = new Database();
    $db = $database->connect();
    $user = new User($db);
    session_start();
    unset($_SESSION['user_session']);
    session_destroy();
    $user->redirect('../sign-in.php');
?> 