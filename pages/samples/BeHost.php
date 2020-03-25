<?php
session_start();
if( isset($_SESSION['username']))
{
  header("location:../../homeP.php");
}
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
$user=$_SESSION['username'];
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





$img=array();

if(isset($_POST['EnrFrm']))
{
  
    
    
    $LogeType=$_POST['logetype'];
    $PdfFile=file_get_contents($_FILES["pdf"]["tmp_name"]);
    //$i=$_POST['i_var'];
    $count=0;
    $filename="";
    for ($v=1 ; $v <= 5 ; $v++) 
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
    $nbrloc=$_POST['nbrLoc'];
    $adresseL=$_POST['AdrLo'];
    $prix=$_POST['prixL'];
    $sprfc=$_POST['superficie'];
    $reglement=$_POST['Reg'];

    $checkedItems=$_POST['check_list'];


    $reqI = "SELECT CodeU FROM utilisateur where username=? ";
    $statementI=$conn->prepare($reqI);
    $statementI->bind_param("s",$user);
    $statementI->execute();
    $resI=$statementI->get_result();
    $rowI=$resI->fetch_assoc();
    $CodeU=$rowI['CodeU'];



           
           


    



                //creation logement [creation Studio || Apparetement()],creation images,creation file
                $Forseatch=metaphone($nomL).' '.metaphone($Desc).' '.metaphone($adresseL);
                $req = "INSERT INTO `logement`(`CodeP`, `nom`, `adress`, `description`, `reglement`,`prix`,`superficie`,`SL_adr_nom`, `type`, `status`) VALUES (?,?,?,?,?,?,?,?,?,'Notvalid')";
                $statement=$conn->prepare($req);
                $statement->bind_param("issssdiss",$CodeU,$nomL,$adresseL,$Desc,$reglement,$prix,$sprfc,$Forseatch,$LogeType);
                $statement->execute();

                //$last_id = $conn->insert_id;

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







?>
<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Devenir Hote</title>
        

        <link href="../../vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>
        <link href='../../Resourse/CSS/bootstrap.min.css' rel='stylesheet'>
        <link href='../../Resourse/CSS/Multiform.css' rel='stylesheet'>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 col-xl-6 text-center cardHost mt-3 mb-2">
                    <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                        <h2 id="heading">Ajoute Du logement</h2>
                        <p>veullier remplire tout les input</p>
                        <form action="" method="POST" id="msform" enctype="multipart/form-data" >
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="personal"><strong>Personal</strong></li>
                                <li id="payment"><strong>Image</strong></li>
                                <li id="payment"><strong>Legalite</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> <br> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Personnel Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 1 - 4</h2>
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="form-check rad1">
                                                <label class="form-check-label">
                                                <input type="radio" onclick="showPiece(1)" name="logetype" value="Studio" class="form-check-input">
                                                Studio
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">	
                                            <div class="form-check rad2">
                                                <label class="form-check-label">
                                                <input type="radio" onclick="showPiece(0)" name="logetype" value="Appartement" class="form-check-input" checked>
                                                Appartement
                                                </label>
                                            </div>
                                        </div>



                                    <label class="fieldlabels">Nom Logement: *</label>
                                        <input type="text" name="nomL" placeholder="Nom du logement" />
                                    <label class="fieldlabels">Description: *</label>
                                        <textarea type="text" name="Desc" placeholder="Description" ></textarea>
                                    <label class="fieldlabels">Prix: *</label>
                                        <input type="number" name="prixL" placeholder="Prix" />
                                    <label class="fieldlabels">Superficie: *</label>
                                        <input type="number" name="superficie" placeholder="Superficie" />

                                                <div class="dropdown">
                                                    <button type="button"  class="dropbtn btn btn-default ">Equipment</button>
                                                    <div class="dropdown-content force-scroll">
                                                        <div class="radioEq">
                                                            <?=$equi ;?>
                                                        </div>	
                                                    </div>
                                                </div> 

                                        <div id="PieceInput">
                                        <label class="fieldlabels">Nombre de piece: *</label>
                                            <input type="number" name="nbrP" placeholder="Nombre de piece" />
                                        </div>

                                    <label class="fieldlabels">Nombre de locataire: *</label>
                                        <input type="number" name="nbrLoc" placeholder="Nombre de locataire" />
                                    <label class="fieldlabels">Adresse: *</label>
                                        <input type="text" name="AdrLo" placeholder="Adresse" />
                                    <label class="fieldlabels">Règlement: *</label>
                                        <input type="text" name="Reg" placeholder="Règlement" />
                                        
                            </div> <input type="button" name="next" class="next action-button" value="Next" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Images Upload:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 2 - 4</h2>
                                        </div>
                                    </div> 
                                    <label class="fieldlabels">Images1: *</label>
                                        <input type="file" name="1" accept="image/*" />
                                        <label class="fieldlabels">Images2: *</label>
                                        <input type="file" name="2" accept="image/*" />
                                        <label class="fieldlabels">Images3: *</label>
                                        <input type="file" name="3" accept="image/*" />
                                        <label class="fieldlabels">Images4: *</label>
                                        <input type="file" name="4" accept="image/*" />
                                        <label class="fieldlabels">Images5: *</label>
                                        <input type="file" name="5" accept="image/*" />
                                </div> <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Legalite Upload:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 3 - 4</h2>
                                        </div>
                                    </div> 
                                    <label class="fieldlabels">Upload Your file:</label>
                                    <input type="file" name="pdf" accept="application/pdf">

                                </div> <input type="Submit" name="EnrFrm" class=" action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Finish:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 4 - 4</h2>
                                        </div>
                                    </div> <br><br>
                                    <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image"> </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
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

        
    <script src="../../Resourse/js2/uploadimg.js"></script>
    <script src="../../Resourse/js2/fileUpload.js"></script>
	<script src="../../Resourse/js2/pdf.js"></script>
	<script src="../../Resourse/js2/pdf.worker.js"></script>

    <script type='text/javascript' src='../../Resourse/Js/JSG/jquery.min.js'></script>
    <script type='text/javascript' src='../../Resourse/Js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../../Resourse/Js/Multiform.js'></script>
    </body>
</html>