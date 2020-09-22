
<?php require "./View/header.php";
include './Controller/database.php';
include_once "./Model/product.php";
include_once "./Model/details.php";
include_once "./Model/card.php";
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

// read all products in the database
$productGet = $product->proRead();
$categoryGet = $category->catRead();
include_once './View/nav.php';
include './View/side-nav.php';

?>

<div class="jumbotron .jumbotron-fluid">
    <div class="container-fluid">
        <h2 class="display-4">Welcome to Example Store</h2>
        <p class="lead">We specialize in selling <i>example</i> products!</p>
        <hr class="my-4">
        <p>These are our values and how we do business.</p>
        <p>
            These are our values and how we do business.These are our values and how we do business.These are our values and how we do business.
        </p>
        <p>
            These are our values and how we do business.These are our values and how we do business.These are our values and how we do business.
        </p>
    </div>
</div>

<?php require "./View/footer.php" ?>