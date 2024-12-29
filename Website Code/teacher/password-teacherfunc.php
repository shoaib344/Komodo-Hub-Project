<?php
function TeacherPasswordVerify($teacher_password, $connect, $teacher_id)
{
    $sql_query = "SELECT password FROM teachers WHERE teacher_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() == 1) {
        $teacher = $stmt->fetch();
        $hashed_password = $teacher['password'];

        if (password_verify($teacher_password, $hashed_password)) {
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
    isset($_POST['teacher_id'])
) {
    include '../database-connection.php';

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $teacher_id = $_POST['teacher_id'];

    if (empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "All fields are required";
        header("Location: teacher-profile.php?error=$error_message");
        exit;
    } elseif ($new_password !== $confirm_new_password) {
        $error_message = "The Confirm Password does not match the New Password.";
        header("Location: teacher-profile.php?error=$error_message");
        exit;
    } elseif (!TeacherPasswordVerify($old_password, $connect, $teacher_id)) {
        $error_message = "Invalid Old Password";
        header("Location: teacher-profile.php?error=$error_message");
        exit;
    } else {
        // Hashing the new password
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql_query = "UPDATE teachers SET password = ? WHERE teacher_id=?";
        $stmt = $connect->prepare($sql_query);

        if ($stmt->execute([$new_password, $teacher_id])) {
            $success_message = "The password has been changed successfully!";
            header("Location: teacher-profile.php?success=$success_message");
            exit;
        } else {
            $error_message = "An error occurred when trying to change the password.";
            header("Location: teacher-profile.php?error=$error_message");
            exit;
        }
    }
} else {
    $error_message = "An error occurred";
    header("Location: teacher-profile.php?error=$error_message");
    exit;
}
?>
