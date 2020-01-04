<?php
class Product {
    // connection and table name
    private $connection;
    private $table_name = "products";

    // object  props
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // constructor 
    public function __construct($db){
        $this->connection = $db;
    }

}
?>