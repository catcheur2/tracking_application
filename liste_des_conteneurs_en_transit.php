<style>
th {
  color: #007bff;
}
</style>

<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<!--<th>Branch Code</th>-->
						<th class="text-center">Conteneur</th>
                        <th class="text-center">Montant</th>
                        <th class="text-center">Status</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
					$design_arr[0]= "Unset";
					while($row=$num_conteneur->fetch_assoc()){
						$design_arr[$row['id']] =$row['nom'];
					}
					
					$qry = $conn->query("SELECT conteneur.id, conteneur.nom_c, conteneur.status_c, SUM(invoice.grand_total) AS total
                                         FROM invoice
                                         INNER JOIN conteneur
                                         ON invoice.num_conteneur = conteneur.id 
                                         GROUP BY nom_c");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><b><?php echo ucwords($row['nom_c']) ?></b></td>
                        <td class="text-center"><b><?php echo ucwords($row['total']) ?></b></td>
                        <td class="text-center"><b><?php echo $design_arr[$row['status_c']] ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
								<a href="index.php?page=status&id=<?php echo $row['id'] ?>&cs=<?php echo $design_arr[$row['status_c']] ?>&cn=<?php echo $row['nom_c'] ?>" class="btn btn-primary btn-flat ">
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
		$('.view_conteneur').click(function(){
			uni_modal("Details du conteneur","view_conteneur.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_conteneur').click(function(){
	_conf("Êtes-vous sûr de vouloir supprimer ce conteneur?","delete_conteneur",[$(this).attr('data-id')])
	})
	})
	function delete_conteneur($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_conteneur',
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