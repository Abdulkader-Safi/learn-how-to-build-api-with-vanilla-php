<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../Models/Category.php';

// Instantiate DB && connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog category object
$category = new Category($db);

// Get row category data
$data = json_decode(file_get_contents("php://input"));

// Set id to update
$category->id = $data->id;

$category->name = $data->title;

// Update category
if ($category->update()) {
  echo json_encode(
    array(
      'message' => 'category Updated'
    )
  );
} else {
  echo json_encode(
    array(
      'message' => 'category Not Updated'
    )
  );
}
