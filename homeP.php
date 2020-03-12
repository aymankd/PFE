  <?php
session_start();
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


if(isset($_POST['connect']))
 {
  $login = $_POST["login"];
  $password = $_POST["password"];

  $req = "SELECT * from utilisateur where email=? and pass=?";
  $statement=$conn->prepare($req);
  $statement->bind_param("ss",$login,$password);
  $statement->execute();
  $res=$statement->get_result();
  $row=$res->fetch_assoc();
  
  if($res->num_rows==1)
  {
    
    
    $CodeU=$row['CodeU'];
    session_regenerate_id();
    $_SESSION['username']=$row['username'];
    $_SESSION['type']=$row['type'];
    session_write_close();
      if($_SESSION['type'] == "admin")
      header("Location:AdminPages/dash.php");
      else if($_SESSION['type'] == "normal")
        header("Location:NorUserPages/Home.php");
      else if($_SESSION['type'] == "pro")
        header("Location:ProUserPages/Home.php");


  }

 }

?>

<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Homepage</title>
  <link rel="stylesheet" type="text/css" href="Resourse/CSS/semantic.min.css">
  <link href="Resourse/vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" type="text/css" href="Resourse/CSS/Style.css">
  <link rel="stylesheet" type="text/css" href="Resourse/CSS/StyleLogin.css">

</head>
<style type="text/css">
       .lwhite{
      width: 100px;
      height: 25px;
      margin-top: 20px;
    }
</style>

<body>

<!-- Following Menu -->

<div class="ui inverted segment large top fixed hidden menu">
  <div class="ui inverted secondary menu">
    <div class="ui container">
      <div class="right menu">
       <a href="/PropPges/LoginHote.php" class="active item">Devenez hôte</a>
        <a class="item">Aide</a>
        <a href="pages/samples/register.php" class="item">Inscription</a>
        <a href="pages/samples/login.php" class="item">Connexion</a>
      </div>
  </div>
</div>
</div>

<!-- Sidebar Menu -->
<div class="ui vertical inverted sidebar menu">
  <a class="active item">Home</a>
  <a class="item">Work</a>
  <a class="item">Company</a>
  <a class="item">Careers</a>
  <a href="pages/samples/login.php" class="item">Login</a>
  <a href="pages/samples/register.php" class="item">Signup</a>
</div>


<!-- Page Contents -->
<div class="pusher">
  <div class="ui inverted vertical masthead center aligned segment">
  
    <div class="ui container">
      <div class="ui large secondary pointing inverted menu">
     
        <img src="Resourse/images/logoWhite.png" class="lwhite" />
        <div class="right item">
            <a class="active item">Devenez hôte</a>
            <a class="item">Aide</a>
            <a href="pages/samples/register.php" class="item">Inscription</a>
            <a href="pages/samples/login.php"  class="item" >Connexion</a>

        </div>
      </div>
    </div>
    <div class="ui text container">
        <h1 class="ui inverted header">
        <img src="Resourse/images/logoHome.png" class="lwhite" />
        </h1>
        <h2>Do whatever you want when you want to.</h2>
       
      </div>
  <!--filter div-->
      <form class="ui card" action="pages/samples/searshResult.php" methode="POST">
        <div class="ui fluid icon input">
            <input type="text" name="rech" placeholder="Search a very wide input..." required>
            
            <i class="fas fa-search "></i>
        </div>
      </div>

  </form>
   
  <div class="textSEP">We have the most listings and constant updates.
    So you’ll never miss out.</div>

    
          
       

          <div class="ui link cards">
            <div class="card">
              <div class="image">
                <img src="Resourse/imgs/matthew.png">
              </div>
              <div class="content">
                <div class="header">Matt Giampietro</div>
                <div class="meta">
                  <a>Friends</a>
                </div>
                <div class="description">
                  Matthew is an interior designer living in New York.
                </div>
              </div>
              <div class="extra content">
                <span class="right floated">
                  Joined in 2013
                </span>
                <span>
                  <i class="user icon"></i>
                  75 Friends
                </span>
              </div>
            </div>
            <div class="card">
              <div class="image">
                <img src="Resourse/imgs/matthew.png">
              </div>
              <div class="content">
                <div class="header">Molly</div>
                <div class="meta">
                  <span class="date">Coworker</span>
                </div>
                <div class="description">
                  Molly is a personal assistant living in Paris.
                </div>
              </div>
              <div class="extra content">
                <span class="right floated">
                  Joined in 2011
                </span>
                <span>
                  <i class="user icon"></i>
                  35 Friends
                </span>
              </div>
            </div>
            <div class="card">
              <div class="image">
                <img src="Resourse/imgs/matthew.png">
              </div>
              <div class="content">
                <div class="header">Elyse</div>
                <div class="meta">
                  <a>Coworker</a>
                </div>
                <div class="description">
                  Elyse is a copywriter working in New York.
                </div>
              </div>
              <div class="extra content">
                <span class="right floated">
                  Joined in 2014
                </span>
                <span>
                  <i class="user icon"></i>
                  151 Friends
                </span>
              </div>
            </div>
          </div>




  <div class="ui inverted vertical footer segment">
    <div class="ui container">
      <div class="ui stackable inverted divided equal height stackable grid">
        <div class="three wide column">
          <h4 class="ui inverted header">About</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Sitemap</a>
            <a href="#" class="item">Contact Us</a>
            <a href="#" class="item">Religious Ceremonies</a>
            <a href="#" class="item">Gazebo Plans</a>
          </div>
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Services</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Banana Pre-Order</a>
            <a href="#" class="item">DNA FAQ</a>
            <a href="#" class="item">How To Access</a>
            <a href="#" class="item">Favorite X-Men</a>
          </div>
        </div>
        <div class="seven wide column">
          <h4 class="ui inverted header">Footer Header</h4>
          <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
        </div>
      </div>
    </div>
  </div>
</div>


</body>

<script src="Resourse/Js/JSG/jquery.min.js"></script>
<script src="Resourse/Js/JSG/semantic.min.js"></script>


<script src="Resourse/Js/JSG/visibility.js"></script>
<script src="Resourse/Js/JSG/sidebar.js"></script>
<script src="Resourse/Js/JSG/transition.js"></script>
<script src="Resourse/Js/main2.js"></script>

<script src="Resourse/Js/LoginPage/main.js"></script>


</html>