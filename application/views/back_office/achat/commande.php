
<?php //var_dump($commande); ?>
<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Service Achat</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Bon de commande crees </li>
    </ol>
  </nav>
<?php
  if(isset($commande) && count($commande) > 0 ){ 
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
                <h4 class="mt-5 mb-2 text-muted">Bon de commande  to : </h4>
                <p><?php echo $commande[0]["nomfournisseur"]?><br> <?php echo $commande[0]["adresse"]?>,<br> <?php echo $commande[0]["email"]?> <br> <?php echo $commande[0]["contact"]?></p>
              </div>
              <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                <h6 class="text-end mb-5 pb-4">Numero B.C: <b><?php echo $commande[0]["idboncommande"];?></b>  </h6>
                <p class="text-end mb-1"> Date du <?php echo $commande[0]["datecommande"];?> </p>
                <h4 class="text-end fw-normal"></h4>
              </div>
            </div>
            
            <div class="container-fluid mt-5 d-flex justify-content-center w-100">
              <div class="table-responsive w-100">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-end">Nature</th>
                        <th>Nom materiel</th>
                        <th class="text-end">Quantite</th>
                        <th class="text-end">Unite</th>
                        <th class="text-end">Prix unitaire HT</th>
                        <th class="text-end">TOTAL HT</th>
                        <th class="text-end">TOTAL TTC</th>   
                      </tr>
                    </thead>
                    
                    <tbody>
                    
                      <?php 
                      for($u =0 ; $u < count($commande) ;$u++ ){ ?>
                          <input type="hidden" name=global[] value=<?php  echo $commande[$u]['idglobal']; ?>>
                      <tr>
                        <td ><?php echo $commande[$u]["nomnature"];?></td>
                        <td class="text-start"><?php echo $commande[$u]["nommateriel"];?></td>
                        <td><?php echo $commande[$u]["qte"];?></td>
                        <td ><?php echo $commande[$u]["nomunite"];?></td>
                        <td> Ar <?php echo number_format($commande[$u]['pu'], 2, ',', ' '); ?></td>
                        <td> Ar <?php echo number_format($commande[$u]['montantht'], 2, ',', ' ') ;?></td>
                        <td> Ar <?php echo number_format($commande[$u]['montantttc'], 2, ',', ' ') ;?></td>
                      </tr>
                      
                      <?php  } ?>
                      <tr class="text-end">
                        <td class="text-start"></td>
                        <td ></td>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td>Total</td>
                        <td><b> Ar <?php echo number_format($commande[0]['total'], 2, ',', ' ') ;?> </b> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
            <div style="padding: 2% 2% 2% 2%">
                Arrêter la présente Bon de commande à la somme de Ariary  
                  <b>  <?php echo strtoupper($this -> Bandcommande -> chiffreEnLettre($commande[0]['total'])); ?> 
                   (<?php echo number_format($commande[0]['total'], 2, ',', ' ') ?>) 
                  </b> TTC
            </div>
            
            <div class="container-fluid w-100">
              <br/>
              <br/>
              <span >Responsable ------------------------------------</span>
                  <span class="float-end">Fournisseur ------------------------------------</span>
                  <br/>
              <br/>
                 
              </div>
            </div>
          </div>
        </div>
        <?php if( $commande[0]['status']  == 2){?>
          <div class="d-flex flex-row justify-content-between" style="width: 50%; margin-right: auto;margin-left:auto">
            <form action="<?php echo site_url("index.php/back_office/SendMail/sendDemandeCommande")?>" method="POST">
              <input type="hidden" name="name" value="<?php echo $commande[0]["idboncommande"]?>">
              <input type="hidden" name="email" value="<?php echo $commande[0]["email"]?>">
              <button type="submit" class="btn btn-primary float-end mt-4 ms-2"><i data-feather="send" class="me-3 icon-md"></i>Send command</button>
            </form>  
              <a href="javascript:;" onclick="print('#mycard')" class="btn btn-outline-primary float-right mt-4">
                <i data-feather="printer" class="me-2 icon-md"></i>Print
              </a>
          </div>           
          <?php } ?>
      </div>
        <br/>      
      <?php 
    } ?>
</div>

   