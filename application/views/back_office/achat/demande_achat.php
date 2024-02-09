<div class="page-content">

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
        <li class="breadcrumb-item active" aria-current="page">DEMANDE ACHAT</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h3 class="text-start mb-3"> Enumerez vos besoins ici </h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterial">
              Ajouter + 
            </button>
             <!-- Modal -->
              <div class="modal fade" id="addMaterial" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle"> Choisir materiel </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <form action="<?php echo site_url("index.php/back_office/BesoinController/addDetailBesoinCtrl") ?>" method="POST">
                      <input type="hidden" name="idbesoin" value="<?php echo $idbesoin ?>">
                      <div class="modal-body">
                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                          <label class="form-label" style="width: 30%">Produit : </label>
                          <select class="form-select form-select-sm mb-3" name="idmateriel">
                            <?php foreach($materiels as $materiel){ ?>
                              <option value="<?php echo $materiel['idmateriel'] ?>">
                                <?php echo $materiel['nommateriel'] ?>
                              </option>
                            <?php } ?>
                            
                          </select>
                        </div>
                        
                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                          <label class="form-label" style="width: 30%">Quantite : </label>
                          <input type="number" class="form-control" name="quantite">
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Ajouter + </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
						</div>
          </div>
          
          <div class="container">  
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th>Reference</th>
                      <th>Nom</th>
                      <th>Unite</th>
                      <th>Nature</th>
                      <th class="text-end"> Quantite demande </th>
                      <th colspan="2"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($detail_besoins as $db){ ?>
                      <tr >
                        <td> <?php echo $db['idmateriel']; ?> </td>
                        <td> <?php echo $db['nommateriel']; ?> </td>
                        <td> <?php echo $db['nomunite']; ?> </td>
                        <td> <?php echo $db['nomnature']; ?> </td>
                        <td class="text-end"> <?php echo $db['qte']; ?> </td>
                        <td class="text-center text-muted" style="width: 5%"> <i data-feather="edit-3" data-bs-toggle="modal" data-bs-target="#updateMaterial<?php echo $db['idmateriel'];?>"></i></td>
                            <td class="text-center text-muted" style="width: 5%; "><a href="<?php echo site_url("index.php/back_office/BesoinController/deleteDetailBesoinCCtrl") ?>/<?php echo $idbesoin;?>/<?php  echo $db['iddetail']; ?>"><i data-feather="delete"></i></a></td>
                        </tr>
                                                    <!-- Modal -->
                <div class="modal fade" id="updateMaterial<?php echo $db['idmateriel'];?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"> Modifier  materiel </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <form action="<?php echo site_url("index.php/back_office/BesoinController/updateDetailBesoinCCtrl") ?>" method="POST">
                        <input type="hidden" name="idbesoin" value="<?php echo $idbesoin; ?>">
                        <input type="hidden" name="iddetail" value="<?php echo $db['iddetail'] ?>">
                        <div class="modal-body">
                            <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 30%">Produit : </label>
                            <div> <?php echo $db['nommateriel'];?></div>
                            </div>
                            
                            <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 30%">Quantite : </label>
                            <input type="number" class="form-control" name="quantite" placeholder="<?php echo $db['qte'];?>">
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Modifier + </button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
<!-- Modal -->
                    <?php } ?>
                    
                  </tbody>
                </table>
              </div>
          </div>
          <div class="card-footer">
            <form action="<?php echo site_url("index.php/back_office/BesoinController/saveBesoinCtrl") ?>" method="POST">
              <input type="hidden" name="idbesoin" value="<?php echo $idbesoin ?>">
              <button type="submit" class="btn btn-success"> Enregistrer </button>
            </form> 
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>