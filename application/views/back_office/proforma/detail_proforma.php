<?php 
$dep = 'DEP3';
if ($status >50){ ?>
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> PROFORMA </a></li>
            <li class="breadcrumb-item active" aria-current="page">DEMANDE PROFORMA</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                <h3 class="text-start mb-3">  vos Proformas  </h3>
                            </div>
            </div>


            

            <div class="container">  
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                    <thead>
                        <tr class="table-info">
                        <th>Reference</th>
                        <th>Nom</th>
                        <th>Unite</th>
                        <th>Nature</th>
                        <th>Prix unitaire</th>
                        <th class="text-end"> Quantite  </th>
                        <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($detail_proformas as $db){ ?>
                        <tr >
                            <td> <?php echo $db['idmateriel']; ?> </td>
                            <td> <?php echo $db['nommateriel']; ?> </td>
                            <td> <?php echo $db['nomunite']; ?> </td>
                            <td> <?php echo $db['nomnature']; ?> </td>
                            <td> <?php echo $db['pu']; ?> </td>
                            <td class="text-end"> <?php echo $db['qte']; ?> </td>
                            <?php  $user = $this->session->userdata('user_data'); 
                        if($user['iddepartement'] == $dep){
                        ?>
                            <td class="text-center text-muted" style="width: 5%"> <i data-feather="edit-3" data-bs-toggle="modal" data-bs-target="#updateMaterial<?php echo $db['idmateriel'];?>"></i></td>
                            <td class="text-center text-muted" style="width: 5%; "><a data-bs-toggle="modal" data-bs-target="#delete" href="#"><i data-feather="delete"></i></a></td>
                                                   <!-- MODAL DE VERIFICATION -->
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"> Voulez vous vraiment  suprimer ? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
          </div>
          <form action="<?php echo site_url("index.php/back_office/ProformaReceivedController/deleteDetailProformaCtrl") ?>/<?php echo $status;?>/<?php echo $idproforma;?>/<?php  echo $db['iddetail']; ?>" method="POST">
            <div style="padding: 3% 3% 3% 3%">
              <button type="submit" class="btn btn-primary" style="margin-left:45%"> Oui </button>
            </div>   
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
                        </tr>

                                                    <!-- Modal -->
                <div class="modal fade" id="updateMaterial<?php echo $db['idmateriel'];?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"> Modifier  materiel </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <form action="<?php echo site_url("index.php/back_office/ProformaReceivedController/updateDetailProformaCtrl") ?>" method="POST">
                        <input type="hidden" name="idproforma" value="<?php echo $idproforma; ?>">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                        <input type="hidden" name="iddetail" value="<?php echo $db['iddetail'] ?>">
                        <div class="modal-body">
                            <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 30%">Produit : </label>
                            <div> <?php echo $db['nommateriel'];?></div>
                            </div>
                            <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 30%">Prix unitaire : </label>
                            <input type="number" class="form-control" name="pu" placeholder="<?php echo $db['pu'];?>">
                            </div>
                            <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 30%">Quantite : </label>
                            <input type="number" class="form-control" name="quantite" placeholder="<?php echo $db['qte'];?>">
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Modifier + </button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
<!-- Modal -->
                        <?php } ?>
                        
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
            </div>
            
            </div>
        </div>
        </div>
    </div>
</div>
<?php
} else{
    redirect(site_url("index.php/back_office/ProformaReceivedController/proforma"));
}
?>