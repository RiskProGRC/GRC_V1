<?php
include_once'./process/processClass.php';
$processclass=new processClass();

$pid=$_POST['option'];
//echo $pid;
 if($pid)
{
    $pdata = $processclass->showp_dept($pid);
    echo json_encode($pdata);
} 
?>