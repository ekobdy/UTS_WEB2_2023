<?php
namespace Koneksi;

class Koneksi
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'barangku';
    private $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql)
    {
        return mysqli_query($this->connection, $sql);
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}


