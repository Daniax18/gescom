<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DE REPARATION / HISTPRIQUE </li>
      </ol>
  </nav>
  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="align-items-center mb-3">
              <h3 class="text-start mb-3"> Historique de deplacement : <b> <?php echo $voiture['matricule'] ?> </b> </h3>
                
                <div class="d-flex flex-row justify-content-between">
                    <div style="width: 25%">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td> Codification : </td>
                                <td> <b> <?php echo $voiture['code'] ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Kilometrage enregistres :</td>
                                <td> <b> <?php echo $voiture['last'] ?> </b> km </td>
                            </tr>
                        </table>
                    </div>

                    <div style="width: 25%">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td> Modele : </td>
                                <td> <b> <?php echo $voiture['nommodele'] ?> </b> </td>
                            </tr>
                            <tr>
                                <td> Marque : </td>
                                <td> <b> <?php echo $voiture['nommarque'] ?> </b> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Date debut </th>
                        <th> Date fin </th>
                        <th> Employee  </th> 
                        <th> Departement </th>
                        <th> Distance  </th>
                        <th> Motif </th>
                        
                      </tr>
                    </thead>
                    <tbody>
                     <?php if($historiques != null){ 
                        foreach($historiques as $historique){ ?>
                            <tr class="">
                                <td> <?php echo $historique['debut'] ?> </td>
                                <td>  <?php echo $historique['fin'] ?> </td> 
                                <td>  <?php echo $historique['nom'] . ' ' . $historique['prenom'] ?>  </td>
                                <td>  <?php echo $historique['nomdepartement'] ?> </td>
                                <td> <strong> <?php echo $historique['distance'] ?> km </strong> </td>
                                <td>  <?php echo $historique['motif'] ?> </td>
                            </tr>
                        <?php }
                     } ?>
                    </tbody>
                  </table>  
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
