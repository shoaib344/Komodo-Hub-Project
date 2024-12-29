<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {
       
    if ($_SESSION['role'] == 'Admin') {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Home</title>
      
        <style>
    
    body {

    background-color: rgb(229, 235, 237);
    font-family: Arial, Helvetica, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .button-container {
      display: flex;
      flex-wrap: wrap;
     text-align: center;
    }

    .button-section {
      border: 2px solid #000;
      text-decoration: none;
      color: #000;
      border-radius: 20px;
       font-size: 20px;
      padding: 50px;
      margin: 50px;
      align-content: center;
      cursor: pointer;
      background: #f0ffea;
      display:flex;
    }
    
    .button-section:hover{
        background-color: #7defb0;
    }


            </style> 

</head>
<body>
    <?php 
        include "navbar.php";
     ?>
 <div align="center">
  <h1>Admin Dashboard</h1>
</div>
  <div class="button-container">
       
  <a href="admin-home.php" class="button-section">Home</a>
  <a href="school.php" class="button-section">Schools</a>
    <a href="teacher.php" class="button-section">Teachers</a>
    <a href="student.php" class="button-section">Students</a>
    <a href="community.php" class="button-section">Communities</a>
    <a href="member.php" class="button-section">Members</a>
 
  </div>

  <div class="button-container">
  
    
    <a href="../logout.php" class="button-section">Logout</a>

  </div>



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