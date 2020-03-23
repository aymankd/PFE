<?php
  $servername = "localhost";
  $userservername = "root";
  $database = "pfe";
  $msg="";

// Create connection
$conn = new mysqli($servername, $userservername,"", $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = isset($_GET['message']) ? $_GET['message'] : null;
$sender = isset($_GET['sender']) ? $_GET['sender'] : null;
$reciever = isset($_GET['reciever']) ? $_GET['reciever'] : null;

$status = false;

$req = "INSERT INTO `messages`(`Codesender`, `Codereciever`, `Msg`, `vue`) VALUES (?,?,?,?)";
$statement=$conn->prepare($req);
$statement->bind_param("iiss",$sender,$reciever,$msg,$status);
$statement->execute();


?>