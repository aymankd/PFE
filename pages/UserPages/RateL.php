<?php
$servername = "localhost";
$userservername = "root";
$database = "pfe";


// Create connection
$conn = new mysqli($servername, $userservername,"", $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$CodeR=$_POST['rater'];
$CodeL=$_POST['RatedL'];
$rating=$_POST['rating'];
$comment=$_POST['comment'];


$r="INSERT INTO `ratings`(`CodeL`, `CodeU`, `rating`, `comment`) VALUES (?,?,?,?)";
$s=$conn->prepare($r);
$s->bind_param("iiis",$CodeL,$CodeR,$rating,$comment);
$s->execute();



?>