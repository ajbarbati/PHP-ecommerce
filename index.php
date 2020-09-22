
<?php
require './View/header.php';

include './Controller/database.php';
include_once "./Model/product.php";
include_once "./Model/details.php";
include_once "./Model/card.php";
include_once "./Model/categories.php";
include_once "./Model/subcategories.php";
include_once './View/opening-page.php';
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
echo "<div class='product-grid'>";   

$row = 100;

// ALL PRODUCTS
while ($row = $productGet->fetch(PDO::FETCH_ASSOC)) {
    $catId = $row['category_id'];
    $subId = $row['subcategory_id'];
    $proId = $row['product_id'];
    $name = $row['product_name'];
    $description = $row['product_description'];
    $detailsGet = $details->readByIds($catId,$subId,$proId);
    //Make into function that plugs in variables where necessary so that this gets used by every page with a product card.
    $card->makeCard($catId,$subId,$proId,$name,$description);
    while ($det = $detailsGet->fetch(PDO::FETCH_ASSOC)) {         
        
        echo "<option  value='".$det['detail_price'].','.$det['detail_id']."'>".$det['detail_name']."  |  $".$det['detail_price']."</option>";
        $detId = $det['detail_id'];
    };  
        
    echo "               
                        </select>
                        <input type='checkbox' id='{$catId}{$subId}{$proId}{$detId}' name='detail_id' value='{$detId}' checked style='display:none;'>
                    </div>
                </div>
            </div>
        </form>
    ";
    

}

echo "</div>";

require './View/footer.php';  

?>