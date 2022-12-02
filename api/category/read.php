<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../Models/Category.php';

// Instantiate DB && connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Category object
$category = new Category($db);

// Blog Category query 
$result = $category->read();
// get row count
$num = $result->rowCount();

// Check if any Categories
if ($num > 0) {
  // Category array
  $categories_arr = array();
  $categories_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $category_item = array(
      'id' => $id,
      'name' => $name,
    );

    // Push to data
    array_push($categories_arr['data'], $category_item);
  }

  // Turn to JSON && output
  echo json_encode($categories_arr);
} else {
  // No Categories
  echo json_encode(
    array('massage' => 'No Category founds')
  );
}
