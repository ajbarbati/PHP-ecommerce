<?php   
    $_SESSION['page'] = $_POST['submit'];
    echo 'success';
    print_r($_SESSION{'page'});
    header('Location: View/products.php');
?>