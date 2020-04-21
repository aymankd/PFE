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
$CodeU=$_POST['CodeU'];
$CodeL=$_POST['CodeL'];
$action=$_POST['action'];

if($action=='Y')
{
    $r="INSERT INTO `saves`(`CodeL`, `CodeU`) VALUES (?,?)";
    $s=$conn->prepare($r);
    $s->bind_param("ii",$CodeL,$CodeU);
    $s->execute();
}
else if($action=='N')
{
    $r="DELETE FROM `saves` WHERE CodeL=? and CodeU=?";
    $s=$conn->prepare($r);
    $s->bind_param("ii",$CodeL,$CodeU);
    $s->execute();
}






?>