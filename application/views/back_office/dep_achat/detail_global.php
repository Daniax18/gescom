<div class="page-content">

  <nav class="page-breadcrumb mb-5">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE ACHAT </a></li>
          <li class="breadcrumb-item active" aria-current="page"> DETAIL BESOIN GLOBAL DU : <b> <?php echo $global['date']  ?> </b> </li>
      </ol>
  </nav>

  <div class="row">
    <div class="col-lg-4 col-xl-4 grid-margin grid-margin-xl-0">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
            <div class="d-flex flex-row justify-content-between align-items-center">
              <h6 class="card-title mb-4 text-muted border-bottom pb-3">Detail des materiels :</h6>
            </div>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#voirDetail">
                Voir detail
            </button>
          </div>
          <div class="d-flex flex-column">
            <?php foreach($materiels as $materiel) { ?>
              <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                <div class="w-100">
                  <div class="d-flex justify-content-between">
                    <h6 class="text-body mb-2"> <?php echo $materiel['nommateriel'] ?> </h6>
                    <p class="text-start tx-13"> <?php echo $materiel['nomnature'] ?> </p>
                    <h6 class="text-body mb-2"> <?php echo $materiel['total'] ?> </h6>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="card-footer d-flex flex-row justify-content-between">
            <?php if($global['status'] < 0 ){ ?>
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#verificationProforma">
                  Creer proforma
              </button>
              

              <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#verificationDegroup">
                  Degrouper        
                </button>
            <?php } ?>
        </div>
      </div>
    </div>

    <div class="col-lg-8 col-xl-8  d-flex flex-column">
      <h5 class="text-muted text-center border-bottom pb-3 mb-4"> Les proformas a envoyer:  </h5>
        <?php 
        if(isset($suppliers)){
          $this -> load -> model('back_office/dep_achat/Proforma');
          foreach($suppliers as $supplier){
            $details = $this -> Proforma -> getDetailProformaPerSupplier($global['idglobal'], $supplier['idfournisseur']); 
            // var_dump($details[0]);
            ?>
            <div class="card mb-5">
              <div class="card-body">
                <div class="d-flex  align-items-baseline mb-2" style="width: 50%">
                  <span class="text-muted" style="margin-right: 2%">Fournisseurs: </span> <h6 class="card-title mb-4 border-bottom pb-3"> <?php echo $supplier['nomfournisseur'] ?> </h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th class="pt-0"> Ref Produit </th>
                        <th class="pt-0"> Nom produit </th>
                        <th class="pt-0"> Nature </th>
                        <th class="pt-0"> Quantite demande </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($details as $detail){ ?>
                        <tr>
                          <td> <?php echo $detail['idmateriel'] ?> </td>
                          <td> <?php echo $detail['nommateriel'] ?> </td>
                          <td> <?php echo $detail['nomnature'] ?> </td>
                          <td> <?php echo $detail['qte'] ?> </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">

                <a href="<?php echo site_url("index.php/back_office/ProformaController/demande") ?>/<?php echo $details[0]['idproforma'] ?>">
                  <button class="btn btn-primary">
                      Apercu demande
                  </button>  
                </a>
                </div> 
              </div>
            </div>
          <?php }
          } ?>
    </div>

    <!-- MODAL DE DETAIL -->
    <div class="modal fade" id="verificationProforma" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Creer les proformas correspondant? </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <div class="modal-body">
          <div class="d-flex flex-row justify-content-between" style="width: 50%; margin-left: auto; margin-right: auto">
              <form action="<?php echo site_url("index.php/back_office/dep_achat/ProformaController/createProforma") ?>" method="POST">
                <input type="hidden" name="idglobal" value="<?php echo $global['idglobal'] ?>">
                <button type="submit" class="btn btn-success"> Oui </button>   
              </form> 
              <button data-bs-dismiss="modal" class="btn btn-outline-primary"> Non </button>  
            </div>
          </div>
        </div>
      </div>
    </div>
    


    <!-- MODAL DE DETAIL -->
    <div class="modal fade" id="voirDetail" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Apercu du groupement </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <div class="modal-body">
            <?php 
              $this -> load -> model('back_office/achat/Besoin');
              $this -> load -> model('back_office/dep_achat/BesoinAchat');
              foreach($mydetails as $mydetail){
                    $besoin = $this -> BesoinAchat -> besoinGeneralById($mydetail['idbesoin']);
                    $list_materiels = $this -> Besoin -> getBesoinDetail($mydetail['idbesoin']); ?>
                    <div class="border-bottom pb-3 mb-3">
                      <div class="text-muted mb-3">
                          <h6>Departement:  <?php echo $besoin['nomdepartement']; ?></h6>
                      </div>

                      <div class="d-flex flex-row justify-content-between mb-3">
                        <div class="text-center border border-2" style="width: 33%">
                            <h4>Materiels</h4>
                        </div>
                        <div class="text-center border border-2" style="width: 33%">
                            <h4>Nature</h4> 
                        </div>
                        <div class="text-center border border-2" style="width: 33%">
                            <h4>Quantite</h4> 
                        </div>
                      </div>
                      <?php foreach($list_materiels as $materiels) { ?>
                        <div class="d-flex flex-row justify-content-between mb-3">
                          <div class="text-start" style="width: 33%">
                              <?php echo $materiels['nommateriel'] ?>
                          </div>
                          <div class="text-center" style="width: 33%">
                              <?php echo $materiels['nomnature'] ?>
                          </div>
                          <div class="text-center" style="width: 33%">
                              <?php echo $materiels['qte'] ?>
                          </div>
                        </div>
                        <?php } ?>  
                    </div>
                  <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- MODAL DE DEGROUPAGE -->
    <div class="modal fade" id="verificationDegroup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Voulez vous vraiment degrouper cette Besoin Global ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>

          <div class="modal-body">
            <div class="d-flex flex-row justify-content-between" style="width: 50%; margin-left: auto; margin-right: auto">
              <form action="<?php echo site_url("index.php/back_office/dep_achat/BesoinController/degroupeBesoinGlobalCtrl") ?>" method="POST">
                <input type="hidden" name="idglobal" value="<?php echo $global['idglobal'] ?>">
                <button type="submit" class="btn btn-outline-danger"> Oui </button>   
              </form> 
              <button data-bs-dismiss="modal" class="btn btn-outline-primary"> Non </button>  
            </div>
          <div>
        </div>
      </div>
    </div>
    
  </div>    
