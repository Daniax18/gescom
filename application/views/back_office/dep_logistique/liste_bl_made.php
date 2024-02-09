<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE LOGISTIQUE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE LIVRAISONS ENVOYE AUX CLIENTS </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent Bon de Livraison envoyes : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Numero </th>
                        <th> Date Livrasion </th> 
                        <th> Fournisseur </th>
                        <th> Responsable client</th>
                        <th> Magasinier </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($livraisons as $fr){ ?>
                        <tr >
                          <td> <?php echo $fr['idlivraisonclient']; ?> </td>
                          <td> <?php echo $fr['date_livraison']; ?> </td>
                          <td> <?php echo $fr['name_company']; ?> </td>
                          <td> <?php echo $fr['responsable_customer']; ?> </td>
                          <td> <?php echo $fr['nom_emp'] . " " . $fr['prenom_emp']; ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_logistique/BonLivraisonClientController/getDetailBlMade") ?>/<?php echo $fr['idlivraisonclient']; ?>">
                              <i data-feather="eye"> </i>
                            </a>
                          </td>
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

