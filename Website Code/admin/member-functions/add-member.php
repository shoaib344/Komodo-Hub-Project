<?php
function UniqueUsername($username, $connect, $member_id = 0) {
    $sql_query = "SELECT username, member_id FROM member WHERE username=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$username]);
  
    if ($member_id == 0) {
        return $stmt->rowCount() === 0;
    } else {
        if ($stmt->rowCount() >= 1) {
            $member = $stmt->fetch();
            return $member['member_id'] == $member_id;
        } else {
            return true;
        }
    }
  }

// Check if the user is authorized
session_start();
if (!isset($_SESSION['admin_id'], $_SESSION['role']) &&
    $_SESSION['role'] !== 'Admin') {
    header("Location: ../logout.php");
    exit;
}

// Check for incomplete data
if (!isset($_POST['first_name'], $_POST['last_name'], 
$_POST['username'], $_POST['password'], $_POST['email'],
$_POST['phone'],$_POST['community_id'])) {
    $error_message = "Incomplete data provided";
    header("Location: ../add-member.php?error=$error_message");
    exit;
}

include '../../database-connection.php';


// Extract values from $_POST
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$community_id = $_POST['community_id'];

// Check for empty fields
if (empty($first_name) || empty($last_name) || empty($username) || 
empty($password) || empty($email) ||empty($phone) || empty($community_id)) {
    $error_message = "All fields are required";
    header("Location: ../add-member.php?error=$error_message");
    exit;
}

// Check for unique username
if (!UniqueUsername($username, $connect)) {
    $error_message = "Username is taken! Try another.";
    header("Location: ../add-member.php?error=$error_message");
    exit;
}

// Hash the password
$password = password_hash($password, PASSWORD_DEFAULT);

// Insert data into the database
$sql_query = "INSERT INTO member(username, password, first_name, last_name, email, phone, community_id) 
VALUES(?,?,?,?,?,?,?)";
$stmt = $connect->prepare($sql_query);

// Check for execution success
if (!$stmt->execute([$username, $password, $first_name, $last_name,$email,$phone, $community_id])){
    $error_message = "An error occurred";
    header("Location: ../add-member.php?error=$error_message");
    exit;
}
// Insert data into the users table
$sql_user_query = "INSERT INTO users(username, password) VALUES(?,?)";
$stmt_user = $connect->prepare($sql_user_query);

// Set the role for users (e.g., 'Student' or 'Teacher')

// Check for execution success
if (!$stmt_user->execute([$username, $password])) {
    $error_message = "An error occurred";
    header("Location: ../add-member.php?error=$error_message");
    exit;
}
$error_message = "New member registered successfully";
header("Location: ../add-member.php?success=$error_message");
exit;
?>