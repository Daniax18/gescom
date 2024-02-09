
<?php 
    $nom_cat = '';
    $nom_detail = '';
    if($entretiens != null && count($entretiens) > 0){
        $nom_cat = $entretiens[0]['nomcategorie'];
        $nom_detail = $entretiens[0]['nomdetail_categorie'];
    }
?>


<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DE REPARATION  / ENTRETIEN DE LA VOITURE  </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Entretien de la voiture : <b> <?php echo $voiture['matricule'] ?> </b> sur "<?php echo $nom_cat . ' -> ' . $nom_detail ?>" </h3>
            </div>
            <div class="d-flex flex-row justify-content-between">
                <div style="width: 25%">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td> Codification : </td>
                            <td> <b> <?php echo $voiture['code'] ?> </b> </td>
                        </tr>
                        <tr>
                            <td> Kilometrage :</td>
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
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Date  </th>
                        <th> Type </th>
                        <th> Kilometrage enregistre</th>
                        <th> Prix </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php if($entretiens != null){ 
                        foreach($entretiens as $entretien){ ?>
                            <tr class="">
                                <td>  <?php echo $entretien['date_entretien'] ?>  </td>
                                <td>  <?php echo $entretien['nom_entretien'] ?>  </td> 
                                <td>  <?php echo $entretien['kilometrage'] ?> km </td>
                                <td><strong> Ar <?php echo $entretien['prix_entretien'] ?> </strong></td>
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