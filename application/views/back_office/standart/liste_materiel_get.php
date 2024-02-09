<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> MATERIEL </a></li>
          <li class="breadcrumb-item active" aria-current="page"> ENTREE MATERIEL </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent reception materiels : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Bon de sortie </th>
                        <th> Date sortie </th> 
                        <th> Employee donneur </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($received != null){
                        foreach($received as $sortie){ 
                            $details = $this -> BonSortie -> getDetailSortie($sortie['idbonsortie']);
                            ?>
                            <tr >
                            <td> <?php echo $sortie['idbonsortie']; ?> </td>
                            <td> <?php echo $sortie['datesortie']; ?> </td>
                            <td> <?php echo $sortie['nom'] . " " . $sortie['prenom']; ?> </td>
                            <td class="text-center text-muted" style="width: 5%"> 
                                <a  data-bs-toggle="modal" data-bs-target="#search<?php echo $sortie['idbonsortie'] ?>">
                                    <i data-feather="eye"> </i>
                                </a>
                            </td>
                            </tr>
                            <!-- MODALL -->
                            <div class="modal fade" id="search<?php echo $sortie['idbonsortie'] ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle"> Detail des marchandises : </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex flex-row justify-content-between">
                                                <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> <b> Designation </b> </div>
                                                <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> <b> Qty </b> </div>
                                                <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> <b> Unite </b> </div>
                                            </div>
                                            <?php foreach($details as $detail){ ?>
                                                <div class="d-flex flex-row justify-content-between">
                                                    <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> 
                                                        <?php echo $detail['nommateriel'] ?>
                                                    </div>
                                                    <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> 
                                                        <?php echo $detail['qty_leave'] ?>
                                                    </div>
                                                    <div class ="border border-1 text-center" style="width: 33%; padding: 2% 2% 2% 2%"> 
                                                        <?php echo $detail['nomunite'] ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php 
                                          if($sortie['status_sortie'] == 0){ ?>
                                          <form action="<?php echo site_url("index.php/back_office/BesoinController/makeReceptionMateriel") ?>" method="POST">
                                              <input type="hidden" name="idbonsortie" value="<?php echo $sortie['idbonsortie'] ?>">
                                              <div class="modal-footer">
                                                  <button type="submit" class="btn btn-primary">
                                                      Receptionner
                                                  </button>
                                              </div>
                                          </form>
                                          <?php } else{ ?>
                                            <button disabled class="btn btn-success">
                                                Recu
                                            </button>
                                          <?php }
                                        ?>
                                       
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                             
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>