<?php
include_once './connection/connect.php';

$did = $_POST['dept_id'];

if($did){
    $stmt = $con->prepare("SELECT process_id FROM dept_process WHERE dept_id=?"); // prepare query, ? = safe placeholder
    $stmt->bind_param("i", $did);    // bind $did as integer to ?
    $stmt->execute();                // run the query
    $result = $stmt->get_result();   // get results
    $count = $result->num_rows;      // count rows

    if($count > 0){
        echo "<option value=''>SELECT Process</option>";
        while($row = $result->fetch_assoc()){
            $pid = $row['process_id'];

            $stmt2 = $con->prepare("SELECT * FROM process WHERE id=?"); // get process name by ID
            $stmt2->bind_param("i", $pid); // bind $pid as integer
            $stmt2->execute();             // run query
            $pname = $stmt2->get_result()->fetch_assoc(); // fetch row

            echo '<option value="'.$row['process_id'].'">'.$pname['name'].'</option>';
            $stmt2->close(); // close inner statement
        }
    } else {
        echo '<option>No state Found</option>';
    }

    $stmt->close(); // close outer statement
}
