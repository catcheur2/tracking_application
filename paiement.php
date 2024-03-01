<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM invoice where sid = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
$getID = $_GET['id'];

$sqll = "SELECT invoice.SID, invoice.creance, invoice.grand_total, invoice.status, SUM(paiement.montant) AS total
        from invoice
        INNER JOIN paiement
        ON invoice.sid = paiement.sid
        where invoice.SID = '" . $conn->real_escape_string($getID) . "'
        GROUP BY SID";

        $resultats = mysqli_query($conn,$sqll);
        $rowss = mysqli_fetch_array($resultats);
        $reçu = $rowss['total'];
        //echo $reçu;

if(isset($_POST["submit"])){
    $compte_credite=mysqli_real_escape_string($conn,$_POST["compte_credite"]);
    $type_paiement=mysqli_real_escape_string($conn,$_POST["type_paiement"]);
    $date_paiement=date("Y-m-d",strtotime($_POST["date_paiement"]));
    $montant=mysqli_real_escape_string($conn,$_POST["montant"]);

    $nouveau = $reçu + $montant;


    $reponse = "INSERT INTO paiement (sid, compte_credite, type_paiement, date_paiement, montant)  
                VALUES ('$getID', '$compte_credite', '$type_paiement', '$date_paiement', '$montant' )";

    if ($conn->query($reponse) === TRUE){
        //echo "succès paiement";
        $sq = "SELECT invoice.SID, invoice.creance, invoice.grand_total, invoice.status, SUM(paiement.montant) AS total
        from invoice
        INNER JOIN paiement
        ON invoice.sid = paiement.sid
        where invoice.SID = '" . $conn->real_escape_string($getID) . "'
        GROUP BY SID";

        $result = mysqli_query($conn,$sq);
        $ro = mysqli_fetch_array($result);
        $reçue = $ro['total'];
        //echo $reçue;



        $sqls = "SELECT invoice.SID, invoice.creance, invoice.grand_total, invoice.status, paiement.montant
        from invoice
        INNER JOIN paiement
        ON invoice.sid = paiement.sid
        where invoice.SID = '" . $conn->real_escape_string($getID) . "'";

        $resultat = mysqli_query($conn,$sqls);
        $rows = mysqli_fetch_array($resultat);
        $total = $rows['grand_total'];
        //$reçus = $rows['montant'];
        $status = $rows['status'];
        $creance = $rows['creance'];

        if ($reçue == 0){
            $status = 0;
            $new = "UPDATE invoice SET status = '$status' WHERE sid = '" . $conn->real_escape_string($getID) . "' ";
            if ($conn->query($new) === TRUE){
                echo "impayé";
            }else{
                echo "non impayé";
            }
        }
        elseif ($reçue < $total){
            $status = 1;
            $new = "UPDATE invoice SET status = '$status' WHERE sid = '" . $conn->real_escape_string($getID) . "'";
            if ($conn->query($new) === TRUE){
                echo "en cours";
            }else{
                echo "non en cours";
            }
        }
        elseif ($reçue >= $total){
            $status = 2;
            $new = "UPDATE invoice SET status = '$status' WHERE  sid = '" . $conn->real_escape_string($getID) . "'";
            if ($conn->query($new) === TRUE){
                echo "payé";
            }else{
                echo "non payé";
            }
        }

        $creance = $total - $reçue;
        $news = "UPDATE invoice SET creance = '$creance' WHERE  sid = '" . $conn->real_escape_string($getID) . "'";

        if ($conn->query($news) === TRUE){
            echo "creance ok";
        }else{
            echo "creance non ok";
        }
        echo '<script>
              location.href = "index.php?page=liste_des_factures";
              </script>';
    }
    else{
        echo "Erreur paiement: " . $conn->error;
    }
}

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<dl>
						<dt>Facture:</dt>
						<dd> <h4><b><?php echo $invoice_no ?></b></h4></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Informations sur la facture</b>
					<dl>
						<dt>Montant:</dt>
						<dd><?php echo "$grand_total &euro;"; ?></dd>
						<dt>Reçu:</dt>
						<dd><?php echo "$reçu &euro;" ?></dd>
						<dt>Expéditeur:</dt>
						<dd><?php echo ucwords($sender_name) ?></dd>
                        <dt>Numéro Expéditeur:</dt>
						<dd><?php echo ucwords($sender_address) ?></dd>
						<dt>Destinataire:</dt>
						<dd><?php echo ucwords($recipient_name) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Effectuer le paiement</b>
                    <form method="post" action=''>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="" class="control-label">Compte à créditer</label>
                                    <select name="compte_credite" id="compte_credite" class="form-control select2">
                                        <option value=""></option>
                                        <?php 
                                        $compte_credite = $conn->query("SELECT * FROM  compte_crediter");
                                            while($row = $compte_credite->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo isset($compte_credite) && $compte_credite == $row['id'] ? "selected" :'' ?> ><?php echo $row['nom']?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Date de paiement</label>
                                    <input type="date" name="date_paiement" id="" class="form-control form-control-sm" value="<?php echo date('Y-m-d', strtotime($date_paiement));  ?>" required>
                                    <!--<input type="date" name="date_paiement" id="" class="form-control form-control-sm" value="<?php echo isset($date_paiement) ? date('Y-m-d', strtotime($date_paiement)) : '' ?>" required>-->
                                </div>
                                <div class="form-group ">
                                    <label for="" class="control-label">Mode de paiement</label>
                                    <select name="type_paiement" id="type_paiement" class="form-control select2">
                                        <option value=""></option>
                                        <?php 
                                        $type_paiement = $conn->query("SELECT * FROM mode_paiement");
                                            while($row = $type_paiement->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo isset($type_paiement) && $type_paiement == $row['id'] ? "selected" :'' ?> ><?php echo $row['nom']?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Montant</label>
                                    <input type="text" name="montant" id="" class="form-control form-control-sm" value="<?php echo isset($montant) ? $montant : '' ?>" required>
                                </div>
                            </div>
                        </div>
                        <input type='submit' name='submit' value='Enregistrer le paiement' class='btn btn-secondary float-right'>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
	</style>
	<h3 class="text-center"><b>Student Result</b></h3>
</noscript>
<script>
	$('#update_status').click(function(){
		uni_modal("Update Status of: <?php echo $reference_number ?>","manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>","")
	})
</script>