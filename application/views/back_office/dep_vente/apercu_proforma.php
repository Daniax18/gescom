
<?php //var_dump($commande); ?>
<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">MARKETING & VENTE</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Apercu du Proforma a renvoye </li>
    </ol>
  </nav>
<?php
  if(isset($proforma)){ 
    //var_dump($commande);
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card" id="mycard">
          <div class="card-body">
            <div class="container-fluid d-flex justify-content-between">
              <div class="col-lg-3 ps-0">
                <a href="#" class="noble-ui-logo d-block mt-3">GES<span>COM</span></a>                 
                <p class="mt-1 mb-1"><b>Gescom Corp</b></p>
                <p>108,<br> Great Russell St,<br>London, WC1B 3NA.</p>
                <h4 class="mt-5 mb-2 text-muted">FACTURE PROFORMA : </h4>
                <p><?php echo $proforma["name_company"]?><br> <?php echo $proforma["adresse_customer"]?>,<br> <?php echo $proforma["email_customer"]?> <br> <?php echo $proforma["numero_customer"]?></p>
              </div>
              <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                <h6 class="text-end mb-5 pb-4">Reference du demande : <b><?php echo $proforma["numeroproforma"]; ?></b>  </h6>
                <p class="text-end mb-1"> Date du <?php echo $proforma["date_proforma_client_received"]; ?> </p>
                <h4 class="text-end fw-normal"></h4>
              </div>
            </div>
            
            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
                <table class="table table-bordered">
                  <thead>
                      <tr class="table-info">
                      <th> Reference </th>
                      <th> Designation </th>
                      <th> PU Ht </th>
                      <th> Nom Unite</th> 
                      <th> Qty demande </th>
                      <th> Qty dispo </th>
                      <th> Montant Ht </th>
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
                                  <td> Ar <?php echo number_format( $detail['unit_price_ht'], 2, ',', ' '); ?> </td>
                                  <td> <?php echo $detail['qty_request']; ?> </td>
                                  <td> <?php echo $detail['qty_in_stock']; ?> </td>
                                  <td> <?php echo $detail['nomunite']; ?> </td>
                                  <td> Ar <?php echo number_format( $detail['montant_ht'], 2, ',', ' '); ?> </td>
                                  <td> Ar <?php echo number_format( $detail['montant_ttc'], 2, ',', ' '); ?> </td>
                              </tr>
                          <?php 
                          } 
                      } ?>  
                  </tbody>
                  <tfooter>
                    <td colspan="6" class="text-end"> <b>Total</b> </td>
                    <td> <b> Ar <?php echo number_format($total['ht'], 2, ',', ' '); ?> </b> </td>
                    <td> <b> Ar <?php echo number_format($total['ttc'], 2, ',', ' '); ?> </b> </td>
                  </tfooter>
                </table>
            </div> 
            <div style="padding: 2% 2% 2% 2%">
                Arrêter la présente Facture Proforma à la somme de Ariary  
                  <b>  <?php echo strtoupper($this -> Bandcommande -> chiffreEnLettre($total['ttc'])); ?> 
                   (<?php echo number_format($total['ttc'], 2, ',', ' ') ?>)
                  </b> TTC, facture proforma valable jusqu'en <b><?php echo $proforma["date_proforma_client_last"]; ?></b> 
            </div>
            <div class="container-fluid w-100">
              <br/>
              <br/>
              <span >Service Commercial ------------------------------------</span>
                  <span class="float-end">Client ------------------------------------</span>
                  <br/>
              <br/>
                 
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex flex-row justify-content-between" style="width: 50%; margin-left:auto; margin-right:auto">
              <a href="javascript:;" onclick="print('#mycard')" class="btn btn-outline-primary float-right mt-4">
                <i data-feather="printer" class="me-2 icon-md"></i> Imprimer
              </a>
              <a  data-bs-toggle="modal" data-bs-target="#add_pdf">
                <button class="btn btn-outline-primary float-right mt-4">
                  <i data-feather="navigation" class="me-2 icon-md"></i> Envoyer
                </button>
              </a>
            </div>
        </div>
      </div>           
    </div>
        <br/>      
      <?php 
    } ?>
</div>

    <!-- MODAL D'AJOUT JUSTIFICATION -->
    <div class="modal fade" id="add_pdf" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajouter scan du Profroma a envoyer :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_vente/ProformaClientController/envoyerProforma") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idproformaclient" value="<?php echo $proforma['idproformaclient'] ?>">
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

   