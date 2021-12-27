<?php
require_once('Gestion_location/inc/connect_db.php');
$query="SELECT id_client,nom,email,tel,adresse,num_siret,nom_societe FROM `client` ORDER BY id_client";
$result=mysqli_query($conn,$query);
$html='<table><tr><td>Id Client</td><td>Nom Complet</td><td>Email</td><td>Téléphone</td><td>Adresse</td><td>Num Siret</td><td>Nom Société</td><tr/>';
while ($row=mysqli_fetch_assoc($result)){
    $html.='<tr><td>'.$row['id_client'].'</td><td>'.$row['nom'].'</td><td>'.$row['email'].'</td><td>'.$row['tel'].'</td><td>'.$row['adresse'].'</td><td>'.$row['num_siret'].' Siret</td><td>'.$row['nom_societe'].'</td><tr/>';
}
$html.='</table>';
header('Content-Type:application/xls;charset=utf-8');
header('Content-Disposition: attachment; filename="ClientsListe.xls"');
echo($html);
?>