<?php 
if (isset($_GET['id'])){

include("../Gestion_location/inc/connect_db.php");
define("TVA",0.20);
$id_facture = $_GET['id'];

$query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.mode_de_paiement,C.prix,CL.id_client,CL.nom,CL.codetva,CL.adresse,CL.accompte_client,A.id_agence,A.lieu_agence,A.tel_agence,V.pimm,V.id_voiture,MM.Marque,MM.Model
          FROM  facture_client AS FC
          LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
          LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
          LEFT JOIN agence AS A ON A.id_agence =C.id_agence
          LEFT JOIN voiture AS V ON V.id_voiture =C.id_voiture
          LEFT JOIN marquemodel AS MM ON V.id_MarqueModel =MM.id_MarqueModel
          Where C.type_location = 'Vehicule'
          AND FC.id_facture = $id_facture";

$result = mysqli_query($conn, $query);
    
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    
    $Facture_number = $row['id_facture'];
	$Facture_number = str_pad($Facture_number, 4, '0', STR_PAD_LEFT);
    $Facture_date = $row['date_facture'];
    $Facture_date = date("d/m/Y", strtotime($Facture_date));

    $Contrat_mode_paiement = $row['mode_de_paiement'];
    $Contrat_prix = $row['prix'];

	$Client_id = $row['id_client'];
    $Client_name = $row['nom'];
    $Client_adresse = $row['adresse'];
	$Client_code_tva = $row['codetva'];
	$Client_accompte = $row['accompte_client'];

	$Voiture_id = $row['id_voiture'];
    $Voiture_imm = $row['pimm'];
    $Voiture_marque = $row['Marque'];
    $Voiture_model = $row['Model'];

    $Agence_lieu = $row['lieu_agence'];
    $Agence_tel = $row['tel_agence'];
  }
}

require('fpdf.php');
class PDF extends FPDF
{
protected $col = 0; // Colonne courante
protected $y0;      // Ordonnée du début des colonnes
function Header(){
    global $titre;
        $this->SetFont('Arial','B',12);
        $w = $this->GetStringWidth($titre)+20;
        $this->SetX((310-$w)/8);
        $this->SetTextColor(220,50,50);
        $this->Cell($w,35,utf8_decode($titre),0,1,'C',false);
        $this->Ln(-13);
        $this->y0 = $this->GetY(); }
function SetCol($col){
    // Positionnement sur une colonne
    $this->col = $col;
    $x = 10 + $col * 50;
    $this->SetLeftMargin($x);
    $this->SetX($x);}
function AcceptPageBreak(){
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
    }}
function printTableHeaderCode($header,$w){
	//Couleurs, épaisseur du trait et police grasse
  $this->SetFillColor(255,255,255);
  $this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauration des couleurs et de la police pour les données du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');}
function printTableHeader($header,$w){
	//Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(235,235,235);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauration des couleurs et de la police pour les données du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');}
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
		$this->Line(10,210,200,210);
	
		$this->setXY($posStartX,$posAfterY);
	}
 
	//Tracé des colonnes
	$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
  $this->PrintCols($w,$posStartX,$posStartY,$posAfterY);}
function PrintCols($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,210);
  $this->Line(200,$posStartY,200,210);}
function table1($header,$w,$al,$datas){
	//Impression de l'entête tableau
	$this->SetLineWidth(.3);
	$this->printTableHeaderCode($header,$w);
 
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
			$this->MultiCell($w[$i],8,strip_tags($row[$i]),'',$al[$i],false);
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
	$this->PrintCols1($w,$posStartX,$posStartY,$posAfterY);}
function PrintCols1($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,$posAfterY);
	$colX=$posStartX;
	//On trace la ligne pour chaque colonne
	foreach($w as $row){
		$colX+=$row;
		$this->Line($colX,$posStartY,$colX,$posAfterY);
	}}
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
	return 0;}
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
  return $nl;}



}

function openExchangeRatesConvert($amount, $base, $dest)
{
    $endpoint = 'https://openexchangerates.org/api/latest.json';
    $appId = '34b8c90f27694a2ea9d4ab7abdacfe1a';
    $url = "$endpoint?app_id=$appId";
    $latest = json_decode(file_get_contents($url), true);
 
    return round(($amount / $latest['rates'][$base]) * $latest['rates'][$dest], 2);
}

$pdf = new PDF('P','mm','A4');
// Nouvelle page A4
$pdf->AddPage();
define('EURO',chr(128));
$pdf->SetTitle(utf8_decode("Facture n° : L ").$Facture_number);
$pdf->SetFont('Times','B',16);
$pdf->Image('logok2.jpg',175,10,20,15);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,-40,"K2",0,2,'',false);
$pdf->Ln(23);
//Adresse
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(47,5,$Agence_lieu."\n"."\nTel. ".$Agence_tel."\nSAS au capital de 146 000 ".chr(128).utf8_decode("\nN° TVA : FR59882363070")."\nRC : B88 236 307 0 DIJON"."\nIBAN - BIC",0,'L',false);
//Informations Facture
$pdf->SetY(55);
$pdf->SetFont('Arial','B',15);
$pdf->Cell(55,9,"FACTURE",1,2,'C');
$pdf->SetXY($pdf->GetX()+70,$pdf->GetY()-6);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(24,5,'Page '.$pdf->PageNo(),0,0,'C');
$pdf->SetY($pdf->GetY()+7);
//Table Information Client
$datas = array();
$datas[] = array($Client_id,'L '.$Facture_number,$Facture_date);
// $prixTotalHorsTaxes=$Contrat_prix;
$header=array(utf8_decode('Code client'),utf8_decode('Numéro pièce'),utf8_decode('Date'));
$w=array(30,30,27);
$al=array('C','C','C');
$pdf->table1($header,$w,$al,$datas);
$pdf->SetY($pdf->GetY());

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(150,5,"Votre identification TVA : ".$Client_code_tva,'','L',false);

$pdf->SetFont('Arial','',10);
$pdf->SetXY(108,55);
$pdf->MultiCell(50,6,utf8_decode($Client_name."\n".$Client_adresse),'','L',false);
$position=$pdf->getY()+10;
if($pdf->getY()>$position){
	$position=$pdf->getY();
}
$pdf->SetXY(10,95);

//Tableau
$position=0;
$prixTVA=0;
$prixTotalHorsTaxes=0;
$prixTTCeuro=0;
$prixTTCdolar=0;
//Création des données qui seront contenues la table
$datas = array();
$datas[] = array($Voiture_id,$Voiture_imm." - ".$Voiture_marque." ".$Voiture_model,number_format('1', 2, ',', ''),' ',"1",number_format($Contrat_prix, 2, ',', ''),number_format($Contrat_prix, 2, ',', ''));

$prixTotalHorsTaxes=$Contrat_prix;
$prixTVA = $prixTotalHorsTaxes*(TVA);
$prixTTCeuro = $prixTotalHorsTaxes + $prixTVA;

if ($Client_accompte > $prixTTCeuro){
	$Client_accompte = $prixTTCeuro;
}

//Tableau contenant les titres des colonnes
$header=array(utf8_decode('Référence'),utf8_decode('Désignation'),utf8_decode('Qté'),utf8_decode('Rem. (%)'),utf8_decode('TVA (*)'),utf8_decode('P.U. HT'),"Montant HT en Euro");
//Tableau contenant la largeur des colonnes
$w=array(22,70,16,15,15,18,34);
//Tableau contenant le centrage des colonnes
$al=array('L','L','C','C','C','C','C');
 
//Génération de la table à proprement dite
$pdf->table($header,$w,$al,$datas);
 
//On se positionne en dessous de la table pour écrire le total
$pdf->SetXY(127,215);
$pdf->Cell(40,5.5,"Total H.T. Brut : ",1,0,'L');
$pdf->Cell(33,5.5,number_format($prixTotalHorsTaxes, 2, ',', ''),1,2,'R');
$pdf->Ln(1);

$pdf->SetX(127);
$y=$pdf->GetY();
$pdf->MultiCell(40,5.5,utf8_decode("Remise (0,00 %) : "."\nEscompte (0,00 %) :"),1,'L');
$pdf->SetXY(167,$y);
$pdf->MultiCell(33,5.5,number_format('0', 2, ',', '')."\n".number_format('0', 2, ',', ''),1,'R');

$pdf->setX(127);
$y1=$pdf->GetY();
$pdf->MultiCell(40,5.5,"Total H.T. :"."\nTotal T.V.A. :",1,'L');
$pdf->SetXY(167,$y1);
$pdf->MultiCell(33,5.5,number_format($prixTotalHorsTaxes, 2, ',', '')."\n".number_format($prixTVA, 2, ',', ''),1,'R');
$pdf->Ln(1);

$pdf->setX(127);
$y2=$pdf->GetY();
$pdf->Cell(40,5.5,"Total T.T.C. :",1,'L');
$pdf->SetXY(167,$y2);
$pdf->Cell(33,5.5,number_format($prixTTCeuro, 2, ',', ''),1,2,'R');

$pdf->setX(127);
$y3=$pdf->GetY();
$pdf->Cell(40,5.5,"Acompte : ",1,0,'L');
$pdf->SetXY(167,$y3);
$pdf->Cell(33,5.5,number_format($Client_accompte, 2, ',', ''),1,2,'R');
$pdf->Ln(1);

$prixTTCeuro=$prixTTCeuro-$Client_accompte;
$pdf->setX(127);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(40,8,utf8_decode("Net à payer : "),1,0,'L');
$pdf->Cell(33,8,number_format($prixTTCeuro, 2, ',', '').chr(128),1,2,'R');
$pdf->Ln(1);

$prixTTCdolar = openExchangeRatesConvert($prixTTCeuro, 'EUR', 'USD');
$pdf->setX(175);
$pdf->SetFont('Arial','',9);
$pdf->Cell(25,5,"(Soit ".number_format($prixTTCdolar, 2, ',', '')." $)");

if ($Contrat_mode_paiement == "Virements bancaires"){
  $texte1 = "Virement bancaire";
} else if ($Contrat_mode_paiement == "Carte bancaire") {
  $texte1 = "Paiements par Carte Bancaire";
} else if ($Contrat_mode_paiement == "Prélèvements automatiques") {
  $texte1 = "Des prélèvements automatiques seront effectués";
} else if ($Contrat_mode_paiement == "Espèces") {
  $texte1 = "Paiements en espèce";
} else {
  $texte1 = "Paiements par Chèque";
}
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,215);
$pdf->MultiCell(110,5,utf8_decode($texte1)." Chevigny au ".$Facture_date,0,'L',false);
$pdf->Ln(3);

$datas = array();
$datas[0] = array("(1) ".(TVA)*100 .",00%",number_format($prixTotalHorsTaxes, 2, ',', ''),number_format($prixTotalHorsTaxes, 2, ',', ''),number_format($prixTVA, 2, ',', ''),number_format($prixTTCeuro, 2, ',', ''));
$datas[1] = array("Total",number_format($prixTotalHorsTaxes, 2, ',', ''),number_format($prixTotalHorsTaxes, 2, ',', ''),number_format($prixTVA, 2, ',', ''),number_format($prixTTCeuro, 2, ',', ''));
$prixTotalHorsTaxes=$Contrat_prix;
$header=array(utf8_decode('(*) Taux'),utf8_decode('HT Brut'),utf8_decode('Base TVA'),utf8_decode('TVA'),utf8_decode('TTC'));
$w=array(30,20,20,20,20);
$al=array('L','C','C','C','C');
$pdf->table1($header,$w,$al,$datas);

$pdf->Output('I',utf8_decode("Facture n°: L ".$Facture_number.".pdf"));
}
else {
  echo "erreur";
} 
?>