
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
    $categoryValue = $_GET['category'];
    $subcategoryValue = $_GET['subcategory'];
    include_once './View/nav.php';
    include './View/side-nav.php';
    

    $sGet = $product->subCatRead($categoryValue, $subcategoryValue);
    $subName = $subcategory->subName($categoryValue, $subcategoryValue);



while ($row = $subName->fetch(PDO::FETCH_ASSOC)) {
    echo '<br>', '<h1 style="text-align: center;">', $row['subcategory_name'], '</h1>', '<br>';
}
echo "<div class='product-grid'>";   
$row = 100;

while ($row = $sGet->fetch(PDO::FETCH_ASSOC)) {
    $catId = $row['category_id'];
    $subId = $row['subcategory_id'];
    $proId = $row['product_id'];
    $name = $row['product_name'];
    $description = $row['product_description'];
    $detailsGet = $details->readByIds($catId,$subId,$proId);
    $card->makeCard($catId,$subId,$proId,$name,$description);

    while ($det = $detailsGet->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option  value='".$det['detail_price']."'>".$det['detail_name']."</option>";
    };                 
    echo "               </select>
                    </div>
                </div>
            </div>
        </form>
    ";
}
?>
<?php echo "</div>";include 'View/footer.php' ?>