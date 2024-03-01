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
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=nouvelle_destination"><i class="fa fa-plus"></i>Nouvelle_destination</a>
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
						<!--<th>Branch Code</th>-->
						<th class="text-center">Noms</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM destination ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><b><?php echo ucwords($row['nom']) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=modifier_destination&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_destination" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
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
			uni_modal("branch's Details","view_conteneur.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_destination').click(function(){
	_conf("Êtes-vous sûr de vouloir supprimer cette destination?","delete_destination",[$(this).attr('data-id')])
	})
	})
	function delete_destination($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_destination',
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