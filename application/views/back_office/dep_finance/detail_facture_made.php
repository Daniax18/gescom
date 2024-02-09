<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL FACTURE ENVOYE</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail Facture : </h3>
                        <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/apercu_pdf_facture") ?>/<?php echo $facture['pathfacture'] ?>" target="_blank">
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
                                    <td> <b> <?php echo $facture['idfacturation'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $facture['date_facturation'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Client : </td>
                                    <td> <b> <?php echo $facture['name_company'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Responsable : </td>
                                    <td> <b> <?php echo $facture['responsable_customer'] ?> </b> </td>
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
                                        <th> Prix Unitaire HT </th>
                                        <th> Montant HT </th>
                                        <th> Montant TTC </th>               
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
                                                <td> Ar <?php echo number_format( $detail['unit_price_ht'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_ht'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_ttc'], 2, ',', ' '); ?> </td>
                                            </tr>
                                        <?php 
                                        } 
                                    } ?>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td colspan="5" class="text-end"><b> Total Montant </b> </td>
                                        <td> <b> Ar <?php echo number_format($total['ht'], 2, ',', ' '); ?> </b></td>
                                        <td> <b> Ar <?php echo number_format($total['ttc'], 2, ',', ' '); ?> </b></td>
                                    <tr>
                                </tfooter>  
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>