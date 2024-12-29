<?php

function teacherById($teacher_id, $connect) {
    $sql_query = "SELECT * FROM teachers WHERE teacher_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$teacher_id]);

    return $stmt->rowCount() == 1 ? $stmt->fetch() : 0;
}
function getAllSchools($connect){
    $sql_query = "SELECT * FROM schools";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role']) &&
    isset($_GET['teacher_id'])
) {
    if ($_SESSION['role'] == 'Admin') {
        include "../database-connection.php";
        $teacher_id = $_GET['teacher_id'];
        $teacher = teacherById($teacher_id, $connect);
        $schools = getAllSchools($connect);

        if ($teacher === 0) {
            header("Location: teacher.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Teacher</title>
	<link rel="stylesheet" href="edit.css">
</head>
<body>
<?php 
    include "navbar.php";  ?>
<div class="back">
    <a href="teacher.php" class="back">Go Back</a>
</div>
<form method="post" class="edit" action="teacher-functions/edit-teacher.php">
    <h3>Edit Teacher</h3>
    <hr>
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">', $_GET['error'], '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="success">', $_GET['success'], '</div>';
    }
    ?>
    <input type="text" value="<?= $teacher['teacher_id'] ?>" name="teacher_id" hidden>
    <div class="container">
        <div class="form-group">
            <label class="form-label">First Name:</label>
            <input type="text" 
            value="<?= $teacher['first_name'] ?>" 
            placeholder="Enter First Name" 
            name="first_name">
        </div>
        <div class="form-group">
            <label class="form-label">Last Name:</label>
            <input type="text" 
            value="<?= $teacher['last_name'] ?>" 
            placeholder="Enter Last Name" 
            name="last_name">
        </div>
        <div class="form-group">
            <label class="form-label">UserName:</label>
            <input type="text" 
            value="<?= $teacher['username'] ?>" 
            placeholder="Enter User Name" 
            name="username">
        </div>
        <div class="form-group">
            <label class="form-label">Email:</label>
            <input type="email" 
            value="<?= $teacher['email'] ?>" 
            placeholder="Enter Email" 
            name="email">
        </div>
        <div class="form-group">
            <label class="form-label">Phone:</label>
            <input type="tel" 
            value="<?= $teacher['phone'] ?>"
             placeholder="Enter Phone"
              name="phone">
        </div>
        <div class="form-group">
            <label class="form-label">Date of Birth:</label>
            <input type="date" 
            value="<?= $teacher['date_of_birth'] ?>" 
            name="date_of_birth">
        </div>
        <div class="form-group">
            <label class="form-label">Gender:</label>
            <select name="gender">
            <option value="Male" <?= ($teacher['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($teacher['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= ($teacher['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
    <label class="form-label">School Name:</label>
    <select name="school_id">
        <?php foreach ($schools as $school): ?>
            <option value="<?= $school['school_id'] ?>" >
                <?= $school['school_name'] ?>
            </option>
        <?php endforeach ?>
    </select>
</div>
        <button type="submit" class="update">Update</button>
    </div>
</form>
<form method="post"
              class="edit" 
              action="teacher-functions/password-teacher.php"
              id="change_password">
        <h3>Change Password</h3><hr>
         <?php
    if (isset($_GET['perror'])) {
        echo '<div class="error">', $_GET['perror'], '</div>';
    }
    if (isset($_GET['psuccess'])) {
        echo '<div class="success">', $_GET['psuccess'], '</div>';
    }
    ?>
 <input type="text"
                value="<?=$teacher['teacher_id']?>"
                name="teacher_id"
                hidden>
       <div class="container">
       <div class="form-group">
            <label class="form-label">Admin password</label>
                <input type="password" 
                      placeholder="Enter Admin Password "
                       name="admin_pass"> 
          </div>
          <div class="form-group">
          <label class="form-label">New password </label>   
                <input type="text" 
                       class="form-control"
                       name="new_pass"
                       placeholder="Enter Password "
                       id="passInput">
                <button class="btn btn-secondary"
                        id="gBtn">
                        Random</button>
            
            
          </div>
       
                <div class="form-group">
            <label class="form-label">Confirm new password  </label>
                <input type="text" 
                       class="form-control"
                       placeholder="Enter Confirm Password "
                       name="confirm_new_pass"
                       id="passInput2"> 
          </div>
          <button type="submit" 
              class="edit">
              Change Password</button>
        </form>
     </div>
     <script>
    function makePass(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;

        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        var passInput = document.getElementById('passInput');
        var passInput2 = document.getElementById('passInput2');
        passInput.value = result;
        passInput2.value = result;
    }
    var gBtn = document.getElementById('gBtn');
    gBtn.addEventListener('click', function (e) {
        e.preventDefault();
        makePass(4);
    });
</script>


</body>
</html>

<?php
} else {
    header("Location: teacher.php");
    exit;
}
} else {
    header("Location: teacher.php");
    exit;
}
?>