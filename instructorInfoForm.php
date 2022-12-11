<?php

require "programClasses.php";

$connection = "mysql:host=localhost;dbname=classschedules;charset=utf8mb4";
$user = "root";
$password = "";
$err = "";
$instructors = array();
try
{
    $pdo = new PDO($connection, $user, $password);
    
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
    <link rel='stylesheet' href='styles.css'/>
    <title>Select Instructor</title>
</head>
<body>
    <div>
        <?php
            if (!$err)
            {
                echo "<h3>Please select an instructor</h3>";
            }
            else
            {
                echo "<p>$err</p>";
            }
        ?>
    </div>
    <?php
        if(!$err) {
            $query = "SELECT instructorid, instructorfirst, instructorlast FROM instructors";
            $res = $pdo->query($query);

            foreach($res->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $inst = new Instructor($row['instructorid'], $row['instructorfirst'], $row['instructorlast']);
                $instructors[$row['instructorid']] = $inst;
            }
        
    ?>
    <form method="POST" action="instructorSchedule.php">
        <label>Select Instructor: </label>
            <select name="instructor">
                <option></option>
                <?php
                    foreach($instructors as $key => $inst) {
                        echo "<option value='" . $key . "'>";
                        echo $inst->getFullName();
                        echo "</option>";
                    }
                ?>
            </select>
            <button>Lookup</button>
    </form>
    <?php
            }
        //}
        $pdo = null;
    ?>
</body>
</html>