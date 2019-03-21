<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "musiconholdnow_db";
    private $username = "root";
    private $password = "root";
    public $conn;
    
    // constructor database connection
    public function __construct(){
        $this->conn = null;
 
        try{
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);            
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
    }
    // get the database connection
    public function getConnection(){
        return $this->conn;
    }
}
?>