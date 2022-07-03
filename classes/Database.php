<?php

    class Database{

        public $conn;

        //INIT DATABASE CONNECTION
        public function __construct(){

            $host = "localhost";
            $username = "root";
            $password = "";
            $db_name = "form_captcha";

            try {
                $connection = new PDO("mysql:host=$host; dbname=$db_name", $username,$password);
                $this->conn = $connection;
            }catch(PDOException $e){
                echo "Connection Error: " . $e->getMessage();
            }
        }
    }


?>