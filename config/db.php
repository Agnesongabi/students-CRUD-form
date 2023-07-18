<?php
class DB {
    private $host = "localhost";
    // private $username = "kwtrpuser";
    private $username = "root";
    // private $password = "KWTRP2009_";
    private $password = "";
    private $dbname = "kwtrp";
    public $conn;

  

    // Constructor: Establish database connection
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to execute a database query
    public function query($sql) {
        return $this->conn->query($sql);
    }
}
?>
