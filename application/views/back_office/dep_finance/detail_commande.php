<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON COMMANDE CLIENT A FACTURER</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail du Commande : </h3>
                        <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/apercu_commande") ?>/<?php echo $commande['pathjustificatif'] ?>" target="_blank">
                            <button class="btn btn-outline-primary"> 
                                Apercu PDF B.C Recu
                            </button>
                        </a>
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
                   
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <th> Reference </th>
                                        <th> Nom </th>
                                        <th> Quantity </th>
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
                <div class="card-footer">
                    <a  data-bs-toggle="modal" data-bs-target="#ask_request">
                        <button class="btn btn-outline-primary"> 
                            Facturer 
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE CREATION DEMANDE -->
    <div class="modal fade" id="ask_request" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Facturation Bon commande:  </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/facturationCommande") ?>" method="POST">
            <input type="hidden" name="idcommandeclient" value="<?php echo $commande['idcommandeclient'] ?>">
            <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Date Facturation : </label>
                  <input type="date" class="form-control" name="datecommande">
                </div>     
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Facturer </button>
              </div>
              </form>
        </div>
      </div>
    </div>
