<?php

require "programClasses.php";

$connection = "mysql:host=localhost;dbname=classschedules;charset=utf8mb4";
$user = "root";
$password = "";
$err = "";
$instructor = "";
try
{
    $pdo = new PDO($connection, $user, $password);
    if(isset($_POST["instructor"]))
    {
        $instructor = $_POST["instructor"];
        if(empty($instructor)) { $err = "No instructor selected."; }
        else { $err = "Fatal error."; }
    }
    
}
catch (PDOException $e) 
{
    $err = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Schedule</title>
</head>
<body>
    <?php
        if(!$err) { echo $err; }
    ?>
    <div>
    <?php
        $query = "SELECT instructorid, instructorfirst, instructorlast FROM instructors WHERE instructorid = :ID";
        $statement = $pdo->prepare($query);
        $statement->execute(['ID' => $instructor]);
        $teacher = $statement->fetch();
        $schedule = new Instructor($teacher[0], $teacher[1], $teacher[2]);
        
        
        if(!$teacher) 
        {
            echo "<p>No instructor selected.</p>";
        }
        else
        {
    ?>
    <div>
            <?php echo "<h3>Instructor: " . $schedule->getId() . "</h3>";
                  echo "<br>";  
                  echo $schedule->getFullName();

                  $classes = "SELECT classes.course, classes.section, classes.dept, classes.enrolled, classes.maxAllowed, titles.title 
                              FROM classes
                              INNER JOIN instructors ON classes.instructorid = instructors.instructorid
                              INNER JOIN titles ON classes.titlecode = titles.titlecode
                              WHERE instructors.instructorid = $instructor;";
                  $stmt = $pdo->prepare($classes);
                  $stmt->execute();
                  foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $col) {
                    if (!$col) {
                        echo "<p>Nothing to display!</p>";
                    } else {
                        echo "<table>";
                        foreach($col as $k => $v) {
                            echo "<tr>";
                            echo "<td>$k</td>";
                            echo "<td>$v</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                  } 
            ?>
    </div>
    <?php
        }
        $pdo = null;
    ?>
    </div>
    <a href='instructorInfoForm.php'>Back To Search</a>
</body>
</html>