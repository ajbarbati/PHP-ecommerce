<?php
    require "./View/header.php";
    include './Controller/database.php';
    include_once "./Model/product.php";
    include_once "./Model/details.php";
    include_once "./Model/card.php";
    include_once "./Model/user.php";
    include_once "./Model/categories.php";
    include_once "./Model/subcategories.php";
    // get database connection
    $database = new Database();
    $db = $database->connect();

    // initialize objects
    $category = new Category($db);
    $subcategory = new SubCategory($db);
    $product = new Product($db);
    $details = new Details($db);
    $card = new Card();
    $user = new User($db);

    $productGet = $product->proRead();
    $categoryGet = $category->catRead();
    
    $userRow = $user->byUserName($userId);  
    $userId = $_SESSION["user_session"];
        if (!$user->is_loggedin()) {
            $user->redirect("index.php");
        }
        
    include_once './View/nav.php';
    include './View/side-nav.php';
?>

<div class="accountPage">
    <h1 class="accountHead">Account Info</h1><br>
    <a href="Controller/logout.php" class="logoutBtn">Logout</a>
    <?php
        
    ?>
    <?php 
        print($userRow["staff_name"]);
        echo "<br><br> Date Created: ";
        print($userRow["date_created"]);
     ?>
</div>