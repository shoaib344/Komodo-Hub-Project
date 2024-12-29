<?php 
function memberById($member_id, $connect) {
  $sql_query = "SELECT * FROM member WHERE member_id=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$member_id]);

  return $stmt->rowCount() == 1 ? $stmt->fetch() : 0;
}
function adminPasswordVerify($admin_password, $connect, $admin_id){
  $sql_query = "SELECT * FROM admin WHERE admin_id=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$admin_id]);
  if ($stmt->rowCount() == 1) {
    $admin = $stmt->fetch();
    $password  = $admin['password'];
    if (password_verify($admin_password, $password)) {
      return 1;
    }else {
      return 0;
    }
  }else {
   return 0;
  }
}
session_start();
if (isset($_POST['admin_password']) &&
    isset($_POST['new_pass']) &&
    isset($_POST['confirm_new_pass']) &&
    isset($_POST['member_id'])) {
    include '../../database-connection.php';
    $admin_password = $_POST['admin_password'];
    $new_pass = $_POST['new_pass'];
    $confirm_new_pass = $_POST['confirm_new_pass'];
    $member_id = $_POST['member_id'];
    $id = $_SESSION['admin_id'];
    $data = 'member_id=' . $member_id . '#change_password';
    if (empty($admin_password) || empty($new_pass) || empty($confirm_new_pass)) {
        $error_message = "All fields are required";
        header("Location: ../edit-member.php?perror=$error_message&$data");
        exit;
    } elseif ($new_pass !== $confirm_new_pass) {
        $error_message = "The Confirm Password does not match the New Password.";
        header("Location: ../edit-member.php?perror=$error_message&$data");
        exit;
    } elseif (!adminPasswordVerify($admin_password, $connect, $id)) {
        $error_message = "Invalid Admin Password";
        header("Location: ../edit-member.php?perror=$error_message&$data");
        exit;
    } else { 
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql_query = "UPDATE member SET password = ? WHERE member_id=?";
        $stmt = $connect->prepare($sql_query);
        if ($stmt->execute([$new_pass, $member_id])) {
            $success_message = "The password has been changed successfully!";
            header("Location: ../edit-member.php?psuccess=$success_message&$data");
            exit;
        } else {
            $error_message = "An error occurred when trying to change the password.";
            header("Location: ../edit-member.php?perror=$error_message&$data");
            exit;
        }
    }
} else {
    $error_message = "An error occurred";
    header("Location: ../edit-member.php?error=$error_message");
    exit;
}?>