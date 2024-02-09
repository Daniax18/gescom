<div class="page-content">

  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
          <li class="breadcrumb-item active" aria-current="page"> LISTE DES INVENTAIRES </li>
      </ol>
  </nav>

  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
              <h3 class="text-start mb-3">Recent inventaire : </h3>
              <div class="d-flex flex-row justify-content-between" style="width: 40%">
                    Total valeur ecart : <b style="color: red"> Ar <?php echo number_format($perte, 2, ',', ' '); ?> </b>
              </div>
             
            </div>
            
        <?php //var_dump($inventaires); ?>

            <div class="container">  
              <div class="table-responsive pt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="table-info text-center">
                        <th> Reference </th>
                        <th> Date inventaire </th>
                        <th> Responsable </th>
                        <th> Total ecart </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($inventaires as $inventaire){ ?>
                        <tr >
                            <td> <?php echo $inventaire['idinventaire']; ?> </td>
                            <td> <?php echo $inventaire['dateinventaire']; ?> </td>
                            <td> <?php echo $inventaire['nom'] . " " . $inventaire['prenom']; ?> </td>
                            <td class="text-end" style="color: <?php echo $inventaire['color'] ?>"> 
                               <b> Ar <?php echo number_format($inventaire['ecart'], 2, ',', ' '); ?> </b>
                            </td>
                            <td class="text-center text-muted" style="width: 5%"> 
                                <a href="<?php echo site_url("index.php/back_office/dep_finance/EcartController/getDetailInventaire") ?>/<?php echo $inventaire['idinventaire']; ?>">
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
