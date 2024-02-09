<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> REGLE DE GESTION DES CONTROLES DE VOITURE </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">La liste des controles a faire pour chaque categories d'entretien : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Reference </th>
                        <th> Categorie </th>
                        <th> Detail  </th> 
                        <th> Tous les  </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($controles as $controle){ ?>
                        <tr >
                          <td> <?php echo $controle['id_controle_km']; ?> </td>
                          <td> <?php echo $controle['nomcategorie']; ?> </td>
                          <td> <strong> <?php echo $controle['nomdetail_categorie']; ?> </strong> </td>
                          <td> <?php echo $controle['nombre_km']; ?> km </td>
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
