<?php
function UniqueUsername($username, $connect, $admin_id = 0) {
    $sql_query = "SELECT username, admin_id FROM admins WHERE username=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$username]);
  
    if ($admin_id == 0) {
        return $stmt->rowCount() === 0;
    } else {
        if ($stmt->rowCount() >= 1) {
            $admin = $stmt->fetch();
            return $admin['admin_id'] == $admin_id;
        } else {
            return true;
        }
    }
  }
session_start();
if (!isset($_SESSION['admin_id'], $_SESSION['role']) &&
    $_SESSION['role'] !== 'Admin') {
    header("Location: ../logout.php");
    exit;
}
if (!isset($_POST['first_name'], $_POST['last_name'], 
$_POST['username'], $_POST['password'])) {
    $error_message = "Incomplete data provided";
    header("Location: ../add-admin.php?error=$error_message");
    exit;
}
include '../../database-connection.php';
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$password = $_POST['password'];
if (empty($first_name) || empty($last_name) || empty($username) || 
empty($password) ) {
    $error_message = "All fields are required";
    header("Location: ../add-admin.php?error=$error_message");
    exit;
}
if (!UniqueUsername($username, $connect)) {
    $error_message = "Username is taken! Try another.";
    header("Location: ../add-admin.php?error=$error_message");
    exit;
}
$password = password_hash($password, PASSWORD_DEFAULT);
$sql_query = "INSERT INTO admin(username, password, first_name, last_name) 
VALUES(?,?,?,?)";
$stmt = $connect->prepare($sql_query);
if (!$stmt->execute([$username, $password, $first_name, $last_name])){
    $error_message = "An error occurred";
    header("Location: ../add-admin.php?error=$error_message");
    exit;
}
$sql_user_query = "INSERT INTO users(username, password) VALUES(?,?)";
$stmt_user = $connect->prepare($sql_user_query);
if (!$stmt_user->execute([$username, $password])) {
    $error_message = "An error occurred";
    header("Location: ../add-admin.php?error=$error_message");
    exit;
}
$error_message = "New Admin Registered Successfully";
header("Location: ../add-admin.php?success=$error_message");
exit;
?>