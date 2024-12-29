<?php
session_start();
if (!isset($_SESSION['admin_id'], $_SESSION['role']) &&
    $_SESSION['role'] !== 'Admin') {
    header("Location: ../logout.php");
    exit;
}
if (!isset($_POST['school_name'], $_POST['school_address'], 
$_POST['school_type'])) {
    $error_message = "Incomplete data provided";
    header("Location: ../add-school.php?error=$error_message");
    exit;
}
include '../../database-connection.php';
$school_name = $_POST['school_name'];
$school_address = $_POST['school_address'];
$school_type = $_POST['school_type'];
if (empty($school_name) || empty($school_address) || empty($school_type) 
) {
    $error_message = "All fields are required";
    header("Location: ../add-school.php?error=$error_message");
    exit;
}
$sql_query = "INSERT INTO schools(school_name, school_address, school_type) 
VALUES(?,?,?)";
$stmt = $connect->prepare($sql_query);
if (!$stmt->execute([$school_name,$school_address,$school_type])){
    $error_message = "An error occurred";
    header("Location: ../add-school.php?error=$error_message");
    exit;
}
$error_message = "New school registered successfully";
header("Location: ../add-school.php?success=$error_message");
exit;
?>