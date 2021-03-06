<?php
session_start();
if(isset($_POST['logoutbtn'])) 
{
	unset($_SESSION['type']);
	unset($_SESSION['username']);
}
if( !isset($_SESSION['username']) || $_SESSION['type'] != "pro" )
{
  header("location:../../indexx.php");
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

$ulLog="";
//dropdown logement ultra
$requl="SELECT * FROM logement WHERE CodeP=? and (CodeL NOT IN (SELECT CodeL FROM pack where CodeU=? and type!='super' and type!='ultra' ))";
$statementul=$conn->prepare($requl);
$statementul->bind_param("ii",$codeU,$codeU);
$statementul->execute();
$resul=$statementul->get_result();
while($rowul = mysqli_fetch_array($resul)){ 
$ulLog.="
<div class='form-check'>
  <label class='form-check-label'>
  <input type='checkbox' name='check_ul' value='".$rowul['CodeL']."' class='form-check-input check_ul' >
  ".$rowul['nom']."
  </label>
</div>
";
}
$SupLog="";
//dropdown logement super
$reqSu="SELECT * FROM logement WHERE CodeP=? and (CodeL NOT IN (SELECT CodeL FROM pack where CodeU=? and type!='super' ))";
$statementSu=$conn->prepare($reqSu);
$statementSu->bind_param("ii",$codeU,$codeU);
$statementSu->execute();
$resSu=$statementSu->get_result();
while($rowSu = mysqli_fetch_array($resSu)){ 
$SupLog.="
<div class='form-check'>
  <label class='form-check-label'>
  <input type='checkbox' name='check_su' value='".$rowSu['CodeL']."' class='form-check-input check_su' >
  ".$rowSu['nom']."
  </label>
</div>
";
}







?>
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
  <link rel="stylesheet" href="../../Resourse/css2/dropbtn.css">
  <link rel="shortcut icon" href="../../Resourse/images/favicon.png" />


  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
  <link rel="stylesheet" href="../../Resourse/css3/chatbox.css">
  <link rel="stylesheet" href="../../Resourse/css3/packbox.css">


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
                    <a class="dropdown-item">
                      <i class="mdi mdi-account text-primary"></i>
                      Mon Compte
                    </a>
                    <a class="dropdown-item">
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

    <!-- partial -->
		<div class="container-fluid">
    <main class="grid">

          <div class='containerbox'>
        <section class='card' data-toggle='modal' data-target='#UltraModal'>
          <div class='card_inner'>
            <div class='card_inner__circle'>
              <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/rocket.png'>
            </div>
            <div class='card_inner__header'>
              <img src='http://www.pixeden.com/media/k2/galleries/343/002-city-vector-background-town-vol2.jpg'>
            </div>
            <div class='card_inner__content'>
              <div class='title'>Ultra Logement</div>
              <div class='price'>$39</div>
              <div class='text'>
                RECHERCH <br>
                HOME <br>
                +10 PHOTO
              </div>
            </div>
            <div class='card_inner__cta'>
              <button>
                <span>Buy now</span>
              </button>
            </div>
          </div>
        </section>
        <section class='card' style="display:none">
        </section>
        <section class='card' data-toggle='modal' data-target='#SuperModal'>
          <div class='card_inner'>
            <div class='card_inner__circle'>
              <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/paperplane.png'>
            </div>
            <div class='card_inner__header'>
              <img src='http://7428.net/wp-content/uploads/2013/06/Forest-Creek.jpg'>
            </div>
            <div class='card_inner__content'>
              <div class='title'>Super Logement</div>
              <div class='price'>$19</div>
              <div class='text'>
                * RECHERCH <br>
                * +5 PHOTO <br>
                <br>
              </div>
            </div>
            <div class='card_inner__cta'>
              <button>
                <span>Buy now</span>
              </button>
            </div>
          </div>
        </section>

      </div>


    </main>


				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
    <?=$chatboxs; ?>

    <!-- Ultra Modal -->
    <div class="modal fade" id="UltraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ultra Modal</h5>
          </div>
          <div class="modal-body">

            <div class="form-group row">
              <div class="col-sm-9">
                <div class="dropdown">
                  <button class="dropbtn form-control btn btn-default btn-sm dropdown-toggle ">Logement</button>
                  <div class="dropdown-content force-scroll">
                    <div class="radioEq">
                      <?=$ulLog; ?>

                    </div>	
                  </div>
                </div> 
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9">
                <div class="dropdown">
                  <button class="dropbtn form-control btn btn-default btn-sm dropdown-toggle ">temp de pack</button>
                  <div class="dropdown-content force-scroll">
                    <div class="radioEq">
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='temp' value="1" class='form-check-input' checked>
                        1 mois
                        </label>
                      </div>
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='temp' value="3" class='form-check-input' >
                        3 mois
                        </label>
                      </div>
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='temp' value="12" class='form-check-input' >
                        1 année
                        </label>
                      </div>
                    </div>	
                  </div>
                </div> 
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <div id="ultraprix">
              
            </div>
            <button type="button" id="ulAccepte" onclick="ulAcc()" class="btn btn-primary">Accepte</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Super Modal -->
    <div class="modal fade" id="SuperModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Super Modal</h5>
          </div>
          <div class="modal-body">

            <div class="form-group row">
              <div class="col-sm-9">
                <div class="dropdown">
                  <button class="dropbtn form-control btn btn-default btn-sm dropdown-toggle ">Logement</button>
                  <div class="dropdown-content force-scroll">
                    <div class="radioEq">
                      <?=$SupLog; ?>

                    </div>	
                  </div>
                </div> 
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9">
                <div class="dropdown">
                  <button class="dropbtn form-control btn btn-default btn-sm dropdown-toggle ">temp de pack</button>
                  <div class="dropdown-content force-scroll">
                    <div class="radioEq">
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='Stemp' value="1" class='form-check-input' checked>
                        1 mois
                        </label>
                      </div>
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='Stemp' value="3" class='form-check-input' >
                        3 mois
                        </label>
                      </div>
                      <div class='form-check'>
                        <label class='form-check-label'>
                        <input type='radio' name='Stemp' value="12" class='form-check-input' >
                        1 année
                        </label>
                      </div>
                    </div>	
                  </div>
                </div> 
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <div id="Superprix">
              
            </div>
            <button type="button" id="suAccepte" onclick="suAcc()" class="btn btn-primary">Accepte</button>
          </div>
        </div>
      </div>
    </div>

    








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
   
    
    </script>
    <script>
    setInterval(function() {

                  var checkedlog = [];
                // Initializing array with Checkbox checked values
                $("input[name='check_ul']:checked").each(function(){
                  checkedlog.push(this.value);
                });
                  var timepack = $('input:radio[name="temp"]:checked').val();
                  
                  $.ajax({  
                            url:"ultra.php",  
                            method:"POST",  
                            data:{logment: checkedlog,timeout:timepack},  
                            success:function(data){
                              $('#ultraprix').html(data);
                            }  
                      });

                var checkedlogSu = [];
              // Initializing array with Checkbox checked values
              $("input[name='check_su']:checked").each(function(){
                checkedlogSu.push(this.value);
              });
                var timepackSu = $('input:radio[name="Stemp"]:checked').val();
                
                $.ajax({  
                          url:"super.php",  
                          method:"POST",  
                          data:{logment: checkedlogSu,timeout:timepackSu},  
                          success:function(data){
                            $('#Superprix').html(data);
                          }  
                    });
    }, 100);

    </script>
    <script>
    //validation method
    function ulAcc() {
      var checkedlogU = [];
                // Initializing array with Checkbox checked values
                $("input[name='check_ul']:checked").each(function(){
                  checkedlogU.push(this.value);
                });
                  var timepackU = $('input:radio[name="temp"]:checked').val();


      $.ajax({  
              url:"ulclick.php",  
              method:"POST",  
              data:{logment: checkedlogU,timeout:timepackU},  
              success:function(data){
                $('#ultraprix').html(data);
              }  
        });
    }
    function suAcc() {
      var checkedlogS = [];
                // Initializing array with Checkbox checked values
                $("input[name='check_su']:checked").each(function(){
                  checkedlogS.push(this.value);
                });
                  var timepackS = $('input:radio[name="Stemp"]:checked').val();
      $.ajax({  
              url:"suclick.php",  
              method:"POST",  
              data:{logment: checkedlogS,timeout:timepackS},  
              success:function(data){
                $('#Superprix').html(data);
              }  
        });
    }

    </script>



    <?=$jsScript; ?>

  
</body>
</html>