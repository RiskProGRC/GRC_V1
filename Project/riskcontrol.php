<?php
include_once'./control/controlClass.php';

$controlClass=new controlClass();


$risk=$_POST["risk"];
$control=$_POST["control"];

$alert=$controlClass->addriskcontrol($risk,$control);
echo $alert;

?>


