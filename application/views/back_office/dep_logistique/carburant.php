
<!-- <?php var_dump($carburant);?> -->
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">HISTORIQUE CARBURANT</li>
        </ol>
    </nav>
    <?php if(isset($error) && $error != null) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Alert!</strong> <?php echo $error; ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
<!-- header -->

                <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Matricule de la voiture : <b> <?php echo $voiture['matricule'] ?> </b> </h3>
            </div>
            <div class="d-flex flex-row justify-content-between">
                <div style="width: 25%">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td> Codification : </td>
                            <td> <b> <?php echo $voiture['code'] ?> </b> </td>
                        </tr>
                    </table>

                </div>

                <div class="d-flex flex-row justify-content-between" style ="width: 30%">
                <a  data-bs-toggle="modal" data-bs-target="#ask_carburant">
                    <button class="btn btn-outline-primary"> 
                            Ajouter Carburant
                    </button>
                </a>
              </div>
            </div>
<!-- header -->
                   
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">

                                <thead>
                                    <tr class="table-info">
                                    
                      <th style="width: 10%"> matricule </th>
                      <th> date </th>
                      <th> employee </th>
                      <th style="width: 10%"> station </th>
                      <th> litre </th>
                      <th> Prix/litre </th>
                      <th> Prix Total </th>
                      <th> Consommation / 100 </th>
                      <th style="width: 8%"> + km </th>
                      <th> km total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($carburant) && $carburant != null) { 
                                    foreach($carburant as $detail){ 
                                        ?>
                                            <tr>
                                           
                                  <td> <?php echo $detail['matricule']; ?> </td>
                                  <td> <?php echo $detail['date']; ?> </td>
                                  <td> <?php echo $detail['nom']; ?> </td>
                                  <td> <?php echo $detail['nomstation']; ?> </td>
                                  <td> <?php echo $detail['litre']; ?> </td>
                                  <td>AR <?php echo number_format($detail['prix'] , 2, ',', ' '); ?>  </td>
                                  <td>AR <?php echo number_format($detail['prixTotal'] , 2, ',', ' '); ?>  </td>
                                  <td>L <?php echo number_format($detail['consommation'] , 2, ',', ' '); ?>  </td>
                                  <td class = "text-end"> +KM <?php echo number_format($detail['kilometre'] , 2, ',', ' '); ?>  </td>
                                  <td class = "text-end"> KM <?php echo number_format($detail['kilometreTotal'] , 2, ',', ' '); ?>  </td>
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

            </div>
        </div>
    </div>


           <!-- MODAL DE CREATION AJOUT CARBURANT-->
           <div class="modal fade" id="ask_carburant" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/insertCarburant") ?>" method="POST">
            <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Employee : </label>
                 <select name="idemployee"  class="form-control">
                  <?php  foreach($employee as $emp){  ?>
                  <option value="<?php echo $emp['idemployee']?>"><?php echo $emp['prenom']?></option>
                  <?php } ?>
                 </select>
                </div>
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Station : </label>
                 <select name="idstation"  class="form-control">
                  <?php  foreach($station as $emp){  ?>
                  <option value="<?php echo $emp['idstation']?>"><?php echo $emp['nomstation']?></option>
                  <?php } ?>
                 </select>
                </div>
                <input type="hidden" class="form-control" name="idvoiture" value="<?php echo $voiture['idvoiture']; ?>">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">litre : </label>
                  <input type="text" class="form-control" name="litre" required>
                </div>     
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Date  : </label>
                  <input type="date" class="form-control" name="date" required>
                </div>     
 
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="submitForm" > Ajouter </button>
              </div>
              </form>
        </div>
      </div>
    </div>