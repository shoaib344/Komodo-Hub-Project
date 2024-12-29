<?php
function StudentpasswordVerify($student_password, $connect, $student_id)
{
$sql_query = "SELECT password FROM students WHERE student_id=?";
$stmt = $connect->prepare($sql_query);
$stmt->execute([$student_id]);

if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    $hashed_password = $student['password'];

    if (password_verify($student_password, $hashed_password)) {
        return true;
    } else {
        return false;
    }
} else {
    return false;
}
}
session_start();
if (
isset($_POST['old_password']) &&
isset($_POST['new_password']) &&
isset($_POST['confirm_new_password']) &&
isset($_POST['student_id'])
) {
    include '../database-connection.php';

$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];
$student_id = $_POST['student_id'];

if (empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
    $error_message = "All fields are required";
    header("Location: student-profile.php?error=$error_message");
    exit;
} elseif ($new_password !== $confirm_new_password) {
    $error_message = "The Confirm password does not match the New password.";
    header("Location: student-profile.php?error=$error_message");
    exit;
} elseif (!StudentpasswordVerify($old_password, $connect, $student_id)) {
    $error_message = "Invalid old password";
    header("Location: student-profile.php?error=$error_message");
    exit;
} else {
    // Hashing the new password
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql_query = "UPDATE students SET password = ? WHERE student_id=?";
    $stmt = $connect->prepare($sql_query);

    if ($stmt->execute([$new_password, $student_id])) {
        $success_message = "The password has been changed successfully!";
        header("Location: student-profile.php?success=$success_message");
        exit;
    } else {
        $error_message = "An error occurred when trying to change the password.";
        header("Location: student-profile.php?error=$error_message");
        exit;
    }
}
} else {
    $error_message = "An error occurred";
    header("Location: student-profile.php?error=$error_message");
    exit;
}
?>
