<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DES INVENTAIRES </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent inventaire : </h3>
              <div class="d-flex flex-row justify-content-between" style="width: 40%">
                <a  data-bs-toggle="modal" data-bs-target="#download_xls">
                    <button class="btn btn-success"> 
                        <i class="mdi mdi-file-excel"></i> Imprimer model d'inventaire
                    </button>
                </a>

                <a  data-bs-toggle="modal" data-bs-target="#add_inventaire">
                    <button class="btn btn-outline-primary"> 
                        Creer inventaire
                    </button>
                </a>
              </div>
             
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Reference </th>
                        <th> Date inventaire </th>
                        <th> Responsable </th>
                        <th> Status </th>
                        <th> Progression </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($inventaires as $inventaire){ ?>
                        <tr >
                          <td> <?php echo $inventaire['idinventaire']; ?> </td>
                          <td> <?php echo $inventaire['dateinventaire']; ?> </td>
                          <td> <?php echo $inventaire['nom'] . " " . $inventaire['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $inventaire['status'][0]; ?></span></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $inventaire['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/getDetailInventaire") ?>/<?php echo $inventaire['idinventaire']; ?>">
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

      <!-- MODAL DE ENREGISTREMENT EXCEL -->
      <div class="modal fade" id="download_xls" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Telechargement du modele fichier Excel :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/downloadXls") ?>" method="POST">
                
                <div class="modal-body">
                    <div class="alert alert-info d-flex flex-column" role="alert">
                        <p> <i class="mdi mdi-information-variant"></i> 
                            Veuillez remplir le fichier Excel et l'enregister au format .csv afin de l'enregister dans la base
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Telecharger </button>
                </div>
            </form>
        </div>
      </div>
    </div>


    <!-- MODAL DE CREATION INVENTAIRE -->
    <div class="modal fade" id="add_inventaire" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Creer inventaire avec CSV   </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/InventaireController/createGeneralInventaire") ?>" method="POST" enctype="multipart/form-data">
                
                <div class="modal-body">
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                        <label class="form-label" style="width: 30%">Date Inventaire : </label>
                        <input type="date" class="form-control" name="dateinvetntaire">
                    </div>

                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                        <input type="file" name="file" id="file" accept=".csv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Enregistrer </button>
                </div>
            </form>
        </div>
      </div>
    </div>
