<?php
if(!isset($conn)){ include 'db_connect.php'; } 
    $getID = $_GET['id'];
	$con = $_GET['cn'];
	$sqll = "SELECT id, nom_c, status_c from conteneur where id = '" . $conn->real_escape_string($getID) . "'";

	$resultats = mysqli_query($conn,$sqll);
	$rowss = mysqli_fetch_array($resultats);
	$reçu = $rowss['status_c'];
	//echo $reçu;

    if(isset($_POST["submit"])){
		
		if($reçu != 5){
			
			$status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);
			$sql = "UPDATE conteneur 
				  SET status_c = '$status_c'
				  WHERE  id = '" . $conn->real_escape_string($getID) . "'";

			if ($conn->query($sql) === TRUE){
				echo "succès maj conteneur";
	
				$sqlss = "UPDATE invoice 
				SET status_retr = '$status_c'
				WHERE  num_conteneur = '" . $conn->real_escape_string($getID) . "'";
				if ($conn->query($sqlss) === TRUE){
					echo "succès facture";
					$date = date("Y-m-d h:i:s");
					//echo $date;
					$sqls = "INSERT into conteneur_track (conteneur_id, invoice_id, status )
							SELECT num_conteneur, invoice_no, status_retr
							from invoice where num_conteneur = '" . $conn->real_escape_string($getID) . "'";
	
					if ($conn->query($sqls) === TRUE){
						require 'mail/phpmailer/PHPMailerAutoload.php';

						$con = $_GET['cn'];
						include 'test10.php';
						include 'test11.php';
						
						$qry = $conn->query("SELECT sender_address, recipient_address 
						FROM invoice 
						WHERE retire = 0 
            			AND num_conteneur = '" . $conn->real_escape_string($getID) . "'");
					
						$number = "";
						
						while($row = $qry->fetch_assoc()):
							$data[] = $row["recipient_address"];
							$datas[] = $row["sender_address"];
						endwhile; 
						var_dump($data);
						
						$arrlength = count($data);
						$arrlengths = count($datas);
						include('WhatsappAPI.php'); // include given API file
						
						for($x = 0; $x < $arrlength; $x++) {
							$wp = new WhatsappAPI("4990", "55c89e4269b159362f740b96725e51ee31e156c6"); // create an object of the WhatsappAPI class with your user id and api key
							$number = $data[$x];

							$num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
							$design_arr[0]= "Unset";
							while($row=$num_conteneur->fetch_assoc()){
								$design_arr[$row['id']] =$row['nom'];
							}

							$status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);
							$con = $_GET['cn'];

							$message = ' Cher client nous sommes heureux de vous informer que le conteneur: '.$con.' '.$design_arr[$status_c].' NB : Si vous avez déjà payé merci de nous envoyer la preuve de paiement';
							//echo $data[$x];
							$status = $wp->sendText($number, $message);
							$status = json_decode($status);
						
							if($status->status == 'error'){
								echo $status->response;
							}elseif($status->status == 'success'){
								echo 'Success <br />';
								echo $status->response;
							}else{
							print_r($status);
							}
							echo "<br>";
						}
						
						for($x = 0; $x < $arrlengths; $x++) {
							$wp = new WhatsappAPI("4990", "55c89e4269b159362f740b96725e51ee31e156c6"); // create an object of the WhatsappAPI class with your user id and api key
							$number = $datas[$x];
							
							$num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
							$design_arr[0]= "Unset";
							while($row=$num_conteneur->fetch_assoc()){
								$design_arr[$row['id']] =$row['nom'];
							}

							$status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);
							$con = $_GET['cn'];

							$message = ' Cher client nous sommes heureux de vous informer que le conteneur: '.$con.' '.$design_arr[$status_c].' NB : Si vous avez déjà payé merci de nous envoyer la preuve de paiement';
							//echo $data[$x];
							$status = $wp->sendText($number, $message);
							$status = json_decode($status);
						
							if($status->status == 'error'){
								echo $status->response;
							}elseif($status->status == 'success'){
								echo 'Success <br />';
								echo $status->response;
							}else{
							print_r($status);
							}
							echo "<br>";
						}


					echo '<script>
              			location.href = "index.php?page=liste_des_conteneurs_en_transit";
              		</script>';
						
					}else{
						echo "erreur maj track";
					}
				}else{
					echo "erreur facture";
				}
				
			}else{
				echo "erreur maj conteneur";
			}
		}
		else{
			$status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);
			if ($status_c != 1){
				echo "impossible";
			}
			else{
				$sq = "UPDATE conteneur 
				SET status_c = '$status_c'
				WHERE  id = '" . $conn->real_escape_string($getID) . "'";
				if ($conn->query($sq) === TRUE){
					echo "basculement réussi";
					echo '<script>
              			location.href = "index.php?page=liste_des_conteneurs_en_transit";
              		</script>';
				}
			}

		}
        
        
    }

?>
<div class="container-fluid">
	<form action="" method="post" >
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
		<div class="form-group">
			<label for="">Modifier Status</label>
            <div class="form-group ">
                <select name="status_c" id="status_c" class="custom-select custom-select-sm">
                    <option value=""></option>
                    <?php 
                    $status_c = $conn->query("SELECT * FROM status_conteneur where nom != 'Retiré' " );
                        while($row = $status_c->fetch_assoc()):
                    ?>

                    <option value="<?php echo $row['id'] ?>" <?php echo isset($status_c) && $status_c == $row['id'] ? "selected":'' ?>><?php echo $row['nom']?></option>
                    <?php endwhile; ?>
                </select>
              </div>
		</div>
        <input type='submit' name='submit' value='Mise à jour' class='btn btn-success float-right'>
	</form>
</div>

<!--<div class="modal-footer display p-0 m-0">
        <button class="btn btn-primary" form="Modifier status de">Mise à jour</button>
        <button type="button" class="btn btn-secondary" onclick="uni_modal('Parcel\'s Details','view_parcel.php?id=<?php echo $_GET['id'] ?>','large')">Fermer</button>
</div>-->
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
<script>
	$('#Modifier status de').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=update_parcel',
			method:'POST',
			data:$(this).serialize(),
			error:(err)=>{
				console.log(err)
				alert_toast('An error occured.',"error")
				end_load()
			},
			success:function(resp){
				if(resp==1){
					alert_toast("Parcel's Status successfully updated",'success');
					setTimeout(function(){
						location.reload()
					},750)
				}
			}
		})
	})
</script>