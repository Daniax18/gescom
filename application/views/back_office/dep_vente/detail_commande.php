<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> MARKETING & VENTE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON COMMANDE CLIENT</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail du Commande : </h3>
                        <?php if($commande['status_commande_client'] < 0) { ?>
                            <a  data-bs-toggle="modal" data-bs-target="#add_detail_commande">
                                <button class="btn btn-outline-primary"> 
                                    Ajouter +
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/apercu_commande") ?>/<?php echo $commande['pathjustificatif'] ?>" target="_blank">
                                <button class="btn btn-outline-primary"> 
                                    Apercu PDF Recu
                                </button>
                            </a>
                        <?php } ?>
                        
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $commande['numerocommande'] ?>  </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $commande['date_commande_client_received'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Client : </td>
                                    <td> <b> <?php echo $commande['name_company'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Responsable Client : </td>
                                    <td> <b> <?php echo $commande['responsable_customer'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php //var_dump($error) ?>
                    <div class="container">  
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger d-flex flex-row justify-content-between mt-2" role="alert">
                                <div>
                                    <i data-feather="alert-circle"></i>
                                    Quelques materiels ne sont plus disponibles ces demandes
                                </div>
                                
                                <table class="table table-borderless table-sm" style="width: 50%">
                                    <thead>
                                        <tr>
                                            <th>Materiel</th>
                                            <th>Reste</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($error as $er){ ?>
                                            <tr>
                                                <td><?php echo $er['materiel']; ?></td>
                                                <td><?php echo $er['qty_lack']; ?></td>
                                            </tr>
                                        <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <th> Reference </th>
                                        <th> Nom </th>
                                        <th> Qty request </th>
                                        <th> Nom Unite </th>
                                        <th> unit_price_ht </th> 
                                        <th> montant_ht </th>      
                                        <th> montant_ttc </th>         
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($details) && $details != null) { 
                                    foreach($details as $detail){ 
                                        ?>
                                            <tr>
                                                <td> <?php echo $detail['idmateriel']; ?> </td>
                                                <td> <?php echo $detail['nommateriel']; ?> </td>
                                                <td> <?php echo number_format( $detail['qty_request'], 0, ',', ' '); ?> </td>
                                                <td> <?php echo $detail['nomunite']; ?> </td>
                                                <td> Ar <?php echo number_format( $detail['unit_price_ht'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_ht'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_ttc'], 2, ',', ' '); ?> </td>
                                            </tr>
                                        <?php 
                                        } 
                                    } ?>              
                                </tbody>
                                <tfooter>
                                    <td colspan="5" class="text-end"> <b>Total</b> </td>
                                    <td> <b> Ar <?php echo number_format( $total['ht'], 2, ',', ' '); ?> </b> </td>
                                    <td> <b> Ar <?php echo number_format( $total['ttc'], 2, ',', ' '); ?> </b> </td>
                                </tfooter>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <?php if($commande['status_commande_client'] < 0){ ?>
                    <div class="card-footer">
                        <a  data-bs-toggle="modal" data-bs-target="#add_pdf">
                            <button class="btn btn-outline-primary"> 
                                Enregister +
                            </button>
                        </a>
                    </div>
                <?php } else if($commande['status_commande_client'] == 0) { ?>
                    <div class="card-footer">
                        <form action="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/sendToDepartement") ?>" method="post">
                            <input type="hidden" name="idcommandeclient" value="<?php echo $commande['idcommandeclient'] ?>">
                            <button class="btn btn-outline-primary" type="submit"> 
                                Envoi vers Dept concerne
                            </button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- MODAL DE CREATION DEMANDE -->
    <div class="modal fade" id="ask_request" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Envoyer la reponse de cette demande ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/sendReponse") ?>" method="POST">
            <input type="hidden" name="idcommandeclient" value="<?php echo $commande['idcommandeclient'] ?>">
            <div style="padding: 3% 3% 3% 3%">
              <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
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
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajouter scan du Bon de Commande :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/saveCommandeClient") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idcommandeclient" value="<?php echo $commande['idcommandeclient'] ?>">
                <div class="modal-body">
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                    <input type="file" name="file" id="file" accept=".pdf, .jpg, .jpeg, .png">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Enregistrer </button>
            </div>
            </form>
        </div>
      </div>
    </div>
 
    <!-- MODAL D'AJOUT DETAIL COMMANDE CLIENT -->
    <div class="modal fade" id="add_detail_commande" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajoute produit :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/addDetailCommandeClient") ?>" method="POST">
              <div class="modal-body">
                <input type="hidden" name="idcommandeclient" value="<?php echo $commande['idcommandeclient'] ?>">
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
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Ajout + </button>
            </div>
            </form>
        </div>
      </div>
    </div>
