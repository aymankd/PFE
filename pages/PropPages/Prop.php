<?php

session_start();
if( !isset($_SESSION['username']) || $_SESSION['type'] != "pro" )
{
  header("location:../../homeP.php");
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
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                        <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                        </h6>
                        <p class="font-weight-light small-text text-muted mb-0">
                          The meeting is cancelled
                        </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                        <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                        </h6>
                        <p class="font-weight-light small-text text-muted mb-0">
                          New product launch
                        </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content flex-grow">
                        <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                        </h6>
                        <p class="font-weight-light small-text text-muted mb-0">
                          Upcoming board meeting
                        </p>
                    </div>
                  </a>
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
                    <span class="nav-profile-name">Johnson</span>
                    <span class="online-status"></span>
                    <img src="../../Resourse/images/dashboard/face29.png" alt="profile"/>
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
   <img src="../../Resourseimages/lockscreen-bg.jpg" class="d-block w-100">
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

  
</body>
</html>