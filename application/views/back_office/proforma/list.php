
<div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Liste Demande</h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="ProformaController/adddemandeproforma"><button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">+ Demande proforma</button></a>
          </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card" style="margin:auto">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Liste Demande</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID Proforma</th>
                                        <th>Nom Fournisseur</th>
                                        <th>Email</th>
                                        <th>Date Sent</th>
                                        <th>Date Received</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($proforma as $p) { ?>
                                    <tr>
                                        <th><code><?php echo $p["idproforma"];?></code></th>
                                        <td><?php echo $p["nomfournisseur"];?></td>
                                        <td><?php echo $p["email"];?></td>
                                        <td><?php echo $p["dateproformasent"];?></td>
                                        <td><?php echo $p["dateproformareceived"];?></td>
                                        <td>
                                            <a href="ProformaController/demande/<?php echo $p["idproforma"];?>" >Details</a>
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