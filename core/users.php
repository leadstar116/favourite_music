<?php

class Users{
 
    // database connection and table name
    private $conn;
    private $table_name = "admin_users";
 
    public $username;
    public $email;
    public $user_id;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // check login
    function checkLogin($username, $password){
        $result = [
            'success' => false
        ];
        $qry = $this->conn->prepare("SELECT id, email, created_date FROM ". $this->table_name ." WHERE name = '". $username ."' AND password=sha1('". $password ."') limit 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id, $email, $created_date);
                while($qry->fetch()) {
                    if($id) {
                        $result['success'] = true;
                        $result['id'] = $id;
                        $this->username = $username;
                        $this->email = $email;
                        $this->user_id = $id;
                    } else {
                        $result['success'] = false;
                    }
                }
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        
        return $result;        
    }    

    // user signup
    function userRegister($username, $email, $password) {
        $result = [
            'success' => false
        ];

        $qry = $this->conn->prepare("SELECT id FROM ". $this->table_name ." WHERE name = ? OR email = ? limit 1;");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('ss', $username, $email);
            if ($qry->execute()) {
                $qry->store_result();
                $qry->bind_result($id);
                if($qry->fetch()) {
                    if($id) {
                        $result['error'] = 'User already exists';
                        $result['id'] = $id;
                        $qry->close();
                        return $result;
                    }
                }
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();

        $qry = $this->conn->prepare("INSERT INTO ". $this->table_name ." SET name = ?, email = ?, password=sha1(?);");
        if ($qry === false) {
            trigger_error(mysqli_error($this->conn));
        } else {
            $qry->bind_param('sss', $username, $email, $password);
            if ($qry->execute()) {
                $result['user_id'] = $this->conn->insert_id;
                $result['success'] = true;
            } else {
                trigger_error(mysqli_error($this->conn));
            }
        }
        $qry->close();
        return $result;
    }
}