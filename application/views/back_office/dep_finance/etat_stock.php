<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> VOIR ETAT DE STOCK AVANT < <b> <?php echo $date ?> </b> > </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3"> Evaluation de l'etat de stock : </h3>
              <a  data-bs-toggle="modal" data-bs-target="#search">
                <button class="btn btn-outline-primary"> 
                  Recherche
                </button>
              </a>
            </div>
            
            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info">
                        <th> Ref Produit </th>
                        <th> Designation </th>
                        <th> Qty </th> 
                        <th> PU moyenne </th>
                        <th> Montant HT </th>
                        <th> Montant TTC </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($stock as $be){ ?>
                        <tr >
                          <td> <?php echo $be['etat']['idmateriel']; ?> </td>
                          <td> <?php echo $be['etat']['nommateriel']; ?> </td>
                          <td> <?php echo $be['etat']['qty']; ?> </td>
                          <td class = "text-end"> Ar <?php echo number_format( $be['etat']['pu'], 2, ',', ' '); ?> </td>
                          <td class = "text-end"> Ar <?php echo number_format( $be['etat']['montant_ht'], 2, ',', ' '); ?> </td>
                          <td class = "text-end"> Ar <?php echo number_format( $be['etat']['montant_ttc'], 2, ',', ' '); ?> </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfooter>
                        <tr>
                            <td class = "text-end" colspan = "4"> <b> Total </b> </td>
                            <td class = "text-end">  <b> Ar <?php echo number_format( $total[0], 2, ',', ' '); ?> </b> </td>
                            <td class = "text-end">  <b> Ar <?php echo number_format( $total[1], 2, ',', ' '); ?> </b>  </td>
                        </tr>
                    </tfooter>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- MODAL DE RECHERCHE PAR PRODUIT B.E -->
    <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle"> Recherche par produit : </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
              
            <form action="<?php echo site_url("index.php/back_office/dep_finance/StockController/getEtatStockProduct") ?>" method="POST">
              <div class="modal-body">
                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%"> Produit </label>
                  <select class="form-select form-select-sm mb-3" name="idmateriel">
                    <!-- <option value="%"> Tous produits </option> -->
                    <?php foreach($materiels as $materiel){ ?>
                      <option value="<?php echo $materiel['idmateriel'] ?>">
                      <?php echo $materiel['idmateriel'] ?> - <?php echo $materiel['nommateriel'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3 d-flex flex-row justify-content-between align-items-center">
                  <label class="form-label" style="width: 30%">Date a choisir : </label>
                  <input type="date" class="form-control" name="datestock">
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> Search <i class="link-icon" data-feather="search"></i> </button>
              </div>
            </form>
        </div>
      </div>
    </div>
