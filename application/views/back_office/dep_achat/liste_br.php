<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES BONS DE RECEPTION </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent bons de receptions : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref B.Reception </th>
                        <th> Date B.Reception </th> 
                        <th> Fournisseur </th>
                        <th> Enregistreur </th>
                        <th> Status </th>
                        <th> Progression </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($brs as $br){ ?>
                        <tr >
                          <td> <?php echo $br['idbonreception']; ?> </td>
                          <td> <?php echo $br['datereception']; ?> </td>
                          <td> <?php echo $br['nomfournisseur']; ?> </td>
                          <td> <?php echo $br['nom'] . " " . $br['prenom']; ?> </td>
                          <td> <span class="badge rounded-pill bg-info"> <?php echo $br['status'][0]; ?></span></td>
                          <td>
                              <div class="progress">
                                  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $br['status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                          </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_achat/BonReceptionController/getDetailReception") ?>/<?php echo $br['idbonreception']; ?>">
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

