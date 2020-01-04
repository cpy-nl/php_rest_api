<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get connection
include_once '../config/Database.php';

// instantiate product object
include_once '../objects/Product.php';

$database = new Database();
$db = $databse->getConnection();

$product = new Product($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// maje sure the data is not empty
if (
    !empty($data->name) &&
    !empty($data->description) &&
    !empty($data->price) &&
    !empty($data->category_id)
) {
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    // create product
    if ($product->create()) {
        // set response code: 201 created
        http_response_code(201);

        // inform user
        echo json_encode(array("message" => "Product was created."));

    // unable to create
    } else {
        // set response code: 503 service unavailable
        http_response_code(503);

        // inform user
        echo json_encode(array("message" => "Unable to create ptoduct."));

    // data incomplete
    }
} else {
    
    // set response code: 400 bad request
    http_response_code(400);

    // inform user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>