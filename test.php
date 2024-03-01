<?php

    $_result="";

    if (isset($_POST['submit'])){
    	
        require 'mail/phpmailer/PHPMailerAutoload.php';
		$nom = "2726481@collegelacite.ca";
    	$mail = new phpmailer;
        $mail->isSMTP();

        $mail->Host='mail.ashkloud.com';
        $mail->Port=465;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='ssl';

        $mail->Username='admin@boca-grpservices.com';
        $mail->Password='Owz4l51UB%';

        //$mail->setFrom($_POST['email'],$_POST['name']);
		$mail->setFrom('admin@boca-grpservices.com');

        //$mail->addAddress('monkamjohvani2@gmail.com');
		$mail->addAddress('admin@boca-grpservices.com');

        //$mail->addReplyTo($_POST['email'],$_POST['name']);

        $mail->isHTML(true);
        $mail->Subject='Devis Client: '.$_POST['subject'];
        $mail->Body='<h1 align=center>Name:'.$_POST['name'].'<br>Telephone: '.$_POST['phone'].'<br>Email: '.$_POST['email'].'<br>Ville de depart: '.$_POST['ville_depart'].'<br>Ville du destinataire: '.$_POST['ville_destnataire'].'<br>Poids du colis: '.$_POST['poids'].'</h1>';

        if(!$mail->send()){
            $_result="erreur!!";
        }
        else{
            $result="Merci ".$_POST['name']."de nous avoir contacté. A Bientot!";
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<body>
	<!--page start-->
    <div class="page">
        <div class="site-main">
            <!--fid-section end -->
            
            <!-- multiple-section -->
            <section id="devis" class="cmt-row multiple-section mt-70 res-991-mt-0 cmt-bgcolor-darkgrey cmt-bg cmt-bgimage-yes bg-img1 clearfix ">
                <div class=" cmt-bg-layer cmt-row-wrapper-bg-layer"></div>
                <div class="container-fluid">
                    <div class="fade-in">
                        <!--row-->
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="brocken-wrap-form res-991-mt-30"> 
                                    <div class="cmt-bgcolor-white box-shadow z-index-U">
                                        <div class="cmt-bgcolor-skincolor w-100 d-flex">
                                            <div class="cmt-icon cmt-icon_element-size-sm">
                                                <i class="flaticon-email-1"></i>
                                            </div>
                                            <!--section-title-->
                                            <div class="title-header">
                                                <h2 class="title">Devis</h2>
                                            </div><!--section-title end-->
                                        </div>
                                        <form id="cmt-contactform-1" class="cmt-contactform-1 wrap-form clearfix spacing-6" method="post" action="" >
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="name" type="text" value="" placeholder="Nom" required="required"></span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="email" type="text" value="" placeholder="Email" required="required"></span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="phone" type="text" value="" placeholder="Téléphone" required="required"></span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="subject" type="text" value="" placeholder="Objet" required="required"></span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="ville_depart" type="text" value="" placeholder="Ville de Départ" required="required"></span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>
                                                        <span class="text-input"><input name="ville_destnataire" type="text" value="" placeholder="Ville destinataire" required="required"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>
                                                        <span class="text-input"><input name="poids" type="text" value="" placeholder="Poids" required="required"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="submit" name="submit" id="submit" value="Envoi devis" class="submit cmt-btn cmt-btn-size-md cmt-btn-shape-square cmt-btn-style-fill cmt-btn-color-darkgrey w-100">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--End multiple-section-->
</body>

</html>