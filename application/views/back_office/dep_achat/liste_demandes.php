<div class="page-content">

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> SERVICE ACHAT </a></li>
        <li class="breadcrumb-item active" aria-current="page"> LISTE DES BESOINS DES DEPARTEMENTS </li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h3 class="text-start mb-3">Liste des demandes de cette semaine : </h3>
            <a href="<?php echo site_url("index.php/back_office/dep_achat/BesoinController/groupeBesoinsCtrl") ?>">
                <button class="btn btn-primary"> Grouper demandes </button>
            </a>

          </div>
          
          <div class="container">  
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th> Reference</th>
                      <th> Date besoin</th>
                      <th> Departement</th>
                      <th> Status </th>
                      <th> Progression </th>
                      <th> Appelant </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $this -> load -> model('back_office/achat/Besoin');
                    foreach($besoins as $besoin){ 
                        $list_materiels = $this -> Besoin -> getBesoinDetail($besoin['idbesoin']);
                        ?>
                      <tr >
                        <td> <?php echo $besoin['idbesoin']; ?> </td>
                        <td> <?php echo $besoin['date']; ?> </td>
                        <td> <?php echo $besoin['nomdepartement']; ?> </td>
                        <td> <span class="badge rounded-pill bg-info"> <?php echo $besoin['status'][0]; ?></span></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $besoin['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td> <?php echo $besoin['nom'] .' '. $besoin['prenom'] ?> </td>
                        <td class="text-center text-muted" style="width: 5%"> 
                            <a href="" data-bs-toggle="modal" data-bs-target="#voirDetail<?php echo $besoin['idbesoin']  ?>">
                                <i data-feather="eye"></i>
                            </a>
                        </td>
                      </tr>

                    <!-- MODAL DE DETAIL -->
                    <div class="modal fade" id="voirDetail<?php echo $besoin['idbesoin']  ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalCenterTitle"> Besoin du departement <?php echo $besoin['nomdepartement']; ?> </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                          </div>

                          <div class="modal-body">
                              <div class="d-flex flex-row justify-content-between mb-3">
                                  <div class="text-center border border-2" style="width: 33%">
                                      <h4>Materiels</h4>
                                  </div>
                                  <div class="text-center border border-2" style="width: 33%">
                                      <h4>Nature</h4> 
                                  </div>
                                  <div class="text-center border border-2" style="width: 33%">
                                      <h4>Quantite</h4> 
                                  </div>
                              </div>

                              <?php foreach($list_materiels as $materiels) { ?>
                                  <div class="d-flex flex-row justify-content-between mb-3">
                                      <div class="text-start" style="width: 33%">
                                          <?php echo $materiels['nommateriel'] ?>
                                      </div>
                                      <div class="text-center" style="width: 33%">
                                          <?php echo $materiels['nomnature'] ?>
                                      </div>
                                      <div class="text-center" style="width: 33%">
                                          <?php echo $materiels['qte'] ?>
                                      </div>
                                  </div>
                                  <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>

                    <?php 
                    
                } 
                
                ?>
                    
                  </tbody>
                </table>
              </div>
                    </div>
        </div>
      </div>
    </div>
  </div>
</div>