<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> FINANCE </a></li>
          <li class="breadcrumb-item active" aria-current="page">LISTE DES FACTURES DES FOURNISSEURS </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent Factures recus : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#addBl">
                <button class="btn btn-outline-primary"> 
                  Receptionner Facture
                </button>
              </a>
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
                        <th> Enregistreur </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($frs as $fr){ ?>
                        <tr >
                          <td> <?php echo $fr['idfacturereceived']; ?> </td>
                          <td> <?php echo $fr['datefacture']; ?> </td>
                          <td> <?php echo $fr['nomfournisseur']; ?> </td>
                          <td> <?php echo $fr['nom'] . " " . $fr['prenom']; ?> </td>
                          <td> Ar <?php echo number_format($fr['montant_ht_facture'], 2, ',', ' '); ?> </td>
                          <td> Ar <?php echo number_format($fr['montant_ttc_facture'], 2, ',', ' '); ?> </td>
                          <td class="text-center text-muted" style="width: 5%"> 
                            <a href="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/getDetailFactureReceived") ?>/<?php echo $fr['idfacturereceived']; ?>">
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

   <!-- MODAL DE RECEPTION FACTURE -->
   <div class="modal fade" id="addBl" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Reception Facture :  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_finance/FactureReceivedController/createFactureReceived") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date facture : </label>
                  <input type="date" class="form-control" name="datefacture">
                </div>
                
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Numero document : </label>
                  <input type="text" class="form-control" name="numero">
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Reference B.C : </label>
                  <select class="form-select form-select-sm mb-3" name="idcommande">
                    <option value=""> Aucun Bon Commande </option>
                    <?php foreach($commande_sent as $commande){ ?>
                      <option value="<?php echo $commande['idboncommande'] ?>">
                        <?php echo $commande['idboncommande'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Enregistrer + </button>
              </div>
            </form>
        </div>
      </div>
    </div>

