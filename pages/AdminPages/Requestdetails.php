<?php 
session_start();
if( !isset($_SESSION['username']) || $_SESSION['type'] != "admin" )
{
  header("location:../../homeP.php");
}


?>