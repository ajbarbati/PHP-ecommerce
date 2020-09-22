
<?php
// Connections
    require "./View/header.php";
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
    $productGet = $product->proRead();
    $categoryGet = $category->catRead();
    include_once './View/nav.php';
    include './View/side-nav.php';
// Connections

if (isset($_GET['cat'])) {
    $cat = $_GET['cat'];
    $sub = $_GET['sub'];
    $pro = $_GET['pro'];
    $productGet = $product->cartRead($cat, $sub, $pro);
}

// CSS Styles
    echo "
        <style>
        .page-grid {
            height: 100vh;
        }
        .product-grid {
            width: 100%;
            margin-top: 4rem;
            margin-bottom: 4rem;
            place-items: center;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: auto;
            grid-row: 2;
        }
        .product-grid form {
            width: 100%;
        }
        .product-card {
            grid-template-columns: 1fr;
            grid-template-rows: auto;
            height: 100%;
        }

        .product-price-grid{
            display: grid;
            grid-template-columns: auto;
            grid-template-rows: 100px auto 75px;
            background-color: white;
            height: 100%;
            width: 100%;
            grid-column: 2;
        }
        .product-price-title{
            grid-row: 1;
        }
        .product-price-title h1{
            padding: 1em;
            color: white;
            text-align: center;
            font-size: 32px;
        }
        .product-price-description{
            padding: 1em;
            grid-row: 2;
        }
        .product-price-description p {
            text-indent: 50px;
        }
        .product-price-buy{
            grid-row: 3;
        }

        .comment-container{
            display: grid;
            grid-template-columns: auto;
            grid-template-rows: auto;
            background-color: white;
            height: 100%;
            width: 100%;
            grid-column: 1 / span 2;
            grid-row: 3;
        }
        </style>
    ";
// /CSS Styles


echo "<div class='product-grid'>";   
$row = 100;

// Page Body
    while ($row = $productGet->fetch(PDO::FETCH_ASSOC)) {
        $catId = $row['category_id'];
        $subId = $row['subcategory_id'];
        $proId = $row['product_id'];
        $name = $row['product_name'];
        $description = $row['product_description'];
        $detailsGet = $details->readByIds($catId,$subId,$proId);

        // Display Product
            echo "
            <div class='product-card' style='width: 18rem;'>
                <a class='product-image-container' href='individual-product.php?cat={$cat}&sub={$sub}&pro={$pro}'>
                    <img class='product-image' style='max-width: 450px;' src='View/Public/Images/product-images/{$cat}{$sub}{$pro}.jpg' alt='{$name} - {$description}'>
                </a>
            </div>

            <div class='product-price-grid'>
                <div class='product-price-title bg-primary'>
                    <h1>".$name."</h1>
                </div>
                
                <div class='product-price-description bg-light'>
                    <h4>Item Description:</h4>
                    <p>".$description."</p>
                </div>

                <div class='product-price-buy'>
                    <form name='card' action='Controller/add-to-cart.php' method='POST' id='{$cat}{$sub}{$pro}{$name}'>
                        <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <input type='checkbox' id='{$cat}{$sub}{$pro}{$name}' name='product' value='{$name}' checked style='display:none;'>
                                <input type='checkbox' id='{$cat}{$name}' name='cat' value='{$cat}' checked style='display:none;'>
                                <input type='checkbox' id='{$sub}{$name}' name='sub' value='{$sub}' checked style='display:none;'>
                                <input type='checkbox' id='{$pro}{$name}' name='prod' value='{$pro}' checked style='display:none;'>
                                <input type='checkbox' id='{$pro}{$name}$cat}' name='descr' value='{$description}' checked style='display:none;'>
                                <button type='submit' key='{$cat}{$sub}{$pro}' name='combined' value='{$cat}{$sub}{$pro}' class='btn btn-success text-white add-to-cart-btn' onclick='scrollSave.scroll()'><i class='fa fa-cart-plus' aria-hidden='true'></i></button>
                            </div>
                            <select class='custom-select' style='margin-right: 0;' name='price' id='{$pro}' aria-label='Example select with button addon'>
                        ";
                        while ($det = $detailsGet->fetch(PDO::FETCH_ASSOC)) {
                            $q = (string)$det['detail_id'];
                            echo "<option value='".$det['detail_price']."'>".$det['detail_name']."  |  $".$det['detail_price']."</option>";
                        };     
                        echo "</select>
                            <input type='checkbox' id='{$catId}{$proId}{$name}' name='detail_id' value='".$q."' checked style='display:none;'>
                        </div>
                    </form>
                </div>
            </div>
            "; 
        // Display Product
        
        

    } 
// /Page Body
?>
<?php echo "</div>";include './View/footer.php' ?>