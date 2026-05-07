<?php
class Database
{
    protected $conn;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $host = 'localhost';
        $db = 'retail_db';
        $user = 'root';
        $pass = '';
        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
