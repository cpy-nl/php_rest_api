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

    // constructor method
    public function __construct($db){
        $this->connection = $db;
    }

    // read products method
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

    // create product method
    function create(){
        // query to insert record
        $query =    "INSERT INTO
                    " . $this->table_name . "
                    SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    
        // prepare query
        $stmt = $this->connection->prepare($query);
    
        // sanitize data
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
}
?>