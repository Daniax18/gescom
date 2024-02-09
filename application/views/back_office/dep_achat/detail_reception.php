<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON DE RECEPTION</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail B.RECEPTION : </h3>
                        <a href="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/apercu_bl") ?>/<?php echo $br['pathjustificatif'] ?>" target="_blank">
                            <button class="btn btn-outline-primary"> 
                                Apercu PDF B.Livraison
                            </button>
                        </a>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $br['idbonreception'] ?>  </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $br['datereception'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Fournisseur : </td>
                                    <td> <b> <?php echo $br['nomfournisseur'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Reference B.Livraison : </td>
                                    <td> <b> <?php echo $br['idbonlivraison'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <?php //var_dump($globals) ?>
                    <div class="container">  
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                    <th> Reference </th>
                                    <th> Designation </th>
                                    <th> Quantite sur Bon de Livraison </th>
                                    <th> Quantite Recu</th>
                                    <th> Nom Unite</th>     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($details) && $details != null) { 
                                    foreach($details as $detail){ 
                                        ?>
                                            <tr>
                                                <td> <?php echo $detail['idmateriel']; ?> </td>
                                                <td> <?php echo $detail['nommateriel']; ?> </td>
                                                <td> <?php echo $detail['qty_request']; ?> </td>
                                                <td> <?php echo $detail['qty_received']; ?> </td>
                                                <td> <?php echo $detail['nomunite']; ?> </td>
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

                <div class="card-footer">
                    <a  href="<?php echo site_url("index.php/back_office/dep_achat/BonReceptionController/printReception") ?>/<?php echo $br['idbonreception'] ?>">
                        <button class="btn btn-outline-primary"> 
                            Imprimer 
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
