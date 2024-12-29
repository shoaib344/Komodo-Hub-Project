
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Homepage - Teacher</title>
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
    
    </style>
</head>

<body>

<?php
    include 't_header.php';
    include '../_dbconnect.php'; ?>

<?php function getAllpost($conn)
    {
        $sql_query = "SELECT * FROM post ORDER BY id DESC";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    $result = getAllpost($conn); ?>

    

    <main>

        <div class=" px-4 pt-5 my-4">


            <div class="container">

                <div>
                    <div class="card">
                        <div class="card-header">
                            Write a Post
                        </div>
                        <div class="card-body">
                            <form action="take.php" method="POST">
                            <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" required placeholder="Your Name" name="name">
                            </div>
                            </div>
                                <div class="form-group">
                                    <label >What's on your mind?</label>
                                    <textarea class="form-control" name="details" rows="4" required></textarea>
                                </div>
                                <br>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary col-lg-3">Post</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       

        <div class="container ">
            <div class="row d-flex justify-content-center">
            <?php foreach ($result as $row) { ?>

                        <div class="col-lg-8 m-2">
                            <div class="card">
                                <div class="card-header">
                                <b>  <?= $row['name'] ?></b>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                    <p>  <?= $row['details'] ?></p>
                                    </p>

                                </div>

                            </div>
                        </div>
                <?php

                    }
                
                ?>

            </div>
        </div>
    </main>
      
</body>
</html>