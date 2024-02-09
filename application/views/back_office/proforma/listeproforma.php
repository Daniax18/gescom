<div class="page-content">
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> ACHAT </a></li>
        <li class="breadcrumb-item active" aria-current="page">DEMANDE ACHAT</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h3 class="text-start mb-3">Liste des proformas : </h3>
          </div>
          <?php //var_dump($globals) ?>
          <div class="container">  
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th> Global_ref </th>
                      <th> Reference</th>
                      <th> Fournisseur</th>
                      <th> Envoie proforma</th>
                      <th> Reception proforma</th>
                      <th> Status</th>                
                      <th>Receive</th>
                      <th></th>
                      <th>Status B.C</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($globals) && $globals != null) { 
                      foreach($globals as $global){ 
                        $proformas = $this -> Proforma -> getProformaPerGlobal($global['idglobal']);
                        $count = 0; 
                        foreach($proformas as $proforma){ 
                          ?>
                            <tr>
                              <?php if($count == 0) { ?> 
                                <td class="text-center align-middle" rowspan = "<?php echo count($proformas) ?> "> <?php echo $proforma['idglobal']; ?> </td> 
                              <?php } ?>
                              <td> <?php echo $proforma['idproforma']; ?> </td>
                              <td> <?php echo $proforma['nomfournisseur']; ?> </td>
                              <td> <?php echo $proforma['dateproformasent']; ?> </td>
                              <td> <?php echo $proforma['dateproformareceived']; ?> </td>
                              <td> <span class="badge rounded-pill bg-info"> <?php echo $proforma['status'][0]; ?></span></td>
                              <td class="text-center text-muted" style="width: 5%"> 
                                <a href="<?php echo site_url("index.php/back_office/proformaReceivedController/receive") ?>/<?php echo $proforma['idproforma']; ?>">
                                  <i data-feather="check-circle"></i>
                                </a>
                              </td>
                              <td class="text-center text-muted" style="width: 5%"> 
                                <a href="<?php echo site_url("index.php/back_office/proformaReceivedController/listeProformaCtrl") ?>/<?php  echo $proforma['status'][1] ; ?>/<?php echo $proforma['idproforma']; ?>">
                                  <i data-feather="eye"></i>
                                </a>
                              </td>
                              <?php if($count == 0) { ?> 
                                <td class="text-center align-middle" rowspan = "<?php echo count($proformas) ?> "> 
                                  <?php if($global['status'] == 0){ ?>
                                    <form action="<?php echo site_url("index.php/back_office/BandcommandeController/createBoncommande") ?>" method="POST">
                                      <input type="hidden" name="global" value="<?php echo $global['idglobal'] ?>">
                                      <button class="btn btn-outline-success" type="submit">
                                        Create B.C
                                      </button>  
                                    </form>
                                        
                                    <?php }else{ ?>
                                      B.C created
                                    <?php } ?> 
                                </td> 
                              <?php } ?>
                            </tr>
                          <?php 
                        $count++;  
                        } 
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