<?php
class Card {

    // Function to make card that takes in all necessary variables
        public function makeCard($cat,$sub,$pro,$name,$descr){
            echo "
            <form name='card' action='Controller/add-to-cart.php' method='POST' id='{$cat}{$sub}{$pro}{$name}'>
                <div class='product-card' style='width: 18rem;'>
                    <a class='product-image-container' href='individual-product.php?cat={$cat}&sub={$sub}&pro={$pro}'>
                        <img class='product-image' src='View/Public/Images/product-images/{$cat}{$sub}{$pro}.jpg' alt='{$name} - {$descr}'>
                    </a>
                    <div class='product-card-body'>
                        <a href='individual-product.php?cat={$cat}&sub={$sub}&pro={$pro}'><h6 class='card-title'>{$name}</h6></a>
                        <p class='product-card-text'>{$descr}</p>
                        <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <input type='checkbox' id='{$cat}{$sub}{$pro}{$name}' name='product' value='{$name}' checked style='display:none;'>
                                <input type='checkbox' id='{$cat}{$name}' name='cat' value='{$cat}' checked style='display:none;'>
                                <input type='checkbox' id='{$sub}{$name}' name='sub' value='{$sub}' checked style='display:none;'>
                                <input type='checkbox' id='{$pro}{$name}' name='prod' value='{$pro}' checked style='display:none;'>
                                <input type='checkbox' id='{$pro}{$name}$cat}' name='descr' value='{$descr}' checked style='display:none;'>
                                <button type='submit' key='{$cat}{$sub}{$pro}' name='combined' value='{$cat}{$sub}{$pro}' class='btn btn-success text-white add-to-cart-btn' onclick='scrollSave.scroll()'><i class='fa fa-cart-plus' aria-hidden='true'></i></button>
                            </div>
                            <select class='custom-select' name='price' id='{$pro}' aria-label='Example select with button addon'>
            ";
        }
}

?>
