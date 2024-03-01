<?php
include 'db_connect.php';
//$qry = $conn->query("SELECT * FROM conteneur where id = ".$_GET['id'])->fetch_array();

$qry = mysqli_query($conn,"SELECT * FROM conteneur where id = ".$_GET['id']); 
while ($rows = mysqli_fetch_array($qry)){
/*foreach($qry as $k => $v){
	$$k = $v;
}*/

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<dl>
						<dt>Informations sur le conteneur:</dt>
						<dd> <h4><b><?php echo ucwords($rows['nom_c']) ?></b></h4></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Détails</b>
						<div class="row">
							<div class="col-sm-6">
								
							</div>
						</div>
					<dl>
						
						<dt>Status:</dt>
						<dd>
							<?php 
                            $statut = $conn->query("SELECT * FROM status_conteneur ");
                            $design_arr[0]= "Unset";
                            while($row=$statut->fetch_assoc()){
                                $design_arr[$row['id']] =$row['nom'];
                            }

                            echo $design_arr[$rows['status_c']];

							?>
							<!--<span class="btn badge badge-primary bg-gradient-primary" id='update_status'><i class="fa fa-edit"></i> Modifier Statut</span>-->
							<a href="index.php?page=status&id=<?php echo $rows['id'] ?>&cs=<?php echo $design_arr[$rows['status_c']] ?>" class="btn btn-primary btn-flat ">
								<i class="fas fa-eye"></i>
							</a>
						</dd>

					</dl>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
		uni_modal("Modifier status de : <?php echo $rows['nom_c'] ?>","status.php?id=<?php echo $rows['id'] ?>&cs=<?php echo $design_arr[$rows['status_c']] ?>","")
	})
</script>
<?php
}
?>