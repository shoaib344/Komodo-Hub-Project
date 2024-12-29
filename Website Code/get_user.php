<?php
include "../database-connection.php";

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $sqlAdmins = "SELECT admin_id AS user_id, username FROM admin WHERE username LIKE ?";
    $stmtAdmins = $connect->prepare($sqlAdmins);
    $stmtAdmins->execute(["%$search%"]);
    $admins = $stmtAdmins->fetchAll(PDO::FETCH_ASSOC);

    $sqlTeachers = "SELECT teacher_id AS user_id, username FROM teachers WHERE username LIKE ?";
    $stmtTeachers = $connect->prepare($sqlTeachers);
    $stmtTeachers->execute(["%$search%"]);
    $teachers = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);

    $sqlStudents = "SELECT student_id AS user_id, username FROM students WHERE username LIKE ?";
    $stmtStudents = $connect->prepare($sqlStudents);
    $stmtStudents->execute(["%$search%"]);
    $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

    $users = array_merge($admins, $teachers, $students);

    echo json_encode($users);
}
?>