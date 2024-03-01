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
						<th class="text-center">Facture</th>
						<th class="text-center">Compte crédité</th>
						<th class="text-center">Date de paiement</th>
						<th class="text-center">Type de paiement</th>
						<th class="text-center">Montant (Euro)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$num_conteneur = $conn->query("SELECT * FROM compte_crediter ");
					$design_arr[0]= "";
					while($row=$num_conteneur->fetch_assoc()){
						$design_arr[$row['id']] =$row['nom'];
					}

                    $conteneur = $conn->query("SELECT * FROM mode_paiement ");
					$design[0]= "";
					while($row=$conteneur->fetch_assoc()){
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
                    $qry = $conn->query("SELECT invoice.invoice_no, paiement.compte_credite, paiement.date_paiement, paiement.type_paiement, paiement.montant
										FROM invoice
										INNER JOIN paiement
              							ON invoice.sid = paiement.sid $where");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><b><?php echo ucwords($row['invoice_no']) ?></b></td>
						<td class="text-center"><b><?php echo isset($design_arr[$row['compte_credite']]) ? $design_arr[$row['compte_credite']] : 'Pas de compte' ?></b></td>
						<td class="text-center"><b><?php echo date("d-M-Y",strtotime($row['date_paiement'])) ?></b></td>
						<td class="text-center"><b><?php echo isset($design[$row['type_paiement']]) ? $design[$row['type_paiement']] : 'Pas de type' ?></b></td>
						<td class="text-center"><b><?php echo ucwords($row['montant']) ?></b></td>
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