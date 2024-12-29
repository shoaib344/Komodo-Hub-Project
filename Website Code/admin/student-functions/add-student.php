<?php
function UniqueUsername($username, $connect, $student_id = 0) {
    $sql_query = "SELECT username, student_id FROM students WHERE username=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$username]);
  
    if ($student_id == 0) {
        return $stmt->rowCount() === 0;
    } else {
        if ($stmt->rowCount() >= 1) {
            $student = $stmt->fetch();
            return $student['student_id'] == $student_id;
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
$_POST['username'], $_POST['password'], $_POST['email'],
$_POST['phone'],$_POST['date_of_birth'],$_POST['gender'],$_POST['school_id'])) {
    $error_message = "Incomplete data provided";
    header("Location: ../add-student.php?error=$error_message");
    exit;
}
include '../../database-connection.php';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $school_id = $_POST['school_id'];
if (empty($first_name) || empty($last_name) || empty($username) || 
empty($password) || empty($email) ||empty($phone) ||empty($date_of_birth)||empty($gender) || empty($school_id)) {
    $error_message = "All fields are required";
    header("Location: ../add-student.php?error=$error_message");
    exit;
}
if (!UniqueUsername($username, $connect)) {
    $error_message = "Username is taken! Try another.";
    header("Location: ../add-student.php?error=$error_message");
    exit;
}
$password = password_hash($password, PASSWORD_DEFAULT);
$sql_query = "INSERT INTO students(username, password, first_name, last_name, email, phone, date_of_birth, gender, school_id) 
VALUES(?,?,?,?,?,?,?,?,?)";
$stmt = $connect->prepare($sql_query);
if (!$stmt->execute([$username, $password, $first_name, $last_name, $email, $phone, $date_of_birth, $gender, $school_id])) {
    $error_message = "An error occurred";
    header("Location: ../add-student.php?error=$error_message");
    exit;
}
$sql_user_query = "INSERT INTO users(username, password) VALUES(?,?)";
$stmt_user = $connect->prepare($sql_user_query);
if (!$stmt_user->execute([$username, $password])) {
    $error_message = "An error occurred";
    header("Location: ../add-student.php?error=$error_message");
    exit;
}
$error_message = "New student registered successfully";
header("Location: ../add-student.php?success=$error_message");
exit;
?>