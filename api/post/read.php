<?php

// Headers
use models\Post;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//include file
include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//instantiate post
$post=new Post($db);

//get posts
$posts=$post->read();

//Posts row
$num=$posts->rowCount();
if($num>0)
{
    $post_arr=array();
    while ($row=$posts->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $post_item=array(
            'id'=>$id,
            'title'=>$title,
            'author'=>$author,
            'body'=>html_entity_decode($body),
            'category_id'=>$category_id,
            'category_name'=>$category_name
        );

        //push in array
        array_push($post_arr,$post_item);

    }
    echo json_encode($post_arr);
}else{
    echo json_encode(['message'=>'no posts found']);
}

