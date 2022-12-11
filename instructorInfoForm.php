<?php

require "programClasses.php";

$connection = "mysql:host=localhost;dbname=classschedules;charset=utf8mb4";
$user = "root";
$password = "";
$err = "";
$instructors = array();
try {
    $pdo = new PDO($connection, $user, $password);
} catch (PDOException $e) {
    $err = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Select Instructor</title>
</head>
<style>
.container {
    height: 100vh;
}
</style>
<body>
    <div class='container d-flex justify-content-center align-items-center'>
        <div class='card text-center d-flex' style='width: 30rem;'>
            <?php
            if (!$err) {
                echo "<div class='card-header'>Please select an instructor</div>";
            } else {
                echo "<p>$err</p>";
            }
            ?>

            <?php
            if (!$err) {
                $query = "SELECT instructorid, instructorfirst, instructorlast FROM instructors";
                $res = $pdo->query($query);

                foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $inst = new Instructor($row['instructorid'], $row['instructorfirst'], $row['instructorlast']);
                    $instructors[$row['instructorid']] = $inst;
                }

            ?>
                <div class="card-body">
                    <form method="POST" action="instructorSchedule.php">
                        <select class='form-select' aria-label='Instructor Select' name="instructor">
                            <option></option>
                            <?php
                            foreach ($instructors as $key => $inst) {
                                echo "<option value='" . $key . "'>";
                                echo $inst->getFullName();
                                echo "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class='btn btn-outline-primary mt-3'>Lookup</button>
                    </form>
                </div>
        </div>
    <?php
            }
            //}
            $pdo = null;
    ?>
    </div>
</body>

</html>