<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES BONS DE LIVRAISON</li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent bons de livraisons : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#addBl">
                <button class="btn btn-outline-primary"> 
                  Creer B.L
                </button>
              </a>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Numero </th>
                        <th> Ref B.C </th>
                        <th> Date B.L </th> 
                        <th> Fournisseur </th>
                        <th> Enregistreur </th>
                        <th> Status </th>
                        <th> Progression </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($bls as $bl){ ?>
                        <tr >
                          <td> <?php echo $bl['numerolivraison']; ?> </td>
                          <td> <?php echo $bl['idboncommande']; ?> </td>
                          <td> <?php echo $bl['datelivraison']; ?> </td>
                          <td> <?php echo $bl['nomfournisseur']; ?> </td>
                          <td> <?php echo $bl['nom'] . " " . $bl['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $bl['status'][0]; ?></span></td>
                          <td>
                              <div class="progress">
                                  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $bl['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                          </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/getDetailLivraison") ?>/<?php echo $bl['idbonlivraison']; ?>">
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

    <!-- MODAL DE CREATION B.L -->
    <div class="modal fade" id="addBl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Reception Bon de Livraison:  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_achat/BonLivraisonController/createBonLivraison") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date livraison : </label>
                  <input type="date" class="form-control" name="datelivraison">
                </div>
                
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Numero document : </label>
                  <input type="text" class="form-control" name="numero">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Reference B.C : </label>
                  <select class="form-select form-select-sm mb-3" name="idcommande">
                    <option value=""> Aucun Bon Commande </option>
                    <?php foreach($commande_sent as $commande){ ?>
                      <option value="<?php echo $commande['idboncommande'] ?>">
                        <?php echo $commande['idboncommande'] ?>
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