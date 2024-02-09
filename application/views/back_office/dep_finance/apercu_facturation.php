
<?php //var_dump($commande); ?>
<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">SERVICE FINANCE</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Apercu du FACTURE a renvoye </li>
    </ol>
  </nav>
<?php
  if(isset($facture)){ 
    // var_dump($details);
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
                <h4 class="mt-5 mb-2 text-muted">FACTURE to : </h4>
                <p><?php echo $facture["name_company"]?><br> <?php echo $facture["adresse_customer"]?>,<br> <?php echo $facture["email_customer"]?> <br> <?php echo $facture["numero_customer"]?></p>
              </div>
              <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                <h6 class="text-end mb-5 pb-4">Numero : <b><?php echo $facture["idfacturation"]; ?></b>  </h6>
                <p class="text-end mb-1"> Date facture : <?php echo $facture["date_facturation"]; ?> </p>
                <h4 class="text-end fw-normal"></h4>
              </div>
            </div>
            
            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
                <table class="table table-bordered">
                  <thead class="text-center">
                      <tr class="table-info">
                      <th> Ref </th>
                      <th style="width: 10%"> Designation </th>
                      <th> PU Ht </th>
                      <th style="width: 8%"> Qty </th>
                      <th> Unite</th>
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
                                  <td class = "text-end"> Ar <?php echo number_format($detail['unit_price_ht']  , 2, ',', ' '); ?>  </td>
                                  <td> <?php echo $detail['qty_request']; ?> </td>
                                  <td> <?php echo $detail['nomunite']; ?> </td>
                                  <td class = "text-end"> Ar <?php echo number_format($detail['montant_ht'] , 2, ',', ' '); ?>  </td>
                                  <td class = "text-end"> Ar <?php echo number_format($detail['montant_ttc'] , 2, ',', ' '); ?>  </td>
                              </tr>
                          <?php 
                          } 
                      } ?>  
                  </tbody>
                  <tfooter>
                    <td colspan="5" class = "text-end"> <b>Total</b> </td>
                    <td class = "text-end"> <b> Ar <?php echo number_format($total['ht'], 2, ',', ' '); ?> </b> </td>
                    <td class = "text-end"> <b> Ar <?php echo number_format($total['ttc'], 2, ',', ' '); ?> </b> </td>
                  </tfooter>
                </table>
            </div> 
            <div style="padding: 2% 2% 2% 2%">
                Arrêter la présente Facture à la somme de Ariary  
                  <b>  <?php echo strtoupper($this -> Bandcommande -> chiffreEnLettre($total['ttc'])); ?> 
                   (<?php echo number_format($total['ttc'], 2, ',', ' ') ?>)
                  </b> TTC.
            </div>
            <div class="container-fluid w-100">
              <br/>
              <br/>
              <span >Service Comptabilite ------------------------------------</span>
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
              <h5 class="modal-title" id="exampleModalCenterTitle">Inserer facture scan pdf:   </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/saveFacturePdf") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idfacturation" value="<?php echo $facture['idfacturation'] ?>">
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

   