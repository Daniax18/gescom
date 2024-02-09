<div class="page-content">
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> SERVICE DEPARTEMENT INFORMATIQUE </a></li>
        <li class="breadcrumb-item active" aria-current="page"> BONS COMMANDES A VALIDER</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                <h3 class="text-start mb-3">Recents  bons de commandes : </h3>
            </div>
            <?php //var_dump($globals) ?>
            <div class="container">  
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-info">
                            <th> Global_ref </th>
                            <th> Numero BC</th>
                            <th> Fournisseur</th>
                            <th> Date BC </th>
                            <th> Montant total</th>                
                            <th> Action </th>
                            <th>  </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($commandes) && $commandes != null) { 
                            foreach($commandes as $commande){ 
                            ?>
                                <tr>
                                    <td> 
                                        <?php echo $commande['idglobal']; ?> 
                                    </td> 
                                    <td> <?php echo $commande['idboncommande']; ?> </td>
                                    <td> <?php echo $commande['nomfournisseur']; ?> </td>
                                    <td> <?php echo $commande['datecommande']; ?> </td>
                                    <td> Ar <?php echo number_format($commande['total'], 2, ',', ' '); ?> </td>
                                    <td>
                                        <?php if($commande['status'] == 1) { ?>
                                            <a href="<?php echo site_url("index.php/back_office/BandcommandeController/validateCommandeAdjoint") ?>/<?php echo $commande['idboncommande']; ?>">
                                                <button class="btn btn-outline-success">
                                                    Valider
                                                </button>
                                            </a>
                                        <?php } else if($commande['status'] == 2){ ?>
                                            <a href="<?php echo site_url("index.php/back_office/BandcommandeController/devalidateCommandeAdjoint") ?>/<?php echo $commande['idboncommande']; ?>">
                                                <button class="btn btn-outline-danger">
                                                    Devalider
                                                </button>
                                            </a>
                                        <?php } ?>    
                                    </td>
                                    <td class="text-center text-muted" style="width: 5%"> 
                                        <a href="<?php echo site_url("index.php/back_office/BandcommandeController/bonCommandePerId") ?>/<?php echo $commande['idboncommande']; ?>">
                                        <i data-feather="eye"></i>
                                        </a>
                                    </td>
                                    </tr>
                                <?php }
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