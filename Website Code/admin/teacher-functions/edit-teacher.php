<?php 
function UniqueUsername($username, $connect, $teacher_id = 0) {
  $sql_query = "SELECT username, teacher_id FROM teachers WHERE username=?";
  $stmt = $connect->prepare($sql_query);
  $stmt->execute([$username]);
  if ($teacher_id == 0) {
      return $stmt->rowCount() === 0;
  } else {
      if ($stmt->rowCount() >= 1) {
          $teacher = $stmt->fetch();
          return $teacher['teacher_id'] == $teacher_id;
      } else {
          return true;
      }
  }
}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
  
  include '../../database-connection.php';
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $teacher_id = $_POST['teacher_id'];
  $school_id = $_POST['school_id'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender = $_POST['gender'];
  $urlData = 'teacher_id=' . $teacher_id;
  if (empty($first_name) || empty($last_name) || empty($username) || empty($school_id) || empty($email) || empty($phone) || empty($date_of_birth) || empty($gender)) {
      $error_message = "All fields are required";
      header("Location: ../edit-teacher.php?error=$error_message&$urlData");
      exit;
  } elseif (!UniqueUsername($username, $connect, $teacher_id)) {
      $error_message = "Username is taken! Try another.";
      header("Location: ../edit-teacher.php?error=$error_message&$urlData");
      exit;
  } else {
      $sql_query = "UPDATE teachers SET username=?, first_name=?, last_name=?, school_id=?, email=?, phone=?, date_of_birth=?, gender=? WHERE teacher_id=?";
      $stmt = $connect->prepare($sql_query);
      $stmt->execute([$username, $first_name, $last_name, $school_id, $email, $phone, $date_of_birth, $gender, $teacher_id]);
      $success_message = "Successfully updated!";
      header("Location: ../edit-teacher.php?success=$success_message&$urlData");
      exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}
?>