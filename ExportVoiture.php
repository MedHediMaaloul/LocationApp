<?php
require_once('Gestion_location/inc/connect_db.php');
$query="SELECT V.id_voiture,V.type,V.pimm,MM.Marque,MM.Model,V.fournisseur,V.km,V.date_achat,V.dispo 
FROM `voiture` AS V 
LEFT JOIN marquemodel AS MM ON V.id_MarqueModel=MM.id_MarqueModel
 ORDER BY id_voiture";
$result=mysqli_query($conn,$query);
$html='<table><tr><td>Id Vehicule</td><td>Type</td><td>PIMM</td><td>Fournissuer</td><td>Marque</td><td>Modele</td><td>Km</td><td>Date Achat</td><td>Disponibilite</td><tr/>';
while ($row=mysqli_fetch_assoc($result)){
    $html.='<tr><td>'.$row['id_voiture'].'</td><td>'.$row['type'].'</td><td>'.$row['pimm'].'</td><td>'.$row['Marque'].'</td><td>'.$row['Model'].'</td><td>'.$row['fournisseur'].'</td><td>'.$row['km'].'</td><td>'.$row['date_achat'].'</td><td>'.$row['dispo'].'</td><tr/>';
}
$html.='</table>';
header('Content-Type:application/xls; charset=utf-8');
header('Content-Disposition: attachment; filename="VéhiculeListe.xls"');
echo($html);
?>