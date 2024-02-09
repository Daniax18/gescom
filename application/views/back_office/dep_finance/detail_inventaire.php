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
                                        <th > 
                                            Ecart 
                                        </th>
                                        <th > 
                                            Valeur Perte 
                                        </th>
                                        <th style="width: 5%"> 
                                        
                                        </th>  
                                                   
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

                                                <td class="text-end" style="color : <?php echo $ecart['color'] ?>"> 
                                                    <b>  <?php echo number_format( $ecart['qty_ecart'], 2, ',', ' '); ?>   </b>
                                                </td>
                                                <td class="text-end" style="color : <?php echo $ecart['color'] ?>"> 
                                                    <b> Ar <?php echo number_format( $ecart['value_ecart'], 2, ',', ' '); ?>  </b>
                                                </td>
                                                <td>
                                                    <a  data-bs-toggle="modal" data-bs-target="#flux<?php echo $detail['iddetail_inventaire']; ?>">
                                                        <i class="link-icon" data-feather="eye" style="color: blue"></i>
                                                    </a>
                                                </td>
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
                                                                    <b> <?php echo number_format( $last_qty_inventaire['qty_inventaire'], 2, ',', ' '); ?>  </b>
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
                                                                    <b><?php echo number_format( $entre['quantity'], 2, ',', ' '); ?> </b>
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
                                                                    <b>  <?php echo number_format( $sortie['quantity'], 2, ',', ' '); ?> </b>
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
                                        <?php } 
                                    } ?>
                                    <tr>
                                        <td colspan="5" class="text-end"> 
                                            <b> Total ecart </b>
                                        </td>
                                        <td class="text-end" style="color: <?php echo $inventaire['color'] ?>">
                                            <b> Ar <?php echo number_format( $inventaire['valeurEcart'], 2, ',', ' '); ?>  </b>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    