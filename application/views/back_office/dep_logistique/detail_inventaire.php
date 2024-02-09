<?php 
$user = $this->session->userdata('user_data');
?>


<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL INVENTAIRE </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail de l'inventaire : </h3>
                        <?php if($last_inventaire != null){ ?>
                            <span> Dernier inventaire: <b> <?php echo $last_inventaire['dateinventaire'] ?> </b> </span>
                        <?php } ?>      
                                         
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $inventaire['idinventaire'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $inventaire['dateinventaire'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Responsable : </td>
                                    <td> <b> <?php echo $inventaire['nom'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Status : </td>
                                    <td> <b> <?php echo $inventaire['status'][0] ?> </b> </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <?php //var_dump($globals) ?>
                    <div class="container">  
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info text-center">
                                        <th> Reference </th>
                                        <th> Designation </th>
                                        <th> Nom Unite</th>
                                        <th> Qty Inventaire</th>
                                        <?php if(($inventaire['status_inventaire'] == 1 && $user['privilege'] == 1)){ ?>
                                            <th > 
                                                Ecart 
                                            </th>
                                            <th style="width: 5%"> 
                                          
                                            </th>
                                        <?php } ?>    
                                            
                                        <?php if($inventaire['status_inventaire'] == 0 || ($inventaire['status_inventaire'] == 1 && $user['privilege'] == 1)){ ?>
                                            <th style="width: 5%"></th>
                                        <?php } ?>        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($details) && $details != null) { 
                                    foreach($details as $detail){ 
                                        $ecart = $this -> Ecart -> getMaterielEcart($detail['idmateriel'], $inventaire['idinventaire']);
                                        $last_qty_inventaire = $this -> Ecart -> getMaterielEcart($detail['idmateriel'], $last_inventaire['idinventaire']);
                                        $entries = $this -> Stock -> get_entries_between_dates($detail['idmateriel'], $last_inventaire['dateinventaire'], $inventaire['dateinventaire']);
                                        $sorties = $this -> Stock -> get_sorties_between_dates($detail['idmateriel'], $last_inventaire['dateinventaire'], $inventaire['dateinventaire']);
                                        ?>
                                            <tr>
                                                <td> <?php echo $detail['idmateriel']; ?> </td>
                                                <td> <?php echo $detail['nommateriel']; ?> </td>
                                                <td class="text-center"> <?php echo $detail['nomunite']; ?> </td>
                                                <td class="text-end">  <?php echo number_format( $detail['qty_inventaire'], 2, ',', ' '); ?></td>
                                                <!-- VERIFICATION ECART AVEC DETAIL -->
                                                <?php if(($inventaire['status_inventaire'] == 1 && $user['privilege'] == 1)){ ?>
                                                    <td class="text-end" style="color : <?php echo $ecart['color'] ?>"> 
                                                        <?php echo number_format( $ecart['qty_ecart'], 2, ',', ' '); ?> 
                                                    </td>
                                                    <td>
                                                        <a  data-bs-toggle="modal" data-bs-target="#flux<?php echo $detail['iddetail_inventaire']; ?>">
                                                            <i class="link-icon" data-feather="eye" style="color: blue"></i>
                                                        </a>
                                                    </td>
                                                <?php } ?> 
                                            
                                                    <!-- BOUTON DE MODIFICATION -->
                                                <?php if($inventaire['status_inventaire'] == 0 || ($inventaire['status_inventaire'] == 1 && $user['privilege'] == 1)){ ?>
                                                    <td>
                                                        <a  data-bs-toggle="modal" data-bs-target="#modify<?php echo $detail['iddetail_inventaire']; ?>">
                                                            <i class="link-icon" data-feather="edit-3" style="color: green"></i>
                                                        </a>
                                                    </td>
                                                <?php } ?>
                                            </tr>

                                            <!-- MODAL DE VISIONNAGE FLUX -->
                                            <div class="modal fade" id="flux<?php echo $detail['iddetail_inventaire']; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle"> Flux du materiel : <?php echo $detail['nommateriel'] ?>  </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                            
                                                        <div class="modal-body">
                                                            <!-- STOCK INITIAL -->
                                                            <h6 class="text-muted mb-3"> Stock initial (Dernier Inventaire) </h6>
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Date
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Unite
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Qty
                                                                </div>
                                                            </div>

                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    <?php echo $last_inventaire['dateinventaire'] ?>
                                                                </div>
                                                                <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Unity
                                                                </div>
                                                                <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                <b> <?php echo number_format( $last_qty_inventaire['qty_inventaire'], 2, ',', ' '); ?> </b>
                                                                </div>
                                                            </div>
                                                        
                                                                <!-- STOCK ENTREE -->
                                                                <h6 class="text-muted mb-3 mt-4"> Listes entrees : </h6>
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Date
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Unite
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Qty
                                                                </div>
                                                            </div>

                                                            <?php foreach($entries as $entre){ ?>
                                                                <div class="d-flex flex-row justify-content-between">
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                        <?php echo $entre['dateentree'] ?>
                                                                    </div>
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                        Unity
                                                                    </div>
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    <b> <?php echo number_format( $entre['quantity'], 2, ',', ' '); ?> </b>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                                <!-- STOCK SORTIES -->
                                                                <h6 class="text-muted mb-3 mt-4"> Listes sorties : </h6>
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Date
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Unite
                                                                </div>
                                                                <div class="border border-2 text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    Qty
                                                                </div>
                                                            </div>

                                                            <?php foreach($sorties as $sortie){ ?>
                                                                <div class="d-flex flex-row justify-content-between">
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                        <?php echo $sortie['datesortie'] ?>
                                                                    </div>
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                        Unity
                                                                    </div>
                                                                    <div class="text-center" style="width:33%; padding: 2% 2% 2% 2%">
                                                                    <b> <?php echo number_format( $sortie['quantity'], 2, ',', ' '); ?> </b>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary"> Fermer </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- MODAL MODIFICATION INVENTAIRE -->
                                            <div class="modal fade" id="modify<?php echo $detail['iddetail_inventaire']; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle"> Modifier detail inventaire :  </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                        </div>
                                                        
                                                        <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/modifyDetailInventaire") ?>" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="inventaire" value="<?php echo $inventaire['idinventaire'] ?>">
                                                                <input type="hidden" name="iddetail_inventaire" value="<?php echo $detail['iddetail_inventaire'] ?>">
                                                                <input type="hidden" name="idmateriel" value="<?php echo $detail['idmateriel'] ?>">

                                                                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                                    <label class="form-label" style="width: 30%">Produit : </label>
                                                                    <input type="text" class="form-control" value="<?php echo $detail['nommateriel']; ?>" readonly>
                                                                </div>
                                                                
                                                                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                                    <label class="form-label" style="width: 30%">Quantite : </label>
                                                                    <input type="number" class="form-control" name="qty" value="<?php echo $detail['qty_inventaire']; ?>">
                                                                </div>

                                                                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                                    <label class="form-label" style="width: 30%">Remarque : </label>
                                                                    <input type="text" class="form-control" name="remarque" value="<?php echo $detail['remarque']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary"> Modifier + </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } 
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- DEMANDE DE VALIDATION -->
                <?php if($inventaire['status_inventaire'] == 0){ ?>
                    <div class="card-footer">
                        <a  data-bs-toggle="modal" data-bs-target="#verification_save">
                            <button class="btn btn-outline-primary"> 
                                Demande validation +
                            </button>
                        </a>
                    </div>

                    <!-- CHEF DEPARTEMENT -> validation / reverification -->
                <?php }else if($inventaire['status_inventaire'] == 1 && $user['privilege'] == 1){ ?>
                    <div class="card-footer d-flex flex-row justify-content-between" style="width: 40%">
                        <a  data-bs-toggle="modal" data-bs-target="#validation">
                            <button class="btn btn-outline-primary"> 
                                <i class="link-icon" data-feather="upload"></i> Valider inventaire
                            </button>
                        </a>

                        <a  data-bs-toggle="modal" data-bs-target="#reverification">
                            <button class="btn btn-outline-danger"> 
                                <i class="link-icon" data-feather="refresh-ccw"></i> Reverification inventaire
                            </button>
                        </a>
                    </div>
                <?php }  ?>
            </div>
        </div>
    </div>

    
    <!-- MODAL DE VALIDATION -->
    <div class="modal fade" id="validation" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> Valider cette inventaire ?  </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                
                <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/validateInventaire") ?>" method="POST">
                    <input type="hidden" name="inventaire" value="<?php echo $inventaire['idinventaire'] ?>">
                    <div class="modal-body">
                        <div class="alert alert-info d-flex flex-column" role="alert">
                            <p> <i class="link-icon" data-feather="info"></i>
                                Controle des ecarts de materiels disponible.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Valider </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE DEMANDE DE REVERIFICATION -->
    <div class="modal fade" id="reverification" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"> Demande de reverification de cette inventaire ?  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                
                <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/reverifyInventaire") ?>" method="POST">
                <input type="hidden" name="inventaire" value="<?php echo $inventaire['idinventaire'] ?>">
                    <div class="modal-body">
                        <div class="alert alert-info d-flex flex-column" role="alert">
                            <p> <i class="link-icon" data-feather="info"></i>
                                Une fois cette demande de reverification envoye, vous devez attendre que l'inventaire soit a nouveau re-enregistrer afin de la valider.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Demander reverification </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- MODAL D'ENREGISTREMENT INVENTAIRE -->
    <div class="modal fade" id="verification_save" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Faire une demande de validation aupres du Chef ?  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/saveInventaire") ?>" method="POST">
            <input type="hidden" name="inventaire" value="<?php echo $inventaire['idinventaire'] ?>">
                <div class="modal-body">
                    <div class="alert alert-info d-flex flex-column" role="alert">
                        <p><i class="link-icon" data-feather="info"></i>
                            Une fois cette demande envoye, vous ne pourrez plus modifier les details, sauf en cas de devalidation du Chef de Departement.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Demander </button>
                </div>
            </form>
        </div>
      </div>
    </div>


