<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Home Page</title>
    <style>
        .colour {
            background: #f0ffea;
        }

        .navbar {
            font-family: 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;

        }

        .navimg {
            width: 30px;
            height: 30px;
        }
    </style>
</head>

<body>

<?php
    include 'wl_header.php';
    include '_dbconnect.php'; ?>

<?php function getAllpost($conn)
    {
        $sql_query = "SELECT * FROM post ORDER BY id DESC";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    $result = getAllpost($conn); ?>

    

    <!-- Navbar -->

    <main>

        <div class=" px-4 pt-5 my-4">


           

                
        

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
        </div>

    </main>

</body>

</html>