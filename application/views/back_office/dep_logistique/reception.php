

    <div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page"> ACTIVITE DES VOITURES </li>
        </ol>
    </nav>
    <?php if(isset($error) && $error != null) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Alert!</strong> <?php echo $error; ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                      <h3 class="text-start mb-3"> Activites de nos vehicules  : </h3>
                      
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-info text-center">
                                          
                                  <th style="width: 10%"> Code </th>
                                  <th style="width: 10%"> matricule </th>
                                  <th  style="width: 5%"> modele </th>
                                  <th style="width: 8%"> marque </th>
                                  <th style="width: 5%"> consommation</th>
                                  <th style="width: 5%" > Rest km </th> 
                                  <th style="width: 5%" colspan="3"> Action </th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                              
                                if(isset($pv) && $pv != null) { 
                                  foreach($pv as $detail){ ?>
                                        <tr>
                                            <td> <?php echo $detail['code']; ?> </td>
                                            <td> <strong> <?php echo $detail['matricule']; ?> </strong> </td>
                                            <td> <?php echo $detail['nommodele']; ?> </td>
                                            <td> <strong> <?php echo $detail['nommarque']; ?> </strong> </td>
                                            <td class = "text-end"> <?php echo number_format($detail['consommation'] , 2, ',', ' '); ?> L/100   </td>
                                            <td>
                                                  <div class="alert alert-secondary d-flex flex-column" role="alert">
                                                    <?php if($detail['reste_kilometre'] < 20){ ?>
                                                      <p> <b> <?php echo $detail['reste_kilometre'];?>km</b> <i class="link-icon" style="color: red; fill: red" data-feather="flag"></i></p>
                                                      <?php }else{ ?>
                                                        <p> <b>  <?php echo $detail['reste_kilometre'];?> km</b> </p>
                                                    <?php  } ?>
                                                  </div>
                                                </td>
                                                 
                                            <td>
                                                <a 
                                                    href="<?php echo site_url("index.php/back_office/dep_logistique/EntretienController/getHistoriqueVoiture/" . $detail['idvoiture']) ?>"
                                                >
                                                
                                                    <button class="btn btn-outline-primary"> 
                                                        Voir historique
                                                    </button>
                                                </a>
                                            </td>

                                            <td>
                                                <a  data-bs-toggle="modal" data-bs-target="#ask_use<?php echo $detail['idvoiture'];?>">
                                                    <button class="btn btn-outline-primary"> 
                                                            Utiliser
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                                                                    <!-- MODAL DE CREATION DEMANDE -->
                                            <div class="modal fade" id="ask_use<?php echo $detail['idvoiture'];?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/insert") ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Employee : </label>
                                                        <select name="idemployee"  class="form-control">
                                                          <?php  foreach($employee as $emp){  ?>
                                                          <option value="<?php echo $emp['idemployee']?>"><?php echo $emp['prenom']?></option>
                                                          <?php } ?>
                                                        </select>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="idvoiture" value="<?php echo $detail['idvoiture']; ?>">
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Debut Kilometrage : </label>
                                                          <input type="text" class="form-control" name="debut_kilometrage" required>
                                                        </div>   
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Fin Kilometrage : </label>
                                                          <input type="text" class="form-control" name="fin_kilometrage" required>
                                                        </div>    
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Date Debut : </label>
                                                          <input type="datetime-local" class="form-control" name="debut" required>
                                                        </div>   
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Date Fin : </label>
                                                          <input type="datetime-local" class="form-control" name="fin" required>
                                                        </div>  
                                                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                                                          <label class="form-label" style="width: 50%">Motif: </label>
                                                          <textarea id="monChampTextarea" name="motif" rows="10" cols="50" required></textarea>
                                                        </div>   
                                        
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="submit" class="btn btn-primary" id="submitForm" > Utiliser </button>
                                                      </div>
                                                      </form>
                                                </div>
                                              </div>
                                            </div>



                                        <?php 
                                        } 
                                    } ?>              
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




   