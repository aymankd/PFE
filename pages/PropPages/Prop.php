<?php
session_start();
if( !isset($_SESSION['username']) || $_SESSION['type'] != "pro" )
{
  header("location:../../homeP.php");
}

$servername = "localhost";
$userservername = "root";
$database = "pfe";
$msg="";
$openclosejs=" checked = null;";
$jsScript="";
$chatboxs="";
$AllCodeSenders=" var codes = new array();";
$ScriptMsg="";
$sendScr="";
$url='"chatbox.php"';
$method='"GET"';
$i=1;
$UISc='setInterval(function() {
  showdata="";';


// Create connection
$conn = new mysqli($servername, $userservername,"", $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//remplisage des données d'utilisateur courrant
$src="";
$ProfileP="";
$USN=$_SESSION['username'];
$reqIU="SELECT * FROM utilisateur WHERE username=?";
$statementIU=$conn->prepare($reqIU);
$statementIU->bind_param("s",$USN);
$statementIU->execute();
$resIU=$statementIU->get_result();
$rowIU=$resIU->fetch_assoc();
if($rowIU['imageP']!=NULL)
{
  	$src="../Samples/profilpic.php?UN=$USN";
	$ProfileP="<img src='".$src."' alt='profile'/>";
}
else
{
	$src="../../Resourse/imgs/ProfileHolder.jpg";
	$ProfileP="<img src='".$src."' alt='profile'/>";
}

$codeU = $_SESSION['usercode'];
$ntMsg = "";

$req="SELECT idMsg, Codesender, Msg FROM messages 
WHERE Codereciever=?
GROUP BY Codesender  ORDER BY idMsg DESC LIMIT 3";
$statement=$conn->prepare($req);
$statement->bind_param("i",$codeU);
$statement->execute();
$res=$statement->get_result();
while ( $row = mysqli_fetch_array($res) )
{
  $sender=$row['Codesender'];
  $sms=$row['Msg'];
      $reqP="SELECT * from utilisateur where CodeU=?";
      $statementP=$conn->prepare($reqP);
      $statementP->bind_param("i",$sender);
      $statementP->execute();
      $resP=$statementP->get_result();
      $rowP=$resP->fetch_assoc();
      $Pusername=$rowP["username"];

  $ntMsg = $ntMsg.
  '
  <a class="dropdown-item preview-item" id="a'.$sender.'">
    <div class="preview-thumbnail">
        <img src="Proprofile.php?id='.$sender.'" alt="image" class="profile-pic">
    </div>
    <div class="preview-item-content flex-grow">
        <h6 class="preview-subject ellipsis font-weight-normal">'.$Pusername.'
        </h6>
        <p class="font-weight-light small-text text-muted mb-0">
          '.$sms.'
        </p>
    </div>
  </a>
  ';


  $chatboxs = $chatboxs.
  '
  <section class="avenue-messenger" id="Chat'.$sender.'" style="display:none">
  <div class="menu">
     <div class="button" id="CloseChat'.$sender.'" title="End Chat">&#10005;</div> 
  </div>
  <div class="agent-face">
     <div class="half">
     <img class="agent circle" src="Proprofile.php?id='.$sender.'" alt="profile">
     </div>
  </div>
  <div class="chat" >
     <div class="chat-title">
     <h1>'.$Pusername.'
     </div>
     <div class="messages" >
     <div id="'.$sender.'" class="messages-content mCustomScrollbar _mCS_1 mCS_no_scrollbar" >

     </div>
     </div>
     <div class="message-box">
        <textarea type="text" id="input'.$sender.'" class="message-input" placeholder="Type message..."></textarea>
        <button type="submit" id="send'.$sender.'" class="message-submit">Send</button>
     </div>
  </div>
</section>
  ';

  $openclosejs = $openclosejs.
  "
  $('#a".$sender."').click(function(){
    if(checked!=null)
      checked.style='display:none';
      document.getElementById('Chat".$sender."').style='display:block';
      checked=document.getElementById('Chat".$sender."');
      updateScrollbar();
    });
    $('#CloseChat".$sender."').click(function(){
      document.getElementById('Chat".$sender."').style='display:none';
      checked=null;
    });
  ";

  $ScriptMsg = $ScriptMsg.
  '

  $("#send'.$sender.'").click(function() {
    $msgtosend=$("#input'.$sender.'").val();
    insertMessage("'.$sender.'");
    $.ajax({  
          url:"chatbox.php",  
          method:"GET",  
          data:{message:$msgtosend,sender:'.$codeU.',reciever:'.$sender.'}
          });
 });

  ';


  $mCSB_container="'#mCSB_".$i."_container'";
  $i=$i+1;
  
  $UISc=$UISc.
  '
  $.ajax({  
    url:"chatmsg.php",  
    method:"GET",  
    data:{sender:'.$codeU.',reciever:'.$sender.'},  
    success:function(data){
      if(showdata!=data)
      {
        showdata=data;
        $('.$mCSB_container.').html(data);
      }
    }  
  });
  ';




}

$Msgclass='"message message-personal"';


$UISc = $UISc.'updateScrollbar(); 
}, 1000);';

$jsScript = "<script>".$openclosejs.$ScriptMsg."</script>";


//chec pack expiration time

$reqP="SELECT * FROM pack";
$statementP=$conn->prepare($reqP);
$statementP->execute();
$resP=$statementP->get_result();
$date = new DateTime(date('Y-m-d'));
while ( $rowP = mysqli_fetch_array($resP) )
  {
    $date = new DateTime(date('Y-m-d'));
    $DBdate = new DateTime($rowP['ExpeTo']);
    if( $DBdate <= $date )
      {
        $reqEX="DELETE FROM pack WHERE CodeL=?";
        $statementEX=$conn->prepare($reqEX);
        $statementEX->bind_param("i",$rowP['CodeL']);
        $statementEX->execute();
      }
  }
//chec complete


//----------------- ----------Notifications------------
$nbr_nts=0;
// notifications des packs
$notif="";
$reqN="SELECT * FROM logement WHERE CodeP=? and (CodeL NOT IN (SELECT CodeL FROM pack where CodeU=?))";
$statementN=$conn->prepare($reqN);
$statementN->bind_param("ii",$codeU,$codeU);
$statementN->execute();
$resN=$statementN->get_result();

if($resN->num_rows!=0)
  {
    $notif='
    <a class="dropdown-item preview-item" href="ToSuperLog.php">
    <div class="preview-thumbnail">
        <div class="preview-icon bg-success">
          <i class="mdi mdi-information mx-0"></i>
        </div>
    </div>
    <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal">Logement en mode normal</h6>
        <p class="font-weight-light small-text mb-0 text-muted">
          click to go update
        </p>
    </div>
  </a>
    ';
    $nbr_nts=$nbr_nts+1;
  }
//Notifications de localisation de logement:
  $reqN="SELECT * from logement where CodeP=?";
  $statementN=$conn->prepare($reqN);
  $statementN->bind_param("i",$codeU);
  $statementN->execute();
  $resN=$statementN->get_result();
  $notifs="";
  $cnt=1;
  $CodeL1;
  $CodeL2;
  while(($rowN = mysqli_fetch_array($resN)))
  {
    
    if($rowN['lng']==NULL && $rowN['lat']==NULL && $cnt=1)
     { 
       $CodeL1=$rowN['CodeL'];
       $notifs=" <a id='LLoc1' class='dropdown-item preview-item'>
             <div class='preview-thumbnail'>
               <div class='preview-icon bg-success'>
                <i class='fas fa-map-marked-alt'></i>
               </div>
             </div>
             <div class='preview-item-content'>
               <h6 class='preview-subject font-weight-normal'>Localiser votre ".$rowN['type']." '".$rowN['nom']."'</h6>
               <p class='font-weight-light small-text mb-0 text-muted'>
                 Just now
               </p>
             </div>
           </a>";
           $cnt=$cnt+1;
           $nbr_nts=$nbr_nts+1;
     }  
    else if ($rowN['lng']==NULL && $rowN['lat']==NULL && $cnt=2)
     {
      if($rowN['lng']==NULL && $rowN['lat']==NULL && $cnt=1)
      { 
        $CodeL2=$rowN['CodeL'];
        $notifs=" <a id='LLoc2' class='dropdown-item preview-item'>
              <div class='preview-thumbnail'>
                <div class='preview-icon bg-success'>
                 <i class='fas fa-map-marked-alt'></i>
                </div>
              </div>
              <div class='preview-item-content'>
                <h6 class='preview-subject font-weight-normal'>Localiser votre ".$rowN['type']." '".$rowN['nom']."'</h6>
                <p class='font-weight-light small-text mb-0 text-muted'>
                  Just now
                </p>
              </div>
            </a>";
            $cnt=$cnt+1;
            $nbr_nts=$nbr_nts+1;
      } 
     }    
  }
//user notifications(saves/ratings)
  $user_notis="";
  $reqN="SELECT * from user_notis where CodeP=?";
  $statementN=$conn->prepare($reqN);
  $statementN->bind_param("i",$codeU);
  $statementN->execute();
  $resN=$statementN->get_result();
  while(($rowN = mysqli_fetch_array($resN)))
  {
    $user=$rowN['CodeU'];
    $action=$rowN['action'];
    $logement=$rowN['CodeL'];
    $nt_code=$rowN['idN'];

    $reqU="SELECT * from utilisateur where CodeU=?";
    $statementU=$conn->prepare($reqU);
    $statementU->bind_param("i",$user);
    $statementU->execute();
    $resU=$statementU->get_result();
    $rowU=$resU->fetch_assoc();

    $nt_usern=$rowU['username'];

    $reqU="SELECT * from logement where CodeL=?";
    $statementU=$conn->prepare($reqU);
    $statementU->bind_param("i",$logement);
    $statementU->execute();
    $resU=$statementU->get_result();
    $rowU=$resU->fetch_assoc();
    $nt_loge=$rowU['nom'];
    

    if($action=='saved')
     {
       $user_notis.=" <a id='".$nt_code."' class='dropdown-item preview-item'>
                        <div class='preview-thumbnail'>
                            <div class='preview-icon bg-success'>
                             <i class='mdi mdi-heart text-normal'></i>
                            </div>
                        </div>
                        <div class='preview-item-content'>
                          <h6 class='preview-subject font-weight-normal'>".$nt_usern." a enregistré votre logement '".$nt_loge."'</h6>
                          <p class='font-weight-light small-text mb-0 text-muted'>
                           Just now
                          </p>
                        </div>
                      </a>";
                      $nbr_nts=$nbr_nts+1;
     }
    else if($action=='rated')
     {
        $user_notis.=" <a id='".$nt_code."' class='dropdown-item preview-item'>
                        <div class='preview-thumbnail'>
                            <div class='preview-icon bg-success'>
                             <i class='fas fa-star'>
                            </div>
                        </div>
                        <div class='preview-item-content'>
                          <h6 class='preview-subject font-weight-normal'>".$nt_usern." a évalué votre logement '".$nt_loge."'</h6>
                          <p class='font-weight-light small-text mb-0 text-muted'>
                           Just now
                          </p>
                        </div>
                      </a>";
                      $nbr_nts=$nbr_nts+1;
     }
    else if($action=='commented') 
     {
       $user_notis.=" <a id='".$nt_code."' class='dropdown-item preview-item'>
                        <div class='preview-thumbnail'>
                            <div class='preview-icon bg-success'>
                              <i class='far fa-comment'></i> 
                            </div>
                        </div>
                        <div class='preview-item-content'>
                          <h6 class='preview-subject font-weight-normal'>".$nt_usern." a commenté sur votre logement '".$nt_loge."'</h6>
                          <p class='font-weight-light small-text mb-0 text-muted'>
                           Just now
                          </p>
                        </div>
                      </a>";
                      $nbr_nts=$nbr_nts+1;
     }
  
  }


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kapella Bootstrap Admin Dashboard Template</title>
    <link rel="stylesheet" type="text/css" href="../../Resourse/CSS/semantic.min.css">
  <link rel="stylesheet" href="../../Resourse/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../Resourse/vendors/base/vendor.bundle.base.css">
 

  <link rel="stylesheet" href="../../Resourse/css2/styleRe.css">
  <link rel="shortcut icon" href="../../Resourse/images/favicon.png" />


  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
  <link rel="stylesheet" href="../../Resourse/css3/chatbox.css">
  <link href="../../Resourse/vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">



  </head>
  <body>
    <div class="container-scroller">
		<!-- partial:partials/_horizontal-navbar.html -->
		<div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          
          <ul class="navbar-nav navbar-nav-left">
              <li class="nav-item ml-0 mr-5 d-lg-flex d-none">
                <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell mx-0"></i>
                  <span class="count bg-success"><?php if($nbr_nts>0) echo $nbr_nts?></span>
                </a>
                <div id="notifs" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p> <br>
                  <hr>
                  <a id="clr_all">Clear all</a>
                  <?=$user_notis?>
                  <?=$notif; ?>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-warning">
                          <i class="mdi mdi-settings mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">Settings</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                          Private message
                        </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-info">
                          <i class="mdi mdi-account-box mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">New user registration</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                          2 days ago
                        </p>
                    </div>
                  </a>
                  <?=$notifs?>

                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-email mx-0"></i>
                  <span class="count bg-primary">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>

                  <?=$ntMsg;?>
                  

                </div>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link count-indicator "><i class="mdi mdi-message-reply-text"></i></a>
              </li>
              <li class="nav-item nav-search d-none d-lg-block ml-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="search">
                        <i class="mdi mdi-magnify"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="search">
                </div>
              </li>	
            </ul>
 
              
   
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand" href="dash.html"><img src="../../Resourse/images/logo-1.png" alt="logo"/></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
               
              
             
                <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name"><?=$USN?></span>
                    <span class="online-status"></span>
                    <?=$ProfileP?>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                        <i class="mdi mdi-account text-primary"></i>
                        Mon Compte
                      </a>
                      <a class="dropdown-item">
                        <i class="mdi mdi-home-modern text-primary"></i>
                        Les Logement
                      </a>
                      <a class="dropdown-item">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                      </a>
                  </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
    </div>

    <!-- partial -->
		<div class="container-fluid">
    <main class="grid">
  <article>
    <!--Slidshow-->
      <div id="demo1" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo1" data-slide-to="0" class="active"></li>
         <li data-target="#demo1" data-slide-to="1" class=""></li>
         <li data-target="#demo1" data-slide-to="2" class=""></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item active">
   
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo1" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo1" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo2" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo2" data-slide-to="0" class="active"></li>
         <li data-target="#demo2" data-slide-to="1" class=""></li>
         <li data-target="#demo2" data-slide-to="2" class=""></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item active">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo2" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo2" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>
  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-female CA"></i><i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>

  <article>
    <!--Slidshow-->
      <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
         <li data-target="#demo" data-slide-to="0" class=""></li>
         <li data-target="#demo" data-slide-to="1" class=""></li>
         <li data-target="#demo" data-slide-to="2" class="active"></li>
     </ul>

       <!-- The slideshow -->
       <div class="carousel-inner">
   <div class="carousel-item">
     <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item">
  <img src="../../Resourse/images/auth/login-bg.jpg" class="d-block w-100">
</div>
<div class="carousel-item active">
   <img src="../../Resourse/images/lockscreen-bg.jpg" class="d-block w-100">
</div>
</div>

       <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
       </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>

      </div>
        <!--/slidshow-->
        <div class="card-body">
     <h5 class="card-title">The Joshua Tree House</h5>
     <p class="card-text"> <i class="fas fa-tags CA"></i> 300Dh  &nbsp;<i class="fas fa-bed CA"></i> 2  &nbsp;  <i class="fas fa-male CA"></i> 3  &nbsp; <i class="fas fa-warehouse CA"></i> 100 m²</p>
    
     <p class="card-text">  <i class="fas fa-map-marker-alt CA"></i> Salé-Sidi Moussa </p>
      <br>
     <p class="cpara">The Joshua Tree House is a two bed two bath 1949 hacienda located 10 minutes from the west entrance .</p> <br>
       <a href="#" class="btn btn-primary">Voir plus</a>
       </div>
  </article>


</main>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
    <?=$chatboxs; ?>
    








    <!-- container-scroller -->
    <!-- base:js -->
    <script src="../../Resourse/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../Resourse/js2/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <script src="../../Resourse/vendors/chart.js/Chart.min.js"></script>
    <script src="../../Resourse/vendors/progressbar.js/progressbar.min.js"></script>
		<script src="../../Resourse/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
		<script src="../../Resourse/vendors/justgage/raphael-2.1.4.min.js"></script>
		<script src="../../Resourse/vendors/justgage/justgage.js"></script>
    <!-- Custom js for this page-->
    <script src="../../Resourse/js2/dashboard.js"></script>
    <!-- End custom js for this page-->

    <!-- chat-box -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js"></script>

    <script>
    var $MsgCont = $('.messages-content');
    function updateScrollbar() {
      $MsgCont.mCustomScrollbar('scrollTo', 'bottom');
      }

    function insertMessage(messages) {
      var varI='#input'+messages;
      msg = $(varI).val();
        if(msg!=null){
          $('<div class="message message-personal" >' + msg + '</div>').appendTo('#'+messages+' .mCSB_container');
          $(varI).val(null);
          updateScrollbar();
          msg=null;
        }
      }



      <?=$UISc; ?>
      /* 
            setInterval(function() {
      showdata="";
      $.ajax({  
                url:"chatmsg.php",  
                method:"GET",  
                data:{sender,reciever:},  
                success:function(data){
                   if(showdata!=data)
                   {
                     showdata=data;
                     $('.mCSB_container').html(data);
                   }
                }  
           });
                 updateScrollbar(); 
   }, 1000);
      */

    
    </script>
    <?=$jsScript; ?>

  
<script>
$(document).ready(function(){  


   $('#LLoc1').click(function(){  
          
    location.href = 'getLocation.php?target=<?=$CodeL1?>&owner=<?=$codeU?>';
       });
       $('#LLoc2').click(function(){  
          
          location.href = 'getLocation.php?target=<?=$CodeL1?>&owner=<?=$codeU?>';
             });    
       
  
 
 });  
</script>

<script>
document.getElementById("notifs").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
</script>
</body>
</html>