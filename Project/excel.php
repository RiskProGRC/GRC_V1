<?php
if(isset($_POST["ExportType"]))
{
   
    switch($_POST["ExportType"])
    {
        case "export-to-excel" :
            // Submission from
      $filename = "riskregister_".date('Ymd') . ".xls";     
            header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");
      //ExportFile($tasks);
      $_POST["ExportType"] = '';
            exit();
        default :
            die("Unknown action : ".$_POST["action"]);
            break;
    }
}
function ExportFile($records) {
  $heading = false;
    if(!empty($records))
      foreach($records as $row) {
      if(!$heading) {
        // display field/column names as a first row
        echo implode("\t", array_keys($row)) . "\n";
        $heading = true;
      }
      echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}
?>