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
$titres=json_decode(stripslashes($_POST['Titres']));
$descs=json_decode(stripslashes($_POST['Descs']));
$CodeL=$_POST['CodeL'];
$nbr_equi=sizeof($titres);

$titre='';
$desc='';

$i=0;
for($i=0;$i<$nbr_equi;$i++)
{
    $titre=$titres[$i];
    $desc=$desc[$i];
    $r="INSERT INTO `autre_equi`(`CodeL`,`titre`,`description`) VALUES (?,?,?)";
    $s=$conn->prepare($r);
    $s->bind_param("iss",$CodeL,$desc,$titre);
    $s->execute();
}








?>