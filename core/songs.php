<?php

class Songs{
 
    // database connection and table name
    private $conn;
    private $table_name = "songs";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // get all songs
    function getAll(){        
        $result = [];
        $qry = $this->conn->prepare("SELECT id, category_id, song_name, created_date FROM ". $this->table_name . ";");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id, $category_id, $song_name, $created_date);
                while($qry->fetch()) {
                    $result[$id] = [
                        'category_id' => $category_id,
                        'song_name' => $song_name,
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
    function getSongsByCategoryId($category_id){
        $result = [];
        $qry = $this->conn->prepare("SELECT id, song_name, created_date FROM ". $this->table_name ." WHERE category_id = ". $category_id ." LIMIT 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('i', $category_id);
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id, $song_name, $created_date);
                while($qry->fetch()) {
                    $result[$id] = [
                        'song_name' => $song_name,
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

    // get song by id
    function getBySongId($id){
        $result = [];
        $qry = $this->conn->prepare("SELECT category_id, song_name, created_date FROM ". $this->table_name ." WHERE id = ". $id ." LIMIT 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('i', $id);
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($category_id, $song_name, $created_date);
                $qry->fetch();         
                $result['category_id'] = $category_id;
                $result['song_name'] = $song_name;
                $result['created_date'] = $created_date;
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        
        return $result;        
    }   

    // insert new song
    function addNewSong($category_id, $song_name) {
        $qry = $this->conn->prepare("INSERT INTO ". $this->table_name ." SET category_id = ?, song_name = ?;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('is', $category_id, $song_name);
            if ($qry->execute()) {
                
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
    }
}