<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DE REPARATION / ENTRETIEN DE LA VOITURE </li>
      </ol>
  </nav>
  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">La liste des controles de la voiture : <b> <?php echo $voiture['matricule'] ?> </b> </h3>
                <button 
                    class="btn btn-outline-primary"
                    data-bs-toggle="modal" 
                    data-bs-target="#addEntretien"
                > 
                    Ajouter entretien
                </button>
            </div>
            <?php if(isset($status)) { ?>
                <div class="alert alert-danger d-flex flex-row justify-content-between mt-2" role="alert">
                   <?php echo $status ?>
                </div>
            <?php } ?>
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
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Categorie </th>
                        <th> Detail  </th> 
                        <th> Type </th>
                        <th> Date  </th>
                        <th> Kilometrage </th>
                        <th> Prochain controle </th>
                        <th> Prix </th>
                        <th>  </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php if($entretiens != null){ 
                        foreach($entretiens as $entretien){ ?>
                            <tr class="">
                                <td> <?php echo $entretien['nomcategorie'] ?> </td>
                                <td> <strong> <?php echo $entretien['nomdetail_categorie'] ?> </strong> </td> 
                                <td>  <?php echo $entretien['nom_entretien'] ?>  </td>
                                <td>  <?php echo $entretien['date_entretien'] ?>  </td>
                                <td>  <?php echo $entretien['kilometrage'] ?> km </td>
                                <td>  <?php echo $entretien['next_controle'] ?> km </td>
                                <td><strong> Ar <?php echo $entretien['prix_entretien'] ?> </strong></td>
                                <td class="text-center text-muted" style="width: 5%"> 
                                    <a 
                                        href="<?php echo site_url("index.php/back_office/dep_logistique/EntretienController/getDetailCategorieVoiture/" . $voiture['idvoiture'] . '/' . $entretien['iddetail_categorie']) ?>">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                     } ?>
                    </tbody>
                  </table>
                  <a 
                    href="<?php echo site_url('index.php/back_office/dep_logistique/EntretienController/getEntetienVoiture?id_voiture=' . $voiture['idvoiture']) ?>" 
                    class="mt-4">
                    <button 
                        class="btn btn-outline-success mt-4"
                    > 
                        Refresh
                    </button>
                  </a>
                  
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

     <!-- MODAL AJOUT ENTRETIEN-->
    <div class="modal fade" id="addEntretien" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> Enregistrer un nouveau entretien </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="<?php echo site_url("index.php/back_office/dep_logistique/EntretienController/saveEntretien") ?>" method="POST">
                    <input type="hidden" name="id_voiture" value="<?php echo $voiture['idvoiture']; ?>">
                    <div class="modal-body">
                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 40%">Categorie : </label>
                            <select class="form-select form-select-sm mb-3" name="idcategorie" id="categorySelect">
                                <?php foreach($categories as $categorie){ ?>
                                    <option value="<?php echo $categorie['idcategorie'] ?>">
                                        <?php echo $categorie['nomcategorie'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 40%"> Detail  : </label>
                            <select class="form-select form-select-sm mb-3" name="iddetail" id="detailSelect">
                                <!-- Options will be populated dynamically using JavaScript -->
                            </select>
                        </div>

                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 40%">Type d'entretien : </label>
                            <select class="form-select form-select-sm mb-3" name="id_entretien">
                                <?php foreach($type_entretien as $entretien){ ?>
                                    <option value="<?php echo $entretien['id_type_entretien'] ?>">
                                        <?php echo $entretien['nom_entretien'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 40%">Kilometrage : </label>
                            <input type="number" class="form-control" name="kilometrage">
                        </div>

                        <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                            <label class="form-label" style="width: 40%">Prix : </label>
                            <input type="number" class="form-control" name="prix">
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Enregistrer + </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>


  <script>
    document.getElementById('categorySelect').addEventListener('change', function() {
        var categoryId = this.value;
        var detailSelect = document.getElementById('detailSelect');
        
        // Clear existing options
        detailSelect.innerHTML = '';

        // Make XHR request to fetch details based on selected category
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var details = JSON.parse(xhr.responseText);
                    details.forEach(function(detail) {
                        var option = document.createElement('option');
                        option.value = detail.iddetail_categorie;
                        option.textContent = detail.nomdetail_categorie;
                        detailSelect.appendChild(option);
                    });
                } else {
                    console.error('XHR request failed');
                }
            }
        };

        xhr.open('GET', 'getDetailsByCategorie?id=' + categoryId, true);
        xhr.send();
    });
</script>