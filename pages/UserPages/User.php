<?php
session_start();

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
 
  <link rel="stylesheet" href="../../Resourse/ForUserPage/styleCardd.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/grid2.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/colors.css">
  <link rel="stylesheet" href="../../Resourse/ForUserPage/css/responsive.css">

  <link rel="stylesheet" href="../../Resourse/css2/styleUser.css">
  <link rel="shortcut icon" href="../../Resourse/images/favicon.png" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  <link rel="stylesheet" href="../../Resourse/cssSm/font-awesome.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
  <link rel="stylesheet" href="../../Resourse/css3/chatbox.css">


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
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                        <i class="mdi mdi-account text-primary"></i>
                        Mon Compte
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
    <br>
    <nav aria-label="breadcrumb">
  <ol class="SectionName">
    <p class="breadcrumb-item active" aria-current="page">Section 1</p>
  </ol>
</nav>
<section class="section first-section">
            <div class="container-fluid">
                <div class="masonry-blog clearfix">
                    <div class="left-side">
                        <div class="masonry-box post-media">
                             <img src="../../Resourse/images/lag-60.png" alt="" class="img-fluid">
                             <div class="shadoweffect">
                                <div class="shadow-desc">
                                    <div class="blog-meta">
                                        <span class="bg-aqua"><a href="blog-category-01.html" title="">Gardening</a></span>
                                        <h4><a href="garden-single.html" title="">How to choose high quality soil for your gardens</a></h4>
                                        <small><a href="garden-single.html" title="">21 July, 2017</a></small>
                                        <small><a href="#" title="">by Amanda</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end shadow-desc -->
                            </div><!-- end shadow -->
                        </div><!-- end post-media -->
                    </div><!-- end left-side -->

                    <div class="center-side">
                        <div class="masonry-box post-media">
                             <img src="../../Resourse/images/lag-61.png" alt="" class="img-fluid">
                             <div class="shadoweffect">
                                <div class="shadow-desc">
                                    <div class="blog-meta">
                                        <span class="bg-aqua"><a href="blog-category-01.html" title="">Outdoor</a></span>
                                        <h4><a href="garden-single.html" title="">You can create a garden with furniture in your home</a></h4>
                                        <small><a href="garden-single.html" title="">19 July, 2017</a></small>
                                        <small><a href="#" title="">by Amanda</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end shadow-desc -->
                            </div><!-- end shadow -->
                        </div><!-- end post-media -->
                    </div><!-- end left-side -->

                    <div class="right-side hidden-md-down">
                        <div class="masonry-box post-media">
                             <img src="../../Resourse/images/lag-63.png" alt="" class="img-fluid">
                             <div class="shadoweffect">
                                <div class="shadow-desc">
                                    <div class="blog-meta">
                                        <span class="bg-aqua"><a href="blog-category-01.html" title="">Indoor</a></span>
                                        <h4><a href="garden-single.html" title="">The success of the 10 companies in the vegetable sector</a></h4>
                                        <small><a href="garden-single.html" title="">03 July, 2017</a></small>
                                        <small><a href="#" title="">by Jessica</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end shadow-desc -->
                             </div><!-- end shadow -->
                        </div><!-- end post-media -->
                    </div><!-- end right-side -->
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
    <p class="breadcrumb-item active" aria-current="page">Section 2</p>
  </ol>
</nav>
<div class="project-content">
			<div class="col-half">
				<div class="project animate-box" style="background-image:url(../../Resourse/images/lag-60.png);">
					<div class="desc">
						<span>Mr Alami dodo</span>
						<h3>Appartement1</h3>
						<span>Prix : 5000dh</h3>
					</div>
				</div>
			</div>
			<div class="col-half">
				<div class="project-grid animate-box" style="background-image:url(../../Resourse/images/lag-61.png);">
					<div class="desc">
					<span>Mr Alami dodo</span>
						<h3>Appartement1</h3>
						<span>Prix : 5000dh</h3>
					</div>
				</div>
				<div class="project-grid animate-box" style="background-image:url(../../Resourse/images/tr3.png);">
					<div class="desc">
					<span>Mr Alami dodo</span>
						<h3>Appartement1</h3>
						<span>Prix : 5000dh</h3>
					</div>
				</div>
			</div>
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
    <p class="breadcrumb-item active" aria-current="page">Section 3</p>
  </ol>
</nav>
    <main class="grid">
     <article>
    <!-- Card -->
<div class="card">

<div class="view zoom overlay">
  <h4 class="mb-0"><span class="badge badge-primary badge-pill badge-news">Sale</span></h4>
  <a href="#!">
    <div class="mask">
      <img class="img-fluid w-100"
        src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/13.jpg">
      <div class="mask rgba-black-slight"></div>
    </div>
  </a>
</div>

<div class="card-body text-center">

  <h5>Fantasy T-shirt</h5>
  <p class="small text-muted text-uppercase mb-2">Shirts</p>
  
  <hr>
  <h6 class="mb-3">
    <span class="text-danger mr-1">12.99$</span>
    <span class="text-grey"><s>36.99$</s></span>
  </h6>

 
  <button type="button" class="btn btn-light btn-sm mr-1 mb-2">
    <i class="fas fa-info-circle pr-2"></i>Details
  </button>
  <button type="button" class="btn btn-danger btn-sm px-3 mb-2 material-tooltip-main" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
    <i class="far fa-heart"></i>
  </button>

</div>

</div>
<!-- Card -->
  </article>
  <article>
    <!-- Card -->
<div class="card">

<div class="view zoom overlay">
  <h4 class="mb-0"><span class="badge badge-primary badge-pill badge-news">Sale</span></h4>
  <a href="#!">
    <div class="mask">
      <img class="img-fluid w-100"
        src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/13.jpg">
      <div class="mask rgba-black-slight"></div>
    </div>
  </a>
</div>

<div class="card-body text-center">

  <h5>Fantasy T-shirt</h5>
  <p class="small text-muted text-uppercase mb-2">Shirts</p>
  
  <hr>
  <h6 class="mb-3">
    <span class="text-danger mr-1">12.99$</span>
    <span class="text-grey"><s>36.99$</s></span>
  </h6>

 
  <button type="button" class="btn btn-light btn-sm mr-1 mb-2">
    <i class="fas fa-info-circle pr-2"></i>Details
  </button>
  <button type="button" class="btn btn-danger btn-sm px-3 mb-2 material-tooltip-main" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
    <i class="far fa-heart"></i>
  </button>

</div>

</div>
<!-- Card -->
  </article>
  <article>
    <!-- Card -->
<div class="card">

<div class="view zoom overlay">
  <h4 class="mb-0"><span class="badge badge-primary badge-pill badge-news">Sale</span></h4>
  <a href="#!">
    <div class="mask">
      <img class="img-fluid w-100"
        src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/13.jpg">
      <div class="mask rgba-black-slight"></div>
    </div>
  </a>
</div>

<div class="card-body text-center">

  <h5>Fantasy T-shirt</h5>
  <p class="small text-muted text-uppercase mb-2">Shirts</p>
  
  <hr>
  <h6 class="mb-3">
    <span class="text-danger mr-1">12.99$</span>
    <span class="text-grey"><s>36.99$</s></span>
  </h6>

 
  <button type="button" class="btn btn-light btn-sm mr-1 mb-2">
    <i class="fas fa-info-circle pr-2"></i>Details
  </button>
  <button type="button" class="btn btn-danger btn-sm px-3 mb-2 material-tooltip-main" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
    <i class="far fa-heart"></i>
  </button>

</div>

</div>
<!-- Card -->
  </article>
  <article>
    <!-- Card -->
<div class="card">

<div class="view zoom overlay">
  <h4 class="mb-0"><span class="badge badge-primary badge-pill badge-news">Sale</span></h4>
  <a href="#!">
    <div class="mask">
      <img class="img-fluid w-100"
        src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Vertical/13.jpg">
      <div class="mask rgba-black-slight"></div>
    </div>
  </a>
</div>

<div class="card-body text-center">

  <h5>Fantasy T-shirt</h5>
  <p class="small text-muted text-uppercase mb-2">Shirts</p>
  
  <hr>
  <h6 class="mb-3">
    <span class="text-danger mr-1">12.99$</span>
    <span class="text-grey"><s>36.99$</s></span>
  </h6>

 
  <button type="button" class="btn btn-light btn-sm mr-1 mb-2">
    <i class="fas fa-info-circle pr-2"></i>Details
  </button>
  <button type="button" class="btn btn-danger btn-sm px-3 mb-2 material-tooltip-main" data-toggle="tooltip" data-placement="top" title="Add to wishlist">
    <i class="far fa-heart"></i>
  </button>

</div>

</div>
<!-- Card -->
  </article>
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