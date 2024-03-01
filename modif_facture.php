<?php
if(!isset($conn)){ include 'db_connect.php'; } 
    $getID = $_GET['id'];
    $number = "";

    $query = "SELECT invoice.sid, invoice.sender_name, invoice.recipient_name, invoice.date_depot, invoice.sender_address, invoice.recipient_address, invoice.note,
              invoice.sender_email, invoice.recipient_email, invoice.invoice_no, invoice.grand_total, invoice.grand_euro, invoice.total_reduction, invoice.num_conteneur,
              destination.id as destination,
              invoice_products.pname, invoice_products.weight, invoice_products.pricecol, invoice_products.height, invoice_products.length, invoice_products.width, 
              invoice_products.vol, invoice_products.pricevol, invoice_products.reduction, invoice_products.total
              from conteneur
              INNER JOIN invoice
              ON invoice.num_conteneur = conteneur.id
              INNER JOIN destination
              ON invoice.destination = destination.id
              INNER JOIN invoice_products
              ON invoice.sid = invoice_products.SID
              where invoice.sid = '" . $conn->real_escape_string($getID) . "'";

    $conteneur = $conn->query("SELECT * FROM conteneur ");
    $design_arr[0]= "Unset";
    while($row=$conteneur->fetch_assoc()){
      $design_arr[$row['nom_c']] =$row['id'];
    }


    $result = mysqli_query($conn, $query);

    if($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        //détails produits
        $sender_name = $row['sender_name'];
        $sender_address = $row['sender_address'];
        $sender_email = $row['sender_email'];
        $date_depot = date("d-m-Y",strtotime($row["date_depot"]));
        $recipient_name = $row['recipient_name'];
        $recipient_address = $row['recipient_address'];
        $recipient_email = $row['recipient_email'];
        $note = $row['note'];
        $grand_total = $row['grand_total'];
        $grand_euro = $row['grand_euro'];
        $number = $row['invoice_no'];
        $total_reduction = $row['total_reduction'];
        $desti = $row['destination'];
        $conteneur = $row['num_conteneur'];
        $pname = $row['pname'];
        $weight = $row['weight'];
        $pricecol = $row['pricecol'];
        $height = $row['height'];
        $length = $row['length'];
        $width = $row['width'];
        $vol = $row['vol'];
        $pricevol = $row['pricevol'];
        $reduction = $row['reduction'];
        $total = $row['total'];
      }
    }

    if(isset($_POST["submit"])){
      $num_conteneur=mysqli_real_escape_string($conn,$_POST["num_conteneur"]);
      $sender_name=mysqli_real_escape_string($conn,$_POST["sender_name"]);
      $sender_address=mysqli_real_escape_string($conn,$_POST["sender_address"]);
      $sender_email=mysqli_real_escape_string($conn,$_POST["sender_email"]);
      $date_depot=date("Y-m-d",strtotime($_POST["date_depot"]));
      $recipient_name=mysqli_real_escape_string($conn,$_POST["recipient_name"]);
      $recipient_address=mysqli_real_escape_string($conn,$_POST["recipient_address"]);
      $recipient_email=mysqli_real_escape_string($conn,$_POST["recipient_email"]);
      $destination=mysqli_real_escape_string($conn,$_POST["destination"]);
      $note=mysqli_real_escape_string($conn,$_POST["note"]);
      $total_reduction=mysqli_real_escape_string($conn,$_POST["total_reduction"]);
      $grand_euro=mysqli_real_escape_string($conn,$_POST["grand_euro"]);
      $grand_total=mysqli_real_escape_string($conn,$_POST["grand_total"]);

      $sql = "UPDATE invoice 
              SET sender_name = '$sender_name', num_conteneur = '$num_conteneur', sender_address = '$sender_address', sender_email = '$sender_email',
              date_depot = '$date_depot', recipient_name = '$recipient_name', recipient_address = '$recipient_address', recipient_email = '$recipient_email',
              destination = '$destination', note = '$note', total_reduction = '$total_reduction', creance = '$grand_total', 
              grand_euro = '$grand_euro', grand_total = '$grand_total'
              WHERE  sid = '" . $conn->real_escape_string($getID) . "'";
      
      if ($conn->query($sql) === TRUE) {
        echo "succès";
        $requete = "DELETE FROM invoice_products WHERE  SID = '" . $conn->real_escape_string($getID) . "'";
        if ($conn->query($requete) === TRUE) {
          echo "succès suppression";

          //$sid=$conn->insert_id;
          $sql2="insert into invoice_products (SID,pname,weight,pricecol,height,length,width,vol,pricevol,reduction,total) values ";

          $rows=[];
            for($i=0;$i<count($_POST["pname"]);$i++)
          {
            $pname=mysqli_real_escape_string($conn,$_POST["pname"][$i]);
            $weight=mysqli_real_escape_string($conn,$_POST["weight"][$i]);
            $pricecol=mysqli_real_escape_string($conn,$_POST["pricecol"][$i]);
            $height=mysqli_real_escape_string($conn,$_POST["height"][$i]);
            $length=mysqli_real_escape_string($conn,$_POST["length"][$i]);
            $width=mysqli_real_escape_string($conn,$_POST["width"][$i]);
            $vol=mysqli_real_escape_string($conn,$_POST["vol"][$i]);
            $pricevol=mysqli_real_escape_string($conn,$_POST["pricevol"][$i]);
            $reduction=mysqli_real_escape_string($conn,$_POST["reduction"][$i]);
            $total=mysqli_real_escape_string($conn,$_POST["total"][$i]);
            $rows[]="('{$getID}','{$pname}','{$weight}','{$pricecol}','{$height}','{$length}','{$width}','{$vol}','{$pricevol}','{$reduction}','{$total}')";
          }

          $sql2.=implode(",",$rows);
          if ($conn->query($sql2) === TRUE) {
            //$request = "DELETE FROM paiement WHERE  SID = '" . $conn->real_escape_string($getID) . "'";
            echo "succès tableau";

            echo '<script>
              			location.href = "index.php?page=liste_des_factures";
              		</script>';
            
          }else 
          {
            echo "Erreur tableau: " . $conn->error;
          }
        }else 
        {
          echo "Erreur suppression: " . $conn->error;
        }
      } else 
      {
        echo "Erreur: " . $conn->error;
      }
    }
?>
<form method="post" action=''>
        <input type="hidden" name="id" value="<?php echo isset($sid) ? $sid : '' ?>">

        <div id="msg" class=""></div>
          <b class="text-center">Fiche de dépot client pour expédition</b>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="" class="control-label">Expéditeur</label>
                <input type="text" name="sender_name" id="" class="form-control form-control-sm" value="<?php echo isset($sender_name) ? $sender_name : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Téléphone </label>
                <input type="text" name="sender_address" id="" class="form-control form-control-sm" value="<?php echo isset($sender_address) ? $sender_address : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input type="text" name="sender_email" id="" class="form-control form-control-sm" value="<?php echo isset($sender_email) ? $sender_email : '' ?>" required>
              </div>
              <div class="form-group ">
                <label for="" class="control-label">N° du conteneur</label>
                <select name="num_conteneur" id="num_conteneur" class="form-control select2" required>
                    <option value=""></option>
                    <?php 
                    $num_conteneur = $conn->query("SELECT * FROM conteneur");
                        while($row = $num_conteneur->fetch_assoc()):
                    ?>

                    <option value="<?php echo $row['id'] ?>" <?php echo isset($conteneur) && $conteneur == $row['id'] ? "selected":'' ?>><?php echo $row['nom_c']?></option>
                    <?php endwhile; ?>
                </select>
              </div>
              <div class="form-group ">
                <label for="" class="control-label">Destination</label>
                <select name="destination" id="destination" class="form-control select2" required>
                    <option value=""></option>
                    <?php 
                    $destination = $conn->query("SELECT * FROM destination");
                        while($row = $destination->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($desti) && $desti == $row['id'] ? "selected":'' ?>><?php echo $row['nom']?></option>
                    <?php endwhile; ?>
                </select>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="" class="control-label">Destinataire</label>
                <input type="text" name="recipient_name" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_name) ? $recipient_name : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Teléphone</label>
                <input type="text" name="recipient_address" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_address) ? $recipient_address : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input type="text" name="recipient_email" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_email) ? $recipient_email : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Date de dépot du colis</label>
                <input type="date" name="date_depot" id="" class="form-control form-control-sm" value="<?php echo date('Y-m-d', strtotime($date_depot));  ?>" required>
              </div>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="" class="control-label">Caractéristiques du colis</label>
          <input type="text" height="100" placeholder="Notes additionnelles concernant l'expédition..." name="note" id="note" class="form-control form-control-sm" value="<?php echo isset($note) ? $note : '' ?>" >
        </div>
        <!--<hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="dtype">Type</label>
              <input type="checkbox" name="type" id="dtype" <?php echo isset($type) && $type == 1 ? 'checked' : '' ?> data-bootstrap-switch data-toggle="toggle" data-on="Deliver" data-off="Pickup" class="switch-toggle status_chk" data-size="xs" data-offstyle="info" data-width="5rem" value="1">
              <small>Deliver = Deliver to Recipient Address</small>
              <small>, Pickup = Pickup to nearest Branch</small>
            </div>
          </div>
          <div class="col-md-6" id=""  <?php echo isset($type) && $type == 1 ? 'style="display: none"' : '' ?>>
            <?php if($_SESSION['login_branch_id'] <= 0): ?>
              <div class="form-group" id="fbi-field">
                <label for="" class="control-label">Branch Processed</label>
              <select name="from_branch_id" id="from_branch_id" class="form-control select2" required="">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($from_branch_id) && $from_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="from_branch_id" value="<?php echo $_SESSION['login_branch_id'] ?>">
            <?php endif; ?>  
            <div class="form-group" id="tbi-field">
              <label for="" class="control-label">Pickup Branch</label>
              <select name="to_branch_id" id="to_branch_id" class="form-control select2">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($to_branch_id) && $to_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>-->
        <hr>
        <b>Informations de la facture</b>
        <table class="table table-bordered" id="parcel-items">
          <thead>
            <tr>
              <th class="text-center">Produit</th>
              <th width="50" class="text-center" >Quantité</th>
              <th width="130" class="text-center">Prix/colis</th>
              <th width="50" class="text-center">Hauteur</th>
              <th width="50" class="text-center">Longueur</th>
              <th width="50" class="text-center">Largeur</th>
              <th width="50" class="text-center">Volume</th>
              <th width="130" class="text-center">Prix/m³</th>
              <th width="120" class="text-center">Réduction</th>
              <th class="text-center">Prix Total</th>
              <?php if(!isset($sid)): ?>
              <th></th>
            <?php endif; ?>
            </tr>
          </thead>
          <tbody id='product_tbody'>
            <?php
              if(!isset($conn)){ include 'db_connect.php'; } 
              $getID = $_GET['id'];
              // the query
						  $query2 = "SELECT * FROM invoice_products WHERE SID = '" . $conn->real_escape_string($getID) . "'";

              $result2 = mysqli_query($conn, $query2);

              if($result2) {
                while ($rows = mysqli_fetch_assoc($result2)) {
                  $pname = $rows['pname'];
                  $weight = $rows['weight'];
                  $pricecol = $rows['pricecol'];
                  $height = $rows['height'];
                  $length = $rows['length'];
                  $width = $rows['width'];
                  $vol = $rows['vol'];
                  $pricevol = $rows['pricevol'];
                  $reduction = $rows['reduction'];
                  $total = $rows['total'];
            ?>
            <tr>
              <td><input type='text'  name='pname[]' class='form-control' value="<?php echo isset($pname) ? $pname :'' ?>"></td>
              <td><input type='text'  name='weight[]' class='form-control qty' value="<?php echo isset($weight) ? $weight :'' ?>"></td>
              <td><input type='text'  name='pricecol[]' class='form-control pricecol' class='form-control' value="<?php echo isset($pricecol) ? $pricecol :'' ?>"></td>
              <td><input type='text'  name='height[]' class='form-control height' value="<?php echo isset($height) ? $height :'' ?>"></td>
              <td><input type='text'  name='length[]' class='form-control length' value="<?php echo isset($length) ? $length :'' ?>"></td>
              <td><input type='text'  name='width[]' class='form-control width'  value="<?php echo isset($width) ? $width :'' ?>"></td>
              <td><input type='text'  name='vol[]' class='form-control vol' value="<?php echo isset($vol) ? $vol :'' ?>"></td>
              <td><input type='text'  name='pricevol[]' class='form-control pricevol' value="<?php echo isset($pricevol) ? $pricevol :'' ?>"></td>
              <td><input type='text'  name='reduction[]' class='form-control reduction' value="<?php echo isset($reduction) ? $reduction :'' ?>"></td>
              <td><input type='text'  name='total[]' class='form-control total' value="<?php echo isset($total) ? $total :'' ?>"></td>
              <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td>
            </tr>
            <?php
                }
              }
            ?>
            
          </tbody>
              <?php if(!isset($sid)): ?>
          <tfoot>
            <tr>
              <td><input type='button' value='+ Ajouter une ligne' class='btn btn-primary btn-sm' id='btn-add-row'></td>
              <td colspan='7' class='text-right'>Total en Euro</td>
              <td><input type='text' name='total_reduction' id='total_reduction' class='form-control' value="<?php echo isset($total_reduction) ? $total_reduction :'' ?>" required></td>
              <td><input type='text' name='grand_total' id='grand_total' class='form-control' value="<?php echo isset($grand_total) ? $grand_total :'' ?>" required></td>
            </tr>
            <tr>
              <td colspan='9' class='text-right'>Total en XAF</td>
              <td><input type='text' name='grand_euro' id='grand_euro' class='form-control' value="<?php echo isset($grand_euro) ? $grand_euro :'' ?>" required></td>
            </tr>
          </tfoot>
              <?php endif; ?>
        </table>
        <input type='submit' name='submit' value='Enregistrer la facture' class='btn btn-success float-right'>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=liste_des_factures">Annuler</a>
      </form>
  	</div>
	</div>
</div>
<div id="ptr_clone" class="d-none">
  <table>
    <tr>
        <td><input type="text" name='weight[]' required></td>
        <td><input type="text" name='height[]' required></td>
        <td><input type="text" name='length[]' required></td>
        <td><input type="text" name='width[]' required></td>
        <td><input type="text" class="text-right number" name='price[]' required></td>
        <td><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc()"><i class="fa fa-times"></i></button></td>
      </tr>
  </table>
</div>
<script>
  $('#dtype').change(function(){
      if($(this).prop('checked') == true){
        $('#tbi-field').hide()
      }else{
        $('#tbi-field').show()
      }
  })
	$('#manage-parcel').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#parcel-items tbody tr').length <= 0){
      alert_toast("Please add atleast 1 parcel information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_parcel',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
			// if(resp){
      //       resp = JSON.parse(resp)
      //       if(resp.status == 1){
      //         alert_toast('Data successfully saved',"success");
      //         end_load()
      //         var nw = window.open('print_pdets.php?ids='+resp.ids,"_blank","height=700,width=900")
      //       }
			// }
        if(resp == 1){
            alert_toast('Data successfully saved',"success");
            setTimeout(function(){
              location.href = 'index.php?page=parcel_list';
            },2000)

        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }

  $("#btn-add-row").click(function(){
    var row="<tr> <td><input type='text' required name='pname[]' class='form-control'></td> <td><input type='text'  name='weight[]' class='form-control qty'></td> <td><input type='text'  name='pricecol[]' class='form-control pricecol'></td> <td><input type='text'  name='height[]' class='form-control height'></td> <td><input type='text'  name='length[]' class='form-control length'></td> <td><input type='text'  name='width[]' class='form-control width'></td> <td><input type='text'  name='vol[]' class='form-control vol'></td> <td><input type='text'  name='pricevol[]' class='form-control pricevol'></td> <td><input type='text'  name='reduction[]' class='form-control reduction'></td> <td><input type='text'  name='total[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
    $("#product_tbody").append(row);
  });

  $("body").on("click",".btn-row-remove",function(){
    if(confirm("Are You Sure?")){
      $(this).closest("tr").remove();
      total_reduction();
      grand_total();
    }
  });

  $("body").on("keyup",".length",function(){
    var length=Number($(this).val());
    var width=Number($(this).closest("tr").find(".width").val());
    var height=Number($(this).closest("tr").find(".height").val());

    //var grand_euro=Number($(this).closest("tr").find(".grand_euro").val());

    var qty=Number($(this).closest("tr").find(".qty").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());

    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}

    volume();
    total_reduction();
    grand_total();
    grand_euro();
  });

  $("body").on("keyup",".width",function(){
    var width=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var height=Number($(this).closest("tr").find(".height").val());

    var qty=Number($(this).closest("tr").find(".qty").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}

    volume();
    total_reduction();
    grand_total();
  });

  $("body").on("keyup",".height",function(){
    var height=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var width=Number($(this).closest("tr").find(".width").val());

    var qty=Number($(this).closest("tr").find(".qty").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());

    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}

    volume();
    total_reduction();
    grand_total();
  });

  $("body").on("keyup",".pricevol",function(){
    var pricevol=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var width=Number($(this).closest("tr").find(".width").val());
    var height=Number($(this).closest("tr").find(".height").val());

    var qty=Number($(this).closest("tr").find(".qty").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}

    volume();
    total_reduction();
    grand_total();
  });

  $("body").on("keyup",".pricecol",function(){
    var pricecol=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var width=Number($(this).closest("tr").find(".width").val());
    var height=Number($(this).closest("tr").find(".height").val());

    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    var qty=Number($(this).closest("tr").find(".qty").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}

    volume();
    total_reduction();
    grand_total();
  });

  $("body").on("keyup",".qty",function(){
    var qty=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var width=Number($(this).closest("tr").find(".width").val());
    var height=Number($(this).closest("tr").find(".height").val());

    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());
    var reduction=Number($(this).closest("tr").find(".reduction").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}
    
    volume();
    total_reduction();
    grand_total();
  });

  $("body").on("keyup",".reduction",function(){
    var reduction=Number($(this).val());
    var length=Number($(this).closest("tr").find(".length").val());
    var width=Number($(this).closest("tr").find(".width").val());
    var height=Number($(this).closest("tr").find(".height").val());

    var qty=Number($(this).closest("tr").find(".qty").val());
    var pricevol=Number($(this).closest("tr").find(".pricevol").val());
    var pricecol=Number($(this).closest("tr").find(".pricecol").val());
    $(this).closest("tr").find(".vol").val(length*width*height);
    $(this).closest("tr").find(".total").val(length*width*height*pricevol);

    if ((!(pricevol == "")) && (!(pricecol == ""))){
			$(this).closest("tr").find(".total").val(0);
		}
		else if ((!(pricevol == "")) && (pricecol == "")){
      $(this).closest("tr").find(".total").val((length*width*height*pricevol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((length*width*height*pricevol)-parseFloat(reduction)) * 664);
		}
		else if ((pricevol == "") && (!(pricecol == ""))){
      $(this).closest("tr").find(".total").val((qty*pricecol)-parseFloat(reduction));
      //$(this).closest("tr").find(".grand_euro").val(((qty*pricecol)-parseFloat(reduction)) * 664);
		}
		else{
			$(this).closest("tr").find(".total").val(0);
		}
    
    volume();
    total_reduction();
    grand_total();
  });



  function volume(){
    var tot=0;
    $(".vol").each(function(){
      tot+=Number($(this).val());
    });
    //$("#volume").val(tot);
  }

  function total_reduction(){
    var toto=0;
    $(".reduction").each(function(){
      toto+=Number($(this).val());
    });
    $("#total_reduction").val(toto);
  }

  function grand_total(){
    var tota=0;
    var toti= 0;
    $(".total").each(function(){
      tota+=Number($(this).val());
      toti = tota * 680;
    });
    $("#grand_total").val(tota);
    $("#grand_euro").val(toti);
  }

</script>


              