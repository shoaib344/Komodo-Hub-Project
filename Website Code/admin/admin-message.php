<?php 



session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Homepage - Admin</title>
    <style>
        body{
            background-color: rgb(229, 235, 237);
            font-size: 20px;
        }
            
        .colour {
            background: #f0ffea;
        }

        .navbar {
            font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
            font-size: 23px;
            border: 2px solid #000;
        }

        
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    
<?php
    include 'a_header.php';
    
    
        ?>
    <div class="p-2 w-400 rounded shadow">
      

            <div class="input-group mb-3">
                <input type="text" placeholder="Search..." id="searchText" class="form-control">
                <button class="btn btn-primary" id="searchBtn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <ul id="chatList" class="list-group mvh-50 overflow-auto">
                <?php if (!empty($conversations)) { ?>
                    <?php foreach ($conversations as $conversation) { ?>
                        <li class="list-group-item">
                            <a href="chat.php?user=<?=$conversation['username']?>" class="d-flex justify-content-between align-items-center p-2">
                                <div class="d-flex align-items-center">
                                    <img src="uploads/<?=$conversation['p_p']?>" class="w-10 rounded-circle">
                                    <h3 class="fs-xs m-2">
                                        <?=$conversation['name']?><br>
                                        <small>
                                            <?php 
                                                echo ($_SESSION['admin_id']);
                                            ?>
                                        </small>
                                    </h3>
                                </div>
                                <?php if (($conversation['last_seen']) == "Active") { ?>
                                    <div title="online">
                                        <div class="online"></div>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-comments d-block fs-big"></i>
                        No messages yet. Start the conversation.
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
          
          // Search
           $("#searchText").on("input", function(){
               var searchText = $(this).val();
               if(searchText == "") return;
               $.post('chats/ajax/search.php', 
                       {
                        key: searchText
                       },
                     function(data, status){
                        $("#chatList").html(data);
                     });
           });

           // Search using the button
           $("#searchBtn").on("click", function(){
               var searchText = $("#searchText").val();
               if(searchText == "") return;
               $.post('chats/ajax/search.php', 
                       {
                        key: searchText
                       },
                     function(data, status){
                        $("#chatList").html(data);
                     });
           });


          /** 
          auto update last seen 
          for logged in user
          **/
          let lastSeenUpdate = function(){
            $.get("app/ajax/update_last_seen.php");
          }
          lastSeenUpdate();
          /** 
          auto update last seen 
          every 10 sec
          **/
          setInterval(lastSeenUpdate, 10000);

        });
    </script>





</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
} 
} else {
header("Location: ../login.php");
exit;
} 
?>