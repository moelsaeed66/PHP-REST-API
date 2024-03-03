<?php

use models\Category;
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category
$category = new Category($db);

//Get data
$data=json_decode(file_get_contents("php://input"));

//set id
$category->id=$data->id;
if($category->delete())
{
    echo json_encode(['message'=>'category deleted']);
}else
{
    echo json_encode(['message'=>'category not deleted']);
}
