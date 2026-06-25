<?php
include_once'../Project/connection/connect.php';

//include phpspreadsheet library autoloader
require_once '../assets/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST["importsubmit"])){
     // allowed mime types or excel save types
     $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     //validate whether selected file is excel
     if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){
        //if file is ok and checksout and uploaded

        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $reader= new Xlsx();
            $spreadsheet= $reader->load($_FILES['file']['tmp_name']);
            $worksheet= $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            //Remove header row
            unset($worksheet_arr[0]);

            foreach($worksheet_arr as $row){
                $kra=$row[0];
                $performance=$row[1];
                $baseline=$row[2];
                $target=$row[3];
                $weight=$row[4];

               //validate and check whether another email exists in the records
               $result= $db->query("SELECT id FROM bsctool WHERE performance='".$performance."'");

               if($result->num_rows>0){
                //update the record to the database
                //$db->query("UPDATE members SET fname='".$fname."',lname='".$lname."',email='".$email."',
                //phone='".$phone."',status='".$status."',modified=NOW() WHERE email='".$email."' ");


               }else{
                //insert record to db
                $db->query("INSERT INTO bsctool(kra,performance,baseline,target,weight,created,modified) 
                VALUES('".$kra."','".$performance."','".$baseline."','".$target."','".$weight."',NOW(),NOW()) ");
               }
            }

                $qstring='?status:succ';
            }else{
                $qstring='?status:err';
            }
          
     }else{
        $qstring='?status:invalidfile';
     }
}
//redrect
Header('Location:bsciso.php'.$qstring);


?>