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
    include 't_header.php';
    include '../_dbconnect.php'; ?>

    <?php function getAllinfo($conn)
    {
        $sql_query = "SELECT * FROM t_learn ORDER BY id DESC";
        $stmt = $conn->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    $results = getAllinfo($conn); ?>

    <div class=" px-4 pt-5 my-4">
        <div class=" px-4 pt-3">
            <div class="card ">
                <div class="card-header">
                    <h3>Learning Materials</h3>
                </div>
                <div class="card-body">


                    <form action="info.php" method="POST">
                        <div class="form-floating d-flex">
                            <input class="form-control" id="info" type="text" required name="info" />
                            <label for="info">Information</label>

                            <input type="text" name="feed"required />

                            <button type="submit" class="btn btn-success my-2 mx-2 ml-2 md-2 mb-3">Upload</button>
                        </div>
                    </form>






                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Materials</th>
                            <th scope="col"> Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) { ?>
                            <tr>

                                <td><?= $row['info'] ?></td>
                                <td><?= $row['feed'] ?></td>



                            </tr>
                        <?php } ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
    </div>
</body>

</html>