<?php
session_start();
include_once'./login/loginClass.php';
$loginclass= new loginClass();

$uid = $_SESSION["uid"] ?? null;
$loginclass->logout($uid);

unset($_SESSION["uid"]);
unset($_SESSION["user"]);

session_destroy();

header("Location:../login.php");
?>