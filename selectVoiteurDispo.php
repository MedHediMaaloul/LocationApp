<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];


if ($_POST['DateDebutContrat'] && $_POST['DateFinContrat']) {
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
}
// disponibilite_materiel_num_serie(1, $debut, $fin);
$query = "SELECT * FROM voiture WHERE
 id_agence = '$id_agence' and etat_voiture = 'Disponible' ";

$result = mysqli_query($conn, $query);

?>
<label class="col-md-12 p-0"> Vehicule<span class="text-danger">*</span></label>
<div class="col-md-12 border-bottom p-0">
    <select id="list_materiel" name="list_materiel" placeholder="Nom " class="form-control p-0 border-0" required>
        <option value="" disabled selected> Vehicule
        </option>
        <?php
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                //  $disponibilte = 'disponibile';
                $disponibilte = disponibilite_Vehicule($row['id_voiture'], $debut, $fin);
                if ($disponibilte == 'disponibile') {
                    echo '<option value="' . $row['id_voiture'] . '">' . $row['type'] . '-' . $row['pimm'] . '</option>';
                } else {
                    echo '<option disabled value="' . $row['id_voiture'] . '">' . $row['type'] . '-' . $row['pimm'] .  ' Non Disponible</option>';
                }
            }
        }
        ?>
    </select>
</div>


<?php



function disponibilite_Vehicule($id_voiture, $debut, $fin)
{
    global $conn;

    /*
    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $row['quantite_materiels_dispo'];
*/

    $query = "SELECT * FROM contrat_client 
    where  
    id_voiture ='$id_voiture' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
     
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return " non disponibile";
    }
}
?>