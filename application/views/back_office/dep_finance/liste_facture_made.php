<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> FINANCE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES FACTURES ENVOYE AUX CLIENTS </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent Factures envoyes : </h3>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Numero </th>
                        <th> Date Facture </th> 
                        <th> Fournisseur </th>
                        <th> Montant HT</th>
                        <th> Montant TTC</th>
                        <th> Comptable </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($factures as $fr){ 
                        $total = $this -> Facturation -> getTotalMontantFactureClient($fr['idfacturation']);
                        ?>
                        <tr >
                          <td> <?php echo $fr['idfacturation']; ?> </td>
                          <td> <?php echo $fr['date_facturation']; ?> </td>
                          <td> <?php echo $fr['name_company']; ?> </td>
                          <td> Ar <?php echo number_format($total['ht'], 2, ',', ' '); ?> </td>
                          <td> Ar <?php echo number_format($total['ttc'], 2, ',', ' '); ?> </td>
                          <td> <?php echo $fr['nom_emp'] . " " . $fr['prenom_emp']; ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_finance/FacturationClientController/getDetailFactureMade") ?>/<?php echo $fr['idfacturation']; ?>">
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

