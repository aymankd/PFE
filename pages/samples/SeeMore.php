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
//recuperation du code du logement
$CodeL=$_GET["smr"];
//recuperation des données du logement a travers son code
$reqL = "SELECT * from logement where CodeL=?";
$statementL=$conn->prepare($reqL);
$statementL->bind_param("i",$CodeL);
$statementL->execute();
$resL=$statementL->get_result();
$rowL=$resL->fetch_assoc();
$Titre=$rowL["nom"];
$adresse=$rowL["adress"];
$desc=$rowL["description"];
$regl=$rowL["reglement"];
$prix=$rowL["prix"];
$sup=$rowL["superficie"];

//recuperation des images du logement
$reqI="SELECT * FROM image where CodeL=?";
$statementI=$conn->prepare($reqI);
$statementI->bind_param("i",$CodeL);
$statementI->execute();
$resI=$statementI->get_result();
$img="";
$imgs="";
$i=1;
while ( ($rowI = mysqli_fetch_array($resI)) && ($i < 4) ) 
{
  $id=$rowI['CodeImg'];
  $src="genere_image.php?id=$id";
  if($i==1)
    {
      $img.="<div class='tab-pane active' id='pic-1'><img src='".$src."' alt='#' /></div>";
      $imgs.="<li class='active'><a data-target='#pic-1' data-toggle='tab'><img src='".$src."' alt='#' /></a></li>";
    }
  else
    {
      $img.="<div class='tab-pane' id='pic-".$i."'><img src='".$src."' alt='#' /></div>";
      $imgs.=" <li><a data-target='#pic-".$i."' data-toggle='tab'><img src='".$src."' alt='#' /></a></li>";
    }  


  $i = $i + 1;
}


//recuperation des données du prop 
$reqP="SELECT * from proprietaire where CodeP=?";
$statementP=$conn->prepare($reqP);
$statementP->bind_param("i",$rowL["CodeP"]);
$statementP->execute();
$resP=$statementP->get_result();
$rowP=$resP->fetch_assoc();

$Pnom=$rowP["nom"];
$Pprenom=$rowP["prenom"];


?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Voire plus</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!--enable mobile device-->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!--fontawesome css-->
      <link rel="stylesheet" href="../../Resourse/cssSm/font-awesome.min.css">
      <!--bootstrap css-->
      <link rel="stylesheet" href="../../Resourse/cssSm/bootstrap.min.css">
      <!--animate css-->
      <link rel="stylesheet" href="../../Resourse/cssSm/animate-wow.css">
      <!--main css-->
      <link rel="stylesheet" href="../../Resourse/cssSm/style.css">
      <link rel="stylesheet" href="../../Resourse/cssSm/bootstrap-select.min.css">
      <link rel="stylesheet" href="../../Resourse/cssSm/slick.min.css">
      <link rel="stylesheet" href="../../Resourse/cssSm/select2.min.css">
      <!--responsive css-->
      <link rel="stylesheet" href="../../Resourse/cssSm/responsive.css">

      <link href="../../Resourse/vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   </head>
   <body>
      <header id="header" class="top-head">
         <!-- Static navbar -->
         <nav class="navbar navbar-default">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-4 col-sm-12 left-rs">
                     <div class="navbar-header">
                        <button type="button" id="top-menu" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"> 
                        <span class="sr-only">Toggle navigation</span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        </button>
                        <a href="index.html" class="navbar-brand"><img src="../../Resourse/images/logo-1.png" alt="" /></a>
                     </div>
                     <form class="navbar-form navbar-left web-sh">
                        <div class="form">
                           <input type="text" class="form-control" placeholder="Rechercher">
                        </div>
                     </form>
                  </div>
                  <div class="col-md-8 col-sm-12">
                     <div class="right-nav">
                        <!--right nav menu - top menu -->
                     </div>
                  </div>
               </div>
            </div>
            <!--/.container-fluid --> 
         </nav>
      </header>
      <!-- Modal -->
     
    
     
      <div class="product-page-main">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="prod-page-title">
                     <h2 class="titreOne"><?=$Titre?></h2>
                     <p>By <span><?=$Pnom?> <?=$Pprenom?></span></p>
                  </div>
               </div>
            </div>
            <div class="row">
              
               <div class="col-md-7 col-sm-8">
                  <div class="md-prod-page">
                     <div class="md-prod-page-in">
                        <div class="page-preview">
                           <div class="preview">

                              <div class="preview-pic tab-content">
                                 <?=$img?>
                                 <!--
                                 <div class="tab-pane active" id="pic-1"><img src="../../Resourse/images/lag-60.png" alt="#" /></div>
                                 <div class="tab-pane" id="pic-2"><img src="../../Resourse/images/lag-61.png" alt="#" /></div>
                                 <div class="tab-pane" id="pic-3"><img src="../../Resourse/images/lag-60.png" alt="#" /></div>
                                 
                                 <div class="tab-pane" id="pic-4"><img src="../../Resourse/images/lag-61.png" alt="#" /></div>
                                 <div class="tab-pane" id="pic-5"><img src="../../Resourse/images/lag-61.png" alt="#" /></div>-->

                              </div>

                              <ul class="preview-thumbnail nav nav-tabs">

                                <?=$imgs?>
                                 <!--
                                 <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="../../Resourse/images/lag-60.png" alt="#" /></a></li>
                                 <li><a data-target="#pic-2" data-toggle="tab"><img src="../../Resourse/images/lag-61.png" alt="#" /></a></li>
                                 <li><a data-target="#pic-3" data-toggle="tab"><img src="../../Resourse/images/lag-60.png" alt="#" /></a></li>
                                 
                                 <li><a data-target="#pic-4" data-toggle="tab"><img src="../../Resourse/images/lag-61.png" alt="#" /></a></li>
                                 <li><a data-target="#pic-5" data-toggle="tab"><img src="../../Resourse/images/lag-61.png" alt="#" /></a></li>
                                 -->
                              </ul>
                           </div>
                        </div>
                        <div class="btn-dit-list clearfix">
                           <div class="left-dit-p">
                              <div class="prod-btn">
                              
                                 <a href="#"><i class="fas fa-heart"></i> Like this</a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                           <div class="right-dit-p">
                              <div class="like-list">
                                 <ul>
                                    <li>
                                       <div class="im-b"><img class="" src="../../Resourse/images/list-img-01.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="../../Resourse/images/list-img-02.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="../../Resourse/images/list-img-03.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="../../Resourse/images/list-img-04.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="../../Resourse/images/list-img-05.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="../../Resourse/images/list-img-06.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></div>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="description-box">
                        <div class="dex-a">
                           <h4>Description</h4>
                           <p>
                           <?=$desc?>
                           </p>
                           <br>
                           <p>Superficie: <?=$sup?> m²</p>
                        </div>
                        <hr>
                        <div class="spe-a">
                           <h4>Équipements</h4>
                           <ul>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 19px; width: 19px; fill: currentcolor;"><path d="m12 15a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0 5a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm5.92-5.78a.5.5 0 1 1 -.84.55c-1.19-1.81-3.07-2.77-5.08-2.77s-3.89.96-5.08 2.78a.5.5 0 0 1 -.84-.55c1.38-2.1 3.58-3.23 5.92-3.23s4.54 1.13 5.92 3.23zm2.98-3.03a.5.5 0 1 1 -.79.61c-1.66-2.14-5.22-3.8-8.11-3.8-2.83 0-6.26 1.62-8.12 3.82a.5.5 0 0 1 -.76-.65c2.05-2.42 5.75-4.17 8.88-4.17 3.19 0 7.05 1.8 8.9 4.19zm2.95-2.33a.5.5 0 0 1 -.71-.02c-2.94-3.07-6.71-4.84-11.14-4.84s-8.2 1.77-11.14 4.85a.5.5 0 0 1 -.72-.69c3.12-3.27 7.14-5.16 11.86-5.16s8.74 1.89 11.86 5.16a.5.5 0 0 1 -.02.71z" fill-rule="evenodd"></path></svg>     WI-FI</h5>
                                 </div>
                                 <div class="col-md-8">
                                 <h5><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 19px; width: 19px; fill: currentcolor;"><path d="m10.5 0a .5.5 0 0 0 -.5.5v7a .5.5 0 0 1 -.49.5h-1.51v-7.5a.5.5 0 1 0 -1 0v7.5h-1.51a.5.5 0 0 1 -.49-.5v-7a .5.5 0 1 0 -1 0v7c0 .83.67 1.5 1.49 1.5h1.51v5c0 .03.01.06.02.09a1.49 1.49 0 0 0 -1.02 1.41v7c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-7c0-.66-.43-1.21-1.02-1.41.01-.03.02-.06.02-.09v-5h1.51a1.5 1.5 0 0 0 1.49-1.5v-7a .5.5 0 0 0 -.5-.5zm-2.5 15.5v7a .5.5 0 0 1 -.5.5.5.5 0 0 1 -.5-.5v-7c0-.28.22-.5.5-.5s.5.22.5.5zm11.5-15.5h-2c-1.4 0-2.5 1.07-2.5 2.5v7c0 1.43 1.1 2.5 2.5 2.5h1.5v2.09a1.49 1.49 0 0 0 -.5-.09c-.83 0-1.5.67-1.5 1.5v7c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-22.5zm-2 11c-.86 0-1.5-.63-1.5-1.5v-7c0-.87.65-1.5 1.5-1.5h1.5v10zm1.5 11.5a.5.5 0 0 1 -.5.5.5.5 0 0 1 -.5-.5v-7c0-.28.22-.5.5-.5s.5.22.5.5z" fill-rule="evenodd"></path></svg>     Cuisine</h5>
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                   <!--empty-->
                                 </div>
                                 <div class="col-md-8">
                                    <!--empty-->
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 19px; width: 19px; fill: currentcolor;"><path d="m20 11h-19.5a.5.5 0 0 0 -.5.5v2c0 5.79 4.24 10.5 9.5 10.5 3.43 0 6.41-2.01 8.08-5h2.42a4 4 0 0 0 0-8zm-10.5 12c-4.68 0-8.5-4.24-8.5-9.5v-1.5h17v1.5c0 5.26-3.82 9.5-8.5 9.5zm10.5-5h-1.93c.59-1.37.93-2.89.93-4.5v-1.5h1a3 3 0 0 1 0 6zm-11.9-13.7c-.96-1.28-.96-2.53-.37-3.58a2.7 2.7 0 0 1 .42-.57.5.5 0 0 1 .71.71 1.73 1.73 0 0 0 -.25.35c-.41.73-.41 1.55.3 2.49 1.5 2 1.6 3.85.48 5.13a.5.5 0 1 1 -.75-.66c.79-.89.71-2.22-.53-3.87zm-4.49 1.03c-.77-.89-.77-1.85-.31-2.7a2.5 2.5 0 0 1 .32-.46.5.5 0 1 1 .74.67c-.04.04-.1.13-.18.26-.28.52-.28 1.04.15 1.54 2.12 2 2.16 3.22.45 4.29a.5.5 0 1 1 -.53-.85c1.09-.68 1.08-1.12-.64-2.75zm9 0c-.77-.89-.77-1.85-.31-2.7a2.5 2.5 0 0 1 .32-.46.5.5 0 1 1 .74.67c-.04.04-.1.13-.18.26-.28.52-.28 1.04.15 1.54 2.12 2 2.16 3.22.45 4.29a.5.5 0 0 1 -.53-.85c1.09-.68 1.08-1.12-.64-2.75z" fill-rule="evenodd"></path></svg>  Petit déjeuner</h5>
                                 </div>
                                 <div class="col-md-8">
                                 <h5><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 19px; width: 19px; fill: currentcolor;"><path d="m23.99 18.38-.5-2a .5.5 0 0 0 -.49-.38h-22a .5.5 0 0 0 -.49.38l-.5 2a .5.5 0 0 0 .49.62h23a .5.5 0 0 0 .49-.62zm-1.13-.38h-21.72l.25-1h21.22zm-21.36-3h21a .5.5 0 0 0 .5-.53c-.21-3.22-1.22-5.47-3-5.47a4911.8 4911.8 0 0 0 -8.8 0h-1.71c-.2 0-.26-.08-.19-.27a9.59 9.59 0 0 1 .17-.48c.13-.34.27-.68.43-1 .41-.79.82-1.25 1.1-1.25h10.5c.87 0 1.43-.7 1.4-1.52s-.64-1.48-1.55-1.48h-11.35c-3.84 0-7.29 4.4-8.99 11.38a.5.5 0 0 0 .49.62zm8.5-11h11.35c.35 0 .55.21.56.52.01.29-.14.48-.4.48h-10.51c-.8 0-1.42.68-1.99 1.8a10.74 10.74 0 0 0 -.65 1.61c-.31.82.23 1.59 1.13 1.59h1.71a33801.74 33801.74 0 0 1 8.8 0c .94 0 1.71 1.58 1.95 4h-19.8c1.65-6.21 4.7-10 7.85-10zm5 8a1 1 0 1 1 2 0 1 1 0 0 1 -2 0zm3 0a1 1 0 1 1 2 0 1 1 0 0 1 -2 0z" fill-rule="evenodd"></path></svg>  Fer a repasser</h5>

                                 </div>
                              </li><br>
                              <div class="col-md-12">
                                    <a type="button" href="#" aria-busy="false" class="equipment" data-toggle="modal" data-target="#modalEquip">Afficher les 24 équipements</a>
                                 </div>
                           </ul>
                        </div>
                     </div>
                  </div>


                  <div class="similar-box">
                     <h2>Similiar results</h2>
                     
                     <div class="row cat-pd">
                        <div class="col-md-6">
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" src="../../Resourse/images/tr1.png" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                    <h4>Product</h4>
                                    <p>By <span>Beko</span> under <span>Lights</span></p>
                                 </div>
                                 <a href="#" tabindex="0">$1220</a>
                              </div>
                              <div class="prod-btn">
                                
                                 <a href="#"><svg style="height: 16px; width: 16px; display: block; overflow: visible;" viewBox="0 0 24 24" fill="currentColor" fill-opacity="0" stroke="#222222" stroke-width="1.4" focusable="false" aria-hidden="true" role="presentation" stroke-linecap="round" stroke-linejoin="round"><path d="m17.5 2.9c-2.1 0-4.1 1.3-5.4 2.8-1.6-1.6-3.8-3.2-6.2-2.7-1.5.2-2.9 1.2-3.6 2.6-2.3 4.1 1 8.3 3.9 11.1 1.4 1.3 2.8 2.5 4.3 3.6.4.3 1.1.9 1.6.9s1.2-.6 1.6-.9c3.2-2.3 6.6-5.1 8.2-8.8 1.5-3.4 0-8.6-4.4-8.6" stroke-linejoin="round"></path></svg>Like this</a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" src="../../Resourse/images/tr2.png" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                    <h4>Product</h4>
                                    <p>By <span>Beko</span> under <span>Chairs</span></p>
                                 </div>
                                 <a href="#" tabindex="0">$1220</a>
                              </div>
                              <div class="prod-btn">
                                
                                 <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like this</a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row cat-pd">
                        <div class="col-md-6">
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" src="../../Resourse/images/tr3.png" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                    <h4>Product</h4>
                                    <p>By <span>Beko</span> under <span>Lights</span></p>
                                 </div>
                                 <a href="#" tabindex="0">$1220</a>
                              </div>
                              <div class="prod-btn">
                                 
                                 <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like this</a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                           
                        </div>
                        <div class="col-md-6">
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" src="../../Resourse/images/tr4.png" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                    <h4>Product</h4>
                                    <p>By <span>Beko</span> under <span>Chairs</span></p>
                                 </div>
                                 <a href="#" tabindex="0">$1220</a>
                              </div>
                              <div class="prod-btn">
                                 
                                 <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like this</a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 col-sm-12">
                  <div class="price-box-right">
                     <h4>Prix</h4>
                     <h3><?=$prix?> Dh</h3><hr>
                  
                    
                     
                     <a href="#" class="badge badge-primary">Contacter Hote</a>
                  </div>
               </div>
            </div>
         </div>
      </div>

<!--Modal-->

<div class="modal fade" id="modalEquip"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title _26piifo">Équipements</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false" style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);"><path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22" fill-rule="evenodd"></path></svg></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="_1p0spma2">Standard</div>
        <div class="_1lhxpmp">
           <div class="_czm8crp"> Wi-Fi</div>
           <div style="margin-top: 8px;">
              <div class="_1jlnvra2">Accès permanent dans le logement</div> 
              <hr>
              <div class="_czm8crp">Television</div> 
              <hr>
              <div class="_czm8crp">Fer à repasser</div> 
              <hr>
              <div class="_czm8crp">Équipements de base</div> 
              <div class="_1jlnvra2">Serviettes, draps, savon et papier toilette</div> 
              <hr>
              <div class="_czm8crp">Chauffage</div> 
              <div class="_1jlnvra2">Chauffage central ou radiateur électrique</div> 
              <hr>
              <div class="_czm8crp">Climatisation</div> 
              
              <hr>
              <div class="_czm8crp">Eau chaude</div> 
              <hr>
              <div class="_czm8crp">Detecteur de fumée</div> 
              <hr>
              <div class="_czm8crp">Kit de premiers secours</div> 
              <hr>
              <div class="_czm8crp">gg</div> 
              <hr>
              <div class="_czm8crp">gg</div> 
              <hr>
              <div class="_czm8crp">gg</div> 
            </div>
         </div>
         <hr>
         

      </div>
      <div class="modal-footer">
        <!--just for the color -->
      </div>
    </div>
  </div>
</div>

      <footer>
         <div class="main-footer">
            <div class="container">
               <div class="row">
                  <div class="footer-top clearfix">
                     <div class="col-md-2 col-sm-6">
                        <h2>Start a free
                           account today
                        </h2>
                     </div>
                     <div class="col-md-6 col-sm-6">
                        <div class="form-box">
                           <input type="text" placeholder="Enter yopur e-mail" />
                           <button>Continue</button>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-12">
                        <div class="help-box-f">
                           <h4>Question? Call us on 12 34 56 78 for help</h4>
                           <p>Easy setup - no payment fees - up to 100 products for free</p>
                        </div>
                     </div>
                  </div>
                  <div class="footer-link-box clearfix">
                     <div class="col-md-6 col-sm-6">
                        <div class="left-f-box">
                           <div class="col-sm-4">
                              <h2>SELL ON chamb</h2>
                              <ul>
                                 <li><a href="#">Create account</a></li>
                                 <li><a href="howitworks.html">How it works suppliers</a></li>
                                 <li><a href="pricing.html">Pricing</a></li>
                                 <li><a href="#">FAQ for Suppliers</a></li>
                              </ul>
                           </div>
                           <div class="col-sm-4">
                              <h2>BUY ON chamb</h2>
                              <ul>
                                 <li><a href="#">Create account</a></li>
                                 <li><a href="#">How it works buyers</a></li>
                                 <li><a href="#">Categories</a></li>
                                 <li><a href="#">FAQ for buyers</a></li>
                              </ul>
                           </div>
                           <div class="col-sm-4">
                              <h2>COMPANY</h2>
                              <ul>
                                 <li><a href="about-us.html">About chamb</a></li>
                                 <li><a href="#">Contact us</a></li>
                                 <li><a href="#">Press</a></li>
                                 <li><a href="#">Careers</a></li>
                                 <li><a href="#">Terms of use</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6">
                        <div class="right-f-box">
                           <h2>INDUSTRIES</h2>
                           <ul class="col-sm-4">
                              <li><a href="#">Textiles</a></li>
                              <li><a href="#">Furniture</a></li>
                              <li><a href="#">Leather</a></li>
                              <li><a href="#">Agriculture</a></li>
                              <li><a href="#">Food & drinks</a></li>
                           </ul>
                           <ul class="col-sm-4">
                              <li><a href="#">Office</a></li>
                              <li><a href="#">Decoratives</a></li>
                              <li><a href="#">Electronics</a></li>
                              <li><a href="#">Machines</a></li>
                              <li><a href="#">Building</a></li>
                           </ul>
                           <ul class="col-sm-4">
                              <li><a href="#">Cosmetics</a></li>
                              <li><a href="#">Health</a></li>
                              <li><a href="#">Jewelry</a></li>
                              <li><a href="#">See all here</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-md-8">
                     <p><img width="90" src="../../Resourse/images/logo.png" alt="#" style="margin-top: -5px;" /> All Rights Reserved. Company Name © 2018</p>
                  </div>
                  <div class="col-md-4">
                     <ul class="list-inline socials">
                        <li>
                           <a href="">
                           <i class="fa fa-facebook" aria-hidden="true"></i>
                           </a>
                        </li>
                        <li>
                           <a href="">
                           <i class="fa fa-twitter" aria-hidden="true"></i>
                           </a>
                        </li>
                        <li>
                           <a href="">
                           <i class="fa fa-instagram" aria-hidden="true"></i>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           <i class="fa fa-linkedin" aria-hidden="true"></i>
                           </a>
                        </li>
                     </ul>
                     <ul class="right-flag">
                        <li><a href="#"><img src="../../Resourse/images/flag.png" alt="" /> <span>Change</span></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!--main js--> 
      <script src="../../Resourse/js3/jquery-1.12.4.min.js"></script> 
      <!--bootstrap js--> 
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../../Resourse/js3/bootstrap.min.js"></script> 
      <script src="../../Resourse/js3/bootstrap-select.min.js"></script>
      <script src="../../Resourse/js3/slick.min.js"></script> 
      <script src="../../Resourse/js3/select2.full.min.js"></script> 
      <script src="../../Resourse/js3/wow.min.js"></script> 
      <!--custom js--> 
      <script src="../../Resourse/js3/custom.js"></script>
   </body>


</html>