<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->
<?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 3)): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <?php 
                  function last(){
                    $total = 0;
                    include 'db_connect.php';
                    $paie = $conn->query("SELECT * FROM invoice");
                    if($paie->num_rows > 0){
                      while($row = $paie->fetch_array()):
                      $total += $row['grand_total'];
                      endwhile;
                    }
                    return $total;
                  }
                
                  $b = last();
                  $aa=number_format($b,0,',',' ');
                ?>
                <h3><?php echo "$aa &euro;";  ?></h3>
                <p>Montant Total de Facture</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <?php 
                  function lasts(){
                    $totals = 0;
                    include 'db_connect.php';
                    $paies = $conn->query("SELECT * FROM invoice where creance != 0");
                    if($paies->num_rows > 0){
                      while($row = $paies->fetch_array()):
                      $totals += $row['creance'];
                      endwhile;
                    }
                    return $totals;
                  }
                
                  $bs = lasts();
                  $aas=number_format($bs,0,',',' ');
                ?>
                <h3><?php echo "$aas &euro;";  ?></h3>
                <p>Dette Globale</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <?php 
                  function lastss(){
                    $totals = 0;
                    include 'db_connect.php';
                    $paies = $conn->query("SELECT montant FROM paiement ");
                    if($paies->num_rows > 0){
                      while($row = $paies->fetch_array()):
                      $totals += $row['montant'];
                      endwhile;
                    }
                    return $totals;
                  }
                
                  $bs = lastss();
                  $aas=number_format($bs,0,',',' ');
                ?>
                <h3><?php echo "$aas &euro;";  ?></h3>
                <p>Montant Encaissé</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM branches")->num_rows; ?></h3>

                <p>Total des Branches</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM invoice where status_retr = 7 ")->num_rows; ?></h3>

                <p>Nombre de retraits</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
          <!-- <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM parcels")->num_rows; ?></h3>

                <p>Total Parcels</p>
              </div>
              <div class="icon">
                <i class="fa fa-boxes"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM users where type != 1")->num_rows; ?></h3>

                <p>Total Staff</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>-->
          <hr>
          <?php 
              $status_arr = array("Impayé","En cours","Payé");
               foreach($status_arr as $k =>$v):
          ?>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM invoice where status = {$k} ")->num_rows; ?></h3>

                <p><?php echo $v ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-boxes"></i>
              </div>
            </div>
          </div>
            <?php endforeach; ?>
      </div>

<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Bienvenue <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
          
<?php endif; ?>
