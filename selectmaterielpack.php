<?php
session_start();
include('Gestion_location/inc/connect_db.php');
if ($_POST['id_pack']) {
    $id_agence = $_SESSION['id_agence'];
    $query = "SELECT type_voiture FROM group_packs where   id_group_packs=" .  $_POST['id_pack'];
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();

    $type_voiture = $row['type_voiture'];

    if ($type_voiture == 'sans vehicule') {

        echo  '<div>Sans Véhicule</div>
        <input name="vehicule_pack" id="vehicule_pack"  type ="hidden" value ="0">
        ';
    } else {
?>
<div class="form-group mb-4">
    <label class="col-md-12 p-0">Véhicule<span class="text-danger">*</span></label>
    <select name="vehicule_pack" id="vehicule_pack" class="form-control p-0 border-0">
        <?php

                $query = "SELECT * FROM voiture,marquemodel where `marquemodel`.`id_MarqueModel`= `voiture`.`id_MarqueModel` and  id_agence = $id_agence and type='$type_voiture'";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo ' <option value="' . $row['id_voiture'] . '">' . $row['Marque'] . '-' . $row['pimm'] . '</option>';
                    }
                } else {
                    echo  '<div>Sans Véhicule    0000</div>
                    <input name="vehicule_pack" id="vehicule_pack"  type ="hidden" value ="0">
                    ';
                }
                ?>
    </select>
</div>

<?php
    }
    ?>
<div class="form-group mb-4">
    <label class="col-md-12 p-0">Liste des Materiels<span class="text-danger">*</span></label>
    <?php
        $i = 1;
        $query = "SELECT * FROM materiel_group_packs,group_packs where 
    materiel_group_packs.id_group_packs=group_packs.id_group_packs 
    and group_packs.id_group_packs=" . $_POST['id_pack'];
        $result = mysqli_query($conn, $query);
        while ($row = $result->fetch_assoc()) {
            //   echo  '<div>' . $row['id_group_packs'] . ' - ' . $row['id_materiels'] . '</div>';

            $query_m = "SELECT * FROM materiels,materiels_agence where 
     materiels.id_materiels=materiels_agence.id_materiels 
    and materiels_agence.id_materiels =" . $row['id_materiels'] . "
     and materiels_agence.id_agence=" . $id_agence; ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 30px;">
                <span class="text-danger">
                    <?php
                            echo   $row['quantite'];

                            ?>
                    <input name="quantite_materiel_pack[]" id="quantite_materiel_pack<?php echo $i ?>"
                        class="quantite-list-pack" type="hidden" value="<?php echo $row['quantite']; ?>">
                </span>
            </td>
            <td>
                <select name="skill[]" id="fetch-materiel<?php echo $i ?>" class="form-control materiel-list-pack">


                    <?php

                            $result_m = mysqli_query($conn, $query_m);
                            while ($row_m = $result_m->fetch_assoc()) {

                                echo ' <option value="' . $row_m['id_materiels_agence'] . '">' . $row_m['code_materiel'] . '-' . $row_m['designation'] . '-' . $row_m['num_serie_materiels'] . '</option>';
                            } ?>

                </select>
            </td>
        </tr>
    </table>
    <?php
            $i++;
        }
        ?>
</div>
<?php
}