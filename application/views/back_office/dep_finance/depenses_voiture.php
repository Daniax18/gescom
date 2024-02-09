<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
            <li class="breadcrumb-item active" aria-current="page"> SUIVI DEPENSES DES VOITURES </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <h3 class="text-start mb-3"> <?php echo $status ?> </h3>
                        <a data-bs-toggle="modal" data-bs-target="#trier">
                            <button class="btn btn-outline-primary"> 
                                Trier par ...
                            </button>
                        </a>
                    </div>
                   
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th> Code </th>
                                    <th> Matricule </th>
                                    <th> Marque </th>
                                    <th> Consommation </th>
                                    <th> Depense Carburant </th>
                                    <th> Depense Entretien </th>      
                                    <th> Total  </th>         
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($depenses) && $depenses != null) { 
                                foreach($depenses as $detail){ 
                                    ?>
                                        <tr>
                                            <td> <?php echo $detail['code']; ?> </td>
                                            <td> <strong> <?php echo $detail['matricule']; ?> </strong> </td>
                                            <td> <?php echo $detail['nommarque']; ?> </td>
                                            <td> <?php echo number_format( $detail['consommation'], 2, ',', ' '); ?> L/100 km </td>
                                            <td> 
                                                <<?php echo $style_carbu ?>> 
                                                    Ar <?php echo number_format( $detail['total_carburant'], 2, ',', ' '); ?> 
                                                </<?php echo $style_carbu ?>> 
                                            </td>
                                            <td> 
                                                <<?php echo $style_entretien ?>> 
                                                    Ar <?php echo number_format( $detail['total_entretien'], 2, ',', ' '); ?> 
                                                </<?php echo $style_entretien ?>> 
                                            </td>
                                            <td> 
                                                <<?php echo $style_total ?>> 
                                                    Ar <?php echo number_format( $detail['total_depense'], 2, ',', ' '); ?> 
                                                </<?php echo $style_total ?>> 
                                            </td>
                                        </tr>
                                    <?php 
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

    <!-- MODAL DE CREATION DEMANDE -->
    <div class="modal fade" id="trier" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> Trier les depenses ici :  </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="<?php echo site_url("index.php/back_office/dep_finance/VoitureController/getAllDepenseVoiture") ?>" method="GET">
                    <div class="modal-body">
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-center">

                        <select class="form-control" name="status">
                            <option value="2" >Par carburant</option>
                            <option value="1" >Par entretien</option>
                            <option value="3" > Tous depenses </option>
                        
                        </select>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"> Rechercher </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
