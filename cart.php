<?php
// Connections 
    // Includes
        require "./View/header.php";
        include './Controller/database.php';
        include_once "./Model/product.php";
        include_once "./Model/details.php";
        include_once "./Model/card.php";
        include_once "./Model/categories.php";
        include_once "./Model/subcategories.php";
    // Includes

    // DB Connection
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
    // DB Connection

    // Nav & Side-Nav Includes
        include_once './View/nav.php';
        include './View/side-nav.php';
    // /Nav & Side-Nav Includes
// Connections 
?>
<div class="cart-container">
    <div class="products-cart">
        <?php

        // Sets total & loads cart
            $_SESSION['total'] = array();
            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                loadCart($cart, $_SESSION['total']);
            } else {
                echo 'Empty....','<br>','<br>';

            }
        // /Sets total & loads cart
        
        // Sets, deletes, & displays cart items
            if (isset($_POST['cartItem'])) {
                $deletedItem = $_POST['cartItem'];
            }

            if (isset($_POST['cartItem'])) {
                echo $_POST['cartItem'];
            };

            function deleteI($C, $T, $I)
            {
                $iSeparated = explode(',', $I);
            
                if ($C[$iSeparated[0]][0] == $iSeparated[1]) {
                    echo 'deleted';
                    unset($C[$iSeparated[0]]);
                    unset($T[$iSeparated[0]]);
                    print_r($C);
                } else {
                    echo 'error';
                }
            };
        // /Sets, deletes, & displays cart items

        // Displays users cart & total
            function loadCart($C, $T)
            {
                if (isset($C)) {
                    $i = 0;
                    // Display Cart Items
                        echo '<div id="cart-items-container">';
                        foreach ($C as $value) {
                            $deleteValue = "'" . $i++ . ',' . $value[0] . "'";
                            echo "<table class='es-left' cellspacing='0' cellpadding='0' align='left'>
                                        <tbody>
                                            <tr>
                                                <td class='es-m-p0r es-m-p20b esd-container-frame' width='180' valign='top' align='center'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td align='center' class='esd-block-image' style='font-size: 0px; margin-top:5px'>
                                                                <a target='_blank'><img class='adapt-img' src='View/Public/Images/product-images/".$value[0].".jpg' alt style='display: block; margin-top: 10px;' width='50'></a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table cellspacing='0' cellpadding='0' align='right'>
                                        <tbody>
                                            <tr>
                                                <td class='esd-container-frame' width='360' align='left'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td align='left' class='esd-block-text es-p5t'>
                                                                    <table style='width: 100%;' class='cke_show_border' cellspacing='0' cellpadding='0' border='0'>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <p style='line-height: 100%;'><strong class='p_name'>" . $value[1] . "</strong></p>
                                                                                </td>
                                                                                <td style='text-align: center;' width='15%'>
                                                                                    <p class='p_quantity' style='line-height: 100%;'>1</p>
                                                                                </td>
                                                                                <td style='text-align: center;' width='30%'>
                                                                                    <p class='p_price' style='line-height: 100%;'>$" . $value[2] . "</p>
                                                                                </td>
                                                                                </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                <form class='cart-element' method='GET' action='?' id='" . $value[0] . "'>
                                                                    <button value='" . $value[0] . "' id=" . $deleteValue . " type='submit' onClick=" . 'del(' . $deleteValue . ')' . " name='cartItem' class='btn btn-danger'>X</button>
                                                                </form>
                                                            </tr>
                                                            <tr>
                                                                <td align='left' class='esd-block-text'>
                                                                    <p style='color: #999999; margin:0px;'>" . $value[7] . "</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    


                                    <table border='0' width='100%' height='0px' cellpadding='0' cellspacing='0' style='text-align:center;'>
                                        <tbody>
                                            <tr>
                                                <td style='border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;'></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            ";
                            $T[] = (int)$value[2];
                        }
                        echo '</div>';
                    // /Display Cart Items

                    // Display Cart Totals
                        echo "<table class='es-content esd-footer-popover' cellspacing='0' cellpadding='10' align='right'>
                                <tbody>
                                    <tr>
                                        <td class='esd-block-text' align='right'>
                                            <p style='line-height: 100%; font-size: 16px; margin:0;'>
                                                <span style='font-size:18px; margin-left:200px;'>
                                                    Subtotal:<br>
                                                    Shipping<br>
                                                    Discount:<br>
                                                    Tax:
                                                </span><br>
                                                <span style='font-size:20px;'><strong>Order Total:</strong></span>
                                            </p>
                                        </td>
                                        
                                        <td class='esd-block-text' align='left' style='margin-left:50px;'>
                                            <p style='line-height: 100%; font-size: 16px; margin:0;'>
                                                <span style='font-size:18px;'>
                                                    <span style='font-size:17px;'>
                                                        $".number_format(array_sum($T), 2)."<br>
                                                        $0.00<br>
                                                        $0.00
                                                    </span><br>
                                                    <span style='font-size:17px;'>$".number_format(round(7.25*array_sum($T)/100), 2)."</span>
                                                </span><br>
                                                <span style='font-size:19px;'><strong>$".number_format(round((7.25*array_sum($T)/100)+array_sum($T)), 2)."</strong></span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        ";
                    // /Display Cart Totals
                } else {
                    echo "Empty...";
                }
            }
        // Displays users cart & total

        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        function myAjax($data) {
            $.ajax({
                url: 'Controller/ajax-calls.php',
                data: {
                    cartItem: $data
                },
                type: 'GET',
                success: function () {
                    setInterval(function(){location.reload()}, 500)
                    
                    }
            });
        }

        function del(id) {
            document.getElementById(id).remove()
            console.log('yo')
            myAjax(id)
        }
    </script>

    <!-- Empty cart & checkout buttons -->
        <a href="Controller/delete.php" class='delete'><button type="button" class="btn btn-danger">Empty Cart</button></a>
        <?php
            echo "<form method='POST' action='formDelivery.php' class='checkOut'><button type='submit' class='btn btn-success'>Checkout</button></form>";
        ?>
    <!-- /Empty cart & checkout buttons -->

</div>
        

<?php
    if (isset($_POST["submit"])) {
        unset($_SESSION['cart']);
    };
?>