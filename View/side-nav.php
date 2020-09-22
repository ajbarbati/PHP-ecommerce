<?php
if (isset($_GET['category'])) {$subCatGet = $subcategory->catRead($_GET['category']);}
?>

<div id="myDropdown" class="dropdown">

    <button id='modalButton' class='modalButtonSide'>
        <img class="dropbtn" src='View/Public/Images/menu.svg'></img>
    </button>
    
    <div id='simpleModal' class='myModal'>
        <div class='modalContent'>
            <div class='side-nav-menu'>                
                <a class="sNavLink b" href="sign-in.php"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
                <i class="fa fa-times closeBtn" aria-hidden="true"></i>
                <a class="sNavLink a" href="index.php">All Products</a>
            </div>
            <div class="modalInnerContent">
                <?php
                    while ($row = $categoryGet->fetch(PDO::FETCH_ASSOC)) {
                        $catId = $row['category_id'];
                        $name = $row['category_name'];
                        echo "<a class='sNavLink' href='category.php?category={$catId}'>{$name}</a>";
                    
                }
                ?>
                <div class='modalSubcategories' id='subCatButton'>
                    <h5>Subcategories <i class="fa fa-plus" aria-hidden="true"></i></h5>
                    <div id='subCategories' style='display: none;'>
                        <?php
                            if (isset($_GET['category'])) {
                                while ($row = $subCatGet->fetch(PDO::FETCH_ASSOC)) {
                                    $catId = $row['category_id'];
                                    $subId = $row['subcategory_id'];
                                    $name = $row['subcategory_name'];
                                    echo "<a class='sNavLink' href='subcategory.php?category={$catId}&subcategory={$subId}'>{$name}</a>";
                                }
                            }
                            
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</script>