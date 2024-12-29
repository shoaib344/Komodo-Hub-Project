<?php
function memberPasswordVerify($member_pass, $connect, $member_id)
{
    $sql = "SELECT password FROM member WHERE member_id=?";
    $stmt = $connect->prepare($sql);
    $stmt->execute([$member_id]);

    if ($stmt->rowCount() == 1) {
        $member = $stmt->fetch();
        $hashed_password = $member['password'];

        if (password_verify($member_pass, $hashed_password)) {
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
    isset($_POST['member_id'])
) {
    include '../database-connection.php';

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];
    $member_id = $_POST['member_id'];

    if (empty($old_pass) || empty($new_pass) || empty($c_new_pass)) {
        $em = "All fields are required";
        header("Location: member-profile.php?error=$em");
        exit;
    } elseif ($new_pass !== $c_new_pass) {
        $em = "The Confirm Password does not match the New Password.";
        header("Location: member-profile.php?error=$em");
        exit;
    } elseif (!memberPasswordVerify($old_pass, $connect, $member_id)) {
        $em = "Invalid Old Password";
        header("Location: member-profile.php?error=$em");
        exit;
    } else {
        // Hashing the new password
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

        $sql = "UPDATE member SET password = ? WHERE member_id=?";
        $stmt = $connect->prepare($sql);

        if ($stmt->execute([$new_pass, $member_id])) {
            $sm = "The password has been changed successfully!";
            header("Location: member-profile.php?success=$sm");
            exit;
        } else {
            $em = "An error occurred when trying to change the password.";
            header("Location: member-profile.php?error=$em");
            exit;
        }
    }
} else {
    $em = "An error occurred";
    header("Location: member-profile.php?error=$em");
    exit;
}
?>
