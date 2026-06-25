<?php
include_once'./recommend/recommendClass.php';
$recommendclass=new recommendClass();

$rid=$_POST["rid"];
if($rid){
    $recommend=$recommendclass->recdelupdate($rid);
    echo json_encode($recommend);
}

?>