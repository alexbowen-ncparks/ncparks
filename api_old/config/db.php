<?php

class DB
{
    private $host = 'mariadb';
    private $user = 'root';
    private $pass = 'password';
    private $dbname = 'dprcal_new';

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
