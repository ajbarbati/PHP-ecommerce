
<?php
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

    // read all products in the database
    $productGet = $product->proRead();
    $categoryGet = $category->catRead();
    $catGet = $product->categoryRead($_GET['category']);
    $catName = $category->catName($_GET['category']);
    include_once './View/nav.php';
    include './View/side-nav.php';

echo "<div class='product-grid'>";   

$row = 100;
if (isset($_GET['search'])) {
    $term = $_GET['search'];
    $productGet = $product->proSearch($term);
}
// ALL PRODUCTS
while ($row = $productGet->fetch(PDO::FETCH_ASSOC)) {
    $catId = $row['category_id'];
    $subId = $row['subcategory_id'];
    $proId = $row['product_id'];
    $name = $row['product_name'];
    $description = $row['product_description'];
    $detailsGet = $details->readByIds($catId,$subId,$proId);
    $card->makeCard($catId,$subId,$proId,$name,$description);
    while ($det = $detailsGet->fetch(PDO::FETCH_ASSOC)) {
                        $q = (string)$det['detail_id'];
                        echo "<option  value='".$det['detail_price']."'>".$det['detail_name']."</option>";
    };                 
    echo "               </select>
                        <input type='checkbox' id='{$catId}{$proId}{$name}' name='detail_id' value='".$q."' checked style='display:none;'>

                    </div>
                </div>
            </div>
        </form>
    ";
    

}
?>
<?php include 'View/footer.php' ?>
