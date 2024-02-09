


  <div class="page-content">
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> SERVICE FINANCE </a></li>
        <li class="breadcrumb-item active" aria-current="page"> TABLEAU amortissement</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                <h3 class="text-start mb-3">Amortissement : </h3>
            </div>
            <?php //var_dump($globals) ?>
            <div class="container">  
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-info">
                            <th> Valeur brute </th>
                            <th> Taux Lineaire </th>
                            <th> Amortissement cumule debut </th>
                            <th>Dotation </th>
                            <th> Amortissement cumule fin</th>
                            <th> Valeur nette comptable</th>                
                            <th> Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($amortissement) && $amortissement != null) { 
                            foreach($amortissement as $amortissementInit){ 
                            ?>
                                <tr>
                                    <td> 
                                        Ar <?php echo number_format($amortissementInit['vb'], 2, ',', ' '); ?> 
                                    </td> 
                                    <td> <?php echo number_format($amortissementInit['taux'], 2, ',', ' '); ?> </td>
                                    <td> Ar <?php echo number_format($amortissementInit['acd'], 2, ',', ' '); ?> </td>
                                    <td> Ar <?php echo number_format($amortissementInit['dotation'], 2, ',', ' '); ?> </td>
                                    <td> Ar <?php echo number_format($amortissementInit['acf'], 2, ',', ' '); ?> </td>
                                    <td> Ar <?php echo number_format($amortissementInit['vnc'], 2, ',', ' '); ?> </td>
                                    <td> <?php echo $amortissementInit['periode']; ?> </td>
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
