<?php
include_once'./control/controlClass.php';
$controlclass=new controlClass();

$cid=$_POST["controlid"];

if($cid){
    $cdata=$controlclass->fetchcontrol($cid);
    echo json_encode($cdata);

}

?>