<?php
if (isset($_GET['id'])){

  include("../Gestion_location/inc/connect_db.php");
  $id_client = $_GET['id'];
  $query = "SELECT C.id_contrat,C.date_contrat,C.caution,C.num_cheque_caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,C.date_ajoute,CL.id_client,CL.nom,CL.email,CL.tel,CL.adresse,CL.cin,V.type,V.pimm,V.id_voiture,MM.Model,MM.Marque
  FROM contrat_client AS C 
  LEFT JOIN client AS CL ON C.id_client =CL.id_client 
  LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
  LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
  WHERE DATE(NOW()) <= C.date_fin 
  AND  C.type_location = 'Vehicule'
  AND C.id_client =CL.id_client
  AND C.id_contrat = $id_client";
  
  $result = mysqli_query($conn, $query);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $Contrat_number = $row['id_contrat'];
                  $Contrat_date_debut = $row['date_debut'];
                  $Contrat_date_debut = date("d-m-Y", strtotime($Contrat_date_debut));
                  $Contrat_date_fin = $row['date_fin'];
                  $Contrat_date_fin = date("d-m-Y", strtotime($Contrat_date_fin));
                  
                  $Contrat_price = $row['prix'];
                  $Contrat_caution = $row['caution'];
                  $Contrat_num_cheque = $row['num_cheque_caution'];
                  $Contrat_mode_paiement = $row['mode_de_paiement'];
                  $Contrat_duration = $row['duree'];
                  $Contrat_km = $row['KMPrevu'];
                  $Contrat_date_ajout = $row['date_contrat'];
                  $Contrat_date_ajout = date("d-m-Y", strtotime($Contrat_date_ajout));
  
                  $Client_name = $row['nom'];
                  $Client_mail = $row['email'];
                  $Client_tel = $row['tel'];
                  $Client_adress = $row['adresse'];
  
                  $Vehicule = $row['type'];
                  $Vehicule_model = $row['Model'];
                  $Vehicule_marque = $row['Marque'];
                  $Vehicule_imm = $row['pimm'];
              }
          }


require('fpdf.php');

class PDF extends FPDF
{
protected $col = 0; // Colonne courante
protected $y0;      // Ordonnée du début des colonnes
function Header()
{
    global $titre;
        $this->SetFont('Arial','B',12);
        $w = $this->GetStringWidth($titre)+20;
        $this->SetX((310-$w)/8);
        $this->SetTextColor(220,50,50);
        $this->Cell($w,35,utf8_decode($titre),0,1,'C',false);
        $this->Ln(-13);
        $this->y0 = $this->GetY(); 
}
function Footer()
{
    // Pied de page
    $this->SetY(-25);
    $this->SetFont('Arial','I',6);
    $this->SetTextColor(128);
    $this->Cell(0,20,'Page '.$this->PageNo(),0,0,'R');
  
}
function SetCol($col)
{
    // Positionnement sur une colonne
    $this->col = $col;
    $x = 10 + $col * 50;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}
function AcceptPageBreak()
{
    // Méthode autorisant ou non le saut de page automatique
    if($this->col<3)
    {
        // Passage à la colonne suivante
        $this->SetCol($this->col+1);
        // Ordonnée en haut
        $this->SetY($this->y0);
        // On reste sur la page
        return false;
    }
    else
    {
        // Retour en première colonne
        $this->SetCol(0);
        // Saut de page
        return true;
    }
}
function printTableHeader($header,$w){
	//Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],'LRT',0,'C');
	$this->Ln();
	//Restauration des couleurs et de la police pour les données du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');
 
}
function table($header,$w,$al,$datas){
	//Impression de l'entête tableau
	$this->SetLineWidth(.3);
	$this->printTableHeader($header,$w);
 
	$posStartX=$this->getX();	
	$posBeforeX=$posStartX;
 
	$posBeforeY=$this->getY();
	$posAfterY=$posBeforeY;
	$posStartY=$posBeforeY;
 
	//On parcours le tableau des données
	foreach($datas as $row){
		$posBeforeX=$posStartX;
		$posBeforeY=$posAfterY;
 
		//On vérifie qu'il n'y a pas débordement de page.
		$nb=0;
		for($i=0;$i<count($header);$i++){
			$nb=max($nb,$this->NbLines($w[$i],$row[$i]));
		}
		$h=6*$nb;
 
		//Effectue un saut de page si il y a débordement
		$resultat = $this->CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY);
		if($resultat>0){
			$posAfterY=$resultat;
			$posBeforeY=$resultat;
			$posStartY=$resultat;
		}
 
		//Impression de la ligne
		for($i=0;$i<count($header);$i++){
			$this->MultiCell($w[$i],6,strip_tags($row[$i]),'',$al[$i],false);
			//On enregistre la plus grande hauteur de cellule
			if($posAfterY<$this->getY()){
				$posAfterY=$this->getY();
			}
			$posBeforeX+=$w[$i];
			$this->setXY($posBeforeX,$posBeforeY);
		}
		//Tracé de la ligne du dessous
		$this->Line($posStartX,$posAfterY,$posBeforeX,$posAfterY);
		$this->setXY($posStartX,$posAfterY);
	}
 
	//Tracé des colonnes
	$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
}
function PrintCols($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,$posAfterY);
	$colX=$posStartX;
	//On trace la ligne pour chaque colonne
	foreach($w as $row){
		$colX+=$row;
		$this->Line($colX,$posStartY,$colX,$posAfterY);
	}
}
function CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY){
	//Si la hauteur h provoque un débordement, saut de page manuel
	if($this->GetY()+$h>$this->PageBreakTrigger){
		//On imprime les colonnes de la page actuelle
		$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
		//On ajoute une page
		$this->AddPage();
		//On réimprime l'entête du tableau
		$this->printTableHeader($header,$w);
		//On renvoi la position courante sur la nouvelle page
		return $this->GetY();
	}
	//On a pas effectué de saut on revoie 0
	return 0;
}
function NbLines($w,$txt){
  $cw=&$this->CurrentFont['cw'];
  if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r",'',$txt);
  $nb=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
      $nb--;
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $nl=1;
  while($i<$nb)
  {
      $c=$s[$i];
      if($c=="\n")
      {
          $i++;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
          continue;
      }
      if($c==' ')
          $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax)
      {
          if($sep==-1)
          {
              if($i==$j)
                  $i++;
          }
          else
              $i=$sep+1;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
      }
      else
          $i++;
  }
  return $nl;
}
function CorpsChapitre($fichier)
{
    // Lecture du fichier texte
    $txt = file_get_contents($fichier);
    $this->Image('logok2.jpg',10,13,20,15);
    // Police
    $this->SetFont('Arial','',6.5);
    // Sortie du texte sur 6 cm de largeur
    $this->MultiCell(47,2.4,utf8_decode($txt));
    $this->Ln();
    // Mention
    $this->SetFont('','B','I');
    $this->Cell(0,"2","Paraphe");
    // Retour en première colonne
    $this->SetCol(0);
}

function AjouterChapitre($num, $titre, $fichier)
{
    // Ajout du chapitre
    $this->AddPage();
    // $this->TitreChapitre($num,$titre);
    $this->CorpsChapitre($fichier);
}
function VerifPage()
{
  if( (($this->GetY())==0) | (($this->GetY())>=240) ) {
    $this->AddPage();
  }
}
}

$pdf = new PDF('P','mm','A4');
// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
define('EURO',chr(128));
$pdf->SetTitle(utf8_decode('CONTRAT DE LOCATION N°'). $Contrat_number);
$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N°'). $Contrat_number,0,2,'',false);

$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

//Tableau
$position=0;
$prixTotal=0;
$prixTotalHorsTaxes=0;
$totalTtc=0;
//Création des données qui seront contenues la table
$datas = array();
$datas[] = array("Nom: ".$Client_name."\n"."Mail: ".$Client_mail."\n"."Tel: ".$Client_tel."\n"."Adresse: ".$Client_adress,utf8_decode("Véhicule: ".$Vehicule."\n"."Marque: ".$Vehicule_marque." ".$Vehicule_model."\n"."Immatriculation: ".$Vehicule_imm));
//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('INFORMATIONS VÉHICULE'));
//Tableau contenant la largeur des colonnes
$w=array(90,100);
//Tableau contenant le centrage des colonnes
$al=array('L','L');
//Génération de la table à proprement dite
$pdf->table($header,$w,$al,$datas);

$pdf->SetY($pdf->GetY()+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->SetY($pdf->GetY()+8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le matériel loué a bien un rapport direct avec son activité et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le matériel est livré ce jour, qu'il est conforme à sa désignation, aux prescriptions des règlements d'hygiène et de sécurité du travail, qu'il est en bon état de fonctionnement sans vice apparent ou caché et répond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme à la réglementation relative à la pollution et à la protection de l'environnement.";
$pdf->MultiCell(0,5,utf8_decode($texte1));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,'AUTRE INFORMATIONS',0,0);
$pdf->SetY($pdf->GetY()+8);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('État du véhicule:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du véhicule et lors de sarestitution, une fiche de contrôle de l'état du véhicule sera établie entre le locataire et le loueur. Le véhicule devra être restitué dans le même état que lors de sa mise à disposition au locataire. Toutes les détériorations sur le véhicule constatées sur le PV de sortie seront à la charge du locataire et/ou être déduites en partie ou totalité sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Durée:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$Contrat_date_debut." "."au"." ".$Contrat_date_fin);
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$Contrat_price_ttc = $Contrat_price + $Contrat_price* 0.2 ;
if ($Contrat_duration == "Standard") {
        $texte3 = "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."."\n"
        .$Contrat_price." Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc." euros. "."\n".
        "Kilométrage prévu 30000 km/an (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Jour") {
        $texte3 = $Contrat_price. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/jour (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $Contrat_price. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/semaine (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Mois") {
        $texte3 = $Contrat_price. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/mois (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "LLD") {
        $texte3 = "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).
        Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
        .$Contrat_price. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc. " euros.";
}
$pdf->MultiCell(0,5,utf8_decode($texte3));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte4 = "Les loyers sont dus à date échu. Le premier paiement s'effectuera le jour de la mise à disposition du matériel.";
if ($Contrat_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectués.";
  } else if ($Contrat_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectués.";
  } else if ($Contrat_mode_paiement == "Prélèvements automatiques") {
    $texte5 = "Des prélèvements automatiques seront effectués.";
  } else if ($Contrat_mode_paiement == "Espèces") {
    $texte5 = "Des paiements en espèces seront effectués.";
  } else {
    $texte5 = "Chèque";
  }
$pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Dépôt de garantie:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " à titre de dépôt de garantie pour répondre des dégâts qui pourraient être causés aux matériels loués. Le remboursement du dépôt de garantie sera effectué au retour du matériel si celui-ci n'a pas été endommagé. 
N° de chèque de caution : ";
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse à K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6).$Contrat_num_cheque);
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Documents à fournir:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte7 = "Pièce d'identité du gérant 
Permis du gérant. 
Rib. 
Kbis de moins de 3 mois. 
Attestation d'assurance responsabilité civile. ";
$pdf->MultiCell(0,5,utf8_decode($texte7));
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->SetY($pdf->GetY()+5);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Autre elements et accessoires:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Le locataire prendra en charge l'ensemble des charges afférentes à la mise à disposition du véhicule:";
$pdf->Cell(0,5,utf8_decode($texte8));
$pdf->SetY($pdf->GetY()+10);
$pdf->Cell(50, 0,utf8_decode("        - Frais d'entretien(lave glace, liquide de refroidissement, adBlue)."));
$pdf->SetY($pdf->GetY()+5);
$pdf->Cell(50, 0,utf8_decode("        - Les frais de carburant et de stationnement."));
$pdf->SetY($pdf->GetY()+10);
$pdf->Cell(80, 0,utf8_decode("La sous-location du véhicule par le locataire à un tiers est exclue ."));
$pdf->SetY($pdf->GetY()+10);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat relèvera de la compétence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis à chacune des parties, A CHEVIGNY SAINT SAUVEUR, le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$Contrat_date_ajout.".");
$pdf->VerifPage();
$pdf->SetY($pdf->GetY()+15);
$texte9 = "Le locataire soussigné déclare accepter toutes les conditions générales figurant sur les pages suivantes du contrat qui été établi en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de prélèvement ci-dessous et paraphe de chaque page.";
$pdf->MultiCell(0,5,utf8_decode($texte9));
$pdf->VerifPage();
$pdf->SetY($pdf->GetY()+15);
$Y3 = $pdf->GetY();
$pdf->Line(10, $Y3, 200, $Y3);
$pdf->Line(10, $Y3, 10, $Y3 + 50);
$pdf->Line(100, $Y3, 100, $Y3 + 50);
$pdf->Line(200, $Y3, 200, $Y3 + 50);
$pdf->Line(10, $Y3 + 50, 200, $Y3 + 50);
$pdf->SetY($pdf->GetY()+5);
$y4 = $pdf->GetY();
$x4 = $pdf->GetX();
$texte10 = "Cachet commercial et signature du LOCATAIRE (client)";
$texte11 = "précédée de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR";
$pdf->Cell($x4 + 80, 0,utf8_decode($texte10), 'LR', 0,'C');
$pdf->Cell($x4 + 80, 0,utf8_decode($texte12), 'LR', 0,'C');
$pdf->SetY($pdf->GetY()+5);
$pdf->Cell($x4 + 80, 0,utf8_decode($texte11), 'LR', 0,'C');
$pdf->SetY($pdf->GetY()+50);
$pdf->SetFont('','B','I');
$x5 = $pdf->GetX();
$pdf->Cell($x5 + 300, 0,"Paraphe", 'LR', 0,'C');
$titre = "Conditions Générales de Location de Matériel d'entreprise sans opérateur" ;
$pdf->AjouterChapitre(1,$titre,utf8_decode('contrat1.txt'));
$pdf->Image('logok2.jpg',10,13,20,15);
$pdf->Output();
}
else {
  echo "erreur";
}
?>