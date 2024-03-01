<?php 
  require ("fpdf/fpdf.php");
  require ("word.php");
  require "db_connect.php"; 

  //customer and invoice details
  $info=[
    "num_conteneur"=>"",
    "sender_name"=>",",
    "sender_address"=>"",
    "sender_email"=>"",
    "nombre_colis"=>"",
    "date_depot"=>"",
    "recipient_name"=>"",
    "recipient_address"=>"",
    "recipient_email"=>"",
    "invoice_no"=>"",
    "note"=>"",
    "total"=>"",
    "total_xaf"=>"",
    "words"=>"",
  ];
  
  //Select Invoice Details From Database

  $sql = "SELECT invoice.SID, invoice.sender_name, invoice.recipient_name, invoice.date_depot, invoice.sender_address, invoice.recipient_address,
          invoice.sender_email, invoice.note, invoice.recipient_email, invoice.invoice_no, invoice.grand_total, invoice.grand_euro, 
          conteneur.nom_c as conteneur, destination.nom as destination
          from invoice
          INNER JOIN conteneur
          ON invoice.num_conteneur = conteneur.id
          INNER JOIN destination
          ON invoice.destination = destination.id
          where invoice.SID ='{$_GET["id"]}'";

  //$sql="select * from invoice where SID='{$_GET["id"]}'";
  $res=$conn->query($sql);
  if($res->num_rows>0){
	  $row=$res->fetch_assoc();
	  
	  $obj=new IndianCurrency($row["grand_total"]);
	 

	  $info=[
		"num_conteneur"=>$row["conteneur"],
		"sender_name"=>$row["sender_name"],
		"recipient_name"=>$row["recipient_name"],
    "date_depot"=>date("d-m-Y",strtotime($row["date_depot"])),
    "sender_address"=>$row["sender_address"],
    "recipient_address"=>$row["recipient_address"],
    "sender_email"=>$row["sender_email"],
    "recipient_email"=>$row["recipient_email"],
    "destination"=>$row["destination"],
    "invoice_no"=>$row["invoice_no"],
    "total"=>$row["grand_total"],
    "note"=>$row["note"],
    "total_xaf"=>$row["grand_euro"],
		"words"=> $obj->get_words(),
	  ];

    require "db_connect.php"; 
    $num_conteneur = $conn->query("SELECT * FROM conteneur ");
    $design_arr[0]= "Unset";
    while($row=$num_conteneur->fetch_assoc()){
    $design_arr[$row['id']] =$row['nom_c'];
    }

    
  }
  
  //invoice Products
  $products_info=[];
  
  //Select Invoice Product Details From Database
  $sql="select * from invoice_products where SID='{$_GET["id"]}'";
  $res=$conn->query($sql);
  if($res->num_rows>0){
	  while($row=$res->fetch_assoc()){
		   $products_info[]=[
			"name"=>$row["pname"],
			"qté"=>$row["weight"],
			"prix_co"=>$row["pricecol"],
			"hauteur"=>$row["height"],
      "longueur"=>$row["length"],
			"largeur"=>$row["width"],
			"volume"=>$row["vol"],
      "prix_vo"=>$row["pricevol"],
			"total"=>$row["total"],
		   ];
	  }
  }
  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->Image("logoo.png",5,10,50,25,"PNG");
      
    }
    
    function body($info,$products_info){

    

      $this->SetY(16);
      $this->SetX(-51);
      $this->SetFont('Times','B',12);
      $this->Cell(50,7,"Facture ",0,0);
      $this->SetY(16);
      $this->SetX(-36);
      $this->SetFont('Times','B',12);
      $this->Cell(50,7,$info["invoice_no"],0,1);
      $this->SetY(21);
      $this->SetX(-61);
      $this->Cell(50,7,"Delai de livraison: +/-25 jours",0,1,"R");
      
      //Billing Details
      $this->SetY(40);
      $this->SetX(10);

      //1ère ligne
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Num Conteneur: ","LTB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["num_conteneur"],"TBR",0,"R");
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Date depot colis: ","TB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["date_depot"],"TBR",1,"R");

      //2ème ligne
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Expediteur: ","LB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["sender_name"],"BR",0,"R");
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Destinataire: ","B",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["recipient_name"],"BR",1,"R");

      //3ème ligne
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Telephone: ","LB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["sender_address"],"BR",0,"R");
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Telephone: ","B",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["recipient_address"],"BR",1,"R");

      //4ème ligne
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Email: ","LB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["sender_email"],"BR",0,"R");
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Email: ","B",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["recipient_email"],"BR",1,"R");

      //5ème ligne
      $this->SetFont('Times','',12);
      $this->Cell(47.25,5,"Destination: ","LB",0);
      $this->SetFont('Times','B',12);
      $this->Cell(47.25,5,$info["destination"],"BR",1,"R");
      
      //Display Table headings
      $this->SetY(75);
      $this->SetX(10);
      $this->SetFont('Times','B',12);
      $this->Cell(28.5,9,"Produit",1,0,"C");
      $this->Cell(15,9,"Qte",1,0,"C");
      $this->Cell(28.5,9,"Prix/colis",1,0,"C");
      $this->Cell(15,9,"Haut",1,0,"C");
      $this->Cell(15,9,"Long",1,0,"C");
      $this->Cell(15,9,"Larg",1,0,"C");
      $this->Cell(15,9,"Vol(m3)",1,0,"C");
      $this->Cell(28.5,9,"Prix/vol",1,0,"C");
      $this->Cell(28.5,9,"Total",1,1,"R");
      $this->SetFont('Times','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(28.5,9,$row["name"],"LRB",0,"C");
        $this->Cell(15,9,$row["qté"],"RB",0,"C");
        $this->Cell(28.5,9,$row["prix_co"],"RB",0,"C");
        $this->Cell(15,9,$row["hauteur"],"RB",0,"C");
        $this->Cell(15,9,$row["longueur"],"RB",0,"C");
        $this->Cell(15,9,$row["largeur"],"RB",0,"C");
        $this->Cell(15,9,$row["volume"],"RB",0,"C");
        $this->Cell(28.5,9,$row["prix_vo"],"RB",0,"C");
        $this->Cell(28.5,9,$row["total"],"RB",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<8-count($products_info);$i++)
      {
        $this->Cell(28.5,9,"","LR",0,"C");
        $this->Cell(15,9,"","R",0,"R");
        $this->Cell(28.5,9,"","R",0,"C");
        $this->Cell(15,9,"","R",0,"R");
        $this->Cell(15,9,"","R",0,"R");
        $this->Cell(15,9,"","R",0,"R");
        $this->Cell(15,9,"","R",0,"C");
        $this->Cell(28.5,9,"","R",0,"R");
        $this->Cell(28.5,9,"","R",1,"R");
      }
      //Display table total row
      $this->SetFont('Times','B',12);
      $this->Cell(160.5,9,"TOTAL EN EURO",1,0,"R");
      $this->Cell(28.5,9,$info["total"],1,1,"R");

      //Display table total row
      $this->SetFont('Times','B',12);
      $this->Cell(160.5,9,"TOTAL EN FCFA",1,0,"R");
      $this->Cell(28.5,9,$info["total_xaf"],1,1,"R");

      //le notez bien
      $this->SetY(174);
      $this->SetX(10);
      $this->SetFont('Times','B',8);
      $this->Cell(0,9,"NB: La description du contenu du colis est assuree par le client expediteur. \nLes contenus non declares n'engagent aucunement notre responsabilite. En cas de",0,1);

      $this->SetY(177);
      $this->SetX(10);
      $this->SetFont('Times','B',8);
      $this->Cell(0,9,"perte, vol ou deteriorations des colis, le dedommagement ne peut etre excede\n une fois et demi le prix du transport du colis.",0,1);

      $this->SetY(181);
      $this->SetX(10);
      $this->SetFont('Times','B',8);
      $this->Cell(0,9,"ATTENTION: En cas de contentieux seul le tribunal des entreprises de Bruxelles en est competent.",0,1);
      
      //Affichages des agences
      $this->SetY(190);
      $this->SetX(10);

      //1ère ligne
      $this->SetFont('Times','B',8);
      $this->Cell(37.8,5,"BOCA BELGIQUE: ","LTR",0);
      $this->Cell(37.8,5,"BOCA LUXEMBOURG: ","TR",0);
      $this->Cell(37.8,5,"BOCA SUISSE: ","TR",0);
      $this->Cell(37.8,5,"BOCA ALLEMAGNE: ","TR",0);
      $this->Cell(37.8,5,"BOCA FRANCE: ","TR",1);

      //2ème ligne
      $this->SetFont('Times','',7);
      $this->Cell(37.8,5,"TEL: 0032 466 14 33 08","LR",0);
      $this->Cell(37.8,5,"TEL: 0035 661 781 121","R",0);
      $this->Cell(37.8,5,"TEL: 0041 79 340 15 79","R",0);
      $this->Cell(37.8,5,"TEL: 0049 15 21 89 81 408","R",0);
      $this->Cell(37.8,5,"TEL: 0033 788 92 94 93","R",1);

      //3ème ligne
      $this->Cell(37.8,5,"TEL: 0032 483 81 73 24","LR",0);
      $this->Cell(37.8,5,"","R",0);
      $this->Cell(37.8,5,"","R",0);
      $this->Cell(37.8,5,"","R",0);
      $this->Cell(37.8,5,"","R",1);

      //4ème ligne
      $this->Cell(37.8,5,"TEL: 0032 472 50 75 13","LRB",0);
      $this->Cell(37.8,5,"","RB",0);
      $this->Cell(37.8,5,"","RB",0);
      $this->Cell(37.8,5,"","RB",0);
      $this->Cell(37.8,5,"","RB",1);


      //Affichages des transports et signatures
      $this->SetY(215);
      $this->SetX(10);

      //1ère ligne
      $this->SetFont('Times','B',8);
      $this->Cell(35,5,"TRANSPORT MARTIME: ","",0);
      $this->Cell(10,5,"",1,0);
      $this->Cell(25,5,"",0,0);
      $this->Cell(39,5,"SIGNATURE AGENT BOCA: ","B",0);
      $this->Cell(15,5,"",0,0);
      $this->Cell(50,5,"SIGNATURE CLIENT EXPEDITEURS: ","B",1);

      //2ème ligne
      $this->SetFont('Times','B',8);
      $this->Cell(5,2,"",0,1);
      $this->Cell(35,5,"TRANSPORT AERIEN:","R",0);
      $this->Cell(10,5,"",1,1);

      //Affichages des notes de la facture
      $this->SetY(230);
      $this->SetX(10);

      //1ère ligne
      $this->SetFont('Times','B',10);
      $this->Cell(35,5,"Informations du colis : ","",0);
      $this->SetFont('Times','',10);
      $this->Cell(100,5,$info["note"],"",1);
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-38);
      $this->SetFont('Times','B',12);

      //1ère ligne
      $this->SetFont('Times','B',8);
      $this->Cell(43,5,"NUMERO DE COMPTE / IBAN:",0,0);
      $this->Cell(37.8,5,"BE49 0689 0718 7271",0,1);

      //2ème ligne
      $this->SetFont('Times','',8);
      $this->Cell(15,5,"SWIFT/BC:",0,0);
      $this->Cell(37.8,5,"GKCCBEBB",0,1);

      //3ème ligne
      $this->SetFont('Times','B',8);
      $this->Cell(43,5,"communication pour paiement:",0,1);
      $this->SetFont('Times','',8);
      $this->Cell(37.8,5,"Nom expediteur/destinataire suivi du numero du conteneur",0,1);

      //4ème ligne
      $this->SetFont('Times','',8);
      $this->Cell(13,5,"Adresse:",0,0);
      $this->Cell(20,5,"Bergensesteenweg 745 - 1502 Halle/Belgique",0,1);

      //5ème ligne
      $this->Cell(13,5,"Site Web:",0,0);
      $this->Cell(20,5,"https://bocagroupagesetservices.com",0,1);

      //5ème ligne
      $this->Cell(33,5,"CONTACT BRUXELLES:",0,0);
      $this->Cell(20,5,"0032 466 14 33 08 / 0032 483 81 73 24 / 0032 472 50 75 13",0,1);

      //6ème ligne
      $this->SetY(-38);
      $this->SetX(-70);
      $this->SetFont('Times','B',8);
      $this->Cell(43,5,"NUMERO DE COMPTE / Societe Generale (SGC):",0,1);
      $this->SetX(-70);
      $this->Cell(37.8,5,"10003- 03900-06391049083-05",0,1);

      $this->SetY(-28);
      $this->SetX(-70);
      $this->SetFont('Times','',8);
      $this->Cell(33,5,"CONTACT CAMEROUN:",0,0);
      $this->Cell(20,5,"00237 670 688 813",0,1);
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  $pdf->Output();
?>