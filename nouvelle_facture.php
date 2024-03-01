<?php if(!isset($conn)) { include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">

    <?php
      $query = "SELECT invoice_no FROM invoice ORDER BY invoice_no DESC";
      $result = mysqli_query($conn,$query);
      if ($row = mysqli_fetch_array($result)){
        $lastid = $row['invoice_no'];
      }
      //$lastid = $row['invoice_no'];
      
      if(empty($lastid))
      {
          $number = "IN1123-0001";
      }
      else
      {
        //réupérer 0001 dans "IN1223-0001"
        $id1 = str_replace("IN1223-", "", $lastid);
        //prendre les 2 1er chiffres de IN1223//12(mois)
        $id2 = substr($lastid, 2, 2);
        //prendre les 2 derniers chiffres de IN1123//23(année)
        $id3 = substr($lastid, 4, 2);
        //année actuelle
        $id4 =  date('Y');
        //affiche les 2 derniers chiffres du mois (23 ici)
        $id5 = substr($id4, 2, 2);
        //mois actuel en chiffres
        $id6 =  date('m');

        if($id3 == $id5){
          if($id2 == date('m')){
            $id3 = $id5;
            $id2 = date('m');
            $id1 = str_pad($id1 + 1, 4, 0, STR_PAD_LEFT);
          }
          else{
            $id3 = $id5;
            $id2 = date('m');
            $id1 = 1;
            $id1 = str_pad($id1, 4, 0, STR_PAD_LEFT);
          }
        }
        else{
          $id1 = 1;
          $id1 = str_pad($id1, 4, 0, STR_PAD_LEFT);
          $id3 = date('Y');
          $id3 = substr($id3, 2, 2);
          $id2 = date('m');
        }
        $number = 'IN'.$id2.$id3.'-'.$id1;
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
        
        $sql="insert into invoice (invoice_no,num_conteneur,sender_name,sender_address,sender_email,date_depot,recipient_name,recipient_address,recipient_email,destination,note,total_reduction,creance,grand_total,grand_euro) 
        values ('{$number}','{$num_conteneur}','{$sender_name}','{$sender_address}','{$sender_email}','{$date_depot}','{$recipient_name}','{$recipient_address}','{$recipient_email}','{$destination}','{$note}','{$total_reduction}','{$grand_total}','{$grand_total}','{$grand_euro}') ";
        if($conn->query($sql)){
          $sid=$conn->insert_id;
          
          $sql2="insert into invoice_products (SID,pname,weight,pricecol,height,length,width,vol,pricevol,reduction,total) values ";
          //$sql2="insert into invoice_products (SID,pname,weight,pricecol,height,length,width,vol,pricevol,total) values ('{$sid}','{$pname}')";
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
            $rows[]="('{$sid}','{$pname}','{$weight}','{$pricecol}','{$height}','{$length}','{$width}','{$vol}','{$pricevol}','{$reduction}','{$total}')";
          }
          $sql2.=implode(",",$rows);
          if($conn->query($sql2)){
            $sql3="insert into paiement (sid,date_paiement,type_paiement,montant,compte_credite) values ('{$sid}','0','0','0','0') ";
            if($conn->query($sql3)){
              echo "<meta http-equiv='refresh' content='0'>"; 
              echo '<script>
              location.href = "index.php?page=liste_des_factures";
              </script>';
            }else{
              echo "erreur";
            }
          }else{
            echo "<div class='alert alert-danger'>Échec de l'ajout de la facture.</div>";
          }
        }else{
          echo "<div class='alert alert-danger'>Échec de l'ajout de la facture.</div>";
        }
      }
		?>

    <!--id="manage-parcel"id du formulaire--> 
			<form method="post" action=''>
        <input type="hidden" name="sid" value="<?php echo isset($sid) ? $sid : '' ?>">

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

                  <option value="<?php echo $row['id'] ?>" <?php echo isset($num_conteneur) && $num_conteneur == $row['id'] ? "selected":'' ?>><?php echo $row['nom_c']?></option>
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
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($destination) && $destination == $row['id'] ? "selected":'' ?>><?php echo $row['nom']?></option>
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
              <input type="date" name="date_depot" id="" class="form-control form-control-sm" value="<?php echo isset($date_depot) ? date('Y-m-d', strtotime($date_depot)) : '' ?>" required>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="" class="control-label">Caractéristiques du colis</label>
          <textarea type="text" cols="30" rows="2" placeholder="Notes additionnelles concernant l'expédition..." name="note" id="note" class="form-control form-control-sm" value="<?php echo isset($note) ? $note : '' ?>" ></textarea>
        </div>
        <hr>
        <b>Informations de la facture</b>
        <table class="table table-bordered" id="parcel-items">
          <thead>
            <tr>
              <th width="" class="text-center">Produit</th>
              <th width="50" class="text-center">Quantité</th>
              <th width="130" class="text-center">Prix/colis</th>
              <th width="50" class="text-center">Haut(m)</th>
              <th width="50" class="text-center">Long(m)</th>
              <th width="50" class="text-center">Larg(m)</th>
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
    /*$('[name="price[]"]').keyup(function(){
      calc()
    })
  $('#new_parcel').click(function(){
    var tr = $('#ptr_clone tr').clone()
    $('#parcel-items tbody').append(tr)
    $('[name="price[]"]').keyup(function(){
      calc()
    })
    $('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9]/, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val)
    })

  })*/
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
      arrondi = Math.round(tota);
      toti = arrondi * 680;
    });
    $("#grand_total").val(arrondi);
    $("#grand_euro").val(toti);
  }

</script>


              