<?php
include_once'./risk/riskClass.php';
$riskclass=new riskClass();

$id=$_POST['id'];

if($id)
{
    $assdata = $riskclass->showass($id);
    echo json_encode($assdata);
}
?>