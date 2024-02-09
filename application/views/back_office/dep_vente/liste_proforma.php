<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> MARKETING & VENTE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES DEMANDES DE PROFORMA DES CLIENTS</li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent demande de proforma de nos clients: </h3>
              <a  data-bs-toggle="modal" data-bs-target="#addBl">
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
                        <th> Date Retour </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($proformas as $proforma){ ?>
                        <tr >
                          <td> <?php echo $proforma['numeroproforma']; ?> </td>
                          <td> <?php echo $proforma['date_proforma_client_received']; ?> </td>
                          <td> <?php echo $proforma['name_company']; ?> </td>
                          <td> <?php echo $proforma['nom'] . " " . $proforma['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $proforma['status'][0]; ?></span></td>
                          <td>
                              <div class="progress">
                                  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $proforma['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                          </td>
                          <td> <?php echo $proforma['date_proforma_client_send']; ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_vente/ProformaClientController/getDetailProformaClient") ?>/<?php echo $proforma['idproformaclient']; ?>">
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

    <!-- MODAL DE CREATION PROFORMA -->
    <div class="modal fade" id="addBl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Reception Demande de proforma :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_vente/ProformaClientController/createProformaClient") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 60%">Date Demande : </label>
                  <input type="date" class="form-control" name="dateproforma">
                </div>
                
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 60%">Numero document : </label>
                  <input type="text" class="form-control" name="numero">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 60%"> Client : </label>
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