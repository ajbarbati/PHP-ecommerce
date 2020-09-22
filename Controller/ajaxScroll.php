<?php
session_start();
if ($_GET['scroll'] == null) {
    $_SESSION['scrollSet'] = 'DIDNT WORK';
} else {
    $_SESSION['scrollSet'] = $_GET['scroll'];
}