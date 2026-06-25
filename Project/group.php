<?php
include_once'../Project/company/companyClass.php';
$companyClass= new companyClass();

    $file=$_FILES["file"]["name"];
    
    $uid=$_POST['uid']; 
    $ipaddress= $_POST["ip"]; 
    $name=$_POST["groupname"];
    $address=$_POST["address"];
    $logo= basename($file);
    $website=$_POST["website"];
    $country=$_POST["country"];
    $objectives=$_POST["objectives"];
    
    
    
  
    if(empty($name) && empty($address) && empty($website) && empty($country) && empty($objectives)){
        echo "insert data";
    }
    elseif(empty($logo)){

        echo "please select a file to upload";

    }else{

        $alert=$companyClass->group($uid,$ipaddress,$name,$address,$logo,$country,$website,$objectives);
        echo $alert;

    }
?>