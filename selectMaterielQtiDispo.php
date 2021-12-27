<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];
$debut = date('');
$fin = date('');
$query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels

and etat_materiels = 'T'
and id_agence = '$id_agence'
ORDER BY designation ASC 

";
$result = mysqli_query($conn, $query);

?>

<div class="col-md-12 border-bottom p-0">

    <?php
    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {


            //   $disponibilte = 'disponibile';
            $disponibilte = disponibilite_materiel_num_seriee($row['id_materiels'], $row['quantite_materiels'], $debut, $fin);

            $Del_ID = $row['id_materiels_agence'];

            if ($disponibilte) {
                $query2 = "Update   materiels_agence SET quantite_materiels_dispo='$disponibilte' WHERE id_materiels_agence='$Del_ID'";
                $result2 = mysqli_query($conn, $query2);
                // echo $disponibilte;
            } else {
                $query2 = "Update   materiels_agence SET quantite_materiels_dispo='$disponibilte' WHERE id_materiels_agence='$Del_ID'";
                $result2 = mysqli_query($conn, $query2);
                // echo $row['quantite_materiels'];
            }
            echo ' <br>';
        }
    }
    ?>

</div>


<?php


function disponibilite_materiel_num_seriee($id_materiels_agence, $qti, $debut, $fin)
{
    global $conn;
    $date = date('Y-m-d');
    $queryi = "SELECT * FROM contrat_client, materiel_group_packs
    where  contrat_client.id_group_pack= materiel_group_packs.id_group_packs and 
    id_materiels ='$id_materiels_agence' 
    and ( date_debut <= '$date' and date_fin >= '$date')
    ";
    $resulti = mysqli_query($conn, $queryi);

    if ($resulti) {
        while ($row = mysqli_fetch_assoc($resulti)) {
            $qti = $qti - ($row['quantite']);
        }
        return  $qti;
    } else {
        return  $qti;
    }
}
?>