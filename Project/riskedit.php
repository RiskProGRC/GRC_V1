<?php
include_once'../Project/risk/riskClass.php';
$riskclass= new riskClass();

$rid=$_POST["rid"];

if($rid){
    
    $riskedit=$riskclass->fetchRisk($rid);
    echo json_encode($riskedit);
}else{
    echo "no value picked";
}

?>