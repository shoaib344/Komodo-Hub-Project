<?php
function adminPasswordVerify($admin_pass, $connect, $admin_id)
{
    $sql = "SELECT password FROM admins WHERE admin_id=?";
    $stmt = $connect->prepare($sql);
    $stmt->execute([$admin_id]);

    if ($stmt->rowCount() == 1) {
        $admin = $stmt->fetch();
        $hashed_password = $admin['password'];

        if (password_verify($admin_pass, $hashed_password)) {
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
    isset($_POST['old_pass']) &&
    isset($_POST['new_pass']) &&
    isset($_POST['c_new_pass']) &&
    isset($_POST['admin_id'])
) {
    include '../database-connection.php';

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];
    $admin_id = $_POST['admin_id'];

    if (empty($old_pass) || empty($new_pass) || empty($c_new_pass)) {
        $em = "All fields are required";
        header("Location: admin-profile.php?error=$em");
        exit;
    } elseif ($new_pass !== $c_new_pass) {
        $em = "The Confirm Password does not match the New Password.";
        header("Location: admin-profile.php?error=$em");
        exit;
    } elseif (!adminPasswordVerify($old_pass, $connect, $admin_id)) {
        $em = "Incorrect old password";
        header("Location: admin-profile.php?error=$em");
        exit;
    } else {
        // Hashing the new password
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

        $sql = "UPDATE admins SET password = ? WHERE admin_id=?";
        $stmt = $connect->prepare($sql);

        if ($stmt->execute([$new_pass, $admin_id])) {
            $sm = "The password has been changed successfully!";
            header("Location: admin-profile.php?success=$sm");
            exit;
        } else {
            $em = "An error occurred when trying to change the password.";
            header("Location: admin-profile.php?error=$em");
            exit;
        }
    }
} else {
    $em = "An error occurred";
    header("Location: admin-profile.php?error=$em");
    exit;
}
?>
