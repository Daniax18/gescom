<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES DISPATCHING</li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent bons de sorties : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#add_sortie">
                <button class="btn btn-outline-primary"> 
                  Creer Bon de sortie
                </button>
              </a>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Bon de sortie </th>
                        <th> Dept preneur </th>
                        <th> Date sortie </th> 
                        <th> Employee donneur </th>
                        <th> Sortie </th>
                        <th> Progression </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($sorties as $sortie){ ?>
                        <tr >
                          <td> <?php echo $sortie['idbonsortie']; ?> </td>
                          <td> <?php echo $sortie['nomdepartement']; ?> </td>
                          <td> <?php echo $sortie['datesortie']; ?> </td>
                          <td> <?php echo $sortie['nom'] . " " . $sortie['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $sortie['status'][0]; ?></span></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $sortie['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/getDetailSortie") ?>/<?php echo $sortie['idbonsortie']; ?>">
                              <i data-feather="eye"> </i>
                            </a>
                          </td>
                        </tr>
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

    <!-- MODAL DE CREATION B.E -->
    <div class="modal fade" id="add_sortie" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Fabrication Dispatching  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/createBonSortie") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date Sortie : </label>
                  <input type="date" class="form-control" name="datesortie">
                </div>
              

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Dept preneur : </label>
                  <select class="form-select form-select-sm mb-3" name="iddepartement">
                    <?php foreach($departements as $departement){ ?>
                      <option value="<?php echo $departement['iddepartement'] ?>">
                        <?php echo $departement['nomdepartement'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Fabriquer + </button>
              </div>
            </form>
        </div>
      </div>
    </div>
