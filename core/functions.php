<?php
include_once("./config/database.php");
include_once("./core/category.php");

$database = new Database();
$db = $database->getConnection();

// prepare category object
$category_db = new Category($db);

function getAllCategories() {
    global $category_db;
    return $category_db->getAll();
}

?>