<?php
include_once './connection/connect.php';

$pid = $_POST["processid"];

if($pid){
    $stmt = $con->prepare("SELECT * FROM risk WHERE process=?"); // prepare query, ? = safe placeholder
    $stmt->bind_param("i", $pid);  // bind $pid as integer to ?
    $stmt->execute();               // run the query
    $result = $stmt->get_result();  // get results
    $count = $result->num_rows;     // count rows

    if($count > 0){
        echo '<option value="">----------Select Risk-----------</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row["risk_id"].'">'.$row["risk_name"].'</option>'; // output each risk
        }
    } else {
        echo '<option>NO VALUES SELECTED</option>';
    }

    $stmt->close(); // close statement
}
