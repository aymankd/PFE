<?php
session_start();
if(isset($_POST['logoutbtn'])) 
{
	unset($_SESSION['type']);
	unset($_SESSION['username']);
}
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


//logement vue
$Vue = array();
$Vue[1]=0; $Vue[2]=0; $Vue[3]=0; $Vue[4]=0;
$Vue[5]=0; $Vue[6]=0; $Vue[7]=0; $Vue[8]=0;
$Vue[9]=0;$Vue[10]=0;$Vue[11]=0;$Vue[12]=0;
$thisyear = date("Y");

$reqP="SELECT * FROM logement where CodeP=?";
$statementP=$conn->prepare($reqP);
$statementP->bind_param("s",$codeU);
$statementP->execute();
$resP=$statementP->get_result();
while ( $rowP = mysqli_fetch_array($resP) )
  {
    $logementtochar=$rowP['CodeL'];
    $reqVue="SELECT COUNT(*) as sumres,MONTH(date) as mou FROM `log_vues` where YEAR(date) = ?
    and `idL`=? GROUP BY MONTH(date)";
    $statementVue=$conn->prepare($reqVue);
    $statementVue->bind_param("ss",$thisyear,$logementtochar);
    $statementVue->execute();
    $resVue=$statementVue->get_result();
    while ( $rowVue = mysqli_fetch_array($resVue) )
    {
      $Vue[$rowVue['mou']] = $Vue[$rowVue['mou']] + $rowVue['sumres'];
    }
  }





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
  $reqN="SELECT * from user_notis where CodeP=? and status='old'";
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
                      //$nbr_nts=$nbr_nts+1;
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
                     // $nbr_nts=$nbr_nts+1;
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
                    //  $nbr_nts=$nbr_nts+1;
     }
    /* $reqUp="UPDATE `user_notis` SET status='loaded'  where idN=?";
     $statementUp=$conn->prepare($reqUp);
     $statementUp->bind_param("i",$nt_code);
     $statementUp->execute();*/

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
                  <a  id="noti_open" class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell mx-0"></i>
                    <span id="nbrnts" class="count bg-success"><?php if($nbr_nts>0) echo $nbr_nts?></span>
                  </a>
                  <div id="notifs" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p> <br>
                    <hr>
                    <a id="clr_all">Clear all</a>
                    
                    <div id="stsx">
                      
                      </div>
                    <div id="new_user_notis">
                      
                    </div>

                    <div id="loaded_user_notis">
                      
                    </div>

                    <div id="old_user_notis">
                    <?=$user_notis?>   
                    </div>
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
                    <form method="post" class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                      <a href="../Gestions/prop/gestionProp.php" class="dropdown-item">
                        <i class="mdi mdi-account text-primary"></i>
                        Mon Compte
                      </a>
                      <a href="../Gestions/Logement/GestionLog.php" class="dropdown-item">
                        <i class="mdi mdi-home-modern text-primary"></i>
                        Les Logement
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
      <div class="main-panel">
				<div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <h4 class="card-title">Line chart</h4>
                            <canvas id="lineChart" width="682" height="340" class="chartjs-render-monitor" style="display: block; height: 227px; width: 455px;"></canvas>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <h4 class="card-title">Bar chart</h4>
                            <canvas id="barChart" style="display: block; height: 227px; width: 455px;" width="682" height="340" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        </div>
                    </div>
				</div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				<footer class="footer">
          <div class="footer-wrap">
              <div class="w-100 clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020 ESRENT. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"></span>
              </div>
          </div>
        </footer>
				<!-- partial -->
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


<script>
var CodePst=<?=$codeU?>;
var nbrnts=<?=$nbr_nts?>;
var nbrnts2=0;
var audioNT = new Audio('../sound/time-is-now.mp3');




  setInterval(function(){ 
  
//new notis

    $.ajax({  
                          url:"User_Notis.php",  
                          method:"POST",  
                          data:{CodeP:CodePst,nbrnts:nbrnts,act:'get'},  
                          dataType : 'json',
                          success:function(response){
                           
                            nbrnts=response.result;
                            nbrnts2=response.result;

                            if(nbrnts ><?=$nbr_nts?>)
                            {$('#nbrnts').empty().append(nbrnts);
                              audioNT.play();
                            }
                           nbrnts=<?=$nbr_nts?>;
                           
                             
                          }  
                    });
//loaded notis
                    $.ajax({  
                          url:"Loaded_User_Notis.php",  
                          method:"POST",  
                          data:{CodeP:CodePst,nbrnts:<?=$nbr_nts?>},  
                          dataType : 'json',
                          success:function(response2){

                            $('#loaded_user_notis').html(response2.echo);
                            nbrnts=response2.result2;
                            if(nbrnts ><?=$nbr_nts?>)
                            {$('#nbrnts').empty().append(nbrnts);}
                            nbrnts=<?=$nbr_nts?>;

                             
                          }  
                    });

//old notis       

$.ajax({  
                          url:"Old_User_Notis.php",  
                          method:"POST",  
                          data:{CodeP:CodePst,nbrnts:<?=$nbr_nts?>},  
                          dataType : 'json',
                          success:function(response3){

                            $('#old_user_notis').html(response3.echo);
                            
                            
                             
                          }  
                    });
    }, 1000);

   


   


   
</script>

<script>
var mns=0;
$(document).ready(function(){  

nt_clsd="Y";

   $('#noti_open').click(function(){  
          if(nt_clsd=="Y")
           {
            $.ajax({  
                          url:"noti_is_old.php",  
                          method:"POST",  
                          data:{CodeP:CodePst,nbrnts:<?=$nbr_nts?>},  
                          dataType : 'json',
                          success:function(response4){
                            mns=response4.result4;
                            if(mns>0)
                            $('#nbrnts').empty().append(mns);
                          // arr=response3.tab;
                           //$('#old_user_notis').insertAdjacentHTML('afterbegin',response3.echo);
                          //  $('#old_user_notis').html();
                            

                             
                          }  
                    });

             nt_clsd="N";
           }
          else if(nt_clsd=="N")
           {
            

            nt_clsd="Y";
           }
          
       });
        
       
  
 
 }); 
</script>

<script>

$(function() {
  var Linedata = {
    labels: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aou", "Sept", "Oct", "Nov", "Dec"],
    datasets: [{
      label: '# of Votes',
      data: [<?=$Vue[1] ;?>,<?=$Vue[2] ;?>,<?=$Vue[3] ;?>,<?=$Vue[4] ;?>, <?=$Vue[5] ;?>,
        <?=$Vue[6] ;?>, <?=$Vue[7] ;?>, <?=$Vue[8] ;?>, <?=$Vue[9] ;?>, <?=$Vue[10] ;?>,
        <?=$Vue[11] ;?>, <?=$Vue[12] ;?>],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var Bardata = {
    labels: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aou", "Sept", "Oct", "Nov", "Dec"],
    datasets: [{
      label: '# of Votes',
      data: [10, 19, 3, 5, 2, 3,10, 19, 3, 5, 2, 3],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };


  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }
  };
  // Get context with jQuery - using jQuery's .get() method.
  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: Bardata,
      options: options
    });
  }

  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: Linedata,
      options: options
    });
  }

});

</script>
</body>
</html>