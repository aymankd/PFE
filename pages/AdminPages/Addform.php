<?php 
session_start();
$servername = "localhost";
  $userservername = "root";
  $database = "pfe";
  $msg="";
  $alert="";


// Create connection
$conn = new mysqli($servername, $userservername,"", $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

///////////////remplicage des equipment///////////////
$equi="";
$req = "SELECT * FROM equipement";
$statement=$conn->prepare($req);
$statement->execute();
$res=$statement->get_result();
while ($row = mysqli_fetch_array($res)) 
{
	$equi .= 
"	<div class='form-check'>
	<label class='form-check-label'>
	<input type='checkbox' name='check_list[]' value=".$row['CodeE']." class='form-check-input' >
	".$row['nom']."
	</label>
	</div>
";
}
//////////////////////////////////////////////////////


////////////////////////Ajout/////////////////////////

$img=array();

if(isset($_POST['EnrFrm']))
{
	$AccType=$_POST['rad1'];
	$LogeType=$_POST['logetype'];
	$PdfFile=file_get_contents($_FILES["pdf"]["tmp_name"]);
	$i=$_POST['i_var'];
	$count=0;
	$filename="";
	for ($v=0 ; $v < $i ; $v++) 
	 {
	   $filename=$_FILES[$v]['name'];
	   if($filename!="")
	    {
	      $img[$count]=file_get_contents($_FILES[$v]["tmp_name"]);
	      $count = $count + 1;
	    }
	   $filename="";
	 }

	$nomL=$_POST['nomL'];
	$Desc=$_POST['Desc'];
	$nbrloc=$_POST['nbrloc'];
	$adresseL=$_POST['AdrLo'];
	$prix=$_POST['prixL'];
	$sprfc=$_POST['sprfc'];
	$reglement=$_POST['Reg'];

	$checkedItems=$_POST['check_list'];





			$Accval=null;
			$CodeU=null;


			if($AccType=="New")
			{
					$nom=$_POST['nomP'];
					$prenom=$_POST['PrenomP'];
					$CIN=$_POST['CIN'];
					$Tel=$_POST['Tel'];
					$AdressP=$_POST['Adr'];
					$Email=$_POST['Email'];

					$reqC = "SELECT * from proprietaire where CIN=? ";
					$statementC=$conn->prepare($reqC);
					$statementC->bind_param("s",$CIN);
					$statementC->execute();
					$resC=$statementC->get_result();
					$reqT = "SELECT * from proprietaire where Tel=?";
					$statementT=$conn->prepare($reqT);
					$statementT->bind_param("s",$Tel);
					$statementT->execute();
					$resT=$statementT->get_result();
					$reqE = "SELECT * from utilisateur where Email=?";
					$statementE=$conn->prepare($reqE);
					$statementE->bind_param("s",$Email);
					$statementE->execute();
					$resE=$statementE->get_result();


					if ($resC->num_rows==0 && $resT->num_rows==0 && $resE->num_rows==0)
					 {

						//creation utilisateur , select Code , creation Proprietaire

				          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				          $pa = '';
				          for ($i = 0; $i < 8; $i++) {
				              $pa = $pa.$characters[rand(0, strlen($characters))];
				          }
				          $pa=sha1($pa);
							$type="proprietaire";
					        $reqI = "INSERT INTO `utilisateur`(`username`, `email`, `pass`, `type`) VALUES (?,?,?,?)";
					        $statementI=$conn->prepare($reqI);
					        $statementI->bind_param("ssss",$CIN,$Email,$pa,$type);
					        $statementI->execute();

							$reqI = "SELECT CodeU FROM utilisateur where username=? ";
					        $statementI=$conn->prepare($reqI);
					        $statementI->bind_param("s",$CIN);
					        $statementI->execute();
						    $resI=$statementI->get_result();
						    $rowI=$resI->fetch_assoc();
						    $CodeU=$rowI['CodeU'];

					        $reqP = "INSERT INTO `proprietaire`(`CodeP`, `CIN`, `adress`, `nom`, `prenom`, `tel`) VALUES (?,?,?,?,?,?)";
					        $statementP=$conn->prepare($reqP);
					        $statementP->bind_param("isssss",$CodeU,$CIN,$AdressP,$nom,$prenom,$Tel);
					        $statementP->execute();

					        $Accval="Ok";
					}
					else if($resC->num_rows!=0 && $resT->num_rows!=0)
					{
					   $alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>CIN et numero de telephone existent déjà:</strong> entrez des nouvelles valeures.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
					}
					else if($resT->num_rows!=0 && $resE->num_rows!=0)
					{
						$alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>Email et numero de telephone existent déjà:</strong> entrez des nouvelles valeures.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
					}
					else if($resE->num_rows!=0 && $resC->num_rows!=0)
					{
						$alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>CIN et Email existent déjà :</strong> entrez des nouvelles valeures.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
					}
					else if($resC->num_rows!=0 && $resT->num_rows!=0 && $resE->num_rows!=0)
					{
					   $alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>CIN,Email et numero de telephone existent déjà :</strong> entrez des nouvelles valeures.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
					}
					else if ($resC->num_rows!=0)
					{
					  $alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			          <strong>CIN existe déjà :</strong> entrez une nouvelle valeure.
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			          </button>
			          </div>';
					}
					else if ($resT->num_rows!=0)
					{
					  $alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			          <strong>Numero de Tele existe déjà:</strong> entrez une nouvelle valeure.
			          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			          </button>
			          </div>';
					}
					else if ($resE->num_rows!=0)
					{
					   $alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>Email existe déjà :</strong> entrez une nouvelle valeure.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
					}
			}
			else if($AccType="EXST")
			{

					$Username=$_POST['Username'];

					$reqU = "SELECT * from utilisateur where Username=? ";
					$statementU=$conn->prepare($reqU);
					$statementU->bind_param("s",$Username);
					$statementU->execute();
					$resU=$statementU->get_result();
					$rowU=$resU->fetch_assoc();

					if ($resU->num_rows==1)
					{
						$Utype=$rowU['type'];
						if($Utype=="normal")
						{
						$CodeU=$rowU['CodeU'];
						$req = "INSERT INTO `proprietaire`(`CodeP`) values() ";
						$statement=$conn->prepare($req);
						$statement->bind_param("i",$CodeU);
						$statement->execute();
						$Accval="Ok";				
						}
						else if ($Utype=="proprietaire"){
						$Accval="Ok";
						$CodeU=$rowU['CodeU'];
						}else
						{
						$alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>ce username appartien à un admin :</strong> tapez un autre username.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
						}
					}else if($resU->num_rows!=1)
						{
						$alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">
			           <strong>Username non existant :</strong> entrez un unsername valide.
			           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			           <span aria-hidden="true">&times;</span>
			           </button>
			           </div>';
						}
			}


			if ($Accval=="Ok" && $CodeU!=null)
			{
				//creation logement [creation Studio || Apparetement()],creation images,creation file
				$Forseatch=metaphone($nomL).' '.metaphone($Desc).' '.metaphone($adresseL);
				$req = "INSERT INTO `logement`(`CodeP`, `nom`, `adress`, `description`, `reglement`,`prix`,`superficie`,`SL_adr_nom`, `type`, `status`) VALUES (?,?,?,?,?,?,?,?,?,'valide')";
			    $statement=$conn->prepare($req);
			    $statement->bind_param("issssdiss",$CodeU,$nomL,$adresseL,$Desc,$reglement,$prix,$sprfc,$Forseatch,$LogeType);
			    $statement->execute();

				$reqI = "SELECT CodeL FROM logement where nom=? ";
			    $statementI=$conn->prepare($reqI);
			    $statementI->bind_param("s",$nomL);
			    $statementI->execute();
			    $resI=$statementI->get_result();
			    $rowI=$resI->fetch_assoc();
			    $CodeL=$rowI['CodeL'];

			    //files et images
					foreach ($img as $data) {
					$req = "INSERT INTO `image`(`CodeL`, `image`) values(?,?)";
					$statement=$conn->prepare($req);
					$statement->bind_param("is",$CodeL,$data);
					$statement->execute();
					}
					$req = "INSERT INTO `files`(`CodeL`, `file`) values(?,?)";
					$statement=$conn->prepare($req);
					$statement->bind_param("is",$CodeL,$PdfFile);
					$statement->execute();			    	
			    
				//insertion apartement ou studio
			    if($LogeType=="Appartement")
			    {
					$nbr_piece=$_POST['nbrP'];

					$req = "INSERT INTO `appartement`(`Codeapp`,`nbrC`, `nbrP`) VALUES (?,?,?)";
			        $statement=$conn->prepare($req);
			        $statement->bind_param("iii",$CodeL,$nbr_piece,$nbrloc);
			        $statement->execute();

			    }else if($LogeType=="Studio")
				{
					$req = "INSERT INTO `studio`(`CodeS`, `nbrP`) VALUES (?,?)";
			        $statement=$conn->prepare($req);
			        $statement->bind_param("ii",$CodeL,$nbrloc);
			        $statement->execute();							
				}
				//creation equipement
				foreach ($checkedItems as $CodeEqu) {
					$req = "INSERT INTO `eqlo`(`CodeE`, `CodeL`) VALUES (?,?)";
			        $statement=$conn->prepare($req);
			        $statement->bind_param("si",$CodeEqu,$CodeL);
			        $statement->execute();													
				}


			   $alert='<div class="alert alert-success alert-dismissible fade show" role="alert">
			   <strong>Succes:</strong> Logement ajouté avec succes.
			   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			   <span aria-hidden="true">&times;</span>
			   </button>
			   </div>';

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
    <!-- base:css -->
    <link rel="stylesheet" href="../../Resourse/vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="../../Resourse/vendors/base/vendor.bundle.base.css">
	 
	<link rel="stylesheet" type="text/css" href="../../Resourse/CSS/semantic.min.css">
    <link href="../../vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../Resourse/css2/style.css">
    <!-- endinject -->
	<link rel="shortcut icon" href="../../Resourse/images/favicon.png" />
	
	<script src="../../Resourse/js2/pdf.js"></script>
   <script src="../../Resourse/js2/pdf.worker.js"></script>



  </head>
  <body>
    <div class="container-scroller">
		
		<!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          
             
              
   
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="dash.html"><img src="../../Resourse/images/logo.svg" alt="logo"/></a>
                <a class="navbar-brand brand-logo-mini" href="dash.html"><img src="../../Resourse/images/logo-mini.svg" alt="logo"/></a>
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
                        <i class="mdi mdi-settings text-primary"></i>
                        Settings
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
      <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
              <li class="nav-item">
                <a class="nav-link" href="dash.php">
                  <i class="mdi mdi-file-document-box menu-icon"></i>
                  <span class="menu-title">Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                    <span class="menu-title">Ajouter</span>
                    <i class="menu-arrow"></i>
                  </a>
                  <div class="submenu">
                      <ul>
                          <li class="nav-item"><a class="nav-link" href="Addform.php">Une location</a></li>
                          <li class="nav-item"><a class="nav-link" href="#">Un user</a></li>
                      </ul>
                  </div>
              </li>
            
				  <li class="nav-item">
                  <a href="pages/forms/basic_elements.html" class="nav-link">
                    <i class="mdi mdi-chart-areaspline menu-icon"></i>
                    <span class="menu-title">Form Elements</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="pages/charts/chartjs.html" class="nav-link">
                    <i class="mdi mdi-finance menu-icon"></i>
                    <span class="menu-title">Charts</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="pages/tables/basic-table.html" class="nav-link">
                    <i class="mdi mdi-grid menu-icon"></i>
                    <span class="menu-title">Tables</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="pages/icons/mdi.html" class="nav-link">
                    <i class="mdi mdi-emoticon menu-icon"></i>
                    <span class="menu-title">Icons</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi-codepen menu-icon"></i>
                    <span class="menu-title">Sample Pages</span>
                    <i class="menu-arrow"></i>
                  </a>
                  <div class="submenu">
                      <ul class="submenu-item">
                          <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
                        
                      </ul>
                  </div>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                    <span class="menu-title">Documentation</span></a>
              </li>
	
            </ul>
        </div>
      </nav>
	</div>
	
	<!-- partial -->
<?=$alert;?>
	<br>
	<br>
     <!--Accordion -->
<form  method="POST" enctype="multipart/form-data" >			
	<div class="accordion"><i class="fas fa-info-circle"></i>  INFORMATION PROPRITAIRE</div>
	<div class="panel">
				<div class="card-body form-brdr">
						<div class="radio">
						<div class="rowR">
                           <div class="col-6">
							   <div class="form-check rad1">
								<label class="form-check-label">
								<input type="radio" onclick="showform(0)" name="rad1" value="New" class="form-check-input" checked>
								Nouveau
								</label>
							   </div>
						   </div>
						
                           <div class="col-6">	
							   <div class="form-check rad2">
								  <label class="form-check-label">
								  <input type="radio" onclick="showform(1)" name="rad1" value="EXST" class="form-check-input" >
								   Existe
								  </label>
								</div>
					       </div>
                        </div>
						</div>

						<div class="forms-sample">

						<div id="formNew">

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputUsername2" class="col-sm-3 col-form-label"><i class="fas fa-user"></i>  Nom</label>

								<input type="text" class="form-control" name="nomP" id="exampleInputUsername2" placeholder="Nom">
							</div>
							</div>
						
							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputEmail2" class="col-sm-3 col-form-label"> <i class="fas fa-user"></i>  Prenom</label>
								<input type="text" class="form-control" name="PrenomP" id="exampleInputEmail2" placeholder="Prenom">
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputMobile" class="col-sm-3 col-form-label"><i class="fas fa-fingerprint"></i>  CIN</label>

								<input  type="text" class="form-control" name="CIN" id="exampleInputMobile" placeholder="CIN">
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-phone"></i>  Tel</label>

								<input type="text" class="form-control" name="Tel" id="exampleInputPassword2" placeholder="Tel">
							</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-9">
								<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-map-marker-alt"></i>  Adresse</label>

								<input type="text" class="form-control" name="Adr" id="exampleInputPassword2" placeholder="Adresse">
								</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-envelope"></i>  Email</label>

								<input type="email" class="form-control" name="Email" id="exampleInputPassword2" placeholder="Email">
							</div>
							</div>

						</div>
						<div id="formExst" style="display:none;" >																																											
							<div class="form-group row" >
								<div class="col-sm-9">
								<label for="exampleInputUsername2" class="col-sm-3 col-form-label"><i class="fas fa-user"></i>  Username</label>
								<input type="text" class="form-control" name="Username" id="exampleInputUsername2" placeholder="Username">
								</div>
							</div>
						</div>

					</div>
						</div>
					
	</div>
	
	<div class="accordion"><i class="fas fa-info-circle"></i>  INFORMATIONS DE LOGEMENT</div>
	<div class="panel">
		<div class="card-body">
		<div class="radio">
						<div class="rowR">
                           <div class="col-6">
						   		<div class="form-check rad1">
									<label class="form-check-label">
									<input type="radio" onclick="showPiece(1)" name="logetype" value="Studio" class="form-check-input">
									Studio
									</label>
								</div>
						   </div>
						
				
                           <div class="col-6">	
						   		<div class="form-check rad2">
									<label class="form-check-label">
									<input type="radio" onclick="showPiece(0)" name="logetype" value="Appartement" class="form-check-input" checked>
									Appartement
									</label>
								</div>
                        	</div>
						</div>

						<div class="forms-sample">
							
							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputEmail2" class="col-sm-3 col-form-label"><i class="fas fa-user"></i>  Nom</label><br>
								<input type="text" class="form-control" name="nomL" id="exampleInputEmail2" placeholder="Nom">
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleTextarea1" class="col-sm-3 col-form-label"><i class="fas fa-comment"></i>  Description</label><br>
								<textarea class="form-control" name="Desc" id="exampleTextarea1" rows="4"></textarea>
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputEmail2" class="col-sm-3 col-form-label"><i class="fas fa-tag"></i> Prix</label><br>
								<input type="text" class="form-control" name="prixL" id="exampleInputEmail2" placeholder="Prix">
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleInputEmail2" class="col-sm-3 col-form-label"><i class="fas fa-user"></i>  Superficie</label><br>
								<input type="text" class="form-control" name="sprfc" id="exampleInputEmail2" placeholder="sprfc">
							</div>
							</div>

							<div class="form-group row">
							<div class="col-sm-9">
							<label for="exampleTextarea1" class="col-sm-3 col-form-label"><i class="fas fa-images"></i>  Importer des images</label><br>

							<br>
								<div class="container">
									<div class="row">
										<div class="col-sm-2 imgUp">
											<div class="imagePreview"></div>
											<label class="btn btn-primary">
												Upload<input type="file" name="0" class="uploadFile img"  style="width: 0px;height: 0px;overflow: hidden;">
											</label>
											</div><!-- col-2 -->
												<i class="fa fa-plus imgAdd"></i>
											</div><!-- row -->
										</div><!-- container -->
									</div>
								</div>
							<div class="form-group row">
								<div class="col-sm-9">
									<label for="exampleInputPassword2" class="col-sm-3 col-form-label">Equipements </label>
									<div class="dropdown">
										<button class="dropbtn form-control btn btn-default btn-sm dropdown-toggle ">Dropdown</button>
										<div class="dropdown-content force-scroll">
											<div class="radioEq">
												<?=$equi ;?>
											</div>	
										</div>
									</div> 
								</div>
							</div> 
							<div id="PieceInput">
								<div class="form-group row" >
									<div class="col-sm-9">
									<label for="exampleInputPassword2" class="col-sm-3 col-form-label">Nombre de piece</label>
										<input type="number" class="form-control" name="nbrP" id="nbr_piece" placeholder="nbr_piece">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-9">
								<label for="exampleInputPassword2" class="col-sm-3 col-form-label">Nombre de locataire </label>
								<input type="number" class="form-control" name="nbrloc" id="nbr_locataire " placeholder="nbr_locataire ">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-9">
								<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-map-marker-alt"></i>  Adresse </label>
									<input type="text" class="form-control" name="AdrLo" id="adresse " placeholder="adresse ">
								</div>
							</div>


						
<!--
							<div class="form-group row">
								<div class="col-sm-9">
								<label for="exampleInputPassword2" class="col-sm-3 col-form-label">Equipements </label>
									<button type="button" class="form-control btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
									<ul class="form-control dropdown-menu">
									<div class="radioEq">
										<?=$equi ;?>
									</div>	
                               </ul>
								</div>
							</div>-->
							<div class="form-group row">
								<div class="col-sm-9">
								<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-file-prescription"></i>  Règlement </label>

									<input type="text" class="form-control" name="Reg" id="nbr_locataire " placeholder="règlement ">
								</div>
							</div>
									
						</div>
					</div>
	</div>
</div>	
	<div class="accordion"><i class="fas fa-file-alt"></i>  PIECE DE LEGALITE</div>
	<div class="panel">
		<div class="card-body">
			<div class="forms-sample">
				<div class="form-group row">
				
					<div id="preview-container">
					<label for="exampleInputPassword2" class="col-sm-3 col-form-label"><i class="fas fa-file-upload"></i>  Ajouter un document ( Certificat de propriété )</label>
						<div id="upload-dialog"><i class="fas fa-upload"></i>  Choose PDF</div>
						<input type="file" id="pdf-file" name="pdf" accept="application/pdf" required />
						<div id="pdf-loader">Loading Preview ..</div>
						<canvas id="pdf-preview" width="150"></canvas>
						<span id="pdf-name"></span>
						<button hidden id="upload-button">Upload</button>
						<button id="cancel-pdf">Cancel</button>
					</div>
				</div>		
			</div>
		</div>
	</div> 

	<div class="btns">
		<button class="btn btn X" name="CancelFrm">Annuler</button>
		<button class="btn btn X" name="EnrFrm" >Ajouter</button>
	</div>

	<input type="text" id="i_varable" name="i_var" hidden>

</form>

		<footer class="footer">
			<div class="footer-wrap">
				<div class="w-100 clearfix">
				  <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="https://www.templatewatch.com/" target="_blank">templatewatch</a>. All rights reserved.</span>
				  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart-outline"></i></span>
				</div>
			</div>
		</footer>
		
    
 
 
 
 
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
 
    <!-- Custom js for this page-->
    <script src="../../Resourse/js2/dashboard.js"></script>
	<!-- End custom js for this page-->
	
	<script src="../../Resourse/Js/JSG/semantic.min.js"></script>

	<script src="../../Resourse/js2/accordion.js"></script>
	<script src="../../Resourse/js2/uploadimg.js"></script>
	<script src="../../Resourse/js2/fileUpload.js"></script>
	<script src="../../Resourse/js2/pdf.js"></script>
	<script src="../../Resourse/js2/pdf.worker.js"></script>


	<script type="text/javascript">

		function showform(x)
		{
			if(x==0)
			  {
				document.getElementById('formExst').style.display='none';
				document.getElementById('formNew').style.display='block';
			  }
			  else
			  {
				document.getElementById('formNew').style.display='none';
				document.getElementById('formExst').style.display='block';
			  }
		}

				function showPiece(x)
		{
			if(x==0)
			  {
				document.getElementById('PieceInput').style.display='block';
			  }
			  else
			  {
				document.getElementById('PieceInput').style.display='none';
			  }
		}

	</script>

<script>
var options = [];

$( '.dropdown-menu a' ).on( 'click', function( event ) {

   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       $inp = $target.find( 'input' ),
       idx;

   if ( ( idx = options.indexOf( val ) ) > -1 ) {
      options.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      options.push( val );
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }

   $( event.target ).blur();
      
   console.log( options );
   return false;
});

	</script>

  </body>
</html>

<?php




?>