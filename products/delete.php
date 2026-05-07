<?php
require_once '../classes/Product.php';

$product = new Product();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $product->delete($id);
}

header('Location: ../index.php');
exit;
