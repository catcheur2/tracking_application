<style>
th {
  color: #007bff;
}
</style>

<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=nouvelle_facture"><i class="fa fa-plus"></i> Ajouter nouvelle facture</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
                        <th class="text-center">N° Facture</th>
						<th class="text-center">N° Conteneur</th>
						<th class="text-center">Expéditeur</th>
						<th class="text-center">Destinataire</th>
						<th class="text-center">Statuts</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$num_conteneur = $conn->query("SELECT * FROM conteneur ");
					$design_arr[0]= "Unset";
					while($row=$num_conteneur->fetch_assoc()){
						$design_arr[$row['id']] =$row['nom_c'];
					}

                    $statut = $conn->query("SELECT * FROM status_conteneur ");
					$design[0]= "Unset";
					while($row=$statut->fetch_assoc()){
						$design[$row['id']] =$row['nom'];
					}

					$where = "";
					if(isset($_GET['s'])){
						$where = " where status = {$_GET['s']} ";
					}
					/*if($_SESSION['login_type'] != 1 ){
						if(empty($where))
							$where = " where ";
						else
							$where .= " and ";
						$where .= " (from_branch_id = {$_SESSION['login_branch_id']} or to_branch_id = {$_SESSION['login_branch_id']}) ";
					}*/
					//$qry = $conn->query("SELECT * from parcels $where order by  unix_timestamp(date_created) desc ");
                    $qry = $conn->query("SELECT invoice.sid, invoice.invoice_no, invoice.num_conteneur, invoice.sender_name, invoice.recipient_name, 
                                        invoice.status, invoice.status_retr, invoice.num_conteneur,
                                        conteneur.status_c, conteneur.id
										FROM invoice
										INNER JOIN conteneur
                                        ON invoice.num_conteneur = conteneur.id $where");
              							//ON invoice.sid = paiement.sid $where");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
                        <td class="text-center"><b><?php echo ucwords($row['invoice_no']) ?></b></td>
						<td class="text-center"><b><?php echo isset($design_arr[$row['num_conteneur']]) ? $design_arr[$row['num_conteneur']] : 'Unknow Designation' ?></b></td>
						<td class="text-center"><b><?php echo ucwords($row['sender_name']) ?></b></td>
                        <td class="text-center"><b><?php echo ucwords($row['recipient_name']) ?></b></td>
                        
                        <td class="text-center"><b><?php echo $design[$row['status_retr']] ?></b></td>
						
						<td class="text-center">
		                    <div class="btn-group">
								<a href="index.php?page=Fermeture_de_la_transaction&id=<?php echo $row['id'] ?>&cs=<?php echo $design[$row['status_retr']] ?>&co=<?php echo $row['sid'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-eye"></i>
		                        </a>
	                        </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_parcel').click(function(){
			uni_modal("Parcel's Details","view_parcel.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_facture').click(function(){
	_conf("Êtes-vous sûr de vouloir supprimer cette facture?","delete_facture",[$(this).attr('data-id')])
	})
	})
	function delete_facture($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_facture',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimées avec succès",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>