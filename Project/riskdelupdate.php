<?php
include_once'./risk/riskClass.php';
$riskClass= new riskClass();

$rid=$_POST["riskid"];
if($rid){
    $rdata=$riskClass->fetchdelRisk($rid);
    echo json_encode($rdata);
}
?>