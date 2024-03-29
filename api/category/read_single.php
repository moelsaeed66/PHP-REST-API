<?php
use models\Category;
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category
$category = new Category($db);

//Get id
$category->id=isset($_GET['id'])?$_GET['id']:die;

//Get Category
$category->read_single();

$category_arr=array(
    'id'=>$category->id,
    'name'=>$category->name
);
print_r(json_encode($category_arr));
