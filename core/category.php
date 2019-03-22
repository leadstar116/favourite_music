<?php

class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // get all categories
    function getAll(){        
        $result = [];
        $qry = $this->conn->prepare("SELECT c.id, c.category_name, c.category_popularity, c.created_date, (SELECT count(*) FROM songs s WHERE s.category_id = c.id) as song_count FROM ". $this->table_name . " c ORDER BY category_popularity DESC;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id, $category_name, $category_popularity, $created_date, $songs_count);
                while($qry->fetch()) {
                    $result[$id] = [
                        'category_name' => $category_name,
                        'category_popularity' => $category_popularity,
                        'created_date' => $created_date,
                        'songs_count' => $songs_count
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
        $qry = $this->conn->prepare("SELECT c.category_name, c.category_popularity, c.created_date, (SELECT count(*) FROM songs s WHERE s.category_id = c.id) as song_count FROM ". $this->table_name ." c WHERE id = ". $id ." LIMIT 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($category_name, $category_popularity, $created_date, $songs_count);
                $qry->fetch();         
                $result['category_name'] = $category_name;
                $result['category_popularity'] = $category_popularity;
                $result['created_date'] = $created_date;
                $result['songs_count'] = $songs_count;
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        
        return $result;        
    }    
}