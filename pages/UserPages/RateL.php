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


$r="INSERT INTO `ratings`(`CodeL`, `CodeU`, `rating`) VALUES (?,?,?)";
$s=$conn->prepare($r);
$s->bind_param("iii",$CodeL,$CodeR,$rating);
$s->execute();

$r="UPDATE `logement` SET `rating`=(SELECT sum(ratings.rating) from ratings where CodeL=?)/(SELECT count(*) from ratings where CodeL=2) WHERE CodeL=?;"
$s=$conn->prepare($r);
$s->bind_param("ii",$CodeL,$CodeL);
$s->execute();


?>