
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">ETAT DE NOS VEHICULES</li>
        </ol>
    </nav>
    <?php 
    
    if(isset($error) && $error != null) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Alert!</strong> <?php echo $error; ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                    
                      <th style="width: 10%"> Voiture </th>
                      <th style="width: 10%"> Note </th>
                      <th style="width: 10%"> Etat </th>
                      <th></th>
                     </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($etat) && $etat != null) { 
                                    for ($i=0; $i < count($etat) ; $i++){  ?>
                                        <tr>
                                            <td><?php echo $etat[$i]['main_voiture']['matricule'] . ' - ' . $etat[$i]['main_voiture']['nommarque'] ?></td>
                                            <td> <?php echo number_format($etat[$i]['note'], 2, ',', ' '); ?> / 10 </td>
                                            <td><?php echo $etat[$i]['etat']; ?>  </td>
                                           <td class="text-center text-muted" style="width: 5%"> 
                                                <a  href='<?php echo site_url("index.php/back_office/dep_finance/ReceptionController/getEtat") ?>?voiture=<?php echo $etat[$i][0]['idvoiture']; ?>'>
                                                <i data-feather="eye"> </i>
                                                </a>
                                            </td>
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


   