<?php
require_once('Gestion_location/inc/connect_db.php');
$query="SELECT id_materiel,nom_materiel,categorie,fournisseur,date_achat,designation,dispo 
FROM `materiel` ORDER BY id_materiel";
$result=mysqli_query($conn,$query);
$html='<table><tr><td>Id Materiel</td><td>Nom</td><td>Categorie</td><td>Fournissuer</td><td>Date Achat</td><td>Designation</td><td>Disponibilite</td><tr/>';
while ($row=mysqli_fetch_assoc($result)){
    $html.='<tr><td>'.$row['id_materiel'].'</td><td>'.$row['nom_materiel'].'</td><td>'.$row['categorie'].'</td><td>'.$row['fournisseur'].'</td><td>'.$row['date_achat'].'</td><td>'.$row['designation'].'</td><td>'.$row['dispo'].'</td><tr/>';
}
$html.='</table>';
header('Content-Type:application/xls; charset=utf-8');
header('Content-Disposition: attachment; filename="MaterielListe.xls"');
echo($html);
?>