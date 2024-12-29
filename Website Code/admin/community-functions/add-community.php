<?php
session_start();
if (!isset($_SESSION['admin_id'], $_SESSION['role']) &&
    $_SESSION['role'] !== 'Admin') {
    header("Location: ../logout.php");
    exit;
}

if (!isset($_POST['community_name'], $_POST['community_address']
)) {
    $error_message = "Incomplete data provided";
    header("Location: ../add-community.php?error=$error_message");
    exit;
}
include '../../database-connection.php';
$community_name = $_POST['community_name'];
$community_address = $_POST['community_address'];
if (empty($community_name) || empty($community_address) 
) {
    $error_message = "All fields are required";
    header("Location: ../add-community.php?error=$error_message");
    exit;
}
$sql_query = "INSERT INTO community(community_name, community_address) 
VALUES(?,?)";
$stmt = $connect->prepare($sql_query);
if (!$stmt->execute([$community_name,$community_address])){
    $error_message = "An error occurred";
    header("Location: ../add-community.php?error=$error_message");
    exit;
}

$error_message = "New Community Registered Successfully";
header("Location: ../add-community.php?success=$error_message");
exit;
?>