<div class="page-content">
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> SERVICE ACHAT </a></li>
        <li class="breadcrumb-item active" aria-current="page">  LISTE BONS COMMANDES </li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row justify-content-between align-items-center mb-3">
            <h3 class="text-start mb-3">Liste des bons de commandes : </h3>
          </div>
          <?php //var_dump($globals) ?>
          <div class="container">  
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr class="table-info">
                      <th> Global_ref </th>
                      <th> BC_ref</th>
                      <th> Fournisseur</th>
                      <th> Date BC </th>
                      <th> Montant total</th>                
                      <th> Status </th>
                      <th> Progression </th>
                      <th>  </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($globals) && $globals != null) { 
                      foreach($globals as $global){ 
                        $commandes = $this -> Bandcommande -> getBonCommandePerGlobal($global['idglobal']);
                        //var_dump($commandes);
                        $count = 0; 
                        foreach($commandes as $commande){ 
                          ?>
                            <tr>
                                <?php if($count == 0) { ?> 
                                    <td class="text-center align-middle" rowspan = "<?php echo count($commandes) ?> "> 
                                        <?php echo $commande['idglobal']; ?> 
                                    </td> 
                                <?php } ?>
                                <td> <?php echo $commande['idboncommande']; ?> </td>
                                <td> <?php echo $commande['nomfournisseur']; ?> </td>
                                <td> <?php echo $commande['datecommande']; ?> </td>
                                <td> Ar <?php echo number_format($commande['total'], 2, ',', ' '); ?> </td>
                                <td> <span class="badge rounded-pill bg-info"> <?php echo $commande['my_status'][0]; ?></span></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $commande['my_status'][1]; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                              <td class="text-center text-muted" style="width: 5%"> 
                                <a href="<?php echo site_url("index.php/back_office/BandcommandeController/bonCommandePerId") ?>/<?php echo $commande['idboncommande']; ?>">
                                  <i data-feather="eye"></i>
                                </a>
                              </td>
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