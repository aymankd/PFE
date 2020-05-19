
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- base:css -->
    <link rel="stylesheet" href="../../Resourse/Packs/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../Resourse/Packs/vendors/base/vendor.bundle.base.css">
  
    <!-- inject:css -->
    <link rel="stylesheet" href="../../Resourse/Packs/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../Resourse/Packs/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
		<!-- partial:partials/_horizontal-navbar.html -->
    <div id="mn" class="horizontal-menu">
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
                    <span id="nbrnts" class="count bg-success"></span>
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
                      <span class="nav-profile-name"></span>
                      <span class="online-status"></span>
                     
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
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
        <div class="grid-container1">
  <div class="texthead">
  <h2 class="card-title head">LES PACKS</h2>
  <h1 class="card-title head">Nos Packs</h1>
  </div>
</div>
				<div class="grid-container">
  <div class="card1">
  <div class="card">
								<div class="card-body">
									
                <h4 class="card-title head">Localiser mon logement</h4>
              
										<div class="h3div">
                      <h3  class="card-title">Recommandation sur la page acceuil</h3>
                      <h3  class="card-title">Recommandation  dans les resultats de recherche </h3>
                      <h3  class="card-title">Recommandation dans les resultats similaire</h3>
                      <h3  class="card-title">Ajout de 10 nouveaux photos de votre logement</h3>
                      <h3  class="card-title">Accès au statistiques du logements</h3>

                      <h5  class="prixtext">  150 Dh<h5>
</div>
                      

                     
               
<div class="buttonbotom">
                <button id="cnfrm" type="button" class="btn btn-success" >Acheter</button>		</div>
									</div>
								</div>


  </div>
  <div class="card2">
  <div class="card">
								<div class="card-body">
									
                <h4 class="card-title head">Localiser mon logement</h4>
                <div class="h3div">
                      <h3  class="card-title">Recommandation  dans les résultat de recherche</h3>
                      <h3  class="card-title">Ajout de 5 nouveaux photos de votre logement</h3>
                      <h3  class="card-title">Accès au statistuqes du logement</h3>
                      <h3  class="card-title">Ajout de 101 nouveaux photos de votre logement</h3>
                      <h3  class="card-title TOHIDE">Ajout de 101 nouveaux photos de votre logement</h3>

                      <h5  class="prixtext">  70 Dh<h5>
</div>
<div class="buttonbotom">
<button type="button" class="btn btn-secondary">Acheter</button></div>
									</div>
								</div>


  </div>
</div>
						
							


                
							</div>
						
					
					
					
					
        </div>
        
     
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="../../Resourse/Packs/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../Resourse/Packs/js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
  
    <!-- Custom js for this page-->
    <script src="../../Resourse/Packs/js/dashboard.js"></script>
    <!-- End custom js for this page-->
   