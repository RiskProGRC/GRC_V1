<?php
include_once'../Project/risk/riskClass.php';

$riskclass= new riskClass();
$rid=$_POST["riskid"];

if($rid){
    $rdata=$riskclass->fetchRisk($rid);
    echo json_encode($rdata);

}

?>

