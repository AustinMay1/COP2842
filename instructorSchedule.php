<?php

require "programClasses.php";

$connection = "mysql:host=localhost;dbname=classschedules;charset=utf8mb4";
$user = "root";
$password = "";
$err = "";
$instructor = "";
try {
    $pdo = new PDO($connection, $user, $password);
    if (isset($_POST["instructor"])) {
        $instructor = $_POST["instructor"];
        if (empty($instructor)) {
            $err = "No instructor selected.";
        } else {
            $err = "Fatal error.";
        }
    }
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
    <title>Instructor Schedule</title>
</head>

<body>
    <div class="container">
        <?php
        if (!$err) {
            echo $err;
        }
        ?>
        <div>
            <?php
            $query = "SELECT instructorid, instructorfirst, instructorlast FROM instructors WHERE instructorid = :ID";
            $statement = $pdo->prepare($query);
            $statement->execute(['ID' => $instructor]);
            $teacher = $statement->fetch();
            $teacherInfo = new Instructor($teacher[0], $teacher[1], $teacher[2]);


            if (!$teacher) {
                echo "<p>No instructor selected.</p>";
            } else {
            ?>
                <div class='container'>
                    <div class="card text-center">
                    <div class='card-header'><h3><?php echo $teacherInfo->getFullName() . " (ID: " . $teacherInfo->getId() . ")"; ?></h3></div>
                    <div class='card-body'>
                    <table class='table table-bordered border-dark'>
                        <thead>

                            <?php
                            $classes = "SELECT classes.course, classes.section, classes.dept, classes.enrolled, classes.maxAllowed, titles.title 
                              FROM classes
                              INNER JOIN instructors ON classes.instructorid = instructors.instructorid
                              INNER JOIN titles ON classes.titlecode = titles.titlecode
                              WHERE instructors.instructorid = $instructor;";
                            $sch = $pdo->query($classes);

                            echo "<tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Department</th>
                                    <th>Enrolled</th>
                                    <th>Seats Free</th>
                                    <th>Textbook</th>
                                 </tr>";

                            foreach ($sch as $col) {
                                if (!$col) {
                                    echo "<p>Nothing to display!</p>";
                                } else {
                                    echo
                                    "<tr><td>" . $col['course'] .
                                        "</td><td>" . $col['section'] .
                                        "</td><td>" . $col['dept'] .
                                        "</td><td>" . $col['enrolled'] .
                                        "</td><td>" . $col['maxAllowed'] - $col['enrolled'] .
                                        "</td><td>" . $col['title'] .
                                        "</tr>";
                                }
                            }
                            ?>
                    </table>
                    </div>
                        </div>
                </div>
            <?php
            }
            $pdo = null;
            ?>
        </div>
        <a href='instructorInfoForm.php' class='btn btn-outline-primary mt-3'>Back To Search</a>
    </div>
</body>
</html>