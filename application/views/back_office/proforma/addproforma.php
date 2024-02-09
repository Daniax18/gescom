
<div class="page-content">
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card" style="margin: auto;">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Ajout Proforma</h6>

                                <form class="forms-sample" action="Addproforma" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-label">Fournisseur</label>
                                      <select class="form-select form-select-sm mb-3" name="article">
                                        <option selected >Choix fournisseur</option>
                                        <?php foreach($fournisseur as $f) { ?>
                                        <option value="<?php echo $f['idfournisseur']; ?>"><?php echo $f['nomfournisseur']; ?></option>
                                         <?php } ?>   
                                    </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Valider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>