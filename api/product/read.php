<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection
include_once '../config/Database.php';
include_once '../objects/Product.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize the object
$product = new Product($db);

// read products
$stmt = $product->read();
$num = $stmt->rowCount();

// check for records
if ($num > 0) {

    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name,
        );

        array_push($products_arr["records"], $product_item);
    }

    // set repsonse code: 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($products_arr);
} else {
    // no products found?
    http_response_code(404);

    // show message
    echo json_encode(
        array("message" => "No products found.")
    );

}