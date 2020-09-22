<?php
session_start();
$cart = $_SESSION['cart'];
$total = $_SESSION['total'];
$deletedItem = $_GET['cartItem'];
function deleteI($C, $T, $I)
{
    $iSeparated = explode(',', $I);
    if ($C[$iSeparated[0]][0] == $iSeparated[1]) {
        echo 'deleted';
        unset($C[$iSeparated[0]]);
        unset($T[$iSeparated[0]]);
        echo '<br>';
        echo '<br>';
        echo 'Rob AJax';
        print_r($C);
        print_r($T);
        unset($_SESSION['cart']);
        $resetcart = array_values($C);
        $_SESSION['cart'] = $resetcart;
    } else {
        echo 'error';
    }
};
echo '<br>';
echo '$CART = ';
print_r($cart);
echo '<br>';
echo '$TOTAL= ';
var_dump($_SESSION['total']);
echo '<br>';
echo '$DELETEDITEM = ';
echo $deletedItem;
echo '<br>';
print_r($total);
echo '<--- total';

deleteI($cart, $total, $deletedItem);



