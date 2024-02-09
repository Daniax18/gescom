<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE  </a></li>
          <li class="breadcrumb-item active" aria-current="page"> VOIR ETAT DE STOCK AVANT < <b> <?php echo $date ?> </b> > </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3"> Evaluation de l'etat de stock : </h3>
              <div class="d-flex flex-row justify-content-between" style ="width: 30%">
                <a  data-bs-toggle="modal" data-bs-target="#search">
                    <button class="btn btn-outline-primary"> 
                        Recherche par produit
                    </button>
                </a>
                <a  data-bs-toggle="modal" data-bs-target="#addBl">
                    <button class="btn btn-outline-primary"> 
                        Faire demande
                    </button>
                </a>
              </div>
             
            </div>
            <div class="alert alert-secondary d-flex flex-column" role="alert">
                <p> <i class="link-icon" style="color: red; fill: red" data-feather="flag"></i>  Produit en dessous du <b> stock minimum </b> </p>
                <p> <i class="link-icon" style="color: orange;" data-feather="flag"></i>  Produit en dessous du <b> stock d'alert </b> </p>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                      <thead class="table-info text-center">
                        <th> Ref Produit </th>
                        <th> Designation </th>
                        <th> Unite </th>
                        <th style = "width: 5%"> Stock alerte </th> 
                        <th style = "width: 5%"> Stock minimum  </th>
                        <th> Stock Reel </th>
                      </thead>
                    <tbody>
                      <?php foreach($stock as $be){ ?>
                        <tr >
                          <td> <?php echo $be['etat']['idmateriel']; ?> </td>
                          <td> <?php echo $be['etat']['nommateriel']; ?> </td>
                          <td> <?php echo $be['etat']['nomunite']; ?> </td>
                          <td class="text-end"> <?php echo $be['materiel']['stock_alerte']; ?> </td>
                          <td  class="text-end">  <?php echo $be['materiel']['stock_minimum']; ?>      </td>
                          <td class="text-end">
                              <b> <?php echo $be['etat']['qty']; ?> </b> 
                              <span style="opacity: 0"> --- </span> 
                            <span class="translate-middle top-0 start-50 badge rounded-pill text-light">
                            <?php if(isset($be['etat']['icon']) == true){
                                echo $be['etat']['icon'];
                            } ?>
                            </span> 
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- MODAL DE RECHERCHE PAR PRODUIT B.E -->
    <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Recherche par produit : </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/StockController/getEtatStockProduct") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%"> Produit </label>
                  <select class="form-select form-select-sm mb-3" name="idmateriel">
                    <!-- <option value="%"> Tous produits </option> -->
                    <?php foreach($materiels as $materiel){ ?>
                      <option value="<?php echo $materiel['idmateriel'] ?>">
                      <?php echo $materiel['idmateriel'] ?> - <?php echo $materiel['nommateriel'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date a choisir : </label>
                  <input type="date" class="form-control" name="datestock">
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Search <i class="link-icon" data-feather="search"></i> </button>
              </div>
            </form>
        </div>
      </div>
    </div>


    <!-- MODAL DE CREATION DEMANDE DES PRODUITS  MANQUANTE -->
    <div class="modal fade" id="addBl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Demande d'achat pour les materiels < Stock minimum </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/StockController/makeDemande") ?>" method="POST">
              <div class="modal-body">
              
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Envoyer demande + </button>
              </div>
            </form>
        </div>
      </div>
    </div>
