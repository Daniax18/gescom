
<?php //var_dump($commande); ?>
<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Service Achat</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Apercu du Bon de Reception </li>
    </ol>
  </nav>
<?php
  if(isset($br)){ 
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
                <h4 class="mt-5 mb-2 text-muted">BON DE RECEPTION to : </h4>
                <p><?php echo $br["nomfournisseur"]?><br> <?php echo $br["adresse"]?>,<br> <?php echo $br["email"]?> <br> <?php echo $br["contact"]?></p>
              </div>
              <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                <h6 class="text-end mb-5 pb-4">Numero Bon de Reception : <b><?php echo $br["idbonreception"]; ?></b>  </h6>
                <p class="text-end mb-1"> Date du <?php echo $br["datereception"]; ?> </p>
                <h4 class="text-end fw-normal"></h4>
              </div>
            </div>

            <div style="padding: 2% 2% 2% 2%">
                Nous accusons reception par la présente Bon de Reception la liste des materiels ci-dessous :
            </div>
            
            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
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
            <div class="container-fluid w-100">
              <br/>
              <br/>
              <span >Receptioniste ------------------------------------</span>
                  <span class="float-end">Livreur ------------------------------------</span>
                  <br/>
              <br/>
                 
              </div>
            </div>
          </div>
        </div>
            <a href="javascript:;" onclick="print('#mycard')" class="btn btn-outline-primary float-right mt-4">
              <i data-feather="printer" class="me-2 icon-md"></i>Print
            </a>
          </div>           
      </div>
        <br/>      
      <?php 
    } ?>
</div>

   