<?php

use models\Category;

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Category($db);

//Get data
$data=json_decode(file_get_contents("php://input"));

//SET Data
$category->id=$data->id;
$category->name=$data->name;
if($category->update())
{
    echo json_encode(['message'=>'category update']);
}else
{
    echo json_encode(['message'=>'category not update']);
}
