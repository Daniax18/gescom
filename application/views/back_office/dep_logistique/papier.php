
<!-- <?php var_dump($carburant);?> -->
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">HISTORIQUE PAPIER</li>
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
                <a  data-bs-toggle="modal" data-bs-target="#ask_papier">
                    <button class="btn btn-outline-primary"> 
                            Reglement Papier
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
                      <th> date debut </th>
                      <th> date fin </th>
                      <th style="width: 10%"> papier </th>
                      <th> Employee </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($papier) && $papier != null) { 
                                    for($i = count($papier) - 1; $i >= 0 ; $i --){ 
                                        ?>
                                            <tr>
                                           
                                  <td> <?php echo $papier[$i]['matricule']; ?> </td>
                                  <td> <?php echo $papier[$i]['date_debut']; ?> </td>
                                  <?php 
                                  date_default_timezone_set('Europe/Moscow');
                                  $dateActuelleObj = new DateTime();
                                  $diffEnJours = $dateActuelleObj->diff(new DateTime($papier[$i]['date_fin']))->days;
                                  $diffEnJoursAbsolue = abs($diffEnJours);
                                  if($diffEnJoursAbsolue < 7 && ($i == count($papier) - 1)){ ?>
                                     
                                    <td>  <div class="alert alert-danger d-flex flex-row justify-content-between mt-1 " role="alert"> <?php echo $papier[$i]['date_fin']; ?>  </div></td>
                                  <?php }else{ ?>
                                  <td> <?php echo $papier[$i]['date_fin']; ?> </td>
                                  <?php } ?>
                                  <td> <?php echo $papier[$i]['nompapier']; ?> </td>
                                  <td> <?php echo $papier[$i]['nom']; ?> </td>
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


               <!-- MODAL DE CREATION ARRANGEMENT PAPIER-->
               <div class="modal fade" id="ask_papier" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form action="<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/insertPapier") ?>" method="POST">
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
                  <label class="form-label" style="width: 50%">Papier : </label>
                  <option value="<?php echo $papierView['idpapier']?>"><?php echo $papierView['nompapier']?></option>
                  <input type="hidden" name="idpapier" value="<?php echo $papierView['idpapier']?>">
                </div>
                <input type="hidden" class="form-control" name="idvoiture" value="<?php echo $voiture['idvoiture']; ?>">   
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Date debut : </label>
                  <input type="date" class="form-control" name="date_debut" required>
                </div>     
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 50%">Date Fin : </label>
                  <input type="date" class="form-control" name="date_fin" required>
                </div>   
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="submitForm" > Regler </button>
              </div>
              </form>
        </div>
      </div>
    </div>