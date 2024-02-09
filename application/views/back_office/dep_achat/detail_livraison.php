<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON LIVRAISON</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail B.L : </h3>
                        <?php if($bl['status_livraison'] < 0) { ?>
                            <a  data-bs-toggle="modal" data-bs-target="#add_detail_bl">
                                <button class="btn btn-outline-primary"> 
                                    Ajouter +
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/apercu_bl") ?>/<?php echo $bl['pathjustificatif'] ?>" target="_blank">
                                <button class="btn btn-outline-primary"> 
                                    Apercu PDF
                                </button>
                            </a>
                        <?php } ?>
                        
                    </div>

                    <div style="width: 25%">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td> Numero :</td>
                                <td> <b> <?php echo $bl['numerolivraison'] ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Fournisseur : </td>
                                <td> <b> <?php echo $bl['nomfournisseur'] ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Date : </td>
                                <td> <b> <?php echo $bl['datelivraison'] ?> </b> </td>
                            </tr>
                        </table>
                    </div>

                    <?php //var_dump($globals) ?>
                    <div class="container">  
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                            <thead>
                                <tr class="table-info">
                                <th> Reference </th>
                                <th> Designation </th>
                                <th> Quantite </th>
                                <th> Nom Unite</th>
                                <th> Remarque</th>                
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($details) && $details != null) { 
                                foreach($details as $detail){ 
                                    ?>
                                        <tr>
                                        <td> <?php echo $detail['idmateriel']; ?> </td>
                                        <td> <?php echo $detail['nommateriel']; ?> </td>
                                        <td> <?php echo $detail['qty_received']; ?> </td>
                                        <td> <?php echo $detail['nomunite']; ?> </td>
                                        <td> <?php echo $detail['remarque']; ?> </td>
                                        </tr>
                                    <?php 
                                    } 
                                } ?>
                                
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <?php if($bl['status_livraison'] < 0){ ?>
                    <div class="card-footer">
                        <a  data-bs-toggle="modal" data-bs-target="#add_pdf">
                            <button class="btn btn-outline-primary"> 
                                Enregistrer +
                            </button>
                        </a>
                    </div>
                <?php }else if($bl['status_livraison'] == 0){ ?>
                    <div class="card-footer">
                        <a  data-bs-toggle="modal" data-bs-target="#create_br">
                            <button class="btn btn-outline-primary"> 
                                Creer Bon Reception
                            </button>
                        </a>
                    </div>
                <?php } ?>
                
            </div>
        </div>
    </div>
    <!-- MODAL CREATION BON DE RECEPTION -->
    <div class="modal fade" id="create_br" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Verification avant creation Bon de Reception :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_achat/BonReceptionController/createBonReception") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Date Reception : </label>
                  <input type="date" class="form-control" name="datelivraison">
                </div>

                <input type="hidden" name="idlivraison" value="<?php echo $bl['idbonlivraison'] ?>">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                    <b class="form-b border border-1" style="width: 50%; padding: 2% 2% 2% 2%">Designation : </b>
                    <b class="form-b border border-1" style="width: 50%; padding: 2% 2% 2% 2%">Quantite recus : </b>
                </div>
                <?php foreach($details as $detail){ ?>
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                        <label class="form-label" style="width: 50%"><?php echo $detail['nommateriel'] ?> </label>
                        <input type="text" class="form-control" style="width: 50%" name="<?php echo $detail['idmateriel'] ?>" value="<?php echo $detail['qty_received'] ?>">
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Creer B.R  </button>
            </div>
            </form>
        </div>
      </div>
    </div>


        
    <!-- MODAL D'AJOUT JUSTIFICATION -->
    <div class="modal fade" id="add_pdf" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajouter scan du Bon Livraison :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/saveBonLivraison") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idbonlivraison" value="<?php echo $bl['idbonlivraison'] ?>">
                <div class="modal-body">
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                    <input type="file" name="file" id="file" accept=".pdf, .jpg, .jpeg, .png">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Enregister </button>
            </div>
            </form>
        </div>
      </div>
    </div>


    
    <!-- MODAL D'AJOUT DETAIL B.L -->
    <div class="modal fade" id="add_detail_bl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajoute produit :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/addDetailLivraison") ?>" method="POST">
              <div class="modal-body">
                <input type="hidden" name="idlivraison" value="<?php echo $bl['idbonlivraison'] ?>">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Materiel : </label>
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
                  <input type="number" class="form-control" name="qty">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Remarque : </label>
                  <input type="text" class="form-control" name="remarque">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Ajout + </button>
            </div>
            </form>
        </div>
      </div>
    </div>
