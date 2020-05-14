<?php
session_start();
if(isset($_POST['logoutbtn'])) 
{
	unset($_SESSION['type']);
	unset($_SESSION['username']);
}
if( !isset($_SESSION['username']) || $_SESSION['type'] != "normal" )
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


//recommendation des logement du 1er section(Ultra)
   //codes de logements ultra recommandées.
   $ultra1=0;
   $ultra2=0;
   $ultra3=0;
$line_cnt=0;
$ultra_rec='';
//$reqR1="SELECT * from logement where CodeL is in(SELECT CodeL from pack where type='Ultra')";
$reqR1="SELECT idL,COUNT(*) AS total_rcm FROM log_recomm where idL in(SELECT CodeL from pack where type='ultra') GROUP BY idL ORDER BY total_rcm  limit 3";
$statementR1=$conn->prepare($reqR1);
$statementR1->execute();
$resR1=$statementR1->get_result();

if(mysqli_num_rows($resR1)==0)
{
  
  $reqRS="SELECT * FROM logement where CodeL in(SELECT CodeL from pack where type='ultra') limit 3";
  $statementRS=$conn->prepare($reqRS);
  $statementRS->execute();
  $resRS=$statementRS->get_result();
  while($rowRS= mysqli_fetch_array($resRS))
   {
      $line_cnt=$line_cnt+1;
      $ultra_CodeL=$rowRS['CodeL'];
    
      //info du logement courant
      $reqIL="SELECT * FROM logement where CodeL=?";
      $statementIL=$conn->prepare($reqIL);
      $statementIL->bind_param('i',$ultra_CodeL);
      $statementIL->execute();
      $resIL=$statementIL->get_result();
      $rowIL=$resIL->fetch_assoc();
      $ultra_titre=$rowIL['nom'];
      $ultra_type=$rowIL['type'];
      $ultra_prix=$rowIL['prix'];
      $ultra_CodeP=$rowIL['CodeP'];
      //info prop
      $reqN="SELECT * from utilisateur where CodeU=?";
      $statementN=$conn->prepare($reqN);
      $statementN->bind_param("i",$ultra_CodeP);
      $statementN->execute();
      $resN=$statementN->get_result();
      $rowN=$resN->fetch_assoc();
      $ultra_nomP=$rowN['username'];

      //image du logement
      $reqI="SELECT * FROM image where CodeL=? Limit 1";
      $statementI=$conn->prepare($reqI);
      $statementI->bind_param("i",$ultra_CodeL);
      $statementI->execute();
      $resI=$statementI->get_result();
      $rowI=$resI->fetch_assoc();
      $ultra_IdI=$rowI['CodeImg'];
      $image="genere_image.php?id=$ultra_IdI";

      
      
      if($line_cnt==1)
       { 
        $ultra_rec.=" <div class='left-side'>
                        <div class='masonry-box post-media'>
                          <img src='".$image."' alt='' class='img-fluid'>
                          <div class='shadoweffect'>
                          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
                            <div class='shadow-desc'>
                              <div class='blog-meta'>
                                <span class='bg-aqua'><a title=''>".$ultra_type."</a></span>
                                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                                <small><a href='' title=''>".$ultra_prix."</a></small>
                                <small><a href='' title=''>".$ultra_nomP."</a></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
        $ultra1=$ultra_CodeL;              
       }
      else if($line_cnt==2)
       {
        $ultra_rec.=" <div class='center-side'>
                        <div class='masonry-box post-media'>
                          <img src='".$image."' alt='' class='img-fluid'>
                          <div class='shadoweffect'>
                          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
                            <div class='shadow-desc'>
                              <div class='blog-meta'>
                                <span class='bg-aqua'><a  title=''>".$ultra_type."</a></span>
                                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                                <small><a href='garden-single.html' title=''>".$ultra_prix."</a></small>
                                <small><a href='' title=''>".$ultra_nomP."</a></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
        $ultra2=$ultra_CodeL;                 
       } 
      else if($line_cnt==3)
       {
        $ultra_rec.=" <div class='right-side'>
        <div class='masonry-box post-media'>
          <img src='".$image."' alt='' class='img-fluid'>
          <div class='shadoweffect'>
          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
            <div class='shadow-desc'>
              <div class='blog-meta'>
                <span class='bg-aqua'><a title=''>".$ultra_type."</a></span>
                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                <small><a href='' title=''>".$ultra_prix."</a></small>
                <small><a href='' title=''>".$ultra_nomP."</a></small>
              </div>
            </div>
          </div>
        </div>
      </div>"; 
      $ultra3=$ultra_CodeL;   
       } 

       $datenow = new DateTime(date('Y-m-d'));
      $dateNow = $datenow->format('Y-m-d');

      $reqV = "INSERT INTO `log_recomm`(`idL`, `date`) VALUES (?,?)";
      $statementV=$conn->prepare($reqV);
      $statementV->bind_param("ss",$ultra_CodeL,$dateNow);
      $statementV->execute(); 
 
    }
 
}

else
{
$line_cnt=0;
while(($rowR1= mysqli_fetch_array($resR1)))
{
      $line_cnt=$line_cnt+1;
      $ultra_CodeL=$rowR1['idL'];
      //info du logement courant
      $reqIL="SELECT * FROM logement where CodeL=?";
      $statementIL=$conn->prepare($reqIL);
      $statementIL->bind_param('i',$ultra_CodeL);
      $statementIL->execute();
      $resIL=$statementIL->get_result();
      $rowIL=$resIL->fetch_assoc();
      $ultra_titre=$rowIL['nom'];
      $ultra_type=$rowIL['type'];
      $ultra_prix=$rowIL['prix'];
      $ultra_CodeP=$rowIL['CodeP'];
      //info prop
      $reqN="SELECT * from utilisateur where CodeU=?";
      $statementN=$conn->prepare($reqN);
      $statementN->bind_param("i",$ultra_CodeP);
      $statementN->execute();
      $resN=$statementN->get_result();
      $rowN=$resN->fetch_assoc();
      $ultra_nomP=$rowN['username'];

      //image du logement
      $reqI="SELECT * FROM image where CodeL=? Limit 1";
      $statementI=$conn->prepare($reqI);
      $statementI->bind_param("i",$ultra_CodeL);
      $statementI->execute();
      $resI=$statementI->get_result();
      $rowI=$resI->fetch_assoc();
      $ultra_IdI=$rowI['CodeImg'];
      $image="genere_image.php?id=$ultra_IdI";

      
      if($line_cnt==1)
       { 
        $ultra_rec.=" <div class='left-side'>
                        <div class='masonry-box post-media'>
                          <img  src='".$image."' alt='' class='img-fluid'>
                          
                          <div id='Ultr_Img".$line_cnt."' class='shadoweffect'>
                          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
                            <div class='shadow-desc'>
                              <div class='blog-meta'>
                                <span class='bg-aqua'><a  title=''>".$ultra_type."</a></span>
                                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                                <small><a href='' title=''>".$ultra_prix."</a></small>
                                <small><a href='' title=''>".$ultra_nomP."</a></small>
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
        $ultra1=$ultra_CodeL;                 
       }
      else if($line_cnt==2)
       {
        $ultra_rec.=" <div class='center-side'>
                        <div class='masonry-box post-media'>
                          <img src='".$image."' alt='' class='img-fluid'>
                          <div class='shadoweffect'>
                          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
                            <div class='shadow-desc'>
                              <div class='blog-meta'>
                                <span class='bg-aqua'><a title=''>".$ultra_type."</a></span>
                                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                                <small><a href='' title=''>".$ultra_prix."</a></small>
                                <small><a href='' title=''>".$ultra_nomP."</a></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
        $ultra2=$ultra_CodeL;                 
       } 
      else if($line_cnt==3)
       {
        $ultra_rec.=" <div class='right-side'>
        <div class='masonry-box post-media'>
          <img src='".$image."' alt='' class='img-fluid'>
          <div class='shadoweffect'>
          <button id='ultra".$line_cnt."' class='ultra_save'><i class='far fa-heart rf'></i></button>
            <div class='shadow-desc'>
              <div class='blog-meta'>
                <span class='bg-aqua'><a title=''>".$ultra_type."</a></span>
                <h4><a href='garden-single.html' title=''>".$ultra_titre."</a></h4>
                <small><a href='' title=''>".$ultra_prix."</a></small>
                <small><a href='' title=''>".$ultra_nomP."</a></small>
              </div>
            </div>
          </div>
        </div>
      </div>"; 
      $ultra3=$ultra_CodeL;
       } 

       $datenow = new DateTime(date('Y-m-d'));
      $dateNow = $datenow->format('Y-m-d');

      $reqV = "INSERT INTO `log_recomm`(`idL`, `date`) VALUES (?,?)";
      $statementV=$conn->prepare($reqV);
      $statementV->bind_param("ss",$ultra_CodeL,$dateNow);
      $statementV->execute(); 
 
}
}


//recommendation des logement du 2éme section(Top rated)
  //logements recommandées.
       $rated1=0;
       $rated2=0;
       $rated3=0;

$nbr_rated=0;
$top_rated='';
$reqR2="SELECT * from logement order by rating DESC Limit 3";
$statementR2=$conn->prepare($reqR2);
$statementR2->execute();
$resR2=$statementR2->get_result();
while($rowR2= mysqli_fetch_array($resR2))
{
      $nbr_rated=$nbr_rated+1;

      
      $rated_titre=$rowR2['nom'];
      $rated_type=$rowR2['type'];
      $rated_prix=$rowR2['prix'];
      $rated_CodeP=$rowR2['CodeP'];
      $rated_CodeL=$rowR2['CodeL'];
      //nom du prop
      $reqNP="SELECT * from utilisateur where CodeU=?";
      $statementNP=$conn->prepare($reqNP);
      $statementNP->bind_param("i",$rated_CodeP);
      $statementNP->execute();
      $resNP=$statementNP->get_result();
      $rowNP=$resNP->fetch_assoc();
      $rated_nomP=$rowNP['username'];
      //image du logement
      $reqI="SELECT * FROM image where CodeL=? Limit 1";
      $statementI=$conn->prepare($reqI);
      $statementI->bind_param("i",$rated_CodeL);
      $statementI->execute();
      $resI=$statementI->get_result();
      $rowI=$resI->fetch_assoc();
      $rated_IdI=$rowI['CodeImg'];
      $image="genere_image.php?id=$rated_IdI";
      
      
      

      if($nbr_rated==1)
       { 
         $top_rated.="<div class='col-half'>
                      <div class='project animate-box' style='background-image:url(".$image.");'>
                        <div class='desc'>
                        
                         <span>".$rated_nomP."</span>
                         <button id='rated".$nbr_rated."' class='rated_sv' ><i class='far fa-heart tpr'></i></button>
                         <h3>".$rated_titre."</h3>
                         <span>Prix : ".$rated_prix."dh</h3>
                         
                        </div>
                      </div>
                    </div>";
         $rated1=$rated_CodeL;
       }
      else if($nbr_rated==2)
       {
         $top_rated.="<div class='col-half'>
                      <div class='project-grid animate-box' style='background-image:url(".$image.");'>
                      <button id='rated".$nbr_rated."' class='rated_sv' ><i class='far fa-heart tpr'></i></button>
                        <div class='desc'>
                          <span>".$rated_nomP."</span>
                          <h3>".$rated_titre."</h3>
                          <span>Prix : ".$rated_prix."dh</h3>
                        </div>
                      </div>";
         $rated2=$rated_CodeL;             
       } 
      else if($nbr_rated==3)
       {
          $top_rated.="
                      <div class='project-grid animate-box' style='background-image:url(".$image.");'>
                      <button id='rated".$nbr_rated."' class='rated_sv' ><i class='far fa-heart tpr'></i></button>
                        <div class='desc'>
                          <span>".$rated_nomP."</span>
                          <h3>".$rated_titre."</h3>
                          <span>Prix : ".$rated_prix."dh</h3>
                        </div>
                      </div>
                      </div>";
          $rated3=$rated_CodeL;
        }  
       
       $datenow = new DateTime(date('Y-m-d'));
      $dateNow = $datenow->format('Y-m-d');

      $reqV = "INSERT INTO `log_recomm`(`idL`, `date`) VALUES (?,?)";
      $statementV=$conn->prepare($reqV);
      $statementV->bind_param("ss",$rated_CodeL,$dateNow);
      $statementV->execute(); 
}

//recommendation des logement du 3éme section(popular:vues/saves)
 //logements recommandées 
  $pop1=0;
  $pop2=0;
  $pop3=0;
  $pop4=0;
$top_vues="";
$cnt_pop=0;
$month = date('m');
$year = date('Y');
$reqR3="SELECT idL,count(*) as nbr_vues from log_vues where (MONTH(date)=? and YEAR(date)=?) GROUP BY idL ORDER BY nbr_vues Limit 4";
$statementR3=$conn->prepare($reqR3);
$statementR3->bind_param("ss",$month,$year);
$statementR3->execute();
$resR3=$statementR3->get_result();
while($rowR3= mysqli_fetch_array($resR3))
{
      $cnt_pop=$cnt_pop+1;
      
      $pop_CodeL=$rowR3['idL'];

      if($cnt_pop==1)
      $pop1=$pop_CodeL;
      else if($cnt_pop==2)
      $pop2=$pop_CodeL;
      else if($cnt_pop==3)
      $pop3=$pop_CodeL;
      else if($cnt_pop==4)
      $pop4=$pop_CodeL;

      //info du logement courant
      $reqIL="SELECT * FROM logement where CodeL=?";
      $statementIL=$conn->prepare($reqIL);
      $statementIL->bind_param('i',$pop_CodeL);
      $statementIL->execute();
      $resIL=$statementIL->get_result();
      $rowIL=$resIL->fetch_assoc();
      $pop_titre=$rowIL['nom'];
      $pop_type=$rowIL['type'];
      $pop_prix=$rowIL['prix'];
      $pop_CodeP=$rowIL['CodeP'];
      //info prop
      $reqN="SELECT * from utilisateur where CodeU=?";
      $statementN=$conn->prepare($reqN);
      $statementN->bind_param("i",$pop_CodeP);
      $statementN->execute();
      $resN=$statementN->get_result();
      $rowN=$resN->fetch_assoc();
      $pop_nomP=$rowN['username'];

      //image du logement
      $reqI="SELECT * FROM image where CodeL=? Limit 1";
      $statementI=$conn->prepare($reqI);
      $statementI->bind_param("i",$pop_CodeL);
      $statementI->execute();
      $resI=$statementI->get_result();
      $rowI=$resI->fetch_assoc();
      $pop_IdI=$rowI['CodeImg'];
      $image="genere_image.php?id=$pop_IdI";
 
      $top_vues.="<article>
                    <div class='card'>
                      <div class='view zoom overlay'>
                        <h4 class='mb-0'><span class='badge badge-primary badge-pill badge-news'>".$pop_type."</span></h4>
                       <br>
                        <a href='#!'>
                          <div class='mask'>
                            <img class='img-fluid w-100' src='".$image."'>
                            <div class='mask rgba-black-slight'></div>
                          </div>
                        </a>
                      </div>
                      <div class='card-body text-center'>
                        <h5>".$pop_titre."</h5>
                        <p class='small text-muted text-uppercase mb-2'>".$pop_nomP."</p>
                        <hr>
                        <h6 class='mb-3'>
                          <span class='text-primary mr-1'>".$pop_prix."DH</span>
                        </h6> 
                        <a  href='SeeMore.php?smr=".$pop_CodeL."' class='btn btn-primary vr_pls'>Voir plus</a>
                        <a  id='pop".$cnt_pop."' class='btn btn-primary pop_save'><i class='far fa-heart'></i> Enregistrer</a>
                        
                        
                       
                      </div>
                    </div>
                  </article>";

      $datenow = new DateTime(date('Y-m-d'));
      $dateNow = $datenow->format('Y-m-d');

      $reqV = "INSERT INTO `log_recomm`(`idL`, `date`) VALUES (?,?)";
      $statementV=$conn->prepare($reqV);
      $statementV->bind_param("ss",$pop_CodeL,$dateNow);
      $statementV->execute();            
      
    
 
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kapella Bootstrap Admin Dashboard Template</title>
    <link rel="stylesheet" href="../../Resourse/cssSm/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../Resourse/CSS/semantic.min.css">
  <link rel="stylesheet" href="../../Resourse/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../Resourse/vendors/base/vendor.bundle.base.css">
 
  <link rel="stylesheet" href="../../Resourse/ForUserPage/styleCardd.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/grid2.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/colors.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/responsive.css">

  <link rel="stylesheet" href="../../Resourse/css2/styleUser.css">
  <link rel="shortcut icon" href="../../Resourse/images/favicon.png" />


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
                  <span class="count bg-success">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-success">
                          <i class="mdi mdi-information mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">Application Error</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                          Just now
                        </p>
                    </div>
                  </a>
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
                <form class="input-group" action="searshResult.php" methode="POST">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="search">
                        <i class="mdi mdi-magnify"></i>
                      </span>
                    </div>
                    <input type="text" name="rech" class="form-control" placeholder="Search a very wide input..." aria-label="search" aria-describedby="search">
                </form>
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
                  <form method="post" class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                      <i class="mdi mdi-account text-primary"></i>
                      Mon Compte
                    </a>
                    <a href="UserSaves.php" class="dropdown-item">
                      <i class="mdi mdi-heart text-primary"></i>
                      Enregistrements
                    </a>
                    <button name="logoutbtn" class="dropdown-item">
                    <i class="mdi mdi-logout text-primary"></i>
                    Logout
                    </button>
                  </form>
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
    <br>
    <nav aria-label="breadcrumb">
  <ol class="SectionName">

    <p class="breadcrumb-item active" aria-current="page">Logements recommandés</p>
  </ol>
</nav>
<section class="section first-section">
            <div class="container-fluid">
                <div class="masonry-blog clearfix">
                    <?=$ultra_rec?>

                    
                </div><!-- end masonry -->
            </div>
        </section>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>




   <!-- partial -->
   <div class="container-fluid">
    <br>
    <nav aria-label="breadcrumb">
  <ol class="SectionName">
    <p class="breadcrumb-item active" aria-current="page">Logement avec des bon revus</p>
  </ol>
</nav>

<div class="project-content">
				<?=$top_rated;?>
</div>

				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
<br>



 <!-- partial -->
 <div class="container-fluid">
    <br>
    <nav aria-label="breadcrumb">
  <ol class="SectionName">
    <p class="breadcrumb-item active" aria-current="page">Logements populaires</p>
  </ol>
</nav>
    <main class="grid">

  <?=$top_vues?>
   
</main>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
<br>





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
    <script src="../../Resourse/js2/Card.js"></script>

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


</body>
</html>


<script>
//pop save script
var pop1_state='N';
var pop2_state='N';
var pop3_state='N';
var pop4_state='N';

var pop1=<?=$pop1;?>;
var pop2=<?=$pop2;?>;
var pop3=<?=$pop3;?>;
var pop4=<?=$pop4;?>;
var currentU=<?=$codeU?>;


$(document).ready(function(){ 
  //POP1
$('#pop1').click(function(){
         if(pop1_state=='N')
       {
          $('#pop1').empty().append("<i class='fas fa-heart ff'></i> Enregistrée");
          pop1_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop1,CodeU:currentU,action:pop1_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(pop1_state=='Y')
       {
          $('#pop1').empty().append("<i class='far fa-heart ff'></i> Enregistrer");
          pop1_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop1,CodeU:currentU,action:pop1_state},
                 success:function(data){  

                  }
                 });

       }
      });   
//POP2
      $('#pop2').click(function(){
         if(pop2_state=='N')
       {
          $('#pop2').empty().append("<i class='fas fa-heart ff'></i> Enregistrée");
          pop2_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop2,CodeU:currentU,action:pop2_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(pop2_state=='Y')
       {
          $('#pop2').empty().append("<i class='far fa-heart ff'></i> Enregistrer");
          pop2_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop2,CodeU:currentU,action:pop2_state},
                 success:function(data){  

                  }
                 });

       }
      });   


//POP3      

$('#pop3').click(function(){
         if(pop3_state=='N')
       {
          $('#pop3').empty().append("<i class='fas fa-heart ff'></i> Enregistrée");
          pop3_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop3,CodeU:currentU,action:pop3_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(pop3_state=='Y')
       {
          $('#pop3').empty().append("<i class='far fa-heart ff'></i> Enregistrer");
          pop3_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop3,CodeU:currentU,action:pop3_state},
                 success:function(data){  

                  }
                 });

       }
      });   
//POP4
$('#pop3').click(function(){
         if(pop4_state=='N')
       {
          $('#pop4').empty().append("<i class='fas fa-heart ff'></i> Enregistrée");
          pop4_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop4,CodeU:currentU,action:pop4_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(pop4_state=='Y')
       {
          $('#pop4').empty().append("<i class='far fa-heart ff'></i> Enregistrer");
          pop4_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:pop4,CodeU:currentU,action:pop4_state},
                 success:function(data){  

                  }
                 });

       }
      });   


   });   
   
</script>

<script>
//enregister top rated script

var rated1_state='N';
var rated2_state='N';
var rated3_state='N';


var rated1=<?=$rated1;?>;
var rated2=<?=$rated2;?>;
var rated3=<?=$rated3;?>;




$(document).ready(function(){ 
  //rated1
$('#rated1').click(function(){
         if(rated1_state=='N')
       {
          $('#rated1').empty().append("<i class='fas fa-heart ff rf'></i>");
          rated1_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated1,CodeU:currentU,action:rated1_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(rated1_state=='Y')
       {
          $('#rated1').empty().append("<i class='far fa-heart ff tpr'></i>");
          rated1_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated1,CodeU:currentU,action:rated1_state},
                 success:function(data){  

                  }
                 });

       }
      });   
 //rated2   

 $('#rated2').click(function(){
         if(rated2_state=='N')
       {
          $('#rated2').empty().append("<i class='fas fa-heart ff rf'></i>");
          rated2_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated2,CodeU:currentU,action:rated2_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(rated2_state=='Y')
       {
          $('#rated2').empty().append("<i class='far fa-heart ff tpr'></i>");
          rated2_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated2,CodeU:currentU,action:rated2_state},
                 success:function(data){  

                  }
                 });

       }
      });
//rated 3
      $('#rated3').click(function(){
         if(rated3_state=='N')
       {
          $('#rated3').empty().append("<i class='fas fa-heart ff rf'></i>");
          rated3_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated3,CodeU:currentU,action:rated3_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(rated3_state=='Y')
       {
          $('#rated3').empty().append("<i class='far fa-heart ff tpr'></i>");
          rated3_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:rated3,CodeU:currentU,action:rated3_state},
                 success:function(data){  

                  }
                 });

       }
      });      

});
</script>


<script>

var ultra1_state='N';
var ultra2_state='N';
var ultra3_state='N';


var ultra1=<?=$ultra1;?>;
var ultra2=<?=$ultra2;?>;
var ultra3=<?=$ultra3;?>;




$(document).ready(function(){ 
  //ultra1
$('#ultra1').click(function(){
         if(ultra1_state=='N')
       {
          $('#ultra1').empty().append("<i class='fas fa-heart ff rf'></i>");
          ultra1_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra1,CodeU:currentU,action:ultra1_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(ultra1_state=='Y')
       {
          $('#ultra1').empty().append("<i class='far fa-heart ff tpr'></i>");
          ultra1_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra1,CodeU:currentU,action:ultra1_state},
                 success:function(data){  

                  }
                 });

       }
      });   
//ultra2
$('#ultra2').click(function(){
         if(ultra2_state=='N')
       {
          $('#ultra2').empty().append("<i class='fas fa-heart ff rf'></i>");
          ultra2_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra2,CodeU:currentU,action:ultra2_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(ultra2_state=='Y')
       {
          $('#ultra2').empty().append("<i class='far fa-heart ff tpr'></i>");
          ultra2_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra2,CodeU:currentU,action:ultra2_state},
                 success:function(data){  

                  }
                 });

       }
      });   

//ultra3
$('#ultra3').click(function(){
         if(ultra3_state=='N')
       {
          $('#ultra3').empty().append("<i class='fas fa-heart ff rf'></i>");
          ultra3_state='Y';
          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra3,CodeU:currentU,action:ultra3_state},
                 success:function(data){  

                  }
                 });


       }   
      else if(ultra3_state=='Y')
       {
          $('#ultra3').empty().append("<i class='far fa-heart ff tpr'></i>");
          ultra3_state='N';

          $.ajax({  
                 url:"SaveL.php",   
                 method:"POST",
                 data:{CodeL:ultra3,CodeU:currentU,action:ultra3_state},
                 success:function(data){  

                  }
                 });

       }
      });        

    });
</script>
<script>

var nbr_cards=<?=$line_cnt;?>;

document.getElementById('ultra1').style.display='none';
if(nbr_cards==2)
document.getElementById('ultra2').style.display='none';
if(nbr_cards==3)
{
  document.getElementById('ultra2').style.display='none';
 document.getElementById('ultra3').style.display='none';
}
$(document).ready(function(){ 

    $('#Ultr_Img1').mouseenter(function(){
      document.getElementById('ultra1').style.display='block';
       
      });   
      $('#Ultr_Img1').mouseleave(function(){
      document.getElementById('ultra1').style.display='none';
       
      });      
    });     
</script>