<?php
    session_start();
    if (isset($_POST['price'])) {
        $deets = explode(',',$_POST['price']);
        $deets[0]; //price
        $deets[1];//id
    }
    $id = isset($_POST['combined']) ? $_POST['combined'] : null;
    $price = $deets[0];
    $name = isset($_POST['product']) ? $_POST['product'] : null;
    $descr = isset($_POST['descr']) ? $_POST['descr'] : null;
    $detail_id = $deets[1];
    $cat = isset($_POST['cat']) ? $_POST['cat'] : null;
    $sub = isset($_POST['sub']) ? $_POST['sub'] : null;
    $prod = isset($_POST['prod']) ? $_POST['prod'] : null;
    $idF = floatval($id);
    var_dump($id);
    if (!isset($cart)) {
        $cart = array();
    }

    $productInfo = array($id, $name, $price, $cat,  $sub, $prod, $detail_id, $descr );

    // check if the item is in the array, if it is, do not add
    if (array_key_exists($id, $_SESSION['cart'])) {
        // redirect to product list and tell the user it was added to cart
        header('Location: ../cart.php');
    } else {
        $_SESSION['cart'][] = $productInfo;
        // redirect to product list and tell the user it was added to cart
        header('Location: ../index.php');
    }
?>

<p>
    <h1>ITEM ADDED</h1>
    <?php
    echo "<a href='../index.php'>go home </a>"
    ?>
</p>