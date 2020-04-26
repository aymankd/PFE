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
$CodeP=$_POST['CodeP'];

if($action=='Y')
{
    $r="INSERT INTO `saves`(`CodeL`, `CodeU`) VALUES (?,?)";
    $s=$conn->prepare($r);
    $s->bind_param("ii",$CodeL,$CodeU);
    $s->execute();

    $r="INSERT INTO `user_notis`(`CodeU`, `CodeP`,`action`,`CodeL`) VALUES (?,?,'saved',?)";
    $s=$conn->prepare($r);
    $s->bind_param("iii",$CodeU,$CodeP,$CodeL);
    $s->execute();
}
else if($action=='N')
{
    $r="DELETE FROM `saves` WHERE CodeL=? and CodeU=?";
    $s=$conn->prepare($r);
    $s->bind_param("ii",$CodeL,$CodeU);
    $s->execute();

    $r="DELETE FROM `user_notis` where CodeU=? and CodeP=? and CodeL=? and action='saved' ";
    $s=$conn->prepare($r);
    $s->bind_param("iii",$CodeU,$CodeP,$CodeL);
    $s->execute();
}






?>