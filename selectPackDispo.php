<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];


if ($_POST['DateDebutContrat'] && $_POST['DateFinContrat']) {
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
}

?>
<div class="form-group mb-4" id="materiel">
    <?php

    $query = "SELECT * FROM group_packs  where etat_group_pack ='T'  ORDER BY  designation_pack 
                                                             
                                                            ASC ";
    $result = mysqli_query($conn, $query);
    ?>
    <label class="col-md-12 p-0">
        Pack<span class="text-danger">*</span></label>
    <div class="col-md-12 border-bottom p-0">
        <select id="id_pack" name="id_pack" placeholder="Nom " class="form-control p-0 border-0"
            onchange="List_Materiel_Pack(this.value)" required>
            <option value="" disabled selected> Pack
            </option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id_group_packs'] . '">' . $row['designation_pack'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
</div>