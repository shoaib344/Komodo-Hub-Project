
<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {  
       include "../database-connection.php";      
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add New Admin</title>
  <link rel="stylesheet" href="add.css">
</head>
<body>
<?php 
    include"navbar.php";  
?>
  <div class="back">
    <a href="admin.php"
        class="back">Go Back</a>
    <form method="post"
        class="add" 
        action="admin-functions/add-admin.php">
        <h3>Add New Admin</h3>
              <hr>
        <?php
if (isset($_GET['error'])) {
    echo '<div class="error">' , 
    $_GET['error'] , '</div>' ;
}
if (isset($_GET['success'])) {
    echo '<div class="success">' ,
     $_GET['success'] , '</div>' ;
}
?>
    <div class="container">
    <div class="form-group">
      <label class="form-label">First Name:</label>
      <input type="text" 
              placeholder="Enter First Name" 
              name="first_name">
    </div>
    <div class="form-group">
    <label class="form-label">Last Name:</label>
    <input type="text" 
      placeholder="Enter Last Name"
      name="last_name">
    </div>
    <div class="form-group">
      <label class="form-label">User Name:</label>
      <input type="text" 
          placeholder="Enter User Name"
          name="username">
    </div>
    <div class="form-group">
      <label class="form-label">Password:</label>
      <div class="input-group form-group">
          <input type="text" 
            placeholder="Generate password randomly OR Enter password manually"
            name="password"
            id="passInput">
          <button class="pass"
            id="randomPassButton">
            Random</button>
      </div>
    </div>
  <button type="submit" class="add">Add </button>
     </form>
    </div>     
<script>
    function generateRandomPassword() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return Array.from({ length: 4 }, function() {
            return characters[Math.floor(Math.random() * characters.length)];
        }).join('');
    }
    document.getElementById('randomPassButton').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('passInput').value = generateRandomPassword();
    });
</script>
</body>
</html>
<?php 
  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 
?>
