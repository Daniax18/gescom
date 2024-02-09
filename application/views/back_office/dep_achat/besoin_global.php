<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE ACHAT </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DES BESOINS GLOBAUX </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3"> Besoins Globaux : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Reference</th>
                        <th> Date groupage</th>
                        <th> Appelant </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                      foreach($globals as $global){ ?>
                        <tr >
                          <td> <?php echo $global['idglobal']; ?> </td>
                          <td> <?php echo $global['date']; ?> </td>
                          <td> <?php echo $global['nom'] .' '. $global['prenom'] ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                              <a href="<?php echo site_url("index.php/back_office/dep_achat/ProformaController/getDetaiGlobalProforma") ?>/<?php echo $global['idglobal']; ?>" >
                                  <i data-feather="eye"></i>
                              </a>
                          </td>
                        </tr>
                      <?php 
                  } 
                  
                  ?>
                      
                    </tbody>
                  </table>
                </div>
                      </div>
          </div>
        </div>
      </div>
    </div>
  </div>