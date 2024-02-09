<!-- <?php var_dump($etat);?>  -->
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page">ETAT DU VEHICULE</li>
        </ol>
    </nav>
    <?php if(isset($error) && $error != null) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Alert!</strong> <?php echo $error; ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <th style="width: 25%"> Categorie </th>
                                        <th> Coefficient</th>
                                        <th style="width: 25%"> Sous Categorie </th>
                                        <th> Valeur </th>
                                      
                                        <th style="width: 25%"> Valeur pondere </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($etat) && $etat != null) { 
                                    for ($i=0; $i < count($etat)-3 ; $i++){ 
                                   ?>

                                    <td> <strong> <?php echo $etat[$i]['nomcategorie']; ?></strong> </td>
                                    <td> <?php echo $etat[$i]['coefficient']; ?> </td>
                                  <td> <?php echo $etat[$i]['nomdetail_categorie']; ?> </td>
                                  <td> <strong> <?php echo $etat[$i]['valeur']; ?> </strong> </td>
                                  
                                  <td> <?php echo $etat[$i]['valeurCoefficent']; ?> </td>
                                 </tr>
                                     <?php 
                                     } ?>
                                  <tr>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td> Note General</td>
                                           <td> <strong><?php echo number_format($etat['note'], 2, ',', ' '); ?> / 10 </strong> </td>
                                          </tr>
                                <tr>
                                  <?php  } ?> 

                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


   