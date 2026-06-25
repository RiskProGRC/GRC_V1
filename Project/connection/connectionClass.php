<?php
include_once 'config.php'; // load DB credentials

//$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

class connectionClass extends mysqli
{
    public mixed $conn;

    function __construct()
    {
        $this->conn = $this->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
}
