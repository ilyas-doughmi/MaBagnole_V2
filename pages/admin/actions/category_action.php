<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/Category.php";

$db = DB::connect();
$category = new Category($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add_category'])) {
        $category->category_name = $_POST['category_name'];
        $category->category_description = $_POST['category_description'];
        
        $category->addCategory();
        header("Location: ../categories.php");
        exit();
    }

    if (isset($_POST['delete_category'])) {
        $id = $_POST['category_id'];
        $category->deleteCategory($id);
        header("Location: ../categories.php");
        exit();
    }
    
    if (isset($_POST['update_category'])) {
        $category->category_id = $_POST['category_id'];
        $category->category_name = $_POST['category_name'];
        $category->category_description = $_POST['category_description'];
        $category->updateCategory();
        header("Location: ../categories.php");
        exit();
    }
}
