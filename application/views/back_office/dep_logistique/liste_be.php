<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES BONS D'ENTRES </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent bons d'entrees : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#addBl">
                <button class="btn btn-outline-primary"> 
                  Creer Bon d'Entree
                </button>
              </a>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Bon d'entree </th>
                        <th> Ref Bon de Reception </th>
                        <th> Date B.Reception </th> 
                        <th> Fournisseur </th>
                        <th> Enregistreur </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($bes as $be){ ?>
                        <tr >
                          <td> <?php echo $be['idbonentree']; ?> </td>
                          <td> <?php echo $be['idbonreception']; ?> </td>
                          <td> <?php echo $be['dateentree']; ?> </td>
                          <td> <?php echo $be['nomfournisseur']; ?> </td>
                          <td> <?php echo $be['nom'] . " " . $be['prenom']; ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonEntreeController/getDetailEntree") ?>/<?php echo $be['idbonentree']; ?>">
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
    <div class="modal fade" id="addBl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Fabrication Bon d'Entree : </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/BonEntreeController/createBonEntree") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 70%">Date Entree : </label>
                  <input type="date" class="form-control" name="dateentree">
                </div>
              

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 70%">Reference B.Reception : </label>
                  <select class="form-select form-select-sm mb-3" name="idbonreception">
                    <?php foreach($brs as $br){ ?>
                      <option value="<?php echo $br['idbonreception'] ?>">
                        <?php echo $br['idbonreception'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Enregistrer + </button>
              </div>
            </form>
        </div>
      </div>
    </div>
