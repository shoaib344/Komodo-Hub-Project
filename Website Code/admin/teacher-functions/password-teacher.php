<?php 
function teacherById($teacher_id, $connect) {
  $sql_query_query = "SELECT * FROM teachers WHERE teacher_id=?";
  $stmt = $connect->prepare($sql_query_query);
  $stmt->execute([$teacher_id]);

  return $stmt->rowCount() == 1 ? $stmt->fetch() : 0;
}

function adminPasswordVerify($admin_pass, $connect, $admin_id){
  $sql_query = "SELECT * FROM admins
          WHERE admin_id=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$admin_id]);

  if ($stmt->rowCount() == 1) {
    $admin = $stmt->fetch();
    $pass  = $admin['password'];

    if (password_verify($admin_pass, $pass)) {
      return 1;
    }else {
      return 0;
    }
  }else {
   return 0;
  }
}

session_start();
if (isset($_POST['admin_pass']) &&
    isset($_POST['new_pass']) &&
    isset($_POST['c_new_pass']) &&
    isset($_POST['teacher_id'])) {

    include '../../database-connection.php';

    $admin_pass = $_POST['admin_pass'];
    $new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];

    $teacher_id = $_POST['teacher_id'];
    $id = $_SESSION['admin_id'];

    $data = 'teacher_id=' . $teacher_id . '#change_password';

    if (empty($admin_pass) || empty($new_pass) || empty($c_new_pass)) {
        $error_message = "All fields are required";
        header("Location: ../edit-teacher.php?perror=$error_message&$data");
        exit;
    } elseif ($new_pass !== $c_new_pass) {
        $error_message = "The Confirm Password does not match the New Password.";
        header("Location: ../edit-teacher.php?perror=$error_message&$data");
        exit;
    } elseif (!adminPasswordVerify($admin_pass, $connect, $id)) {
        $error_message = "Invalid Admin Password";
        header("Location: ../edit-teacher.php?perror=$error_message&$data");
        exit;
    } else {
       
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

        $sql_query = "UPDATE teachers SET password = ? WHERE teacher_id=?";
        $stmt = $connect->prepare($sql_query);

        if ($stmt->execute([$new_pass, $teacher_id])) {
            $success_message = "The password has been changed successfully!";
            header("Location: ../edit-teacher.php?psuccess=$success_message&$data");
            exit;
        } else {
            $error_message = "An error occurred when trying to change the password.";
            header("Location: ../edit-teacher.php?perror=$error_message&$data");
            exit;
        }
    }
} else {
    $error_message = "An error occurred";
    header("Location: ../edit-teacher.php?error=$error_message");
    exit;
}