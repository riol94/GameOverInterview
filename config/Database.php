<?php 
    class Database {
        
        private $host = 'localhost';
        private $db_name = 'test';
        private $username = 'test';
        private $password = 'uc6KMrPiunig1ti4';
        private $conn;

        public function __construct(){
            
        }

        public function connect() {
            $this->conn = null;

            try {

                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $ex) {
                echo 'Connection Error: '.$e->getMessage();
            }

            return $this->conn;
        }
    }