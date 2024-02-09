<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON DE LIVRAISON ENVOYE</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail Bon de Livraison : </h3>
                        <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonLivraisonClientController/apercu_pdf_bon_livraison") ?>/<?php echo $livraison['path_livraison'] ?>" target="_blank">
                            <button class="btn btn-outline-primary"> 
                                Apercu PDF
                            </button>
                        </a>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $livraison['idlivraisonclient'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $livraison['date_livraison'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Client : </td>
                                    <td> <b> <?php echo $livraison['name_company'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Responsable : </td>
                                    <td> <b> <?php echo $livraison['responsable_customer'] ?> </b> </td>
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
                                        <th> Quantite </th>
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
            </div>
        </div>
    </div>