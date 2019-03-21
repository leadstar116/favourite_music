<?php

class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "Categories";
 
    // object properties
    public $id;
    public $username;
    public $email;
    public $password;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // get all categories
    function getAll(){        
        $result = [];
        $qry = $this->conn->prepare("SELECT id, category_name, category_popularity, created_date FROM ". $this->table_name . " ORDER BY category_popularity DESC;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id, $category_name, $category_popularity, $created_date);
                while($qry->fetch()) {
                    $result[$id] = [
                        'category_name' => $category_name,
                        'category_popularity' => $category_popularity,
                        'created_date' => $created_date
                    ];
                }
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        
        return $result;       
    }

    // get category by id
    function getById($id){
        $result = [];
        $qry = $this->conn->prepare("SELECT category_name, category_popularity, created_date FROM ". $this->table_name ." WHERE id = ". $id ." LIMIT 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('i', $id);
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($category_name, $category_popularity, $created_date);
                $qry->fetch();         
                $result['category_name'] = $category_name;
                $result['category_popularity'] = $category_popularity;
                $result['created_date'] = $created_date;
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        
        return $result;        
    }    
}