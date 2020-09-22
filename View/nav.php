<?php
if (isset($_GET['category'])) {
    $subCatGet = $subcategory->catRead($_GET['category']);
}
?>

<nav class="customNavbar">
    <div class="nav-container-grid">
        <a class="navbar-brand" href='index.php'>LOGO</a>
        <a class="nav-link" href='cart.php'>
            <?php
            if (isset($_SESSION['cart'])) {
                $items = count($_SESSION['cart']);
                echo "<i class='fa fa-shopping-cart cart-image' aria-hidden='true'></i><sub class='cart-number'>" . $items . "</sub>";
            } else {
                echo "<i class='fa fa-shopping-cart cart-image' aria-hidden='true'></i><sub class='cart-number'>0</sub>";
            }
            ?>
        </a>
        <div class='search'>
            <form class='searchForm' action="search-results.php" method='GET'>
                <input type="text" placeholder="Search" name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <!-- <div class='desktop-menu'>
            <img class="dropbtn" src='View/Public/Images/menu.svg' id='menuBtn'></img>
        </div> -->
        <div class="dropdown">

            <button id='modalButton' onclick='openNav()' class='modalButton'>
                <img class="dropbtn" src='View/Public/Images/menu.svg'></img>
            </button>
            <script>
                function openNav() {
                    document.getElementById("simpleModal").style.width = "300px";
                }

                function closeNav() {
                    document.getElementById("simpleModal").style.width = "0";
                }
            </script>
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
    </div>
</nav>