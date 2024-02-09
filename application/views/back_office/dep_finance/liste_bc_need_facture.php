<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DES BON COMMANDES A FACTURER </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent Bon de Commandes a facturer : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Numero B.C</th>
                        <th> Date recu </th> 
                        <th> Company </th>
                        <th> Responsable Client </th>
                        <th> Commercial </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($commandes as $commande){ ?>
                        <tr >
                          <td> <?php echo $commande['numerocommande']; ?> </td>
                          <td> <?php echo $commande['date_commande_client_received']; ?> </td>
                          <td> <?php echo $commande['name_company']; ?> </td>
                          <td> <?php echo $commande['responsable_customer']; ?> </td>
                          <td> <?php echo $commande['nom'] . " " . $commande['prenom']; ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/getDetailCommandeNeedFacturation") ?>/<?php echo $commande['idcommandeclient']; ?>">
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
