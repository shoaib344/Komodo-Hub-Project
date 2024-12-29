<?php
function schoolById($school_id, $connect) {
    $sql_query = "SELECT * FROM schools WHERE school_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$school_id]);

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
    isset($_GET['school_id'])
) {
    if ($_SESSION['role'] == 'Admin') {
        include "../database-connection.php";
        $school_id = $_GET['school_id'];
        $school = schoolById($school_id, $connect);
        $schools = getAllSchools($connect);

        if ($school === 0) {
            header("Location: school.php");
            exit;
        }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit school</title>
	<link rel="stylesheet" href="edit.css">
</head>
<body>
<?php 
    include "navbar.php";  ?>
<div class="back">
    <a href="school.php" class="back">Go Back</a>
</div>
<form method="post" class="edit" action="school-functions/edit-school.php">
    <h3>Edit school</h3><hr>
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error">', $_GET['error'], '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="success">', $_GET['success'], '</div>';
    }?>
    <input type="text" value="<?= $school['school_id'] ?>" name="school_id" hidden>
    <div class="container">
    <div class="form-group">
          <label class="form-label">School Name:</label>
          <input type="text" 
          value="<?= $school['school_name'] ?>"
                 placeholder="Enter School Name"
                 name="school_name">
        </div>   
        <div class="form-group">
          <label class="form-label"> School Address:</label>
          <input type="text"
          value="<?= $school['school_address'] ?>"
                 placeholder="Enter School Address Name"
                 name="school_address">
        </div>
        <div class="form-group">
            <label class="form-label">School Type:</label>
            <select name="school_type">
            <option value="Govt" <?= ($school['school_type'] == 'Govt') ? 'selected' : '' ?>>Govt</option>
            <option value="Private" <?= ($school['school_type'] == 'Private') ? 'selected' : '' ?>>Private</option>
            <option value="Other" <?= ($school['school_type'] == 'Other') ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <button type="submit" class="update">Update</button>
    </div>
</form>
</body>
</html>
<?php
} else {
    header("Location: school.php");
    exit;
}
} else {
    header("Location: school.php");
    exit;
}?>