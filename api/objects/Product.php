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

    // read products
    function read() {

        // select all
        $query =    "SELECT
                        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM
                    " . $this->table_name . " p
                    LEFT JOIN 
                        categories c
                            ON p.category_id = c.id
                    ORDER BY
                        p.created DESC";
        
        // prepare statement
        $stmt = $this->connection->prepare($query);

        // execute
        $stmt->execute();

        return $stmt;
    }
}
?>