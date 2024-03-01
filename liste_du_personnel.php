<style>
th {
  color: #007bff;
}
</style>

<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<?php if($_SESSION['login_type'] == 2): ?>
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=nouveau_personnel"><i class="fa fa-plus"></i> Ajouter Nouveau</a>
			</div>
		</div>
		<?php endif; ?>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">Personnel</th>
						<th class="text-center">Email</th>
						<th class="text-center">Rôle</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM users ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><b><?php echo ucwords($row['firstname']) ?></b></td>
						<td class="text-center"><b><?php echo ($row['email']) ?></b></td>
						<td class="text-center">
                            <?php 
                            switch ($row['type']){
                                case '1':
									echo "<span class='badge badge-pill badge-danger'> Administrateur</span>";
									break;
								case '2':
									echo "<span class='badge badge-pill badge-info'> Opération</span>";
									break;
								case '3':
									echo "<span class='badge badge-pill badge-success'> Comptabilité</span>";
									break;
								default:
									echo "<span class='badge badge-pill badge-dark'> Autres</span>";
									
									break;
                            }
                            ?>
                        </td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=modifier_personnel&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_staff" data-id="<?php echo $row['id'] ?>">
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
		$('#list').DataTable({
        language: {
            url: "assets/plugins/datatables/french.json"
        }
    	});
		$('.view_staff').click(function(){
			uni_modal("staff's Details","view_staff.php?id="+$(this).attr('data-id'),"large")
		})

		$('.delete_staff').click(function(){
			_conf("Êtes-vous sûr de vouloir supprimer ce personnel?","delete_staff",[$(this).attr('data-id')])
		})
	})
	function delete_staff($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimées avec succès",'succès')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>