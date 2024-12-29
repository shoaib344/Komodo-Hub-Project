
<?php 
function getAllcommunities($connect){
        $sql_query = "SELECT * FROM community";
        $stmt = $connect->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
      }
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
      
       include "../database-connection.php";
       $communities = getAllcommunities($connect);?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Community Member</title>
    <link rel="stylesheet" href="add.css">
</head>
<body>
<?php 
    include"navbar.php";  ?>
     <div class="back">
        <a href="member.php"
           class="back">Go Back</a>
        <form method="post"
              class="add" 
              action="member-functions/add-member.php">
              <h3>Add Community Member</h3>
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
                     placeholder="Enter Password "
                     name="password"
                     id="passInput">
              <button class="pass"
                      id="randomPassButton">
                      Random</button>
          </div>
          
        </div>
        <div class="form-group">
          <label class="form-label"> Email Address:</label>
          <input type="email"
                 placeholder="Enter Email Address Name"
                 name="email">
        </div>
        <div class="form-group">
          <label class="form-label">Phone Number:</label>
          <input type="tel" 
                 placeholder="Enter Phone Number "
                 name="phone">
        </div>
        <div class="form-group">
    <label class="form-label">Community Name:</label>

    <select name="community_id">
        <?php foreach ($communities as $community): ?>
            <option value="<?= $community['community_id'] ?>" >
                <?= $community['community_name'] ?>
            </option>
        <?php endforeach ?>
    </select>
</div>
      <button type="submit" class="add">Add</button>
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
