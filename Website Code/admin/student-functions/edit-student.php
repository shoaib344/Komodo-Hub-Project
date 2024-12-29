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
      }}}
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {   
  include '../../database-connection.php';
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $student_id = $_POST['student_id'];
  $school_id = $_POST['school_id'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender = $_POST['gender'];
  $urlData = 'student_id=' . $student_id;
  if (empty($first_name) || empty($last_name) || empty($username) || empty($school_id) || empty($email) || empty($phone) || empty($date_of_birth) || empty($gender)) {
      $error_message = "All fields are required";
      header("Location: ../edit-student.php?error=$error_message&$urlData");
      exit;
  } elseif (!UniqueUsername($username, $connect, $student_id)) {
      $error_message = "Username is taken! Try another.";
      header("Location: ../edit-student.php?error=$error_message&$urlData");
      exit;
  } else {
      $sql_query = "UPDATE students SET username=?, first_name=?, last_name=?, school_id=?, email=?, phone=?, date_of_birth=?, gender=? WHERE student_id=?";
      $stmt = $connect->prepare($sql_query);
      $stmt->execute([$username, $first_name, $last_name, $school_id, $email, $phone, $date_of_birth, $gender, $student_id]);
      $success_message = "Successfully updated!";
      header("Location: ../edit-student.php?success=$success_message&$urlData");
      exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}?>