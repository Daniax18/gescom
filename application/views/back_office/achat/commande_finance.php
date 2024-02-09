

<script src="<?php echo base_url() ?>assets/back_office/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/back_office/js/print.js"></script>
<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Special pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Invoice</li>
					</ol>
				</nav>
        
<?php
if(isset($commandes) && $commandes !=null ){
for($k=0 ; $k < count($commandes) ;$k++){ 
   
    ?>


				<div class="row">
          
					<div class="col-md-12">

            <div class="card" id="card<?php echo $k;?>">
            
              <div class="card-body">
                <div class="container-fluid d-flex justify-content-between">
                  <div class="col-lg-3 ps-0">
                    <a href="#" class="noble-ui-logo d-block mt-3">GES<span>COM</span></a>                 
                    <p class="mt-1 mb-1"><b>Gescom Corp</b></p>
                    <p>108,<br> Great Russell St,<br>London, WC1B 3NA.</p>
                    <h5 class="mt-5 mb-2 text-muted">Bon de commande  to : Draft</h5>
                    <p><?php echo $commandes[$k][0]["responsable"]?><br> <?php echo $commandes[$k][0]["adresse"]?>,<br> <?php echo $commandes[$k][0]["email"]?> <br> <?php echo $commandes[$k][0]["contact"]?></p>
                  </div>
                  <div class="col-lg-3 pe-0">
                    <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2"></h4>
                    <h6 class="text-end mb-5 pb-4"># <?php echo $commandes[$k][0]["idboncommande"];?></h6>
                    <p class="text-end mb-1">Balance Due</p>
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
                          for($u =0 ; $u < count($commandes[$k]) ;$u++ ){ 
                            ?>
                             <input type="hidden" name=global[] value=<?php  echo $commandes[$k][$u]['idglobal'];?>>
                          <tr class="text-end">
                            <td ><?php echo $commandes[$k][$u]["nomnature"];?></td>
                            <td class="text-start"><?php echo $commandes[$k][$u]["nommateriel"];?></td>
                            <td><?php echo $commandes[$k][$u]["qte"];?></td>
                            <td ><?php echo $commandes[$k][$u]["nomunite"];?></td>
                            <td><?php echo $commandes[$k][$u]['pu'] ;?>Ar</td>
                            <td><?php echo $commandes[$k][$u]['montantht'] ;?>Ar</td>
                            <td><?php echo $commandes[$k][$u]['montantttc'] ;?>Ar</td>
                            
                          </tr>
                         
                          <?php  } ?>
                          <tr class="text-end">
                            <td class="text-start"></td>
                            <td ></td>
                            <td></td>
                            <td ></td>
                            <td></td>
                            <td>Total</td>
                            <td ><?php echo $commandes[$k][0]['total'];?>Ar</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
                
                <div class="container-fluid w-100">
                <br/>
                <br/>
                <span >Responsable ------------------------------------</span>
                    <span class="float-end">Fournisseur ------------------------------------</span>
                    <br/>
                <br/>
                    <?php if( $commandes[$k][0]['status']  == 0){?>
                      <form action="<?php echo site_url("index.php/back_office/BandcommandeController/validateCommande") ?>" method="POST">
                        <input type="hidden" name="commande" value="<?php echo $commandes[$k][0]["idboncommande"];?>">
                        <button type="submit" class="btn btn-success"> Valider B.C </button>
                      </form>

                  <?php } ?>
                </div>
              </div>
            </div>
					</div>
          </div>
        <br/>


                 
    <?php  } 
    
                          }?>

    </div>

   