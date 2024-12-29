<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Komodo Hub</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
    body {
    background-color: rgb(229, 235, 237);
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
}

.header {
    width: auto;
    background-color: #7defb0;
    color: #fff;
    text-align: center;
    padding: 10px;
    border-radius: 6px;
}

.container {
    text-align: center;
    margin-top: 25px;
    width: 25%;
    font-size: 20px;
    height: auto;
    background-color: rgb(255, 255, 255);
    border: 2px solid #000000;
    box-shadow: 0 0 10px rgb(173, 212, 197);
    border-radius: 10px;
    margin: 0 auto;
    padding: 25px;
    box-sizing: border-box;
}

.form-group {
    width: 80%;
    text-align: left;
    margin-bottom: 30px;
    margin-top: 25px;
}

input,
select {
    font-size: 16px; /* Adjusted font size */
    width: 100%; /* Changed width to 100% */
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button[type="submit"] {
    font-size: 18px; /* Adjusted font size */
    background-color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    color: #000000;
}

button[type="submit"]:hover {
    background-color: #7defb0;
    color: #fff;
}

a {
    color: #000000;
    font-size: 18px; /* Adjusted font size */
}



.alert {
    text-align: center;
    font-size: 18px; /* Adjusted font size */
    background-color: lightpink;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
}

footer {
    margin-top: 80px;
    background-color: #7defb0;
    color: #fff;
    text-align: center;
    padding: 10px;
    border-radius: 6px;
}
</style>

</head>
<body>

    <header class="header">
        <h1>Komodo Hub - User Login</h1>
    </header>

    <div class="container">
        <form class="login-form" method="post" action="login-errors/login.php">
                <div class="alert" >
				<?php if (isset($_GET['error'])) { ?>
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter User Name">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password">
            </div>

            <div class="form-group">
                <label for="role">Login As</label>
                <select id="role" name="role">
                    <option value="1">Admin</option>
                    <option value="2">Teacher</option>
                    <option value="3">Student</option>
                    <option value="4">Community Member</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <a href="wl_home_page.php" >Home</a>
        </form>  
    </div>
    <footer>
        <p>&copy; 2023 Komodo Hub. All rights reserved.</p>
    </footer>

</body>
</html>



<!-- 
<div class="tex">
					
                    $inputPassword =1234;
                    $inputPassword =password_hash($inputPassword,PASSWORD_DEFAULT);					
                   echo  $inputPassword

                   
                   </div> -->