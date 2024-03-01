<style>
aside {color: green;}

.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
  background-color: #1b7b3c;
  color: #fff;
}
</style>

  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <div class="dropdown"  >
   	<a href="" class="brand-link" style="background-image: url(img.jpg); background-size: 150px 70px; background-repeat: no-repeat; background-position: center;">
      <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 2) || ($_SESSION['login_type'] == 3)): ?>
      <h3 class="text-center p-0 m-0" style="color:#1b7b3c;"><b>.</b></h3>
      <?php else: ?>
      <h3 class="text-center p-0 m-0"><b>STAFF</b></h3>
      <?php endif; ?>
    </a>
      
    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          
        <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 3)): ?>
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> 
        <?php endif; ?>

        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-modifier_personnel">
              <i class="nav-icon fas fa-users"></i>
              <p >
                Personnels 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=nouveau_personnel" class="nav-link nav-nouveau_personnel tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >Ajouter Nouveau</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_du_personnel" class="nav-link nav-liste_du_personnel tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >Liste</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-modifier_branche">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Branche
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=nouvelle_branche" class="nav-link nav-nouvelle_branche tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouvelle Branche</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_branches" class="nav-link nav-liste_des_branches tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 2)): ?>
          <!--liste des conteneurs-->
          <li class="nav-item">
            <a href="#" class="nav-link nav-modifier_conteneur">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Conteneurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=nouveau_conteneur" class="nav-link nav-nouveau_conteneur tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouveau conteneur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_conteneurs" class="nav-link nav-liste_des_conteneurs tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-modifier_statuts_conteneur">
              <i class="nav-icon fas fa-signal"></i>
              <p>
                Statuts des conteneurs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=nouveau_statut" class="nav-link nav-nouveau_statut tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouveau statut</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_statuts" class="nav-link nav-liste_des_statuts tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-modifier_destination">
              <i class="nav-icon fas fa-city"></i>
              <p>
                Destinations
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=nouvelle_destination" class="nav-link nav-nouvelle_destination tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouvelle destination</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_destinations" class="nav-link nav-liste_des_destinations tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

          <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 3) || ($_SESSION['login_type'] == 2)): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_parcel">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Facture
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 2)): ?>
              <li class="nav-item">
                <a href="./index.php?page=nouvelle_facture" class="nav-link nav-nouvelle_facture tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Nouvelle Facture</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_factures" class="nav-link nav-liste_des_factures nav-sall tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste des factures</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if($_SESSION['login_type'] != 2): ?>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_paiements" class="nav-link nav-liste_des_paiements nav-sall tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste des paiements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=liste_des_clients" class="nav-link nav-liste_des_clients nav-sall tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste des clients</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 3) || ($_SESSION['login_type'] == 2)): ?>
                <?php 
                $status_arr = array("Impayé","En cours","Payé");
                foreach($status_arr as $k =>$v):
                  ?>
                  <li class="nav-item">
                    <a href="./index.php?page=liste_des_factures&s=<?php echo $k ?>" class="nav-link nav-liste_des_factures_<?php echo $k ?> tree-item">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p><?php echo $v ?></p>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </li>
          
          <?php endif; ?>

          <?php if(($_SESSION['login_type'] == 1) || ($_SESSION['login_type'] == 2)): ?>
            <li class="nav-item">
              <a href="#" class="nav-link nav-modifier_conteneur_en_transit">
                <i class="nav-icon fas fa-share"></i>
                <p>
                  Expéditions
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.php?page=liste_des_envois" class="nav-link nav-liste_des_envois tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Liste des envois</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.php?page=liste_des_conteneurs_en_transit" class="nav-link nav-liste_des_conteneurs_en_transit tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Liste</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php endif; ?>

          <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item dropdown">
            <a href="./index.php?page=tracking" class="nav-link nav-tracking">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Tracking
              </p>
            </a>
          </li>  
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>