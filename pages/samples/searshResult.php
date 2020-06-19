
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
     @media (max-width: 991px) {
    #logoo{
      width: 6em;
      margin-top: 1em;
      margin-left: 1em;
      
    }
  }
    </style>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Homepage</title>
  <link rel="stylesheet" href="../../Resourse/css2/styleRe.css">
  <link rel="stylesheet" type="text/css" href="../../Resourse/CSS/semantic.min.css">
  <link href="../../Resourse/vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../../Resourse/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../Resourse/vendors/base/vendor.bundle.base.css">
 

  <link rel="stylesheet" type="text/css" href="../../Resourse/CSS/PageSearch.css">
  <link rel="stylesheet" type="text/css" href="../../Resourse/CSS/StyleSearshBar.css">
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
 
  
	<link rel="shortcut icon" href="../../Resourse/images/favicon.png" />


  <!--leaflet css-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
</head>
<body>


  <!-- Page Contents -->
   <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="#"><img src="../../Resourse/images/logo-1.png" alt="logo"/></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
               
                <li class="nav-item nav-profile dropdown">
                <div class="rightSh">
            <a href="register.php" class="itemXE">Devenez hôte</a>
            <a href="#" class="itemXE">Aide</a>
            <a href="register.php" class="itemXE">Inscription</a>
            <a href="login.php"  class="itemXE" >Connexion</a>
           
            </div>
                 
                </li>
            </ul>
          
          </div>
        </div>
      </nav>
       <!--Mobile view-->
 

<!-- Top Navigation Menu -->
<div class="topnav">
  <img id="logoo" src="../../Resourse/images/logo-1.png" alt="logo"/>
  <a class="spaceline"></a>
  <a id='filters_show'href="#" aria-busy="false" class="equipment" data-toggle="modal" data-target="#modalEquip" class="active"><i class="fas fa-filter"></i>Filters</a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
  <a href="pages/samples/register.php" class="itemXE">Devenez hôte</a>
            <a href="pages/samples/register.php" class="itemXE">Aide</a>
            <a href="pages/samples/register.php" class="itemXE">Inscription</a>
            <a href="pages/samples/login.php"  class="itemXE" >Connexion</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
       <!--/Mobile view-->

     



      <nav class="navbar bottom-navbar col-lg-12 col-12 p-0">
        
        <nav class="bottom-navbar">
          <ul class="nav page-navigation">
            <li class="nav-item">
              <div class="container">
         
                <ul class="nav page-navigation">
                  <div id="SR" class="searshX">
                   <input id="search51" name="q" type="text" value="<?=$_GET['rech']?>"  placeholder="Search..." />
                  </div>
                  
                    
              
                
            </li>
            &nbsp;  &nbsp;&nbsp;
            
            <li id="Drp_prix" class="nav-item dropdown d-lg-flex d-none">
              <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-toggle="dropdown">
                Prix
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"  aria-labelledby="nreportDropdown">
                <div id="PM">
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Prix</p> <br><br>
                    <a class="dropdown-item">
                      <input type="text" class="form-control" placeholder="MIN" id="Imin" value="0" aria-label="search" aria-describedby="MIN">
                    </a>
                    <a class="dropdown-item">
                      <input type="text" class="form-control" placeholder="MIN" id="Imax" value="5000" aria-label="search" aria-describedby="MIN">
                    </a>
                    <br>
                </div>
                <div class="footer">
                  <button type="button" class="btn btn-dark">Fermer</button>
                </div>
              </div>
                 
            </li>
                &nbsp;&nbsp;&nbsp;
          
            <li id="Drp_nbrP" class="nav-item dropdown d-lg-flex d-none">
              <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-toggle="dropdown">
                Nombre de personne
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                <div id="NPM" class="switch-field">
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Nombre de personne</p> <br><br>

                  <a class="dropdown-item">
                        
                    <input type="radio" id="radio-O" name="switch-two" value="All" checked/>
	                  <label for="radio-O">TOUS</label>
	                  <input type="radio" id="radio-one" name="switch-two" value="1" />
	                  <label for="radio-one">1</label>
	                  <input type="radio" id="radio-two" name="switch-two" value="2" />
	                  <label for="radio-two">2</label>
	                  <input type="radio" id="radio-thre" name="switch-two" value="3" />
                    <label for="radio-thre">3</label>
                    <input type="radio" id="radio-four" name="switch-two" value="4" />
	                  <label for="radio-four">4</label>
	                 	<input type="radio" id="radio-five" name="switch-two" value="5" />
	                	<label for="radio-five">5</label>
                  </a>
                      
                     
                  <br>
                </div>
                <div class="footer">
                  <button type="button" class="btn btn-dark">Fermer</button>
                </div>
              </div>
                 
            </li>

              &nbsp;&nbsp;&nbsp;
          
            <li id="Drp_nbrCh" class="nav-item dropdown d-lg-flex d-none">
              <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-toggle="dropdown">
               Nombre de Chambres
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                <div id="NCM" class="switch-field">
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Nombre de Chambres</p> <br><br>

                  <a class="dropdown-item">
                 
                   <input type="radio" id="rad0" name="switchs-two3" value="All" checked/> <label for="rad0">TOUS</label>
                   <input type="radio" id="rad1" name="switchs-two3" value="1" /> <label for="rad1">1</label>
                   <input type="radio" id="rad2" name="switchs-two3" value="2" /> <label for="rad2">2</label>
                   <input type="radio" id="rad3" name="switchs-two3" value="3" /> <label for="rad3">3</label>
                   <input type="radio" id="rad4" name="switchs-two3" value="4" /> <label for="rad4">4</label>
                   <input type="radio" id="rad5" name="switchs-two3" value="5" /> <label for="rad5">5</label>
               


                  </a>
               
                  <br>
                </div>
                <div class="footer">
                 <button type="button" class="btn btn-dark">Fermer</button>
                </div>
              </div>

            </li>

            &nbsp;&nbsp;&nbsp;
          
            <li id="Drp_TL" class="nav-item dropdown d-lg-flex d-none">
              <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-toggle="dropdown">
                Type de Logemnt
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                <div id="TM" class="switch-field">
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Type de Logemnt</p> <br><br>
                    <a class="dropdown-item">
                
                      <input type="radio" id="radio-Oee" name="switch-two4" value="All" checked/>
                      <label for="radio-Oee">TOUS</label>
                      <input type="radio" id="radio-Oe" name="switch-two4" value="studio"/>
                      <label for="radio-Oe">Studio</label>
                      <input type="radio" id="radio-fin" name="switch-two4" value="Apartement" />
                      <label for="radio-fin">Apartement</label>
                      
              


                    </a>
               
                    <br>
                </div>
                <div class="footer">
                 <button type="button" class="btn btn-dark">Fermer</button>
                </div>
              </div>
           
            </li>
            &nbsp;&nbsp;&nbsp;
           
            <li id="Drp_Plus" class="nav-item dropdown d-lg-flex d-none">
              <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-toggle="dropdown">
               Plus
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                <div id="MrM" class="switch-field">
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Colocation</p> <br><br>

                  <a class="dropdown-item">

                   <input type="radio" id="allC" name="switch-Collo"  value="All" checked/>
                   <label for="allC">TOUS</label>
                   <input type="radio" id="Cradio-Oui" name="switch-Collo" value="oui"/>
                   <label for="Cradio-Oui">OUI</label>
                   <input type="radio" id="Cradio-non" name="switch-Collo"  value="non" />
                   <label for="Cradio-non" >NON</label>
                  </a>
                  <br>
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Logement pour étudiant</p> <br><br>

                  <a class="dropdown-item">
                   <input type="radio" id="allEtu" name="switch-Etu"  value="All" checked/>
                   <label for="allEtu">TOUS</label>
                   <input type="radio" id="radio-LOui" name="switch-Etu" value="oui"/>
                   <label for="radio-LOui">OUI</label>
                   <input type="radio" id="radio-Lnon" name="switch-Etu"  value="non" />
                   <label for="radio-Lnon">NON</label>
                  </a>
                  <br>
                  <p id='titre_etable' class="mb-0 font-weight-medium float-left dropdown-header">proche de quel etablisement</p> <br><br>

                  <a class="dropdown-item">
                  <span contentEditable="true" name='etable' id="etable" class="form-control" required></span>
                  </a>
                    
                  <p class="mb-0 font-weight-medium float-left dropdown-header">Région</p> <br><br>

<a class="dropdown-item">
<select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>



</a>
<br>
<p class="mb-0 font-weight-medium float-left dropdown-header">Province/Préfecture</p> <br><br>

                  <a class="dropdown-item">

                  <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
                  </a>
                  <br>
                </div>
                <div class="footer">
                 <button type="button" class="btn btn-dark">Fermer</button>
                </div>
              </div>
           
            </li>
            


          </ul>
       
          <li  class="nav-item">
          <div id='map_cntrl'>
           <img id='map_cntrl_map'  src="map(2).png">  
           <p class="parag">Open map</p> 
          </div>    
         </li>

         <li id="Drp_Rch" class="nav-item">
        
           <button  id="rf" class="btn btn-info">Rechercher</button>       
         </li>
        </div>

        
      </nav>
      <div class="filtersbtn">
    
      </div>  
    </nav> 
  </div>
  
  
  <div id="CNTR" class="containerR">
    <div class="grids grid" id="nC">
      <?=$result ;?>
    </div>
    <div class="map" id="map">

    </div>
  </div>

<!--Modal-->


<div  class="modal fade" id="modalEquip"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">FILTERS </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
                      
                      <div class="modalContent" id="PMS">
                        <p class="mb-0 font-weight-medium float-left dropdown-header">Prix</p> <br><br>

                        <a class="dropdown-item">
                        
                          <input type="text" class="form-control" placeholder="MIN" id="IminS" value="0" aria-label="search" aria-describedby="MIN">

                        </a>
                        <a class="dropdown-item">
                        
                          <input type="text" class="form-control" placeholder="MIN" id="ImaxS" value="5000" aria-label="search" aria-describedby="MIN">

                        </a>
                        <br>
                      </div>

                      <div id="NPMS" class="switch-field modalContent">
                      <p class="mb-0 font-weight-medium float-left dropdown-header">Nombre de personne</p> <br><br>

                        <a class="dropdown-item">
                        
                        <input type="radio" id="radio-OS" name="switch-twoS" value="All" checked/>
	                         	<label for="radio-OS">TOUS</label>
	                        	<input type="radio" id="radio-oneS" name="switch-twoS" value="1" />
	                         	<label for="radio-oneS">1</label>
	                         	<input type="radio" id="radio-twoS" name="switch-twoS" value="2" />
	                          	<label for="radio-twoS">2</label>
	                         	<input type="radio" id="radio-threS" name="switch-twoS" value="3" />
                            <label for="radio-threS">3</label>
                            <input type="radio" id="radio-fourS" name="switch-twoS" value="4" />
	                          	<label for="radio-fourS">4</label>
	                         	<input type="radio" id="radio-fiveS" name="switch-twoS" value="5" />
	                        	<label for="radio-fiveS">5</label>  
                      </a>
                      <br>
                      </div>
              
                      <div id="NCMS" class="switch-field modalContent" >
                <p class="mb-0 font-weight-medium float-left dropdown-header">Nombre de Chambres</p> <br><br>

                  <a class="dropdown-item">
                 
                  <input type="radio" id="rad0S" name="switchs-two3S" value="All" checked/> <label for="rad0S">TOUS</label>
                  <input type="radio" id="rad1S" name="switchs-two3S" value="1" /> <label for="rad1S">1</label>
                  <input type="radio" id="rad2S" name="switchs-two3S" value="2" /> <label for="rad2S">2</label>
                  <input type="radio" id="rad3S" name="switchs-two3S" value="3" /> <label for="rad3S">3</label>
                  <input type="radio" id="rad4S" name="switchs-two3S" value="4" /> <label for="rad4S">4</label>
                  <input type="radio" id="rad5S" name="switchs-two3S" value="5" /> <label for="rad5S">5</label>
                </a>
               
                <br>
                </div>

                <div id="TMS" class="switch-field modalContent">
                <p class="mb-0 font-weight-medium float-left dropdown-header">Type de Logemnt</p> <br><br>
                  <a class="dropdown-item">
                
                  <input type="radio" id="radio-OeeS" name="switch-two4S" value="All" checked/>
                       <label for="radio-OeeS">TOUS</label>
                  <input type="radio" id="radio-OeS" name="switch-two4S" value="studio"/>
                       <label for="radio-OeS">Studio</label>
                      <input type="radio" id="radio-finS" name="switch-two4S" value="Apartement" />
                       <label for="radio-finS">Apartement</label>
                 
                </a>
               
                <br>
                </div>
                

                <div id="MrMS" class="switch-field modalContent">
                    <p class="mb-0 font-weight-medium float-left dropdown-header">Colocation</p> <br><br>

                    <a class="dropdown-item">
                      <input type="radio" id="CollocRadMA" name="CollocRadM" value="All" checked/>
                      <label for="CollocRadMA">TOUS</label>
                      <input type="radio" id="CollocRadMO" name="CollocRadM" value="oui"/>
                      <label for="CollocRadMO">OUI</label>
                      <input type="radio" id="CollocRadMN" name="CollocRadM"  value="non" />
                      <label for="CollocRadMN">NON</label>
                    </a>
                    <br>
                    <p class="mb-0 font-weight-medium float-left dropdown-header">Logement pour étudiant</p> <br><br>

                    <a class="dropdown-item">
                      <input type="radio" id="CollocEtuMA" name="CollocEtuM" value="All" checked/>
                      <label for="CollocEtuMA">TOUS</label>
                      <input type="radio" id="CollocEtuMO" name="CollocEtuM" value="oui"/>
                      <label for="CollocEtuMO">OUI</label>
                      <input type="radio" id="CollocEtuMN" name="CollocEtuM"  value="non" />
                      <label for="CollocEtuMN">NON</label>
                    </a>
                    <br>
                    <p id="etable_mdl_ttl" class="mb-0 font-weight-medium float-left dropdown-header">proche de quel etablisement</p> <br><br>

                    <a class="dropdown-item">
                     <span contentEditable="true" id="etable_mdl" name="etable_mdl" class="form-control" required></span>
                     <br>
                    </a>
  
  
                </div>
                 
               
      </div>
      <div class="modal-footer">
        <button id="filters_cls" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button id="aply_modal"   class="btn btn-primary">Appliquer</button>
      </div>
    </div>
  </div>
</div>

















</body>

<script type="text/javascript">
  
          // Prevents menu from closing when clicked inside 
        // Prevents menu from closing when clicked inside 
        document.getElementById("PM").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
        document.getElementById("NPM").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
        document.getElementById("NCM").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
        document.getElementById("TM").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
        document.getElementById("MrM").addEventListener('click', function (event) 
         {  
          event.stopPropagation(); 
         });
</script>





<script src="../../Resourse/Js/JSG/semantic.min.js"></script>
<script src="../../Resourse/JS/JSG/jquery-3.4.1.min.js"></script>
<script src="../../Resourse/JS/JSG/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="../../Resourse/js2/Card.js"></script>


<script src="../../Resourse/Js/searsh.js"></script>

<script src="../../Resourse/js2/template.js"></script>
<script src="../../Resourse/vendors/base/vendor.bundle.base.js"></script>
    <script src="../../Resourse/js2/dashboard.js"></script>


<!--MAP JavaScript-->   
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>
   
</html>


<script>   
           var sliderMin=<?=$RCMI;?>;
           var sliderMax=<?=$RCMA;?>;
           var lgtp='<?=$LGTP;?>';
           var Min ; 
           var Max;
           var Nbr_pr;
           var Nbr_Ch;
           var TL_Type; 
           var srch;
           var colloc;
           var etu_prch;
           var etabli;
           var region='<?=$region?>';
           var province='<?=$province?>';
 $(document).ready(function(){  
             $('#Imin').val(sliderMin);
             $('#Imax').val(sliderMax);
             $('#IminS').val(sliderMin);
             $('#ImaxS').val(sliderMax);
             if(lgtp=="OptT")
              {
                $("#radio-Oee").prop("checked", true);
                $("#radio-OeeS").prop("checked", true);
              }
             else if(lgtp=="OptA")
              {
                $("#radio-fin").prop("checked", true);
                $("#radio-finS").prop("checked", true);
              }
             else if(lgtp=="OptS")
              {
                $("#radio-Oe").prop("checked", true);
                $("#radio-OeS").prop("checked", true);
              }

             $('#rf').click(function(){  
             Max = document.getElementById("Imax").value; 
             Min = document.getElementById("Imin").value; 
             Nbr_pr=document.querySelector('#NPM input[name="switch-two"]:checked').value;
             Nbr_Ch=document.querySelector('#NCM input[name="switchs-two3"]:checked').value;
             TL_Type=document.querySelector('#TM input[name="switch-two4"]:checked').value; 
             srch=document.querySelector('#SR input[name="q"]').value;
             colloc=document.querySelector('#MrM input[name="switch-Collo"]:checked').value;
             etu_prch=document.querySelector('#MrM input[name="switch-Etu"]:checked').value;
            
           if(etu_prch!='non')
            {
              etabli=document.querySelector('#MrM span[name="etable"]').textContent;
            }
           else
            {
              etabli='';
            } 

           $.ajax({  
                url:"FilteredSearch.php?rech=<?=$_GET['rech']?>",  
                method:"POST",  
                data:{Pmax:Max,
                      Pmin:Min,
                      NP:Nbr_pr,
                      NC:Nbr_Ch,
                      TL:TL_Type,
                      search:srch,
                      colloc:colloc,
                      etu_prch:etu_prch,
                      etab:etabli,
                      region:region,
                      province:province
                      },
                dataType : 'json',        
                success:function(response){  
                  markers = response.markers;

                  for(i=0;i<markers_on_map.length;i++) {
                     map.removeLayer(markers_on_map[i]);
                     }  
                     for(var i=0;i<markers.length;i++)
                      {
                        if(markers[i][6]!=null)
                        { 
                         var icon = L.divIcon({
                             className: 'custom-div-icon',
                             html: "<button  id='"+i+"' class='marker-pin marker'> <i class='fas fa-home hm'></i> </button>"
                              
                         });
                          var marker = L.marker([markers[i][5], markers[i][6]],{ icon: icon }).addTo(map);
                          //marker.bindPopup("<h5>"+markers[i][1]+"</h5><br><p>"+markers[i][2]+"</p>");
                     
                     
                     
                          marker.bindPopup( "<div class='pop_img'>"+markers[i][7]+"<div class='pop_title'><h3>"+markers[i][1]+"</h3></div><div class='pop_adrs'><i class='fas fa-map-marker-alt CA'></i>"+markers[i][8]+"</div><div class='pop_prix'><i class='fas fa-tags CA'></i>"+markers[i][4]+" DH</div></div>");
                        // marker.bindPopup( "<div class='carousel slide' data-ride='carousel'><div class='carousel-inner'>"+markers[i][7]+" </div></div><div class='card-body'><h5 class='card-title'>"+markers[i][1]+"</h5>  <br><p class='cpara'>"+markers[i][3]+"</p> <br> </div>");
                          markers_on_map.push(marker);
                         marker.bindTooltip(""+markers[i][4]+" DH", {className: 'price-tag'});
                         
                         }
                      }



                    


                     $('#nC').html(response.result);  

                     if(Nbr_pr=='All')
                       $("#radio-OS").prop("checked", true);
                     else if(Nbr_pr=='1') 
                       $("#radio-oneS").prop("checked", true); 
                     else if(Nbr_pr=='2') 
                       $("#radio-twoS").prop("checked", true);   
                     else if(Nbr_pr=='3') 
                       $("#radio-threS").prop("checked", true);   
                     else if(Nbr_pr=='4') 
                       $("#radio-fourS").prop("checked", true); 
                     else if(Nbr_pr=='5') 
                       $("#radio-fiveS").prop("checked", true);  


                    if(Nbr_Ch=='All')
                       $("#rad0S").prop("checked", true);
                     else if(Nbr_Ch=='1') 
                       $("#rad1S").prop("checked", true); 
                     else if(Nbr_Ch=='2') 
                       $("#rad2S").prop("checked", true);   
                     else if(Nbr_Ch=='3') 
                       $("#rad3S").prop("checked", true);   
                     else if(Nbr_Ch=='4') 
                       $("#rad4S").prop("checked", true); 
                     else if(Nbr_Ch=='5') 
                       $("#rad5S").prop("checked", true);   
                       
                    if(TL_Type=='All')
                       $("#radio-OeeS").prop("checked", true);
                     else if(TL_Type=='studio') 
                       $("#radio-OeS").prop("checked", true); 
                     else if(TL_Type=='Apartement') 
                       $("#radio-finS").prop("checked", true);  

                       if(etu_prch=='All')
                      {
                       $("#CollocEtuMA").prop("checked", true);
                       document.getElementById('etable_mdl').style.display='none';
                       document.getElementById('etable_mdl_ttl').style.display='none';
                      } 
                     else if(etu_prch=='oui') 
                      {
                       $("#CollocEtuMO").prop("checked", true); 
                       document.getElementById('etable_mdl').style.display='block';
                       document.getElementById('etable_mdl_ttl').style.display='block';
                      } 
                   else if(etu_prch=='non') 
                    {
                     $("#CollocEtuMN").prop("checked", true);
                     document.getElementById('etable_mdl').style.display='none';
                       document.getElementById('etable_mdl_ttl').style.display='none';

                    }


                       

                    $("#IminS").val(Min);  
                    $("#ImaxS").val(Max); 
                   
                }  
           });  
      });  

     

 });  
 </script>  

 <script>
   function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
} 
   </script>



<script>
var MaxS;
var MinS;
var Nbr_prS;
var Nbr_ChS;
var TL_TypeS;
var srchS;
var collocS;
var etu_prchS;
var etabliS;
$(document).ready(function(){  
      $('#aply_modal').click(function(){  
          MaxS = document.getElementById("ImaxS").value; 
          MinS = document.getElementById("IminS").value; 
          Nbr_prS=document.querySelector('#NPMS input[name="switch-twoS"]:checked').value;
          Nbr_ChS=document.querySelector('#NCMS input[name="switchs-two3S"]:checked').value;
          TL_TypeS=document.querySelector('#TMS input[name="switch-two4S"]:checked').value; 
          srchS=document.querySelector('#SR input[name="q"]').value;
          collocS=document.querySelector('#MrMS input[name="CollocRadM"]:checked').value;
          etu_prchS=document.querySelector('#MrMS input[name="CollocEtuM"]:checked').value;
            
           if(etu_prchS!='non')
            {
              etabliS=document.querySelector('#MrMS span[name="etable_mdl"]').textContent;
            }
           else
            {
              etabliS='';
            } 


           $.ajax({  
                url:"FilteredSearch.php?rech=<?=$_GET['rech']?>",  
                method:"POST",  
                data:{Pmax:MaxS,Pmin:MinS,NP:Nbr_prS,NC:Nbr_ChS,TL:TL_TypeS,search:srchS,
                      colloc:collocS,
                      etu_prch:etu_prchS,
                      etab:etabliS},  
                success:function(data){ 
                   
                     $('#nC').html(data); 

                     if(Nbr_prS=='All')
                       $("#radio-O").prop("checked", true);
                     else if(Nbr_prS=='1') 
                       $("#radio-one").prop("checked", true); 
                     else if(Nbr_prS=='2') 
                       $("#radio-two").prop("checked", true);   
                     else if(Nbr_prS=='3') 
                       $("#radio-thre").prop("checked", true);   
                     else if(Nbr_prS=='4') 
                       $("#radio-four").prop("checked", true); 
                     else if(Nbr_prS=='5') 
                       $("#radio-five").prop("checked", true);  


                    if(Nbr_ChS=='All')
                       $("#rad0").prop("checked", true);
                     else if(Nbr_ChS=='1') 
                       $("#rad1").prop("checked", true); 
                     else if(Nbr_ChS=='2') 
                       $("#rad2").prop("checked", true);   
                     else if(Nbr_ChS=='3') 
                       $("#rad3").prop("checked", true);   
                     else if(Nbr_ChS=='4') 
                       $("#rad4").prop("checked", true); 
                     else if(Nbr_ChS=='5') 
                       $("#rad5").prop("checked", true);   
                       
                    if(TL_TypeS=='All')
                       $("#radio-Oee").prop("checked", true);
                     else if(TL_TypeS=='studio') 
                       $("#radio-Oe").prop("checked", true); 
                     else if(TL_TypeS=='Apartement') 
                       $("#radio-fin").prop("checked", true);  


                     
                    if(etu_prchS=='All')
                     {
                       $("#allEtu").prop("checked", true);
                       document.getElementById('etable').style.display='none';
                       document.getElementById('titre_etable').style.display='none';
                     }  
                   else if(etu_prchS=='oui') 
                     {
                      $("#radio-LOui").prop("checked", true); 
                      document.getElementById('etable').style.display='block';
                      document.getElementById('titre_etable').style.display='block';
                     }
                   else if(etu_prchS=='non') 
                    {
                     $("#radio-Lnon").prop("checked", true);
                     document.getElementById('etable').style.display='none';
                     document.getElementById('titre_etable').style.display='none';
                    } 

                    $("#Imin").val(MinS);  
                    $("#Imax").val(MaxS);
                    $('#modalEquip').modal('hide');
                }  
           });
      });
    });  
</script>

<script>
   /*
orgW=$(window).width();
var width = $(window).width();

document.getElementById('filters_show').style.display='none'; 

$(window).on('resize', function() {
  if ($(this).width() != width) {
    width = $(this).width();
    document.getElementById('Drp_prix').style.display='none'; 
    document.getElementById('Drp_nbrP').style.display='none'; 
    document.getElementById('Drp_nbrCh').style.display='none'; 
    document.getElementById('Drp_TL').style.display='none'; 
    document.getElementById('Drp_Plus').style.display='none'; 
    document.getElementById('Drp_Rch').style.display='none'; 

    document.getElementById('filters_show').style.display='block'; 
         $('#logoo').css('width','6em');
         $('#logoo').css('margin-top','1em');
         $('#logoo').css('margin-left','1em');    
  }

  if ($(this).width() == orgW) {
    width = $(this).width();
    document.getElementById('Drp_prix').style.display='block'; 
    document.getElementById('Drp_nbrP').style.display='block'; 
    document.getElementById('Drp_nbrCh').style.display='block'; 
    document.getElementById('Drp_TL').style.display='block'; 
    document.getElementById('Drp_Plus').style.display='block'; 
    document.getElementById('Drp_Rch').style.display='block'; 
    document.getElementById('filters_show').style.display='none'; 
    
  }

});

*/
</script>

<script>
 $(document).ready(function(){  
        document.getElementById('etable').style.display='none';
        document.getElementById('titre_etable').style.display='none';

        document.getElementById('etable_mdl').style.display='none';
        document.getElementById('etable_mdl_ttl').style.display='none';



      $('#radio-Lnon').click(function(){
        document.getElementById('etable').style.display='none';
        document.getElementById('titre_etable').style.display='none';
      });

      $('#radio-LOui').click(function(){
        document.getElementById('etable').style.display='block';
        document.getElementById('titre_etable').style.display='block';
      });

      $('#allEtu').click(function(){
        document.getElementById('etable').style.display='none';
        document.getElementById('titre_etable').style.display='none';
      });




      $('#CollocEtuMN').click(function(){
        document.getElementById('etable_mdl').style.display='none';
        document.getElementById('etable_mdl_ttl').style.display='none';
      });

      $('#CollocEtuMO').click(function(){
        document.getElementById('etable_mdl').style.display='block';
        document.getElementById('etable_mdl_ttl').style.display='block';
      });

      $('#CollocEtuMA').click(function(){
        document.getElementById('etable_mdl').style.display='none';
        document.getElementById('etable_mdl_ttl').style.display='none';
      });
    });    


    
</script>

<!--MAP Loading JavaScreept-->
<script>
var markers_on_map=[];  
var markers = <?php echo json_encode($markers); ?>;
var nbrM=<?php echo count($markers);?>;

const here = {
  apiKey:'gNAS-hI7AKsqytfacNxMU-WZqMQa_Zn-nunnoU2p6s4'
}
const style = 'normal.day';

const hereTileUrl = `https://2.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/${style}/{z}/{x}/{y}/512/png8?apiKey=${here.apiKey}&ppi=320`;

const map = L.map('map', {
   center: [33.589886, -7.603869],
   zoom: 8,
   layers: [L.tileLayer(hereTileUrl)]
});
map.attributionControl.addAttribution('&copy; HERE 2019');
for(var i=0;i<nbrM;i++)
 {
   if(markers[i][6]!=null)
   { 
    var icon = L.divIcon({
        className: 'custom-div-icon',
        html: "<button  id='"+i+"' class='marker-pin marker'> <i class='fas fa-home hm'></i> </button>"
         
    });
     var marker = L.marker([markers[i][5], markers[i][6]],{ icon: icon }).addTo(map);
     //marker.bindPopup("<h5>"+markers[i][1]+"</h5><br><p>"+markers[i][2]+"</p>");



     marker.bindPopup( "<div class='pop_img'>"+markers[i][7]+"<div class='pop_title'><h3>"+markers[i][1]+"</h3></div><div class='pop_adrs'><i class='fas fa-map-marker-alt CA'></i>"+markers[i][8]+"</div><div class='pop_prix'><i class='fas fa-tags CA'></i>"+markers[i][4]+" DH</div></div>");
   // marker.bindPopup( "<div class='carousel slide' data-ride='carousel'><div class='carousel-inner'>"+markers[i][7]+" </div></div><div class='card-body'><h5 class='card-title'>"+markers[i][1]+"</h5>  <br><p class='cpara'>"+markers[i][3]+"</p> <br> </div>");
     markers_on_map.push(marker);
    marker.bindTooltip(""+markers[i][4]+" DH", {className: 'price-tag'});
    
    }
 }
</script>


<script>
  var map_open="Y";
 $(document).ready(function(){ /*
$('.marker').mouseover(function() {
   
   document.getElementById(this.id).innerHTML ="<p class='map_pr'>"+markers[this.id][4]+"DH</p>";
  });

  $('.marker').mouseleave(function() {
   
   document.getElementById(this.id).innerHTML ="<i class='fas fa-home hm'></i>";
  });*/

  $('#map_cntrl').click(function() {
    if(map_open=="Y")
    {
        document.getElementById('map').style.display='none'; 
        $("#CNTR").attr('class', '');
        $("#nC").attr('class', 'grid');
        map_open="N";
    }
    else if(map_open=="N")
    {
      $("#CNTR").attr('class', 'containerR');
        $("#nC").attr('class', 'grids grid');
        document.getElementById('map').style.display='block'; 

        map_open="Y";
    }
    
   });

});



</script>

<style>
.marker{
  font-size:17px;
  border-radius:100%;
  height: 40px;
  width: 40px; 
  background-color: whitesmoke;
  border:0px;
}
.marker:hover{
  height: 41px;
  width: 41px;
  font-size:18px;
  background-color: black;
  color: whitesmoke;
  
   
}

.map_pr{
  margin-left:-7px;
}


</style>