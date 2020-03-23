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

$id=$_GET['id'];
$AllMsg="";

$req = "SELECT * FROM messages WHERE Codesender = ? or Codereciever = ?";
$statement=$conn->prepare($req);
$statement->bind_param("ii",$id,$id);
$statement->execute();
$res=$statement->get_result();
while ( $row = mysqli_fetch_array($res) )
{
    $msg=
}



header('Content-Type: image');
echo $img;

?>