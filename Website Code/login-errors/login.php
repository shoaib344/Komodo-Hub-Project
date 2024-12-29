<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
   
    include "../database-connection.php";

    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $inputRole = $_POST['role'];

    if (empty($inputUsername) || empty($inputPassword)) {
        $error_message = "Username and Password are Required";
        header("Location: ../login.php?error=$error_message");
        exit;
    } else {
        if ($inputRole == '1') {
            $sql_query = "SELECT * FROM admins WHERE username = ?";
            $userRole = "Admin";
        } elseif ($inputRole == '2') {
            $sql_query = "SELECT * FROM teachers WHERE username = ?";
            $userRole = "Teacher";
        } elseif ($inputRole == '3') {
            $sql_query = "SELECT * FROM students WHERE username = ?";
            $userRole = "Student";
        }elseif ($inputRole == '4') {
            $sql_query = "SELECT * FROM member WHERE username = ?";
            $userRole = "Community Member";
        }

        $stmt = $connect->prepare($sql_query);
        $stmt->execute([$inputUsername]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            $Username = $user['username'];
            $Password = $user['password'];
            $id = $user['id'];

            if ($Username === $inputUsername && password_verify($inputPassword, $Password)) {
                $_SESSION['role'] = $userRole;
                $_SESSION['id'] = $id;

                if ($userRole == 'Admin') {
                    $adminId = $user['admin_id'];
                    $_SESSION['admin_id'] = $adminId;
                    header("Location: ../admin/admin-home.php");
                    exit;
                } elseif ($userRole == 'Teacher') {
                    $teacherId = $user['teacher_id'];
                    $_SESSION['teacher_id'] = $teacherId;
                    header("Location: ../teacher/teacher-home.php");
                    exit;
                } elseif ($userRole == 'Student') {
                    $studentId = $user['student_id'];
                    $_SESSION['student_id'] = $studentId;
                    header("Location: ../student/student-home.php");
                    exit;
                }elseif ($userRole == 'Community Member') {
                    $memberId = $user['member_id'];
                    $_SESSION['member_id'] = $memberId;
                    header("Location: ../member/member-home.php");
                    exit;
                }
            } else {
                $error_message = "Invalid Username or Password";
                header("Location: ../login.php?error=$error_message");
                exit;
            }
        } else {
            $error_message = "Invalid Username or Password";
            header("Location: ../login.php?error=$error_message");
            exit;
        }
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>