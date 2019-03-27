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
        $qry = $this->conn->prepare("SELECT c.id, c.category_name, (SELECT sum(s.downloaded_count) FROM songs s WHERE s.category_id = c.id) as popularity, c.created_date, (SELECT count(*) FROM songs s WHERE s.category_id = c.id) as song_count FROM ". $this->table_name . " c ORDER BY popularity DESC;");
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
        $qry = $this->conn->prepare("SELECT c.category_name, (SELECT sum(s.downloaded_count) FROM songs s WHERE s.category_id = c.id) as popularity, c.created_date, (SELECT count(*) FROM songs s WHERE s.category_id = c.id) as song_count FROM ". $this->table_name ." c WHERE id = ". $id ." LIMIT 1;");
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

    // check if category exist
    function checkCategoryExist($category_name) {
        $result = [
            'success' => false
        ];

        $qry = $this->conn->prepare("SELECT id FROM ". $this->table_name ." WHERE category_name = ? limit 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('s', $category_name);
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id);
                if($qry->fetch()) {
                    if($id) {
                        $result['error'] = 'This category is already exist';
                        $qry->close();
                        return $result;
                    }
                }
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();

        $result['success'] = true;
        return $result;
    }

    // add new category
    function addCategory($category_name) {
        $result = $this->checkCategoryExist($category_name);        
        if($result['success']) {
            $qry = $this->conn->prepare("INSERT INTO ". $this->table_name ." SET category_name = ?;");
            if ($qry === false) {
                trigger_error(mysqli_error($this->conn));
            } else {
                $qry->bind_param('s', $category_name);
                if ($qry->execute()) {
                    $result['success'] = true;
                } else {
                    trigger_error(mysqli_error($this->conn));
                }
            }
            $qry->close();
        }
        return $result;
    }

    // remove category
    function removeCategory($category_id) {
        $qry = $this->conn->prepare("DELETE FROM ". $this->table_name ." WHERE id = ?;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('i', $category_id);
            if ($qry->execute()) {
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
    }
}