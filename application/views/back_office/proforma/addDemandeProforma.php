
<div class="page-content">
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card" style="margin: auto;">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Demande Proforma</h6>

                                <form class="forms-sample" action="insertProforma" method="POST">
                                    <div class="mb-3">
                                      <label class="form-label">Fournisseur</label>
                                      <select class="form-select form-select-sm mb-3" name="fou">
                                        <option selected >Choix fournisseur</option>
                                        <?php foreach($fournisseur as $f) { ?>
                                        <option value="<?php echo $f['idfournisseur']; ?>"><?php echo $f['nomfournisseur']; ?></option>
                                         <?php } ?>   
                                      </select>
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-label">Global</label>
                                      <select class="form-select form-select-sm mb-3" name="glo">
                                        <option selected >Choix Global</option>
                                        <?php foreach($global as $g) { ?>
                                        <option value="<?php echo $g['idglobal']; ?>"><?php echo $g['date']; ?></option>
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