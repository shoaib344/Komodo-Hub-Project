<?php
function getmemberById($connect, $member_id) {
    $sql_query = "SELECT * FROM member WHERE member_id = ?";
    $stmt = $connect->prepare($sql_query);
    $stmt->execute([$member_id]);
    return $stmt->fetch();
}

session_start();

if (isset($_SESSION['member_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Community Member') {
    include "../database-connection.php";
    $loggedInmemberId = $_SESSION['member_id'];
    $loggedInmember = getmemberById($connect, $loggedInmemberId);
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color: rgb(229, 235, 237);
        }
        
        
        .colour {
            background: #f0ffea;
        }

        .navbar {
            font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
            font-size: 20px;

        }

        .navimg {
            width: 30px;
            height: 30px;
        }
        h3{
            font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
            font-size: 20px;

        }
    
    </style>
</head>

<body>
    
<?php
    include 'c_header.php';

        ?>

    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
        Community Member Profile
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <?php if (!empty($members[0]['img'])) : ?>
                                    <img src="<?= $members[0]['img'] ?>" alt="Profile Picture" class="d-block ui-w-80 rounded-circle">
                                <?php endif; ?>
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;
                                    <div class="text-light small mt-1">Allowed JPG, GIF, or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="container">

                            <div class="form-group">
                                <h2>       
                        <label class="form-label">Role:</label>
                        <span><?php 
                        if ($_SESSION['role'] == 'Admin') {
                            echo "Admin";
                        }else if ($_SESSION['role'] == 'Teacher'){
                            echo "Teacher";
                        }
                        else if ($_SESSION['role'] == 'Student'){
                            echo "Student";
                        }
                        else if ($_SESSION['role'] == 'Community Member'){
                            echo "Community Member";
                        }                       
                        
                        ?></span>
                                </h2>
                            </div>

                            <div class="form-group">
                <h3>
                    <label class="form-label">User Name:</label>
                    <span><?= $loggedInmember['username'] ?></span>
                </h3>
            </div>

            <div class="form-group">
                <h3>
                    <label class="form-label">First Name:</label>
                    <span><?= $loggedInmember['first_name'] ?></span>
                </h3>
            </div>

            <div class="form-group">
                <h3>
                    <label class="form-label">Last Name:</label>
                    <span><?= $loggedInmember['last_name'] ?></span>
                </h3>
            </div>
        


        <div class="form-group">
                <h3>
                    <label class="form-label">Email:</label>
                    <span><?= $loggedInmember['email'] ?></span>
                </h3>
            </div>


            <div class="form-group">
                <h3>
                    <label class="form-label">Contact Number:</label>
                    <span><?= $loggedInmember['phone'] ?></span>
                </h3>
            </div>



            <div class="form-group">
                <h3>
                    <label class="form-label">Date of Joining:</label>
                    <span><?= $loggedInmember['date_of_joined'] ?></span>
                </h3>
            </div>

            
            <div class="form-group">
            <form method="post" action="password-memberfunc.php" id="change_password">
    <h3>Change Password</h3>
    <?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger" role="alert" style="width: 500px;">
        <?= $_GET['error'] ?>
    </div>
<?php } ?>

<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success" role="alert" style="width: 500px;">
        <?= $_GET['success'] ?>
    </div>
<?php } ?>

    <input type="hidden" value="<?= $loggedInmember['member_id'] ?>" name="member_id">

    <div class="form-group col-md-6">
    <label class="form-label">Old password</label>
    <input type="text" class="form-control" placeholder="Enter Old Password" name="old_pass">
</div>

<div class="form-group col-md-6">
    <label class="form-label">New password</label>
    <input type="text" class="form-control" name="new_pass" placeholder="Enter Password" id="passInput">
    <div class="input-group-append">
        <button class="btn btn-secondary" id="gBtn">Random</button>
    </div>
</div>

<div class="form-group col-md-6">
    <label class="form-label">Confirm new password</label>
    <input type="text" class="form-control" placeholder="Enter Confirm Password" name="c_new_pass" id="passInput2">
</div>

<div class="form-group col-md-12">
    <button type="submit" class="btn btn-primary">Change Password</button>
</div>
</form>

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
        makePass(4); // Adjust the password length as needed
    });
</script>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>

</html>