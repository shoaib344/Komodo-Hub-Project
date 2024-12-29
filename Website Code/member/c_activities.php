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
    include 'c_header.php';
    include '../_dbconnect.php'; ?>

    <?php function getAllevent($conn)
    {
        $sql_query = "SELECT * FROM event ORDER BY id DESC";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    $result = getAllevent($conn); ?>


    <div class=" px-4 pt-5 my-4">
        <div class=" px-4 pt-3">
            <div class="card ">
                <div class="card-header">
                    <h3>Events and Programs</h3>
                </div>
                <div class="card-body">

                    <form action="act.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Event name"  required name="name">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Details" required name="details">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Contact info" required name="contact">
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Time" required name="time">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Date"required name="date">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Location" required name="location">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Reward" required name="reward">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success my-2 mx-2">Upload</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="container  ">
        <div class="row d-flex justify-content-center ">

            <?php foreach ($result as $row) { ?>


                <div class="col-lg-8 m-2">
                    <div class="card shadow-lg">
                        <div class="card-header ">
                            <b> Event name: </b> <?= $row['name'] ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                            <p> <b> Details:</b> <?= $row['details'] ?></p>
                            <p> <b> Contact info:</b> <?= $row['contact'] ?></p>
                            <p> <b>Time:</b> <?= $row['time'] ?></p>
                            <p> <b>Date: </b> <?= $row['date'] ?></p>
                            <p><b> Location: </b><?= $row['location'] ?></p>
                            <p> <b>Reward: </b> <?= $row['reward'] ?></p>
                            </p>

                        </div>

                    </div>
                </div>
            <?php

            }

            ?>

        </div>

    </div>
</body>

</html>