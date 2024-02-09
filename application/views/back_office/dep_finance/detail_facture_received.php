<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL FACTURE RECU</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail Facture : </h3>
                        <?php if($fr['status_facture'] < 0) { ?>
                            <a  data-bs-toggle="modal" data-bs-target="#add_detail_fr">
                                <button class="btn btn-outline-primary"> 
                                    Ajouter +
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/apercu_fr") ?>/<?php echo $fr['pathjustificatif'] ?>" target="_blank">
                                <button class="btn btn-outline-primary"> 
                                    Apercu PDF
                                </button>
                            </a>
                        <?php } ?>
                        
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $fr['numerofacture'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $fr['datefacture'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Fournisseur : </td>
                                    <td> <b> <?php echo $fr['nomfournisseur'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Reference B.Commande : </td>
                                    <td> <b> <?php echo $fr['idboncommande'] ?> </b> </td>
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
                                                <td> <?php echo $detail['qty_received']; ?> </td>
                                                <td> <?php echo $detail['nomunite']; ?> </td>
                                                <td> Ar <?php echo number_format( $detail['unit_price'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_detail_ht'], 2, ',', ' '); ?> </td>
                                                <td> Ar <?php echo number_format( $detail['montant_detail_ttc'], 2, ',', ' '); ?> </td>
                                            </tr>
                                        <?php 
                                        } 
                                    } ?>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td colspan="5" class="text-end"> Total Montant </td>
                                        <td> Ar <?php echo number_format($fr['montant_ht_facture'], 2, ',', ' '); ?> </td>
                                        <td> Ar <?php echo number_format($fr['montant_ttc_facture'], 2, ',', ' '); ?> </td>
                                    <tr>
                                </tfooter>  
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <?php if($fr['status_facture'] < 0){ ?>
                    <div class="card-footer">
                        <a  data-bs-toggle="modal" data-bs-target="#add_pdf">
                            <button class="btn btn-outline-primary"> 
                                Enregister +
                            </button>
                        </a>
                    </div>
                <?php } ?> 
            </div>
        </div>
    </div>

        
    <!-- MODAL D'AJOUT JUSTIFICATION -->
    <div class="modal fade" id="add_pdf" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajouter scan de la FACTURE : <b><?php echo $fr['numerofacture'] ?></b>  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/saveFactureReceived") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idfacturereceived" value="<?php echo $fr['idfacturereceived'] ?>">
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


    
    <!-- MODAL D'AJOUT DETAIL FACTURE RECU -->
    <div class="modal fade" id="add_detail_fr" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajoute produit :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/addFactureReceivedDetail") ?>" method="POST">
              <div class="modal-body">
                <input type="hidden" name="idfacturereceived" value="<?php echo $fr['idfacturereceived'] ?>">
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
