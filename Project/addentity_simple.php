<?php
/**
 * SIMPLE ENTITY ADD - Digital Ocean Compatible
 * Alternative endpoint for adding entities with robust error handling
 */

// Start session for user tracking
session_start();

// Database connection
include_once'./department/departmentClass.php';

// Set content type for proper response
header('Content-Type: text/plain; charset=utf-8');

try {
    // Initialize database connection
    $deptclass = new departmentClass();

    // Get POST data with proper validation
    $uid = isset($_POST["uid"]) && !empty($_POST["uid"]) ? intval($_POST["uid"]) : null;
    $ipaddress = isset($_POST["ip"]) && !empty($_POST["ip"]) ? $_POST["ip"] : $_SERVER['REMOTE_ADDR'];
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $company = isset($_POST["company"]) && !empty($_POST["company"]) ? intval($_POST["company"]) : null;
    $owner = isset($_POST["owner"]) && !empty($_POST["owner"]) ? intval($_POST["owner"]) : null;
    $function = isset($_POST["function"]) ? trim($_POST["function"]) : '';

    // Validation with detailed error messages
    $errors = [];

    if($uid === null) {
        $errors[] = "User ID is required";
    }

    if(empty($name)) {
        $errors[] = "Entity name is required";
    }

    if($company === null) {
        $errors[] = "Company selection is required";
    }

    if($owner === null) {
        $errors[] = "Owner selection is required";
    }

    if(empty($function)) {
        $errors[] = "Entity function is required";
    }

    // If validation errors exist, return them
    if(!empty($errors)) {
        echo "VALIDATION ERROR: " . implode(", ", $errors);
        exit;
    }

    // Add entity to database
    $result = $deptclass->addDept($uid, $ipaddress, $name, $company, $owner, $function);

    // Return success message
    echo $result;

} catch (Exception $e) {
    // Catch any database or system errors
    error_log("Entity Add Error: " . $e->getMessage());
    echo "ERROR: Unable to add entity. Please contact system administrator.";
}
?>
