<?php

ini_set("display_errors",1);
error_reporting(E_ALL);

$mydb = new mysqli('127.0.0.1','root','root','myforum');

if ($mydb->errno != 0){

        echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
        exit(0);

}

// get data that sent from form 

$topic = $_POST['topic'];
$detail = $_POST['detail'];
$name = $_POST['name'];
$datetime = date("d/m/y h:i:s"); //create date time

$query = mysqli_query($mydb,"INSERT INTO fquestions (topic, detail, name, datetime) VALUES ('$topic', '$detail', '$name', '$datetime')");

if($query){
echo nl2br("Post has be submitted<br><br>");
echo "<a href=main_forum.php>View your topic</a>";
}
else {
echo nl2br("ERROR");
}
?>
