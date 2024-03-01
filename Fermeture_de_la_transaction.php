<?php
if(!isset($conn)){ include 'db_connect.php'; } 
    $getID = $_GET['id'];
    //$statut = $_GET['cs'];
    $invoice = $_GET['co'];
    //echo $getID;
    ///echo $statut;
    //echo $invoice;

    $sqls = "SELECT sid, invoice_no from invoice
              where sid = '" . $conn->real_escape_string($invoice) . "'";

    $resultat = mysqli_query($conn,$sqls);
    $rows = mysqli_fetch_array($resultat);
    $total = $rows['invoice_no'];
    //echo $total;


    if(isset($_POST["submit"])){
        $status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);
        $sql = "UPDATE invoice 
              SET status_retr = '$status_c'
              WHERE  sid = '" . $conn->real_escape_string($invoice) . "'";

        if ($conn->query($sql) === TRUE){            
            //echo "succès";

            $sqls = "INSERT into conteneur_track (conteneur_id, invoice_id, status )
						SELECT num_conteneur, invoice_no, status_retr
						from invoice where num_conteneur = '" . $conn->real_escape_string($getID) . "'
                        AND invoice_no = '$total' ";

				if ($conn->query($sqls) === TRUE){
					//echo "succès maj track";
					echo '<script>
					location.href = "index.php?page=liste_des_envois";
					</script>';

					
				}else{
					echo "erreur maj track";
				}
            }else{
            echo "erreur";
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
                    $status_c = $conn->query("SELECT * FROM status_conteneur where nom = 'Retiré' " );
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