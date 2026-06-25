<?php
include_once 'config.php'; // load DB credentials

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); // single shared connection
