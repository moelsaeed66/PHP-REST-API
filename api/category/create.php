<?php

use models\Category;
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category
$category = new Category($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

// Create Category
if($category->create()) {
    echo json_encode(
        ['message' => 'Category Created']
    );
} else {
    echo json_encode(
        ['message' => 'Category Not Created']
    );
}





