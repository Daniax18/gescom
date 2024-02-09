<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> MARKETING & VENTE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES BONS DE COMMANDES DES CLIENTS</li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent Bon de Commandes de nos clients : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#add_bc">
                <button class="btn btn-outline-primary"> 
                  Reception Demande
                </button>
              </a>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Numero </th>
                        <th> Date Profroma </th> 
                        <th> Company </th>
                        <th> Enregistreur </th>
                        <th> Status </th>
                        <th> Progression </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($commandes as $commande){ ?>
                        <tr >
                          <td> <?php echo $commande['numerocommande']; ?> </td>
                          <td> <?php echo $commande['date_commande_client_received']; ?> </td>
                          <td> <?php echo $commande['name_company']; ?> </td>
                          <td> <?php echo $commande['nom'] . " " . $commande['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $commande['status'][0]; ?></span></td>
                          <td>
                              <div class="progress">
                                  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $commande['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                          </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_vente/CommandeClientController/getDetailCommandeClient") ?>/<?php echo $commande['idcommandeclient']; ?>">
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

    <!-- MODAL DE CREATION COMMANDE -->
    <div class="modal fade" id="add_bc" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Reception Bon de Commande :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_vente/commandeClientController/createcommandeClient") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date Demande : </label>
                  <input type="date" class="form-control" name="datecommande">
                </div>
                
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Numero document : </label>
                  <input type="text" class="form-control" name="numero">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%"> Client : </label>
                  <select class="form-select form-select-sm mb-3" name="idcustomer">
                    <?php foreach($customers as $customer){ ?>
                      <option value="<?php echo $customer['idcustomer'] ?>">
                        <?php echo $customer['name_company'] ?>
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