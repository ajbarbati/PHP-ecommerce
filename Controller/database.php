<?php
    class Database {
        // CONNECTION DETAILS 
        private $host = 'restaurant-list-db-do-user-7144326-0.a.db.ondigitalocean.com:25060';
        private $user = 'Drop';
        private $pass = 'DropPwd';
        private $dbname = 'orderforsure';
        public $conn;

        function connect() {
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
            // $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $this->conn;
        }
         // Bind values
         public function bind($param, $value, $type = null) {
            if (is_null ($type)) {
                switch (true) {
                    case is_int ($value) :
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool ($value) :
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null ($value) :
                        $type = PDO::PARAM_NULL;
                        break;
                    default :
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
    }
