<div class="page-content">
    <nav class="page-breadcrumb d-flex flex-row justify-content-between">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
            <li class="breadcrumb-item active" aria-current="page">DETAIL BON DE SORTIE</li>
        </ol>
        <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/getDetailSortie") ?>/<?php echo $sortie['idbonsortie'] ?>" 
            class="btn btn-outline-success"    
        >
                Rafraichir 
        </a>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> Detail Bon de sortie : </h3>
                        
                        <?php if($sortie['status_sortie'] < 0) { ?>
                            <a  data-bs-toggle="modal" data-bs-target="#add_detail_so">
                                <button class="btn btn-outline-primary"> 
                                    Ajouter +
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/apercu_bs") ?>/<?php echo $sortie['pathjustificatif'] ?>" target="_blank">
                                <button class="btn btn-outline-primary"> 
                                    Pdf Bon sortie
                                </button>
                            </a>
                        <?php } ?>
                        
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Numero :</td>
                                    <td> <b> <?php echo $sortie['idbonsortie'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Date : </td>
                                    <td> <b> <?php echo $sortie['datesortie'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 25%">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td> Departement preneur : </td>
                                    <td> <b> <?php echo $sortie['nomdepartement'] ?> </b> </td>
                                </tr>
                                <tr>
                                    <td> Employe donneur : </td>
                                    <td> <b> <?php echo $sortie['nom'] ?> </b> </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if(isset($error)) { ?>
                            <div class="alert alert-danger d-flex flex-row justify-content-between mt-2" role="alert">
                                <div>
                                    <i data-feather="alert-circle"></i>
                                    Materiel non disponible en stock
                                </div>
                                
                                <table class="table table-borderless table-sm" style="width: 50%">
                                    <thead>
                                        <tr>
                                            <th>Materiel</th>
                                            <th>Reste</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td><?php echo $error['materiel']; ?></td>
                                                <td><?php echo $error['left']; ?></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>


                    <?php //var_dump($globals) ?>
                    <div class="container">  
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                    <th> Reference </th>
                                    <th> Designation </th>
                                    <th> Quantite </th>
                                    <th> Nom Unite</th>
                                    <th> Remarque</th>                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($details) && $details != null) { 
                                    foreach($details as $detail){ 
                                        ?>
                                            <tr>
                                            <td> <?php echo $detail['idmateriel']; ?> </td>
                                            <td> <?php echo $detail['nommateriel']; ?> </td>
                                            <td> <?php echo $detail['qty_leave']; ?> </td>
                                            <td> <?php echo $detail['nomunite']; ?> </td>
                                            <td> <?php echo $detail['remarque']; ?> </td>
                                            </tr>
                                        <?php 
                                        } 
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <?php if($sortie['status_sortie'] < 0){ ?>
                        <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/printBonSortie") ?>/<?php echo $sortie['idbonsortie'] ?>" 
                            class="btn btn-outline-success"    
                        >
                                Apercu Bon Sortie 
                        </a>
                    <?php }  ?>
                </div>
                
            </div>
        </div>
    </div>

    
    <!-- MODAL D'AJOUT DETAIL B.Entree -->
    <div class="modal fade" id="add_detail_so" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Ajouter produit :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_logistique/BonSortieController/addDetailSortie") ?>" method="POST">
              <div class="modal-body">
                <input type="hidden" name="idbonsortie" value="<?php echo $sortie['idbonsortie'] ?>">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Materiel : </label>
                  <select class="form-select form-select-sm mb-3" name="idmateriel" onchange="updateStock(this)">
                    <?php foreach($materiels as $materiel){ ?>
                      <option value="<?php echo $materiel['idmateriel'] ?>">
                        <?php echo $materiel['nommateriel'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 40%" >Quantite en stock : </label>
                  <input type="number" class="form-control" id="stockQuantity" style="width: 50%; margin-right: 2%" readonly>
                  <input type="text" class="form-control" id="unityField" style="width: 30%" readonly>
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Quantite need: </label>
                  <input type="number" class="form-control" name="qty">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Remarque : </label>
                  <input type="text" class="form-control" name="remarque">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> Ajout + </button>
            </div>
            </form>
        </div>
      </div>
    </div>

    <script>
        function updateStock(selectElement) {
            var selectedId = selectElement.value;
            var xhr = new XMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Status ok");
                        console.log(xhr.responseText);  
                        var responseData = JSON.parse(xhr.responseText);
                        
                        document.getElementById('stockQuantity').value = responseData.stockQuantity; // Update stock quantity
                        document.getElementById('unityField').value = responseData.unityValue; // Update unity field
                    } else {
                        console.log("Error");
                    }
                }
            };

            xhr.open("GET", "../getEtatStock?id=" + selectedId, true);
            xhr.send();
        }
    </script>
