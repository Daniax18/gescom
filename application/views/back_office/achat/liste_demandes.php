<div class="page-content">

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
        <li class="breadcrumb-item active" aria-current="page">DEMANDE ACHAT</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h3 class="text-start mb-3">Liste des demandes : </h3>
          </div>
          
          <div class="container">  
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th> Reference</th>
                      <th> Date besoin</th>
                      <th> Departement</th>
                      <th> Status</th>
                      <th> Progression </th>
                      <th> Appelant </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($besoins as $besoin){ ?>
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
                        <td class="text-center text-muted" style="width: 5%"> <a href="<?php echo site_url("index.php/back_office/BesoinController/listeDetailCtrl") ?>/<?php  echo $besoin['situation']; ?>/<?php echo $besoin['idbesoin']; ?>"><i data-feather="eye"></a></i></td>
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