
<?php //var_dump($commande); ?>
<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">SERVICE LOGISTIQUE</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Apercu du FACTURE a renvoye </li>
    </ol>
  </nav>
<?php
  if(isset($livraison)){ 
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
                <h4 class="mt-5 mb-2 text-muted">BON DE LIVRAISON to : </h4>
                <p><?php echo $livraison["name_company"]?><br> <?php echo $livraison["adresse_customer"]?>,<br> <?php echo $livraison["email_customer"]?> <br> <?php echo $livraison["numero_customer"]?></p>
              </div>
              <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                <h6 class="text-end mb-5 pb-4">Numero : <b><?php echo $livraison["idlivraisonclient"]; ?></b>  </h6>
                <p class="text-end mb-1"> Date Livraison : <?php echo $livraison["date_livraison"]; ?> </p>
                <h4 class="text-end fw-normal"></h4>
              </div>
            </div>
            
            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
                <table class="table table-bordered">
                  <thead class="text-center">
                      <tr class="table-info">
                      <th> Ref </th>
                      <th style="width: 40%"> Designation </th>
                      <th style="width: 8%"> Qty </th>
                      <th> Unite</th>
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
          
            <div class="container-fluid w-100">
              <br/>
              <br/>
              <span >Service Livraison ------------------------------------</span>
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
      <?php } ?>
</div>

    <!-- MODAL D'AJOUT JUSTIFICATION -->
    <div class="modal fade" id="add_pdf" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Inserer Bon de Livraison scan pdf:   </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/BonLivraisonClientController/saveBonLivraisonPdf") ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idlivraisonclient" value="<?php echo $livraison['idlivraisonclient'] ?>">
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

   