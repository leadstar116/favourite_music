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
    // signup user
    function signup(){
        $result = mysqli_fetch_array($this->conn->query("select addUser('".$this->username."', '". $this->email."', '". $this->password."')"));                        
        $result = json_decode($result[0], true);
        if($result['success']) {
            $this->id = $result['id'];           
        }  
        return $result;        
    }
    // login user
    function login(){        
        $result = mysqli_fetch_array($this->conn->query("select login('".$this->email."', '".$this->password."')"));
        $result = json_decode($result[0], true);
        
        if($result['success']) {
            $this->id = $result['id'];
            $this->username = $result['username'];
        }  
        return $result;        
    }
}