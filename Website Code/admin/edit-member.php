<?php
function memberById($member_id, $connect) {
    $sql_query = "SELECT * FROM member WHERE member_id=?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$member_id]);

    return $stmt->rowCount() == 1 ? $stmt->fetch() : 0;
}
function getAllcommunity($connect){
    $sql_query = "SELECT * FROM community";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute();
    return $stmt->fetchAll();
  }
session_start();

if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role']) &&
    isset($_GET['member_id'])
) {
    if ($_SESSION['role'] == 'Admin') {
        include "../database-connection.php";
        $member_id = $_GET['member_id'];
        $member = memberById($member_id, $connect);
        $communities = getAllcommunity($connect);

        if ($member === 0) {
            header("Location: member.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit Community Member</title>
	<link rel="stylesheet" href="edit.css">
</head>
<body>
<?php 
    include "navbar.php";  ?>

<div class="back">
    <a href="member.php" class="back">Go Back</a>
</div>
<form method="post" class="edit" action="member-functions/edit-member.php">
    <h3>Edit Community Member</h3>
    <hr><?php
    if (isset($_GET['error'])) {
        echo '<div class="error">', $_GET['error'], '</div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="success">', $_GET['success'], '</div>';
    }?>
    <input type="text" value="<?= $member['member_id'] ?>" name="member_id" hidden>
    <div class="container">
        <div class="form-group">
            <label class="form-label">First Name:</label>
            <input type="text" 
            value="<?= $member['first_name'] ?>" 
            placeholder="Enter First Name" 
            name="first_name">
        </div>
        <div class="form-group">
            <label class="form-label">Last Name:</label>
            <input type="text" 
            value="<?= $member['last_name'] ?>" 
            placeholder="Enter Last Name" 
            name="last_name">
        </div>
        <div class="form-group">
            <label class="form-label">UserName:</label>
            <input type="text" 
            value="<?= $member['username'] ?>" 
            placeholder="Enter User Name" 
            name="username">
        </div>
        <div class="form-group">
            <label class="form-label">Email:</label>
            <input type="email" 
            value="<?= $member['email'] ?>" 
            placeholder="Enter Email" 
            name="email">
        </div>
        <div class="form-group">
            <label class="form-label">Phone:</label>
            <input type="tel" 
            value="<?= $member['phone'] ?>"
             placeholder="Enter Phone"
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

        <button type="submit" class="update">Update</button>
    </div>
</form>
<form method="post"
              class="edit" 
              action="member-functions/password-member.php"
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
                value="<?=$member['member_id']?>"
                name="member_id"
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
                       name="c_new_pass"
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
    header("Location: member.php");
    exit;
}
} else {
    header("Location: member.php");
    exit;
}
?>