
<?php 
    $user = $this->session->userdata('user_data');
    $departement_achat = $this->session->userdata('dep_achat');
    $departement_finance = $this->session->userdata('dep_finance');
    $departement_log = $this->session->userdata('dep_logistique');
    $departement_vente = $this->session->userdata('dep_vente');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>GESCOM | 1.0</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/vendors/core/core.css">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/fonts/feather-font/css/iconfont.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/fonts/feather-font/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/vendors/flag-icon-css/css/flag-icon.min.css">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back_office/css/demo1/style.css">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/back_office/images/favicon.png" />
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/_sidebar.html -->
		<nav class="sidebar">
      <div class="sidebar-header">
        <a href="<?php echo site_url("index.php/back_office/HomeController") ?>" class="sidebar-brand">
          GES<span>COM</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="dashboard.html" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-category"> MON DEPARTEMENT </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="key"></i>
              <span class="link-title">KPI</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/apps/chat.html" class="nav-link">
              <i class="link-icon" data-feather="users"></i>
              <span class="link-title">Employes</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/apps/calendar.html" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Agenda</span>
            </a>
          </li>

          <!-- SERVICE ACHAT -->
        <?php 
        if($user['iddepartement'] == $departement_achat || $user['privilege'] == 2){  ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title"> Service Achat </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/dep_achat/BesoinController/getAllBesoinsCtrl") ?>" class="nav-link">
                    Ensemble besoins
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/dep_achat/BesoinController/getBesoinGlobalCtrl") ?>" class="nav-link">
                    Besoins globaux
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/ProformaReceivedController/proforma") ?>" class="nav-link">
                    Liste des proformas
                  </a>
                </li>
                <?php if($user['privilege'] == 2){ ?>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/BandcommandeController/bonCommandeAdjoint") ?>" class="nav-link">
                      B.C en attente Validation
                    </a>
                  </li>
                <?php } ?>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/BandcommandeController/general_commandes") ?>" class="nav-link">
                      B.C created
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/getBonLivraison") ?>" class="nav-link">
                      B . L Recus
                    </a>
                  </li>
                 

                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_achat/BonReceptionController/getBonReception") ?>" class="nav-link">
                      Bon de Reception
                    </a>
                  </li>
              </ul>
            </div>
          </li>
        <?php } ?>


        <!-- SERVICE FINANCE -->
        <?php 
        if($user['iddepartement'] == $departement_finance){ ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="credit-card"></i>
              <span class="link-title"> Service Finance </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                  <li class="nav-item">
                    <a data-bs-toggle="modal" data-bs-target="#amortissement" class="nav-link">
                      Amortissement materiels
                    </a>
                  </li>
                <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/BandcommandeController/bonCommandeFinance") ?>" class="nav-link">
                      B.C en attente validation
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/getFactureReceived") ?>" class="nav-link">
                      Factures des FRNS
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/getFacturation") ?>" class="nav-link">
                      Factures pour Clients
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/getCommadeNeedFacturation") ?>" class="nav-link">
                      B.C a facturer
                    </a>
                  </li>
                  <li class="nav-item">
                    <a data-bs-toggle="modal" data-bs-target="#etatstock_finance" class="nav-link">
                      Etat de stock
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_finance/EcartController/getInventaireValidate") ?>" class="nav-link">
                      Rapprochement stock
                    </a>
                  </li>
                 
                  <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/dep_finance/VoitureController/getAllDepenseVoiture?status=3") ?>" class="nav-link">
                    Depenses voitures
                  </a>
                </li>
              </ul>
            </div>
          </li>
        <?php } ?>

        <!-- SERVICE LOGISTIQUE && ENTRETIEN AUTO -->
        <?php 
        if($user['iddepartement'] == $departement_log){ ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="credit-card"></i>
              <span class="link-title"> Service Logistique </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonEntreeController/getBonEntree") ?>" class="nav-link">
                      Bon d'Entree
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonLivraisonClientController/getBonLivraisonClient") ?>" class="nav-link">
                      Bons de Livraisons emis
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonLivraisonClientController/getCommadeNeedBonLivraisonClient") ?>" class="nav-link">
                      Bons de Livraisons A faire
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/getBonSortie") ?>" class="nav-link">
                      Bon de Sortie (interne)
                    </a>
                  </li>

                  <li class="nav-item">
                    <a data-bs-toggle="modal" data-bs-target="#etatstock" class="nav-link">
                      Etat de stock
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/getInventaires") ?>" class="nav-link">
                      Inventaire physique
                    </a>
                  </li>
                  <li class="nav-item">
                    <a data-bs-toggle="modal" data-bs-target="#PV_REC" class="nav-link">
                    PV de reception
                    </a>
                  </li>
              </ul>
            </div>
          </li>
          <!-- ENTRETIEN AUTO  -->
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedAuto" role="button" aria-expanded="false" aria-controls="advancedAuto">
              <i class="link-icon" data-feather="truck"></i>
              <span class="link-title"> Entretien auto </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedAuto">
              <ul class="nav sub-menu">
                <li class="nav-item">
                <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/getEtatGlobal") ?>" class="nav-link">
                      Etat global voiture
                    </a>
                  </li>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/getPV") ?>" class="nav-link">
                    Activite voiture
                  </a>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="modal" data-bs-target="#entretien_voiture" class="nav-link">
                    Entretien voiture
                  </a>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="modal" data-bs-target="#carburant" class="nav-link">
                    Gestion Carburant
                    </a>
                  </li>
                 <!-- papier -->
                <li class="nav-item">
                  <a data-bs-toggle="modal" data-bs-target="#papier" class="nav-link">
                    Gestion Paperasse
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url("index.php/back_office/dep_logistique/EntretienController/getControleKilometre") ?>" class="nav-link">
                    Gestion controle
                  </a>
                </li>
              </ul>
            </div>
          </li>

        <?php } ?>


        <!-- SERVICE VENTE ET MARKETING -->
        <?php 
        if($user['iddepartement'] == $departement_vente){ ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
              <i class="link-icon" data-feather="credit-card"></i>
              <span class="link-title"> Service Marketing & Vente </span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="advancedUI">
              <ul class="nav sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_vente/ProformaClientController/getProformaClient") ?>" class="nav-link">
                      Proforma Client
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/getCommandeClient") ?>" class="nav-link">
                      B.C Clients
                    </a>
                  </li>
              </ul>
            </div>
          </li>
        <?php } ?>



        <!-- STANDART POUT TOUS LES DEPARTEMENTS -->
          <li class="nav-item nav-category">BESOIN ACHAT</li>
          <li class="nav-item">
            <a data-bs-toggle="modal" data-bs-target="#addAchat" class="nav-link">
              <i class="link-icon" data-feather="tag"></i>
              <span class="link-title">Faire une demande d'achat</span>
            </a>

          </li>
          <li class="nav-item">
            <a href="<?php echo site_url("index.php/back_office/BesoinController/getBesoinsCtrl") ?>" class="nav-link">
              <i class="link-icon" data-feather="map"></i>
              <span class="link-title">Liste des demandes</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url("index.php/back_office/BesoinController/getMaterielsReceived") ?>" class="nav-link">
              <i class="link-icon" data-feather="map"></i>
              <span class="link-title"> Reception materiels </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

      <!-- MODAL D'ETAT STOCK FINCANE-->
      <div class="modal fade" id="etatstock_finance" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir la date de l'evaluation ? </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="<?php echo site_url("index.php/back_office/dep_finance/StockController/getEtatStockGeneral") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date a choisir : </label>
                  <input type="date" class="form-control" name="datestock">
                </div>
                <div style="padding: 3% 3% 3% 3%">
                  <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
                </div>   
              </div>
            </form>
          </div>
        </div>
      </div>

     
     
    <!-- MODAL D'ETAT STOCK LOGISTIQUE-->
    <div class="modal fade" id="etatstock" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir la date de l'evaluation ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_logistique/StockController/getEtatStockGeneral") ?>" method="POST">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Date a choisir : </label>
                <input type="date" class="form-control" name="datestock">
              </div>
              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>

   
    
    
    <!-- MODAL DE CREATION DEMANDE -->
    <div class="modal fade" id="addAchat" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Voulez vous vraiment creer une nouvelle demande ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/BesoinController/createBesoinCtrl") ?>" method="POST">
            <div style="padding: 3% 3% 3% 3%">
              <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
            </div>   
          </form>
        </div>
      </div>
    </div>   
   
    <!-- MODAL ENTRETIEN VOITURE-->
    <div class="modal fade" id="entretien_voiture" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir parmi les voitures : </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_logistique/EntretienController/getEntetienVoiture") ?>" method="GET">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Voiture : </label>
                <select class="form-control" name="id_voiture">
                  <?php 
                  if($cars != null){
                    for($i=0; $i < count($cars); $i++){ ?>
                      <option value="<?php echo $cars[$i]['idvoiture']?>" >
                        <?php echo $cars[$i]['matricule'] . ' - ' . $cars[$i]['nommarque'] ?>
                      </option>
                    <?php } 
                  } ?>
                 
                </select>
              </div>
              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- MODAL PV de reception-->
    <div class="modal fade" id="PV_REC" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Entrer d'une nouvelle immobilisation </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/insertVoiture") ?>" method="POST">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Voiture : </label>
                <select class="form-control" name="idmodele">
                  <?php for($i=0; $i < count($modele); $i++){ ?>
                  <option value="<?php echo $modele[$i]['idmodele']?>" ><?php echo $modele[$i]['nommodele']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Date: </label>
                <input type="date" class="form-control" name="date">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Consommation: </label>
                <input type="text" class="form-control" name="consommation">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">kilometrage : </label>
                <input type="text" class="form-control" name="kilometrage">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Matricule : </label>
                <input type="text" class="form-control" name="matricule">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Prix : </label>
                <input type="text" class="form-control" name="prix">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Taux lineaire : </label>
                <input type="text" class="form-control" name="taux">
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Methode : </label>
                <select class="form-control" name="methode">
                  <option value="0" >lineaire</option>
                  <option value="1">degressif</option>
                </select>
              </div>
                  <?php 
                  $categorie = null;
                  for($i=0; $i < count($detail_categorie); $i++){
                    if($categorie == null || $categorie != $detail_categorie[$i]['nomcategorie']){
                      $categorie = $detail_categorie[$i]['nomcategorie'];?>
                    <div class="mb-3 border-bottom text-center">    <strong><?php echo $categorie; ?></strong>  </div>
                  <?php  }
                    ?>
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%"><?php echo $detail_categorie[$i]['nomdetail_categorie']?>: </label>
                <input type="text" class="form-control" name="value[]" value="0">
                <input type="hidden" name="detail[]" value="<?php echo $detail_categorie[$i]['iddetail_categorie']?>">
              </div>
                
                  <?php } ?>
              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>

      <!-- MODAL PAPIER-->
    <div class="modal fade" id="papier" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir le Vehicule et le papier </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/getPapier") ?>" method="POST">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Voiture : </label>
                <select class="form-control" name="voiture">
                  <?php for($i=0; $i < count($cars); $i++){ ?>
                  <option value="<?php echo $cars[$i]['idvoiture']?>" >
                    <?php echo $cars[$i]['matricule'] . ' - ' . $cars[$i]['nommarque'] ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Papier : </label>
                <select class="form-control" name="papier">
                  <?php for($i=0; $i < count($paperasse); $i++){ ?>
                  <option value="<?php echo $paperasse[$i]['idpapier']?>" ><?php echo $paperasse[$i]['nompapier']?></option>
                  <?php } ?>
                </select>
              </div>
              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- MODAL CARBURANT-->
    <div class="modal fade" id="carburant" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir le vehicule </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/getCarburant") ?>" method="POST">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Voiture : </label>
                <select class="form-control" name="voiture">
                <?php 
                  if($cars != null){
                    for($i=0; $i < count($cars); $i++){ ?>
                      <option value="<?php echo $cars[$i]['idvoiture']?>" >
                        <?php echo $cars[$i]['matricule'] . ' - ' . $cars[$i]['nommarque'] ?>
                      </option>
                    <?php } 
                  } ?>
                </select>
              </div>
              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>

      <!-- MODAL D'AMORTISSEMENT-->
    <div class="modal fade" id="amortissement" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir le produit et la methode? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_finance/AmortissementController/amortissement") ?>" method="POST">
            <div class="modal-body">
              <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                <label class="form-label" style="width: 30%">Produit : </label>
                <select class="form-control" name="produit">
                  <?php for($i=0; $i < count($cars); $i++){ ?>
                  <option value="<?php echo $cars[$i]['idvoiture']?>" >
                  <?php echo $cars[$i]['matricule'] . ' - ' . $cars[$i]['nommarque'] ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <div style="padding: 3% 3% 3% 3%">
                <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
              </div>   
            </div>
          </form>
        </div>
      </div>
    </div>
  
    <!-- PROFILAGE -->
    <div class="page-wrapper">
        <nav class="navbar">
          <a href="#" class="sidebar-toggler">
            <i data-feather="menu"></i>
          </a>
          <div class="navbar-content">
            <form class="search-form">
              <div class="input-group">
                <div class="input-group-text">
                  <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="ms-1 me-1 d-none d-md-inline-block">Departement <?php echo $user_session['nomdepartement'] ?> </span>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="wd-30 ht-30 rounded-circle" src="<?php echo base_url() ?>/assets/back_office/images/face5.jpg" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                  <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                    <div class="mb-3">
                      <img class="wd-80 ht-80 rounded-circle" src="<?php echo base_url() ?>/assets/back_office/images/face5.jpg" alt="">
                    </div>
                    <div class="text-center">
                      <p class="tx-16 fw-bolder"><?php echo $user_session['nom'] . ' ' . $user_session['prenom'] ?></p>
                      <p class="tx-12 text-muted"><?php echo $user_session['nomposte'] ?></p>
                    </div>
                  </div>
                  <ul class="list-unstyled p-1">
                    <li class="dropdown-item py-2">
                      <a href="pages/general/profile.html" class="text-body ms-0">
                        <i class="me-2 icon-md" data-feather="user"></i>
                        <span>Profile</span>
                      </a>
                    </li>
                    <li class="dropdown-item py-2">
                      <a href="<?php echo site_url("index.php/back_office/LoginController/logout") ?>" class="text-body ms-0">
                        <i class="me-2 icon-md" data-feather="log-out"></i>
                        <span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </nav>