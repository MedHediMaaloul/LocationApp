<?php

use PhpMyAdmin\Console;

session_start();
require_once('connect_db.php');

// helpers
function is_image($file)
{
    $ALLOWED_EXTENSIONS = ["jpg", "jpeg", "png", "pdf"];
    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $ALLOWED_EXTENSIONS);
}
//insert Clients Records function
function InsertClient()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $raisonsocial = $_POST['raison_social'];
    $num_siret = $_POST['siret'];
    $code_naf = $_POST['naf'];
    $code_tva = $_POST['codetva'];
    $accompte = $_POST['accompte_client'];
    $comment = $_POST['comment'];
    $type = $_POST['type'];
    $cin = $_FILES['cin'];
    $permis = $_FILES['permis'];
    $kbis = $_FILES['kbis'];
    $rib = $_FILES['rib'];
    if (!is_image($cin["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour CIN", "data" => $cin["name"]]);
    }
    if (!is_image($permis["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour Permis", "data" => $permis["name"]]);
    }
    if (!is_image($kbis["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour kbis", "data" => $kbis["name"]]);
    }
    if (!is_image($rib["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour rib", "data" => $rib["name"]]);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, ["error" => "Email incorrect", "data" => $email]);
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $cin_filename = $unique_id . "_cin." . strtolower(pathinfo($cin["name"], PATHINFO_EXTENSION));
    $permis_filename = $unique_id . "_permis." . strtolower(pathinfo($permis["name"], PATHINFO_EXTENSION));
    $kbis_filename = $unique_id . "_kbis." . strtolower(pathinfo($kbis["name"], PATHINFO_EXTENSION));
    $rib_filename = $unique_id . "_rib." . strtolower(pathinfo($rib["name"], PATHINFO_EXTENSION));
    move_uploaded_file($cin["tmp_name"], "./uploads/${cin_filename}");
    move_uploaded_file($permis["tmp_name"], "./uploads/${permis_filename}");
    move_uploaded_file($kbis["tmp_name"], "./uploads/${kbis_filename}");
    move_uploaded_file($rib["tmp_name"], "./uploads/${rib_filename}");
    $sql_e = "SELECT * FROM client WHERE email='$email'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Email est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            client(nom,email,tel,adresse,cin ,raison_social,siret,naf,codetva,accompte_client,permis,kbis,rib,comment,type) 
            VALUES ('$nom','$email','$tel','$adresse' , '$cin_filename' ,'$raisonsocial','$num_siret','$code_naf','$code_tva','$accompte','$permis_filename','$kbis_filename','$rib_filename', '$comment','$type' )";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>Un client est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout du client</div>";
        }
    }
}
// dispaly client data function
function display_client_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0">Téléphone</th>
            <th class="border-top-0">Adresse</th>
            <th class="border-top-0">Raison Social</th>
            <th class="border-top-0">Num Siret</th>
            <th class="border-top-0">Code NAF</th>
            <th class="border-top-0">Code TVA</th>
            <th class="border-top-0">Accompte</th>
            <th class="border-top-0">Commentaire</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">CIN</th>
            <th class="border-top-0">Permis</th>
            <th class="border-top-0">KBIS</th>
            <th class="border-top-0">RIB</th>
            <th class="border-top-0">Actions</th>   
        </tr>';
    $query = "SELECT * FROM client where etat_client ='A'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_client'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['tel'] . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <td class="border-top-0">' . $row['raison_social'] . '</td>
                <td class="border-top-0">' . $row['siret'] . '</td>
                <td class="border-top-0">' . $row['naf'] . '</td>
                <td class="border-top-0">' . $row['codetva'] . '</td>
                <td class="border-top-0">' . $row['accompte_client'] . '</td>
                <td class="border-top-0">' . $row['comment'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
              </style>          
                <td class="border-top-0"><a href="uploads/' . $row["cin"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["cin"] . '"></a></td>
                <td class="border-top-0"><a href="uploads/' . $row["permis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["permis"] . '"></a></td>
              ';
        if ($row['type'] == "CLIENT PRO") {
            $value .= '     <td class="border-top-0"><a href="uploads/' . $row["kbis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["kbis"] . '"></a></td>
                        <td class="border-top-0"><a href="uploads/' . $row["rib"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["rib"] . '"></a></td>';
        } elseif ($row['type'] == "CLIENT PARTICULIER") {
            $value .= '    <td class="border-top-0">-</td>
                        <td class="border-top-0">-</td>';
        }
        if ($row['type'] == "CLIENT PRO") {
            $value .= '   <td class="border-top-0">   <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
        } else {
            $value .= '   <td class="border-top-0"> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
        }
        $value .= '       <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function display_client_inactif_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Nom</th>
        <th class="border-top-0">E-mail</th>
        <th class="border-top-0">Téléphone</th>
        <th class="border-top-0">Adresse</th>
        <th class="border-top-0">Raison Social</th>
        <th class="border-top-0">Num Siret</th>
        <th class="border-top-0">Code NAF</th>
        <th class="border-top-0">Code TVA</th>
        <th class="border-top-0">Accompte</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">CIN</th>
        <th class="border-top-0">Permis</th>
        <th class="border-top-0">KBIS</th>
        <th class="border-top-0">RIB</th>
        <th class="border-top-0">Actions</th>    
        </tr>';
    $query = "SELECT * FROM client where etat_client ='I'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_client'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['tel'] . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <td class="border-top-0">' . $row['raison_social'] . '</td>
                <td class="border-top-0">' . $row['siret'] . '</td>
                <td class="border-top-0">' . $row['naf'] . '</td>
                <td class="border-top-0">' . $row['codetva'] . '</td>
                <td class="border-top-0">' . $row['accompte_client'] . '</td>
                <td class="border-top-0">' . $row['comment'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
              </style>
               <td class="border-top-0"><a href="uploads/' . $row["cin"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["cin"] . '"></a></td>
               <td class="border-top-0"><a href="uploads/' . $row["permis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["permis"] . '"></a></td>';
        if ($row['type'] == "CLIENT PRO") {
            $value .= '     <td class="border-top-0"><a href="uploads/' . $row["kbis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["kbis"] . '"></a></td>
                <td class="border-top-0"><a href="uploads/' . $row["rib"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["rib"] . '"></a></td>';
        } elseif ($row['type'] == "CLIENT PARTICULIER") {
            $value .= '    <td class="border-top-0">-</td>
                <td class="border-top-0">-</td>';
        }
        $value .= '      <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client" data-id=' . $row['id_client'] . '>
                  <i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-client" data-id1=' . $row['id_client'] . '>
                  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//get particular client record
function get_client_record()
{
    global $conn;
    $ClientId = $_POST['ClientID'];
    $query = " SELECT * FROM client WHERE id_client='$ClientId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client_data = [];
        $client_data[0] = $row['id_client'];
        $client_data[1] = $row['nom'];
        $client_data[2] = $row['email'];
        $client_data[3] = $row['tel'];
        $client_data[4] = $row['adresse'];
        $client_data[6] = $row['cin'];
        $client_data[7] = $row['comment'];
        $client_data[8] = $row['permis'];
        $client_data[9] = $row['kbis'];
        $client_data[10] = $row['rib'];
        $client_data[11] = $row['raison_social'];
        $client_data[12] = $row['type'];
        $client_data[13] = $row['siret'];
        $client_data[14] = $row['naf'];
        $client_data[15] = $row['codetva'];
        $client_data[16] = $row['accompte_client'];
    }
    echo json_encode($client_data);
}
//get id client
function get_id_client()
{
    global $conn;
    $ClientId = $_POST['ClientID'];
    $query = " SELECT * FROM client WHERE id_client='$ClientId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client_data = $row['id_client'];
    }
    echo json_encode($ClientId);
}
// update Client
function update_client_value(){
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID client manquant ", "data" => "ID client manquant"]);
        return;
    }
    $client_id = $_POST["_id"];
    $client_query = "SELECT * FROM  client where id_client = ${client_id}";
    $client_result = mysqli_query($conn, $client_query);
    $client = mysqli_fetch_assoc($client_result);
    if (!$client) {
        echo json_encode(["error" => "Client introuvable ", "data" => "Client $client_id not found."]);
        return;
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $client_updated_cin = $client["cin"];
    if (array_key_exists("cin", $_FILES)) {
        // update cin
        $client_cin_file = $_FILES["cin"];
        $client_cin_new = $unique_id . "_cin." . strtolower(pathinfo($client_cin_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
        if ($client["cin"] && file_exists($client["cin"])) {
            unlink("./uploads/" . $client["cin"]);
        }
        $client_updated_cin = $client_cin_new;
    }
    $client_updated_kbis = $client["kbis"];
    if (array_key_exists("kbis", $_FILES)) {
        // update kbis
        $client_kbis_file = $_FILES["kbis"];
        $client_kbis_new = $unique_id . "_kbis." . strtolower(pathinfo($client_kbis_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_kbis_file["tmp_name"], "./uploads/" . $client_kbis_new);
        if ($client["kbis"] && file_exists($client["kbis"])) {
            unlink("./uploads/" . $client["kbis"]);
        }
        $client_updated_kbis = $client_kbis_new;
    }
    $client_updated_permis = $client["permis"];
    if (array_key_exists("permis", $_FILES)) {
        // update permis
        $client_permis_file = $_FILES["permis"];
        $client_permis_new = $unique_id . "_permis." . strtolower(pathinfo($client_permis_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_permis_file["tmp_name"], "./uploads/" . $client_permis_new);
        if ($client["permis"] && file_exists($client["permis"])) {
            unlink("./uploads/" . $client["permis"]);
        }
        $client_updated_permis = $client_permis_new;
    }
    $client_updated_rib = $client["rib"];
    if (array_key_exists("rib", $_FILES)) {
        // update cin
        $client_rib_file = $_FILES["rib"];
        $client_rib_new = $unique_id . "_rib." . strtolower(pathinfo($client_rib_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_rib_file["tmp_name"], "./uploads/" . $client_rib_new);
        if ($client["rib"] && file_exists($client["rib"])) {
            unlink("./uploads/" . $client["rib"]);
        }
        $client_updated_rib = $client_rib_new;
    }
    $client_updated_nom = $_POST["nom"];
    $client_updated_email = $_POST["email"];
    $client_updated_tel = $_POST["tel"];
    $client_updated_adresse = $_POST["adresse"];
    $client_updated_comment = $_POST["comment"];
    $client_updated_raison_social = $_POST["raison_social"];
    $client_updated_siret = $_POST["siret"];
    $client_updated_naf = $_POST["naf"];
    $client_updated_tva = $_POST["codetva"];
    $client_updated_accompte = $_POST["accompte_client"];
    $client_updated_type = $_POST["updateclientType"];
    $update_query = "UPDATE client SET 
    nom='$client_updated_nom',
    email='$client_updated_email',
    tel='$client_updated_tel',
    adresse='$client_updated_adresse',
    comment='$client_updated_comment',
    raison_social='$client_updated_raison_social',
    siret='$client_updated_siret',
    naf='$client_updated_naf',
    codetva='$client_updated_tva',
    accompte_client='$client_updated_accompte',
    cin='$client_updated_cin',
    kbis='$client_updated_kbis',
    permis='$client_updated_permis',
    rib='$client_updated_rib'
    WHERE id_client = $client_id";
    echo  $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du client!</div>";
        return;
    }
    echo "<div class='text-success'>Client a été mis à jour avec succès!</div>";
    return;
}
// update Client
function update_client_part_value(){
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID client manquant ", "data" => "ID client manquant"]);
        return;
    }
    $client_id = $_POST["_id"];
    $client_query = "SELECT * FROM  client where id_client = ${client_id}";
    $client_result = mysqli_query($conn, $client_query);
    $client = mysqli_fetch_assoc($client_result);
    if (!$client) {
        echo json_encode(["error" => "Client introuvable ", "data" => "Client $client_id not found."]);
        return;
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $client_updated_cin = $client["cin"];
    if (array_key_exists("cin", $_FILES)) {
        // update cin
        $client_cin_file = $_FILES["cin"];
        $client_cin_new = $unique_id . "_cin." . strtolower(pathinfo($client_cin_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
        if ($client["cin"] && file_exists($client["cin"])) {
            unlink("./uploads/" . $client["cin"]);
        }
        $client_updated_cin = $client_cin_new;
    }
    $client_updated_permis = $client["permis"];
    if (array_key_exists("permis", $_FILES)) {
        // update permis
        $client_permis_file = $_FILES["permis"];
        $client_permis_new = $unique_id . "_permis." . strtolower(pathinfo($client_permis_file["name"], PATHINFO_EXTENSION));
        move_uploaded_file($client_permis_file["tmp_name"], "./uploads/" . $client_permis_new);
        if ($client["permis"] && file_exists($client["permis"])) {
            unlink("./uploads/" . $client["permis"]);
        }
        $client_updated_permis = $client_permis_new;
    }
    $client_updated_nom = $_POST["nom"];
    $client_updated_email = $_POST["email"];
    $client_updated_tel = $_POST["tel"];
    $client_updated_adresse = $_POST["adresse"];
    $client_updated_comment = $_POST["comment"];
    $client_updated_siret = $_POST["siret"];
    $client_updated_naf = $_POST["naf"];
    $client_updated_tva = $_POST["codetva"];
    $client_updated_accompte = $_POST["accompte_client"];
    $client_updated_type = $_POST["updateclientType"];
    $update_query = "UPDATE client SET 
    nom='$client_updated_nom',
    email='$client_updated_email',
    tel='$client_updated_tel',
    adresse='$client_updated_adresse',
    comment='$client_updated_comment',
    siret='$client_updated_siret',
    naf='$client_updated_naf',
    codetva='$client_updated_tva',
    accompte_client='$client_updated_accompte',
    type='$client_updated_type',
    cin='$client_updated_cin',
    permis='$client_updated_permis'
    WHERE id_client = $client_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du client!</div>";
        return;
    }
    echo "<div class='text-success'>Client a été mis à jour avec succès!</div>";
    return;
}

function delete_client_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_ClientID'];
    $query = "DELETE FROM client WHERE id_client='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le client est supprimé avec succès';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}
function insert_materiel()
{
    global $conn;
    $ComposantListe = $_POST['ComposantListe'];
    $NumSerieListe = $_POST['NumSerieListe'];
    $count = count($ComposantListe);
    $countNumSerie = count($NumSerieListe);
    $verif = "T";
    $id_materiels = $_POST['id_materiels'];
    $materielnumserie = $_POST['materielnumserie'];
    $quitite = $_POST['quitite'];
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    for ($c = 0; $c < $count; $c++) {
        if ($ComposantListe[$c] != null && $NumSerieListe[$c] == null) {
            $verif = "F";
        } else if ($ComposantListe[$c] == null && $NumSerieListe[$c] != null) {
            $verif = "F";
        }
    }
    if ($materielnumserie == "vide") {
        $materielnumserie = "";
        $sql_e = "SELECT id_materiels_agence FROM materiels_agence WHERE id_materiels='$id_materiels'";
        $res_e = mysqli_query($conn, $sql_e);
        if (mysqli_num_rows($res_e) == 0) {
            $query = "INSERT INTO materiels_agence(id_materiels,num_serie_materiels,quantite_materiels,quantite_materiels_dispo,id_agence,id_user)
                    VALUE('$id_materiels','$materielnumserie','$quitite','$quitite','$id_agence','$id_user')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<div class='text-success'>Le Matériel ajouté avec succés</div>";
            } else {
                echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
            }
        } else {
            $row = mysqli_fetch_row($res_e);
            $id_materiels_agence = $row[0];
            $query = " update materiels_agence set quantite_materiels = quantite_materiels +$quitite, quantite_materiels_dispo =quantite_materiels_dispo +$quitite
               where id_materiels_agence =$id_materiels_agence ";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<div class='text-success'>Le matériel est ajouté avec succés</div>";
            } else {
                echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
            }
        }
    }
    else if ($verif == "T") {
        $sql_e = "SELECT * FROM materiels_agence WHERE num_serie_materiels='$materielnumserie'";
        $res_e = mysqli_query($conn, $sql_e);
        if (mysqli_num_rows($res_e) > 0) {
            echo '<div class="text-danger">
            Désolé ... Num Serie est déjà existant!</div>';
        }
        else {
            $query = "INSERT INTO
            materiels_agence(id_materiels,num_serie_materiels,quantite_materiels,quantite_materiels_dispo,id_agence,id_user)
           VALUE('$id_materiels','$materielnumserie','$quitite','$quitite','$id_agence','$id_user')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $query_get_max_id_materiel = "SELECT max(id_materiels_agence) FROM materiels_agence where id_user='$id_user' ";
                $result_query_get_max_materie = mysqli_query($conn, $query_get_max_id_materiel);
                $row = mysqli_fetch_row($result_query_get_max_materie);
                $id_materiels = $row[0];
                for ($i = 0; $i < $count; $i++) {
                    if ($ComposantListe[$i] != "") {
                        $query_insert_materiel_list = "INSERT INTO composant_materiels(id_materiels_agence,designation_composant,num_serie_composant)
                         VALUES ('$id_materiels','$ComposantListe[$i]','$NumSerieListe[$i]') ";
                        $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                    }
                }
                echo "<div class='text-success'>Le matériel est ajouté avec succès" . $verif . " </div>";
            } else {
                echo "<div class='text-danger'>Le matériel est ajouté avec succès </div>";
            }
        }
    }
    else {
        echo "<div class='text-danger'>Veuillez remplir tous les champs obligatoires !</div>";
    }
}
function view_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<div class="table-responsive">
    <table class="table">
    <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0"> Code de matériel</th>
            <th class="border-top-0">N° de série</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">Quantité</th>
            <th class="border-top-0">Quantité dispo</th>
            <th class="border-top-0">Composant</th>
            <th class="border-top-0">État</th>
            <th class="border-top-0">Actions</th>
        </tr>
        </thead>';
    $query = "SELECT * FROM materiels,materiels_agence 
    where materiels.id_materiels = materiels_agence.id_materiels 
    AND id_agence ='$id_agence' 
    AND materiels_agence.etat_materiels != 'F'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $comp = $row['id_materiels_agence'];
        if ($row['etat_materiels'] == "T") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $etat = "ACTIF ";
        } elseif ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "Hors Service";
        }
        $value .= '
        <tbody>
            <tr ' . $color . ' >
                <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['designation'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';

        $value .= '<td class="border-top-0">';
        $querycomp = "SELECT designation_composant FROM materiels_agence,composant_materiels where materiels_agence.id_materiels_agence = composant_materiels.id_materiels_agence 
                AND materiels_agence.id_materiels_agence = '$comp'";
        $resultcom = mysqli_query($conn, $querycomp);
        while ($row1 = mysqli_fetch_assoc($resultcom)) {
            $value .= ' <span class=" text-primary">' . $row1['designation_composant'] . ' </span> <br> ';
        }
        $value .=   '</td>';
        $value .= ' <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">';
        if ($row['num_serie_obg'] == "T") {
            $value .= '
            <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-materiel" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
        } else {
            $value .= '  <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-materiel-stock" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
        }
        $value .=    ' 
                   <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-materiel" data-id1=' . $row['id_materiels_agence'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= ' </tbody>
    </table>
</div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function get_materiel_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];
    $query = " SELECT * FROM materiel WHERE id_materiel='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Materiel_data = [];
        $Materiel_data[0] = $row['id_materiel'];
        $Materiel_data[1] = $row['nom_materiel'];
        $Materiel_data[2] = $row['categorie'];
        $Materiel_data[3] = $row['fournisseur'];
        $Materiel_data[4] = $row['date_achat'];
        $Materiel_data[5] = $row['num_serie'];
        $Materiel_data[6] = $row['designation'];
        $Materiel_data[7] = $row['dispo'];
    }
    echo json_encode($Materiel_data);
}

function get_materiel_agence_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];
    $query = " SELECT * FROM  materiels,materiels_agence WHERE materiels.id_materiels=materiels_agence.id_materiels AND materiels_agence.id_materiels_agence='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Materiel_data = [];
        $Materiel_data[0] = $row['id_materiels_agence'];
        $Materiel_data[1] = $row['num_serie_materiels'];
        $Materiel_data[2] = $row['etat_materiels'];
    }
    echo json_encode($Materiel_data);
}
function update_materiels()
{
    global $conn;
    $updateMaterielId = $_POST['updateMaterielId'];
    $updateMaterielNumSerie = $_POST['updateMaterielNumSerie'];
    $up_materielEtat = $_POST['up_materielEtat'];
    $query = "UPDATE materiels_agence SET  num_serie_materiels='$updateMaterielNumSerie', etat_materiels='$up_materielEtat' where id_materiels_agence='$updateMaterielId'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'> Modification a été mis à jour </div> ";
    } else {
        echo " <div class='text-danger'>Veuillez vérifier votre requête</div> ";
    }
}

function delete_materiel_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "UPDATE  materiels_agence SET etat_materiels ='F'  where id_materiels_agence='$Del_Id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'> Votre enregistrement a été supprimé</div> ";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête </div>";
    }
}

function display_voiture_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date VT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Actions</th>  
        </tr>';
    $query = "SELECT * 
    FROM voiture as V LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
    WHERE V.etat_voiture = 'Disponible' 
    AND V.id_agence='$id_agence' ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture" data-id=' . $row['id_voiture'] . '><i class="fas fa-edit"></i></button>
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-voiture" data-id1=' . $row['id_voiture'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function display_voiture_vendue_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Action</th>  
        </tr>';
    $query = "SELECT * 
    FROM voiture,histrique_voiture WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
    AND histrique_voiture.action = 'Vendue' 
    AND voiture.id_agence='$id_agence'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['date_HV'] . '</td>
                <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture-vendue" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button>                
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_voiture_hs_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Action</th>            
        </tr>';
    $query = "SELECT * 
    FROM voiture,histrique_voiture 
    WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
    AND voiture.etat_voiture = 'HS'
     AND histrique_voiture.action = 'HS'
    AND voiture.id_agence='$id_agence' 
    GROUP BY voiture.id_voiture 
    ORDER BY `histrique_voiture`.`date_action` DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['date_HV'] . '</td>
                <td class="border-top-0">' . $row['commentaire_HV'] . '</td>             
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture-HS" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
                  </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//Ajouter Voiture Records function
function InsertVoiture()
{
    global $conn;
    $type = $_POST['type'];
    $pimm = $_POST['pimm'];
    $marqueModele = $_POST['marqueModele'];
    $fournisseur = $_POST['fournisseur'];
    $km = $_POST['km'];
    $date_achat = $_POST['date_achat'];
    $dispo = $_POST['dispo'];
    $date_immatriculation = $_POST['date_immatriculation'];
    $date_DPC_VGP = $_POST['date_DPC_VGP'];
    $date_DPC_VT = $_POST['date_DPC_VT'];
    $date_DPT_Pollution = $_POST['date_DPT_Pollution'];
    $carte_grise = $_FILES['carte_grise'];
    $carte_verte = $_FILES['carte_verte'];
    $etat_voiture = $_POST['etat_voiture'];
    $id_agence = $_POST['voitureAgence'];
    $id_user = $_SESSION['id_user'];
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    $sql_e = "SELECT * FROM voiture WHERE pimm='$pimm'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo "<div class='text-danger'>
            Désolé ... PIMM est déjà existant!</div>";
    } else {
        $unique_id = time();
        $carte_grise_filename = $unique_id . "_cg." . strtolower(pathinfo($carte_grise["name"], PATHINFO_EXTENSION));
        $emplecment_carte_grise = "./uploads/voiture/" . $carte_grise_filename;
        move_uploaded_file($carte_grise["tmp_name"], $emplecment_carte_grise);
        $carte_verte_filename = $unique_id . "_cv." . strtolower(pathinfo($carte_verte["name"], PATHINFO_EXTENSION));
        $emplecment_carte_verte = "./uploads/voiture/" . $carte_verte_filename;
        move_uploaded_file($carte_verte["tmp_name"], $emplecment_carte_verte);
        $query = "INSERT INTO 
            voiture(type,pimm,id_MarqueModel,fournisseur,km,date_achat,dispo,date_immatriculation,date_DPC_VGP,date_DPC_VT,date_DPT_Pollution,carte_grise,carte_verte,etat_voiture,id_user,id_agence) 
            VALUES ('$type','$pimm','$marqueModele','$fournisseur','$km','$date_achat','$dispo',' $date_immatriculation','$date_DPC_VGP','$date_DPC_VT','$date_DPT_Pollution','$emplecment_carte_grise','$emplecment_carte_verte','$etat_voiture',' $id_user','$id_agence')";
        $result = mysqli_query($conn, $query);
        $queryVehiculeTid = "SELECT id_voiture FROM `voiture` WHERE `id_voiture`=(SELECT max(id_voiture) from voiture)";
        $resultVehiculeTid = mysqli_query($conn, $queryVehiculeTid);
        while ($row = mysqli_fetch_assoc($resultVehiculeTid)) {
            $rowid = $row['id_voiture'];
        }
        $queryVehiculeT = "INSERT INTO  
         histrique_voiture(id_voiture_HV,id_agence_em,id_agence_recv,action,id_user_HV) 
         VALUES ('$rowid','$id_agence','$id_agence','Ajoute',' $id_user') ";
        $resultVehiculeT = mysqli_query($conn, $queryVehiculeT);
        if ($result) {
            echo "<div class='text-success'>Le véhicule est Ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
        }
    }
}

function InsertVoitureVendue()
{
    global $conn;
    $id_voiture = $_POST['voitureMarqueModel'];
    $Voituredate_vendue = $_POST['Voituredate_vendue'];
    $VoitureCommentaire = $_POST['VoitureCommentaire'];
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $query = "INSERT INTO 
            histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
            VALUES ('$id_voiture','Vendue','$id_agence','$id_agence','$id_user','$VoitureCommentaire','$Voituredate_vendue')";
    $result = mysqli_query($conn, $query);
    $update_query = "UPDATE voiture 
    SET etat_voiture='Vendue'
     WHERE id_voiture = $id_voiture";
    $update_result = mysqli_query($conn, $update_query);
    if ($result) {
        echo "<div class='text-success'>Le véhicule est Ajouté avec succés</div>";
    } else {
        echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
    }
}

function InsertVoitureHS()
{
    global $conn;
    $voitureIDHS = $_POST['voitureIDHS'];
    $Voituredate_HS = $_POST['Voituredate_HS'];
    $VoitureCommentaire = $_POST['VoitureCommentaire'];
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $query = "INSERT INTO 
            histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
            VALUES ('$voitureIDHS','HS','$id_agence','$id_agence','$id_user','$VoitureCommentaire','$Voituredate_HS')";
    $result = mysqli_query($conn, $query);
    $update_query = "UPDATE voiture 
    SET etat_voiture='HS'
     WHERE id_voiture = $voitureIDHS";
    $update_result = mysqli_query($conn, $update_query);
    if ($result) {
        echo "<div class='text-success'>Le véhicule est Ajouté avec succés</div>";
    } else {
        echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
    }
}
//supprime   InsertVoitureVendue()
function delete_voiture_record()
{
    global $conn;
    $Del_ID = $_POST['id_voiture'];
    $query = "UPDATE voiture SET actions='S'   
            WHERE id_voiture='$Del_ID'";
    $result = mysqli_query($conn, $query);



    if ($result) {
        echo "Le véhicule est supprimé avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

//get particular voiture record
function get_voiture_record()
{
    global $conn;
    $idvoiture = $_POST['id_voiture'];
    $query = " SELECT *
    FROM voiture AS V LEFT JOIN marquemodel AS MM ON V.id_MarqueModel =MM.id_MarqueModel
     WHERE V.id_voiture='$idvoiture' AND V.id_MarqueModel = MM.id_MarqueModel  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $voiture_data = [];
        $voiture_data[0] = $row['id_voiture'];
        $voiture_data[1] = $row['type'];
        $voiture_data[2] = $row['pimm'];
        $voiture_data[3] = $row['Marque'];
        $voiture_data[4] = $row['Model'];
        $voiture_data[5] = $row['fournisseur'];
        $voiture_data[6] = $row['km'];
        $voiture_data[7] = $row['date_achat'];
        $voiture_data[9] =   $row['id_MarqueModel'];
        $voiture_data[10] = $row['date_immatriculation'];
        $voiture_data[11] = $row['date_DPC_VGP'];
        $voiture_data[12] = $row['date_DPC_VT'];
        $voiture_data[13] = $row['date_DPT_Pollution'];
        $voiture_data[14] = $row['id_agence'];
        $voiture_data[15] = $row['date_DPC_VT'];
    }
    echo json_encode($voiture_data);
}


function get_voiture_vendue_record()
{
    global $conn;

    $idvoiture = $_POST['id_voitureH'];
    $query = " SELECT *
    FROM histrique_voiture 
     WHERE id_histrique_voiture='$idvoiture'  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $voiture_datav = [];
        $voiture_datav[0] = $row['id_histrique_voiture'];
        $voiture_datav[1] = $row['date_HV'];
        $voiture_datav[2] = $row['commentaire_HV'];
    }
    echo json_encode($voiture_datav);
}


//get particular voiture record
function get_voiture_HS_record()
{
    global $conn;

    $id_voitureH = $_POST['id_voitureH'];
    $query = "SELECT * FROM voiture,histrique_voiture WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
    AND histrique_voiture.id_histrique_voiture = $id_voitureH ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $voiture_data = [];
        $voiture_data[0] = $row['id_histrique_voiture'];
        $voiture_data[1] = $row['id_voiture_HV'];
        $voiture_data[2] = $row['date_HV'];
        $voiture_data[3] = $row['commentaire_HV'];
        $voiture_data[4] = $row['action'];
    }
    echo json_encode($voiture_data);
}


//modifier voiture
function update_voiture_value()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agenceuser = $_SESSION['id_agence'];
    $idvoiture = $_POST['id_voiture'];
    $Update_Type = $_POST['type'];
    $Update_Pimm = $_POST['pimm'];
    $Update_ModeleMarque = $_POST['marquemodele'];
    $Update_Fournisseur = $_POST['fournisseur'];
    $Update_Km = $_POST['km'];
    $Update_Date_achat = $_POST['date_achat'];
    $Update_Dispo = 'OUI';
    $up_date_immatriculation = $_POST['up_date_immatriculation'];
    $up_date_DPC_VGP = $_POST['up_date_DPC_VGP'];
    $up_date_DPT_Pollution = $_POST['up_date_DPT_Pollution'];
    $up_etat_voiture = $_POST['up_etat_voiture'];
    $up_voitureAgence = $_POST['up_voitureAgence'];
    $up_date_DPC_VT = $_POST['up_date_DPC_VT'];
    $update_query = "UPDATE voiture 
    SET type='$Update_Type',pimm='$Update_Pimm',id_MarqueModel=$Update_ModeleMarque
    ,fournisseur='$Update_Fournisseur',km='$Update_Km',date_achat='$Update_Date_achat'
    ,dispo='$Update_Dispo',date_immatriculation='$up_date_immatriculation'
    ,etat_voiture='$up_etat_voiture',id_agence='$up_voitureAgence',date_DPC_VT='$up_date_DPC_VT',
    date_DPC_VGP='$up_date_DPC_VGP',date_DPT_Pollution='$up_date_DPT_Pollution'
     WHERE id_voiture = $idvoiture";
    $update_result = mysqli_query($conn, $update_query);
    $queryVehiculeT = "INSERT INTO  
        histrique_voiture(id_voiture_HV,id_agence_em,id_agence_recv,action,id_user_HV) 
        VALUES ('$idvoiture','$id_agenceuser','$up_voitureAgence','Transferer','$id_user') ";
    $resultVehiculeT = mysqli_query($conn, $queryVehiculeT);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";

        return;
    } else {
        echo "<div class='text-success'>Le véhicule est modifié avec succès</div>";
        return;
    }
}

//modifier voiture
function update_voiture_vendue_value()
{
    global $conn;
    $id_voiture_vendue = $_POST['id_voiture_vendue'];
    $Up_Voituredate_vendue = $_POST['Up_Voituredate_vendue'];
    $Up_VoitureCommentaire = $_POST['Up_VoitureCommentaire'];
    $update_query = "UPDATE histrique_voiture 
    SET date_HV='$Up_Voituredate_vendue',commentaire_HV='$Up_VoitureCommentaire'
     WHERE id_histrique_voiture = $id_voiture_vendue";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}

//modifier voiture
function update_voiture_HS_value()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $id_voiture_HS = $_POST['id_voiture_HS'];
    $Up_Voituredate_HS = $_POST['Up_Voituredate_HS'];
    $Up_VoitureCommentaire = $_POST['Up_VoitureCommentaire'];
    $up_VoitureHS = $_POST['up_VoitureHS'];
    $Up_VHSid = $_POST['Up_VHSid'];
    if ($up_VoitureHS == "HS") {
        echo  $update_query = "UPDATE histrique_voiture 
    SET date_HV='$Up_Voituredate_HS',commentaire_HV='$Up_VoitureCommentaire'
     WHERE id_histrique_voiture = $id_voiture_HS";
        $update_result = mysqli_query($conn, $update_query);
    } else {
        $query = "INSERT INTO 
    histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
    VALUES ('$Up_VHSid','Disponible','$id_agence','$id_agence','$id_user','$Up_VoitureCommentaire','$Up_Voituredate_HS')";
        $result = mysqli_query($conn, $query);
        $update_query = "UPDATE voiture 
                        SET etat_voiture='Disponible'
                        WHERE id_voiture = $Up_VHSid";
        $update_result = mysqli_query($conn, $update_query);
    }
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}


function update_agence_stock()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agenceuser = $_SESSION['id_agence'];
    $id_voiture = $_POST['id_voiture'];
    $up_voitureAgence = $_POST['up_voitureAgence'];
    $queryag = "SELECT * FROM voiture  WHERE id_voiture = $id_voiture";
    $result_ag = mysqli_query($conn, $queryag);
    $result_ag = mysqli_query($conn, $result_ag);
    while ($row = mysqli_fetch_assoc($result_ag)) {
        $id_agenceuser = $row['id_agence'];
    }
    $update_query = "UPDATE voiture 
    SET   id_agence='$up_voitureAgence'
    WHERE id_voiture = $id_voiture";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        $queryVehiculeT = "INSERT INTO  
        histrique_voiture(id_voiture_HV,id_agence_em,id_agence_recv,action,id_user_HV) 
        VALUES ('$id_voiture','$id_agenceuser','$up_voitureAgence','Transferer','$id_user') ";
        $resultVehiculeT = mysqli_query($conn, $queryVehiculeT);
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}

//Ajouter entretien Records function
function InsertEntretien()
{
    global $conn;
    $EntretienType = isset($_POST['EntretienType']) ? $_POST['EntretienType'] : "";
    $Entretiendate = isset($_POST['Entretiendate']) ? $_POST['Entretiendate'] : "";
    $EntretienCommentaire = isset($_POST['EntretienCommentaire']) ? $_POST['EntretienCommentaire'] : "";
    $EntretienModelVoiture = isset($_POST['EntretienModelVoiture']) ? $_POST['EntretienModelVoiture'] : "";
    $ObjetEntretien = isset($_POST['ObjetEntretien']) ? $_POST['ObjetEntretien'] : "";
    $LieuEntretien = isset($_POST['LieuEntretien']) ? $_POST['LieuEntretien'] : "";
    $CoutEntretien = isset($_POST['CoutEntretien']) ? $_POST['CoutEntretien'] : "";
    $EntretienFindate = isset($_POST['EntretienFindate']) ? $_POST['EntretienFindate'] : "";
    $ProchaineEntretiendate = isset($_POST['ProchaineEntretiendate']) ? $_POST['ProchaineEntretiendate'] : "";
    $EntretienDateAchatVoiture = isset($_POST['EntretienDateAchatVoiture']) ? $_POST['EntretienDateAchatVoiture'] : "";
    $EntretienNomMateriel = isset($_POST['EntretienNomMateriel']) ? $_POST['EntretienNomMateriel'] : "";
    $EntretienModelVoiture = isset($_POST['EntretienModelVoiture']) ? $_POST['EntretienModelVoiture'] : "";
    $EntretienPIMM = isset($_POST['EntretienPIMM']) ? $_POST['EntretienPIMM'] : NULL;
    $EntretienNumSerieMateriel = isset($_POST['EntretienNumSerieMateriel']) ? $_POST['EntretienNumSerieMateriel'] : "";
    $EntretienDateAchatMateriel = isset($_POST['EntretienDateAchatMateriel']) ? $_POST['EntretienDateAchatMateriel'] : "";
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    if ($EntretienNomMateriel) {
        $query = "INSERT INTO 
        entretien(id_materiel,type,commentaire,date_achat,date_entretien,objet_entretien,lieu_entretien,cout_entretien,date_fin_entretien,prochaine_entretien) 
        VALUES ('$EntretienNomMateriel','$EntretienType','$EntretienCommentaire','$EntretienDateAchatMateriel','$Entretiendate','$ObjetEntretien','$LieuEntretien','$CoutEntretien','$EntretienFindate','$ProchaineEntretiendate')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>L'entretien est ajouté avec succés</div>";
            $query_update = "UPDATE materiels_agence SET etat_materiels='E' WHERE id_materiels_agence='$EntretienNomMateriel'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } elseif ($EntretienModelVoiture) {
        $query = "INSERT INTO 
        entretien(id_voiture,type,commentaire,date_achat,date_entretien,objet_entretien,lieu_entretien,cout_entretien,date_fin_entretien,prochaine_entretien) 
        VALUES ('$EntretienModelVoiture','$EntretienType','$EntretienCommentaire','$EntretienDateAchatMateriel','$Entretiendate','$ObjetEntretien','$LieuEntretien','$CoutEntretien','$EntretienFindate','$ProchaineEntretiendate')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "L'entretien est ajouté avec succés";
            $query_update = "UPDATE voiture SET etat_voiture='Entretien' WHERE id_voiture='$EntretienModelVoiture'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } else {
        echo 'échoué!';
    }
}

function get_entretien_record()
{
    global $conn;
    $EntretienId = $_POST['EntretienID'];
    $query = "SELECT E.id_entretien,E.type,E.date_entretien,E.commentaire,E.id_voiture,E.id_materiel,
    E.objet_entretien,E.lieu_entretien,E.cout_entretien,E.date_fin_entretien,E.prochaine_entretien,
    V.pimm,M.id_materiels_agence
    FROM `entretien`as E 
    LEFT JOIN materiels_agence as M ON E.id_materiel=M.id_materiels_agence 
    LEFT JOIN voiture as V on E.id_voiture=V.id_voiture 
  
    WHERE id_entretien='$EntretienId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $entretien_data = [];
        $entretien_data[0] = $row['id_entretien'];
        $entretien_data[1] = $row['type'];
        $entretien_data[2] = $row['date_entretien'];
        $entretien_data[3] = $row['commentaire'];
        $entretien_data[5] = $row['id_voiture'];
        $entretien_data[6] = $row['id_materiel'];
        $entretien_data[7] = $row['objet_entretien'];
        $entretien_data[8] = $row['lieu_entretien'];
        $entretien_data[9] = $row['cout_entretien'];
        $entretien_data[10] = $row['date_fin_entretien'];
        $entretien_data[11] = $row['prochaine_entretien'];

    }
    echo json_encode($entretien_data);
}

function update_entretien()
{
    global $conn;
    $Update_Entretien_Id = $_POST['up_dateEntretienId'];
    $Update_Entretien_Date = $_POST['up_dateEntretienDate'];
    $Update_Entretien_Commentaire = $_POST['up_dateEntretienCommentaire'];
    $up_EntretienIdVoiture = $_POST['up_EntretienIdVoiture'];
    $up_ObjetEntretien = $_POST['up_ObjetEntretien'];
    $up_LieuEntretien = $_POST['up_LieuEntretien'];
    $up_CoutEntretien = $_POST['up_CoutEntretien'];
    $up_EntretiendateFin = $_POST['up_EntretiendateFin'];
    $up_ProchaineEntretien = $_POST['up_ProchaineEntretien'];
    $up_VoitureEntretien = $_POST['up_VoitureEntretien'];
    $query = "UPDATE entretien SET  date_entretien='$Update_Entretien_Date',commentaire='$Update_Entretien_Commentaire'
    ,id_voiture='$up_EntretienIdVoiture',objet_entretien='$up_ObjetEntretien'
    ,lieu_entretien='$up_LieuEntretien',cout_entretien='$up_CoutEntretien'
    ,date_fin_entretien='$up_EntretiendateFin',prochaine_entretien='$up_ProchaineEntretien'
     WHERE id_entretien ='$Update_Entretien_Id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if ($up_VoitureEntretien == "Disponible") {
            $queryEnt = "SELECT  id_voiture,id_entretien,id_materiel,type   FROM entretien 
                        WHERE  id_entretien =   $Update_Entretien_Id ";
            $resultEnt = mysqli_query($conn, $queryEnt);
            while ($row = mysqli_fetch_assoc($resultEnt)) {
                if ($row['type'] == "Materiel") {
                    $idvoitureEnt = $row['id_materiel'];
                    $update_queryEnt = "UPDATE materiels_agence 
                    SET etat_materiels='T'
                     WHERE id_materiels_agence = $idvoitureEnt";
                    $update_resultEnt = mysqli_query($conn, $update_queryEnt);
                } else {
                    $idvoitureEnt = $row['id_voiture'];
                    $update_queryEnt = "UPDATE voiture 
                SET etat_voiture='Disponible'
                 WHERE id_voiture = $idvoitureEnt";
                    $update_resultEnt = mysqli_query($conn, $update_queryEnt);
                }
            }
        }
        echo "<div class='text-success'>L'entretien a été mis à jour avec succés</div> ";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function delete_entretien()
{
    global $conn;
    $Del_ID = $_POST['id_entretien'];
    $query = "DELETE FROM entretien WHERE id_entretien='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<div class='text-danger'>L'entretien est supprimé avec succés</div>";
    } else {
        echo "<div class='text-success'>SVP vérifier votre requette !</div>";
    }
}

// Afficher FACTURES
function display_facture_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
   $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_contrat,CL.id_client,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Vehicule'
        AND FC.id_client = C.id_client
        AND FC.id_agence =   $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_facture'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_facture_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
    $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_contrat,CL.id_client,CL.nom,CL.cin
    FROM  facture_client AS FC
    LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
    LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
    WHERE C.type_location = 'Materiel'
    AND FC.id_client = C.id_client
    AND FC.id_agence =   $id_agence";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_facture'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture-materiel" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function display_facture_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
    $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_contrat,CL.id_client,CL.nom,CL.cin
    FROM  facture_client AS FC
    LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
    LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
    WHERE C.type_location = 'Pack'
    AND FC.id_client = C.id_client
    AND FC.id_agence =   $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_facture'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture-pack" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_record_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Agence de départ</th>
    <th class="border-top-0">Agence de retour</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">Email de client</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>

    
    <th class="border-top-0">Actions</th>  
    </tr>';
    $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,C.KMPrevu,
    CL.id_client,CL.nom,CL.email,A.lieu_agence As lieu_dep,
    AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
    V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) <= C.date_fin 
        AND  C.type_location = 'Vehicule'
         AND C.id_client =CL.id_client
         AND C.id_agence =   $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0">' . $row['email'] . '</td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td> 
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-voiture" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td>    
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_archivage_record_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">KM Prévu</th>
    <th class="border-top-0">Actions</th>  
    </tr>';
    $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,C.KMPrevu,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) > C.date_fin 
        AND  C.type_location = 'Vehicule'
         AND C.id_client =CL.id_client
         AND C.id_agence =   $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['KMPrevu'] . '</td>
            <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-voiture" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>  
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_archivage_record_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">Num Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Action</th>     
    </tr>';
    $query = "SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,CL.nom,CL.cin 
    FROM contrat_client AS C 
    LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
    LEFT JOIN client AS CL ON C.id_client=CL.id_client
    WHERE DATE(NOW()) > C.date_fin 
      AND  C.type_location = 'Materiel'
      AND C.id_agence = $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>    
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_archivage_record_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">Num Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">N° de chéque Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">Action</th>  
    </tr>';
    $query = "SELECT CL.nom,CL.cin,
    C.id_contrat, C.duree,C.date_debut, C.date_fin, C.prix, C.mode_de_paiement, C.date_prelevement, C.caution, C.num_cheque_caution,C.type_location,
    MM.Marque, MM.Model,V.pimm
    FROM contrat_client AS C
    LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
    LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    WHERE DATE(NOW()) > C.date_fin 
    AND C.type_location = 'Pack' 
    AND C.id_agence = $id_agence";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['num_cheque_caution'] . '</td> 
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>    
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
// Afficher contrat materiel
function display_contrat_record_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date Début</th>
        <th class="border-top-0">Date Fin</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Désignation matériel</th>
        <th class="border-top-0">Num Série matériel</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Action</th>    
        </tr>';
    $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,
        C.mode_de_paiement,CL.nom,CL.email,CM.designation_contrat,CM.num_serie_contrat
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
         WHERE  C.type_location = 'Materiel'
          AND C.id_agence = $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>

            <td class="border-top-0">' . $row['id_agencedep'] . '</td>
            <td class="border-top-0">' . $row['id_agenceret'] . '</td>
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0">' . $row['email'] . '</td>
            <td class="border-top-0">' . $row['designation_contrat'] . '</td>
            <td class="border-top-0">' . $row['num_serie_contrat'] . '</td> 
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>  
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td>  
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
// Afficher contrat materiel
function display_contrat_record_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type de location</th>
        <th class="border-top-0">Modèle de Véhicule</th>
        <th class="border-top-0">PIMM de véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">Date début</th>
        <th class="border-top-0">Date fin</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">N° de chéque Caution</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Action</th>     
        </tr>';
    $query = " SELECT DISTINCT CL.nom,V.type,V.pimm,MM.Model,C.id_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution_materiel,
    C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN voiture AS V ON V.id_voiture=C.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
         WHERE DATE(NOW()) <= C.date_fin
          AND  C.type_location = 'Pack'
          AND C.id_agence = $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['num_cheque_caution_materiel'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-pack" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-pack" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td>     
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function InsertContratMateriel(){
    global $conn;
    // $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : NULL;
    $ContratType = "Materiel";
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratnumCautionMateriel = isset($_POST['ContratNumCautionMateriel']) ? $_POST['ContratNumCautionMateriel'] : NULL;
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] : NULL;
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] : NULL;
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $Id_materiel = isset($_POST['Id_materiel']) ? $_POST['Id_materiel'] : NULL;
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    $query = "INSERT INTO 
            contrat_client(id_client,id_voiture,id_materiels_contrat,id_group_pack,date_contrat,type_location,duree,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement,id_user,id_agence) 
            VALUES ('$ContratClient','0','$Id_materiel','0' ,'$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratnumCaution','$ContratVoiturekMPrevu','$ContratDatePaiement','$id_user','$id_agence')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_get_max_id_contrat = "SELECT max(id_contrat)
        FROM contrat_client WHERE type_location ='Materiel'";
        $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
        $row = mysqli_fetch_row($result_query_get_max_id_contra);
        $id_contrat = $row[0];
        $query_materiels =    "SELECT  code_materiel,`designation`, `num_serie_materiels`,id_materiels_agence FROM `materiels`,materiels_agence
         where 
         materiels.id_materiels = materiels_agence.id_materiels AND
         id_materiels_agence = '$Id_materiel'";
        $exection_materiel = mysqli_query($conn, $query_materiels);
        $resultat = mysqli_fetch_array($exection_materiel);
        $query = "INSERT INTO 
        materiel_contrat_client(id_contrat,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat) 
        VALUES ('$id_contrat','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','1')";
        $result = mysqli_query($conn, $query);
        $query_materiels_comp =    "SELECT  * FROM `composant_materiels` where id_materiels_agence = '$resultat[id_materiels_agence]'";
        $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
        while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
            $query = "INSERT INTO 
        composant_materiels_contrat(id_contrat,id_materiels_agence,designation_composant,num_serie_composant) 
        VALUES ('$id_contrat','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
            $result = mysqli_query($conn, $query);
        }
        $query_update = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
        $result_update = mysqli_query($conn, $query_update);
        echo "<div class='text-success'>contrat Ajouté</div>";
    } else {
        echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
    }
}

function InsertContratVoiture(){
    global $conn;
    // $ContratDate = $_POST['ContratDate'];
    $ContratType = "Vehicule";
    $ContratDuree = $_POST['ContratDuree'];
    $ContratDateDebut = $_POST['ContratDateDebut'];
    $ContratDateFin = $_POST['ContratDateFin'];
    $ContratPrixContrat = $_POST['ContratPrixContrat'];
    $ContratAssurence = $_POST['ContratAssurence'];
    $ContratPaiement = $_POST['ContratPaiement'];
    $ContratDatePaiement = $_POST['ContratDatePaiement'];
    $ContratCaution = $_POST['ContratCaution'];
    $ContratnumCaution = $_POST['ContratNumCaution'];
    $Contrat_voiture = $_POST['Contrat_voiture'];
    $ContratClient = $_POST['ContratClient'];
    $AgenceDepClient = $_SESSION['id_agence'];
    $AgenceRetClient = $_POST['AgenceRetClient'];
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    if ($ContratAssurence == "") {
        $ContratAssurence = "K2";
    }
    if ($AgenceRetClient == "") {
        $AgenceRetClient = $AgenceDepClient;
    }
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    $query = "INSERT INTO 
            contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,type_location,duree,date_debut,date_fin,prix,mode_de_paiement,caution,num_cheque_caution,assurance,date_prelevement,id_user,id_agence) 
            VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','$Contrat_voiture','0','0' ,'$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratPaiement','$ContratCaution','$ContratnumCaution','$ContratAssurence','$ContratDatePaiement','$id_user','$id_agence')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_update = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
        $result_update = mysqli_query($conn, $query_update);
        echo "<div class='text-success'>Le contrat est ajouté avec succés</div>";
    } else {
        echo "<div class='text-danger'>Erreur lors d'ajout du contrat</div>";
    }
}


function InsertContrat(){
    global $conn;
    $ContratmaterielListe = $_POST['ContratmaterielListe'];
    // $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : NULL;
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : NULL;
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratnumCautionMateriel = isset($_POST['ContratNumCautionMateriel']) ? $_POST['ContratNumCautionMateriel'] : NULL;
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] : NULL;
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] : NULL;
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $count = count($ContratmaterielListe);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    if ($ContratVoitureModel) {
        $query = "INSERT INTO 
        contrat(id_client,id_voiture,id_materiel,type_location,duree,date_debut,date_fin,prix,assurance,
        mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement) 
        VALUES ('$ContratClient','$ContratVoiturePIMM',NULL,'$ContratType','$ContratDuree','$ContratDateDebut',
        '$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratnumCaution',
        '$ContratVoiturekMPrevu','$ContratDatePaiement')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_updateC = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
            $result_update = mysqli_query($conn, $query_updateC);
            echo "<div class='text-success'>contrat véhicule est Ajouté</div>";
            $query_update = "UPDATE voiture SET dispo='NON' WHERE id_voiture='$ContratVoiturePIMM'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } elseif ($ContratmaterielListe) {
        echo $query = "INSERT INTO contrat(id_client,type_location,date_debut,date_fin,prix,assurance,
        mode_de_paiement,caution,date_prelevement,duree,num_cheque_caution_materiel) 
        VALUES('$ContratClient','$ContratType','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat',
        '$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratDatePaiement','$ContratDuree','$ContratnumCautionMateriel')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_contrat)
                    FROM contrat WHERE type_location ='Matériel'";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
                $id_contrat = $row[0];
                $materiel_table = $ContratmaterielListe;
                if ($count >= 1) {
                    for ($i = 0; $i < $count; $i++) {
                        if (trim($_POST["ContratmaterielListe"][$i] != '')) {
                            $query_insert_materiel_list = "INSERT INTO contrat_materiel(id_contrat,id_materiel) VALUES ('$id_contrat','$materiel_table[$i]') ";
                            $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                        }
                    }
                    if ($result_query_insert_materiel_list) {
                        echo ("<div class='text-success'>Le contrat est ajouté  avec succés</div>");
                    } else {
                        echo ("<div class='text-danger'>échoué!</div>");
                    }
                }
            }
        }
    } else {
        echo 'échoué!';
    }
}
function get_contrat_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.caution,C.num_cheque_caution,C.num_cheque_caution_materiel,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId '";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_fin'];
        $contrat_data[2] = $row['type_location'];
        $contrat_data[3] = $row['date_debut'];
        // $contrat_data[4] = $row['date_debut'];
        $contrat_data[5] = $row['prix'];
        $contrat_data[6] = $row['assurance'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['caution'];
        $contrat_data[9] = $row['date_prelevement'];
        $contrat_data[10] = $row['duree'];
        $contrat_data[12] = $row['num_cheque_caution'];
        $contrat_data[13] = $row['num_cheque_caution'];
    }
    echo json_encode($contrat_data);
}

function get_contrat_materiel_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.caution,C.num_cheque_caution,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId '";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_fin'];
        $contrat_data[2] = $row['type_location'];
        $contrat_data[3] = $row['date_debut'];
        // $contrat_data[4] = $row['date_debut'];
        $contrat_data[5] = $row['prix'];
        $contrat_data[6] = $row['assurance'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['caution'];
        // $contrat_data[9] = $row['date_prelevement'];
        // $contrat_data[10] = $row['duree'];
        $contrat_data[12] = $row['num_cheque_caution'];
        
    }
    echo json_encode($contrat_data);
}

function get_contrat_pack_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,C.caution,
    C.num_cheque_caution,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId '";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_debut'];
        $contrat_data[2] = $row['date_fin'];
        $contrat_data[3] = $row['duree'];
        $contrat_data[4] = $row['prix'];
        $contrat_data[5] = $row['caution'];
        $contrat_data[6] = $row['num_cheque_caution'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['date_prelevement'];
    }
    echo json_encode($contrat_data);
}

function update_contrat()
{
    global $conn;
    $Update_Contrat_Id = $_POST['up_contraId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    // $Update_Contrat_Assurence = $_POST['up_contratAssurence'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_Contrat_Caution = $_POST['up_contratCaution'];
    $num_caution_voiture = $_POST['updateContratnumCaution'];
    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',
     prix='$Update_Contrat_Prix',mode_de_paiement='$Update_Contrat_Paiement',caution='$Update_Contrat_Caution',
     num_cheque_caution='$num_caution_voiture'
     WHERE id_contrat ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function update_contrat_materiel()
{
    global $conn;
    $updateContratId = $_POST['updateContratId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    // $Update_Contrat_Assurence = $_POST['up_contratAssurence'];
    $Update_Contrat_Caution = $_POST['up_contratCaution'];
    $Update_num_caution = $_POST['updateContratnumCaution'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_date_Prelevement = $_POST['up_DatePrelevementContrat'];
    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',
     prix='$Update_Contrat_Prix',mode_de_paiement='$Update_Contrat_Paiement',caution='$Update_Contrat_Caution',
     num_cheque_caution='$Update_num_caution',date_prelevement='$Update_date_Prelevement'
     WHERE id_contrat ='$updateContratId'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function update_contrat_pack()
{
    global $conn;
    $updateContratId = $_POST['updateContratId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    $Update_Contrat_Caution = $_POST['up_contratCaution'];
    $Update_num_caution = $_POST['updateContratnumCaution'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_date_Prelevement = $_POST['up_DatePrelevementContrat'];
    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',
     prix='$Update_Contrat_Prix',mode_de_paiement='$Update_Contrat_Paiement',caution='$Update_Contrat_Caution',
     num_cheque_caution='$Update_num_caution',date_prelevement='$Update_date_Prelevement'
     WHERE id_contrat ='$updateContratId'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function delete_contrat_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_ContratID'];
    $query = "DELETE FROM contrat_client WHERE id_contrat='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Le contrat est supprimé";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function DisplayEntretienRecordMateriel()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">Objet Entretien</th>
    <th class="border-top-0">Lieu Entretien</th>
    <th class="border-top-0">Cout Entretien</th>
    <th class="border-top-0">Date Début </th>
    <th class="border-top-0">Date Fin </th>
    <th class="border-top-0"> Prochain entretien  </th>
    <th class="border-top-0">Commentaire</th>
    </tr>';
    $query = "SELECT * FROM entretien,materiels_agence
    WHERE  
     entretien.id_materiel = materiels_agence.id_materiels_agence
    AND `entretien`.`type` ='Materiel'
";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_entretien'] . '</td>
            <td class="border-top-0">Matériel</td>
            <td class="border-top-0">' . $row['objet_entretien'] . '</td>
            <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
            <td class="border-top-0">' . $row['cout_entretien'] . '</td>
            <td class="border-top-0">' . $row['date_entretien'] . '</td>
            <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
            <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
            <td class="border-top-0">' . $row['commentaire'] . '</td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function DisplayEntretienRecordVoitures()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Objet Entretien</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0"> Prochain entretien  </th>
        <th class="border-top-0">Commentaire</th>
        </tr>';
    $query = "SELECT * FROM entretien,voiture
    WHERE  entretien.id_voiture =voiture.id_voiture
         AND `entretien`.`type` ='Vehicule'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_entretien'] . '</td>
                    <td class="border-top-0">Voiture</td>
                    <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                    <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                    <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                    <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
                    <td class="border-top-0">' . $row['commentaire'] . '</td>
                </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function DisplayEntretienRecordVoiture()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Objet Entretien</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0"> Prochain entretien  </th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    $query = "SELECT * FROM entretien,voiture
    WHERE  entretien.id_voiture =voiture.id_voiture
    AND etat_voiture ='Entretien'
  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_entretien'] . '</td>
                <td class="border-top-0">Voiture</td>
                <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
                <td class="border-top-0">' . $row['commentaire'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-Entretien" data-id=' . $row['id_entretien'] . '><i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-Entretien" data-id1=' . $row['id_entretien'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function select_contrat_voiture_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.caution,C.KMPrevu,C.id_client,
    C.type_location,C.num_contrat,C.date_debut,C.date_prelevement,C.date_fin,C.prix,C.assurance,
    C.mode_de_paiement,C.num_cheque_caution,CL.id_client,CL.nom,CL.adresse,CL.num_siret,
    CL.tel,CL.email,CL.cin,V.pimm,MM.Model,MM.Marque,V.type,C.id_voiture
    FROM contrat_client AS C 
    LEFT JOIN client AS CL ON C.id_client =CL.id_client 
    LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
    LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
    WHERE C.type_location = 'Vehicule' 
    AND C.id_client =CL.id_client 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_materiel_data = [];
        $contrat_materiel_data[0] = $row['id_contrat'];
        $contrat_materiel_data[1] = $row['id_client'];
        $contrat_materiel_data[18] = $row['nom'];
        $contrat_materiel_data[2] = $row['email'];
        $contrat_materiel_data[3] = $row['tel'];
        $contrat_materiel_data[4] = $row['adresse'];
        $contrat_materiel_data[5] = $row['type'];
        $contrat_materiel_data[6] = $row['Marque'] . ' ' . $row['Model'];
        $contrat_materiel_data[7] = $row['pimm'];
        $contrat_materiel_data[8] = $row['date_debut'];
        $contrat_materiel_data[9] = $row['date_fin'];
        $contrat_materiel_data[10] = $row['prix'];
        $contrat_materiel_data[11] = $row['mode_de_paiement'];
        $contrat_materiel_data[12] = $row['caution'];
        // $contrat_materiel_data[13] = $row['date_contrat'];
        $contrat_materiel_data[14] = $row['KMPrevu'];
        $contrat_materiel_data[15] = $row['date_prelevement'];
        $contrat_materiel_data[16] = $row['duree'];
        $contrat_materiel_data[17] = $row['num_cheque_caution'];
    }
    echo json_encode($contrat_materiel_data);
}

function select_contrat_materiel_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT CL.nom, CL.email, CL.tel, CL.adresse, 
    C.id_contrat, C.date_contrat, C.date_debut, C.date_fin, C.prix,
     C.mode_de_paiement, C.date_prelevement, C.caution, C.num_cheque_caution_materiel,
      CM.designation_contrat, CM.num_serie_contrat, CC.designation_composant, 
      CC.num_serie_composant 
    FROM materiel_contrat_client AS CM 
    LEFT JOIN contrat_client AS C ON CM.id_contrat =C.id_contrat
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
    WHERE C.type_location = 'Materiel' 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    $contrat_materiel_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($contrat_materiel_data)) {
            $contrat_materiel_data[0] = $row['id_contrat'];
            $contrat_materiel_data[1] = $row['nom'];
            $contrat_materiel_data[2] = $row['email'];
            $contrat_materiel_data[3] = $row['tel'];
            $contrat_materiel_data[4] = $row['adresse'];
            //materiel info
            $contrat_materiel_data[5] = $row['designation_contrat'];
            $contrat_materiel_data[6] = $row['num_serie_contrat'];
            $contrat_materiel_data[7][] = $row['designation_composant'];
            $contrat_materiel_data[14][] = $row['num_serie_composant'];
            //end materiel info
            $contrat_materiel_data[8] = $row['date_debut'];
            $contrat_materiel_data[9] = $row['date_fin'];
            $contrat_materiel_data[10] = $row['prix'];
            $contrat_materiel_data[11] = $row['mode_de_paiement'];
            $contrat_materiel_data[12] = $row['caution'];
            $contrat_materiel_data[13] = $row['date_contrat'];
            $contrat_materiel_data[15] = $row['date_prelevement'];
            $contrat_materiel_data[16] = $row['num_cheque_caution_materiel'];
        } else {
            $contrat_materiel_data[7][] = $row['designation_composant'];
            $contrat_materiel_data[14][] = $row['num_serie_composant'];
        }
    }
    echo json_encode($contrat_materiel_data);
}

function searchAgence()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Lieu agence</th>
            <th class="border-top-0">Date création agence</th>
            <th class="border-top-0">E-mail agence</th>
            <th class="border-top-0">Tél agence</th>
            <th class="border-top-0">Actions</th>  
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM  agence
                WHERE  etat_agence !='S' 
                AND id_agence != 0
                AND  ( id_agence LIKE ('%" . $search . "%')
                OR lieu_agence LIKE ('%" . $search . "%')       
                OR date_agence LIKE ('%" . $search . "%')
                OR email_agence LIKE ('%" . $search . "%')
                OR tel_agence LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_agence'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['date_agence'] . '</td>
                <td class="border-top-0">' . $row['email_agence'] . '</td>
                <td class="border-top-0">' . $row['tel_agence'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-agence" data-id=' . $row['id_agence'] . '>
                  <i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-agence" data-id1=' . $row['id_agence'] . '>
                  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_agence_record();
    }
}

function searchUser()
{
    global $conn;
    $value = '<table class="table">
    <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Nom</th>
        <th class="border-top-0">Login</th>
        <th class="border-top-0">Rôle</th>
        <th class="border-top-0">Lieu Agence</th>
        <th class="border-top-0">Etat</th>
        <th class="border-top-0">Actions</th> 
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM user ,agence 
        WHERE (user.id_agence = agence.id_agence)
        AND  etat_user != 'S'
        AND  ( id_user LIKE ('%" . $search . "%')
            OR nom_user LIKE ('%" . $search . "%')       
            OR login LIKE ('%" . $search . "%')       
            OR role LIKE ('%" . $search . "%')
            OR lieu_agence LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_user'] == 'T') {
                    $etat = "active";
                } else {
                    $etat = "désactiver";
                }
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_user'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td class="border-top-0">' . $row['login'] . '</td>
                <td class="border-top-0">' . $row['role'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $etat . '</td>
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-user" data-id=' . $row['id_user'] . '><i class="fas fa-edit"></i></button> ';
                if ($row['role'] != 'superadmin') {
                    $value .= '   <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-user" data-id1=' . $row['id_user'] . '><i class="fas fa-trash-alt"></i></button>';
                }
                $value .= ' </td>
                            </tr>';
            }
            $value .= '</table>';

            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_user_record();
    }
}

function searchClient()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Nom</th>
    <th class="border-top-0">E-mail</th>
    <th class="border-top-0">Téléphone</th>
    <th class="border-top-0">Adresse</th>
    <th class="border-top-0">Raison Social</th>
    <th class="border-top-0">Commentaire</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">CIN</th>
    <th class="border-top-0">Permis</th>
    <th class="border-top-0">KBIS</th>
    <th class="border-top-0">RIB</th>
    <th class="border-top-0">Actions</th>
        
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM client
         WHERE etat_client ='A'
         AND ( nom LIKE ('%" . $search . "%')
                OR email LIKE ('%" . $search . "%')       
                OR raison_social LIKE ('%" . $search . "%')       
                OR comment LIKE ('%" . $search . "%')       
                OR type LIKE ('%" . $search . "%')       
                OR adresse LIKE ('%" . $search . "%')
                OR tel LIKE ('%" . $search . "%')
                OR id_client LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_client'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['tel'] . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <td class="border-top-0">' . $row['raison_social'] . '</td>
                <td class="border-top-0">' . $row['comment'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
              </style>
               <td class="border-top-0"><a href="uploads/' . $row["cin"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["cin"] . '"></a></td>
               <td class="border-top-0"><a href="uploads/' . $row["permis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["permis"] . '"></a></td>
               <td class="border-top-0"><a href="uploads/' . $row["kbis"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["kbis"] . '"></a></td>
               <td class="border-top-0"><a href="uploads/' . $row["rib"] . '" target="_blank"><img width="60px"height="40px" class="cin" src="uploads/' . $row["rib"] . '"></a></td>
                <td class="border-top-0">';
                if ($row['type'] == "CLIENT PRO") {
                    $value .= '    <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                } else {
                    $value .= '  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                }

                $value .= '       <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_client_record();
    }
}

function searchCategorie()
{
    global $conn;
    $value = '<table class="table">
    <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Code de catégorie</th>
        <th class="border-top-0">Famille de catégorie</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0"> Type de location</th>
        <th class="border-top-0"> N° serie obligatoire</th>
        <th class="border-top-0">Actions</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM materiels
         WHERE etat_materiels_categorie !='S'
         AND ( code_materiel LIKE ('%" . $search . "%')
                OR famille_materiel LIKE ('%" . $search . "%')       
                OR designation LIKE ('%" . $search . "%')
                OR type_location LIKE ('%" . $search . "%')
                OR id_materiels LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['num_serie_obg'] == 'T') {
                    $obligatoireserie = 'OUI';
                } else {
                    $obligatoireserie = 'NON';
                }
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_materiels'] . '</td>
                        <td class="border-top-0">' . $row['code_materiel'] . '</td>
                        <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                        <td class="border-top-0">' . $row['designation'] . '</td>
                        <td class="border-top-0">' . $row['type_location'] . '</td>
                        <td class="border-top-0">' . $obligatoireserie . '</td>
                        <td class="border-top-0">
                        <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-categorie" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_categorie_record();
    }
}

function searchVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">PIMM</th>
    <th class="border-top-0">Marque/Modèle</th>
    <th class="border-top-0">Date VGP</th>
    <th class="border-top-0">Date VT</th>
    <th class="border-top-0">Date Pollution</th>
    <th class="border-top-0">Actions</th>
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * 
        FROM voiture as V LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE V.etat_voiture = 'Disponible' 
        AND actions='T'
        AND V.id_agence='$id_agence' 
        AND (V.id_voiture LIKE ('%" . $search . "%')
                OR V.type LIKE ('%" . $search . "%')       
                OR V.pimm LIKE ('%" . $search . "%')
                OR MM.Marque LIKE ('%" . $search . "%')
                OR MM.Model LIKE ('%" . $search . "%')
                OR V.date_DPC_VGP LIKE ('%" . $search . "%')
                OR V.date_DPC_VT LIKE ('%" . $search . "%')
                OR V.date_DPT_Pollution LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                        <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>
                        <td class="border-top-0">
                        <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture" data-id=' . $row['id_voiture'] . '><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-voiture" data-id1=' . $row['id_voiture'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_record();
    }
}

function searchVoitureVendu()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">PIMM</th>
    <th class="border-top-0">Date vente</th>
    <th class="border-top-0">Commentaire</th>
    <th class="border-top-0">Action</th>
        </tr>';

    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * 
        FROM voiture,histrique_voiture WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
        AND histrique_voiture.action = 'Vendue' 
        AND voiture.id_agence='$id_agence'
        AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . $search . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['date_HV'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                        <td class="border-top-0">
                          <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture-vendue" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button>  
                        </td>
                    </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_vendue_record();
    }
}

function searchVoitureHS()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Action</th> 
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * 
        FROM voiture,histrique_voiture 
        WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
        AND voiture.etat_voiture = 'HS'
         AND histrique_voiture.action = 'HS'
        AND voiture.id_agence='$id_agence' 
        AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . $search . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%'))
                GROUP BY voiture.id_voiture 
                ORDER BY `histrique_voiture`.`date_action` DESC");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['date_HV'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                        <td class="border-top-0">
                          <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-voiture-HS" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
                          </td>
                    </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_hs_record();
    }
}

function searchMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<div class="table-responsive">
    <table class="table">
    <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0"> Code de matériel</th>
            <th class="border-top-0">N° de série</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">Quantité</th>
            <th class="border-top-0">Quantité dispo</th>
            <th class="border-top-0">Composant</th>
            <th class="border-top-0">État</th>
            <th class="border-top-0">Actions</th>
        </tr>
        </thead>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("  SELECT * FROM materiels,materiels_agence 
        where materiels.id_materiels = materiels_agence.id_materiels 
        AND id_agence ='$id_agence' 
        AND materiels_agence.etat_materiels != 'F'
        AND (	id_materiels_agence LIKE ('%" . $search . "%')
                OR code_materiel LIKE ('%" . $search . "%')       
                OR num_serie_materiels LIKE ('%" . $search . "%')
                OR designation LIKE ('%" . $search . "%')
                OR type_location LIKE ('%" . $search . "%')
                OR quantite_materiels LIKE ('%" . $search . "%')
                OR quantite_materiels_dispo LIKE ('%" . $search . "%') )");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $comp = $row['id_materiels_agence'];
                if ($row['etat_materiels'] == "T") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "ACTIF ";
                } elseif ($row['etat_materiels'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $etat = "Hors Service";
                }
                $value .= '
        <tbody>
            <tr ' . $color . ' >
                <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['designation'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';
                $value .= '<td class="border-top-0">';
                $querycomp = "SELECT designation_composant FROM materiels_agence,composant_materiels where materiels_agence.id_materiels_agence = composant_materiels.id_materiels_agence 
                AND materiels_agence.id_materiels_agence = '$comp'";
                $resultcom = mysqli_query($conn, $querycomp);
                while ($row1 = mysqli_fetch_assoc($resultcom)) {
                    $value .= ' <span class=" text-primary">' . $row1['designation_composant'] . ' </span> <br> ';
                }
                $value .=   '</td>';
                $value .= ' <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">';
                if ($row['num_serie_obg'] == "T") {
                    $value .= '
            <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-materiel" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
                } else {
                    $value .= '  <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-materiel-stock" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
                }
                $value .=    ' 
                   <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-materiel" data-id1=' . $row['id_materiels_agence'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_materiel();
    }
}

function searchGestionPack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Désignation</th>
    <th class="border-top-0">Voiture</th>
    <th class="border-top-0">Matériels</th>
    <th class="border-top-0">Etat Pack</th>
    <th class="border-top-0">Actions</th>
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM group_packs where etat_group_pack !='S'
        AND (id_group_packs LIKE ('%" . $search . "%')
                OR designation_pack LIKE ('%" . $search . "%')          
                OR type_voiture LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $comp = $row['id_group_packs'];
                if ($row['etat_group_pack'] == "T") {
                    $etat = "Activer ";
                    $colour = "";
                } elseif ($row['etat_group_pack'] == "F") {
                    $etat = "Hors Service";
                    $colour = "style= 'background:#ececec' ";
                }
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                        <td class="border-top-0">' . $row['designation_pack'] . '</td>
                        <td class="border-top-0">' . $row['type_voiture'] . '</td>';
                $value .= '<td class="border-top-0" >';
                $querycomp = "SELECT * FROM materiel_group_packs,materiels WHERE materiels.id_materiels = materiel_group_packs.id_materiels 
                        AND materiel_group_packs.id_group_packs = '$comp'";
                $resultcom = mysqli_query($conn, $querycomp);

                while ($row_materiels = mysqli_fetch_assoc($resultcom)) {
                    $value .= ' <span class=" text-primary">(' . $row_materiels['quantite'] . ')' . $row_materiels['designation'] . ' </span>
                    </br>  ';
                }
                $value .=   '</td>';
                $value .= ' <td class="border-top-0">' . $etat . '</td>
                        <td class="border-top-0">
                          <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-pack" data-id=' . $row['id_group_packs'] . '><i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-pack" data-id1=' . $row['id_group_packs'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
            }

            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_grouppack_record();
    }
}

function searchStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '  <div class="table-responsive">
    <table  class="table customize-table mb-0 v-middle">
    <thead class="table-light">
            <tr>
                <th class="border-top-1">ID</th>
                <th class="border-top-1">Pimm</th>
                <th class="border-top-1">Type</th>
                <th class="border-top-1">Date Achat</th>
                <th class="border-top-1">Disponibilité</th>
                <th class="border-top-1">Transfert </th>   
            </tr>
    </thead>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT * FROM `voiture`
        WHERE id_agence = '$id_agence'
        AND  (id_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . $search . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_achat LIKE ('%" . $search . "%')       
                OR etat_voiture LIKE ('%" . $search . "%'))
                ORDER BY `etat_voiture` ASC ");
        } else {
            $sql = ("SELECT * FROM `voiture`
        WHERE  (id_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . $search . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_achat LIKE ('%" . $search . "%')       
                OR etat_voiture LIKE ('%" . $search . "%'))
                ORDER BY `etat_voiture` ASC ");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_voiture'] == "Loue") {
                    $color = "badge bg-light-warning text-warning fw-normal";
                    $color1 = "background-color: #ffedd4!important";
                    $row['etat_voiture'] = "LOUER";
                } elseif ($row['etat_voiture'] == "Entretien") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $rowETAT = "ENTRETIEN";
                } elseif ($row['etat_voiture'] == "Vendue") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $rowETAT = "VENDU";
                } elseif ($row['etat_voiture'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #343a40!important";
                    $rowETAT = "HORS SERVICE";
                } elseif ($row['etat_voiture'] == "Disponible") {
                    $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
                    if ($disponibilte == 'disponibile') {
                        $color = "badge bg-light-success text-white fw-normal";
                        $color1 = "background-color: #2cd07e!important";
                        $rowETAT = "DISPONIBLE";
                    } else {
                        $color = "badge bg-light-info text-white fw-normal";
                        $color1 = "background-color: #ff5050!important";
                        $rowETAT = "NON DISPONIBLE";
                    }
                }
                $value .= '
              <tbody>
                      <tr>
                          <td class="border-top-1  ">' . $row['id_voiture'] . '</td>
                          <td class="border-top-1">' . $row['pimm'] . '</td>
                          <td class="border-top-1">' . $row['type'] . '</td>
                          <td class="border-top-1">' . $row['date_achat'] . '</td>
                          <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>';
                if ($row['etat_voiture'] != "VENDU") {
                    $value .= '<td><button class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert" data-id=' . $row['id_voiture'] . '><i class="fas fa-exchange-alt"></i></button></td>';
                }
                $value .= ' </tr>
              </tbody>';
            }
            $value .= '</table> </div>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        selectVoiteurDispoStock();
    }
}

function searchStockMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<div class="table-responsive">
    <table  class="table customize-table mb-0 v-middle">
    <thead class="table-light">
                <th class="border-top-0">ID</th>
                <th class="border-top-0">N° série de matériel </th>
                <th class="border-top-0">Quantité disponible</th>
                <th class="border-top-0">Disponibilitée</th>
            </tr>
            </thead>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM materiels_agence,materiels
             WHERE materiels_agence.id_materiels = materiels.id_materiels
         AND  materiels_agence.etat_materiels !='F'
         AND (num_serie_materiels LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_materiels'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $etat = "HORS SERVICE";
                } elseif ($row['etat_materiels'] == "T") {
                    $disponibilte =  $row['quantite_materiels_dispo'];
                    if ($disponibilte > 0) {
                        $color = "badge bg-light-success text-white fw-normal";
                        $color1 = "background-color: #2cd07e!important";
                        $etat = "DISPONIBLE";
                    } else {
                        $color = "badge bg-light-info text-white fw-normal";
                        $color1 = "background-color: #ff5050!important";
                        $etat = "NON DISPONIBLE";
                    }
                } else {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $etat = "NON DISPONIBLE";
                }
                $value .= '
                <tbody>          
                            <tr>
                            <td class="border-top-0">' . $row['id_materiels'] . '</td>
                            <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                            <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>
                            <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                            <td class="border-top-0">
                            </td>
                            </tr>
                            </tbody>';
            }
            $value .= '</table>
            </div>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        selectMaterielDispoStock();
    }
}
function searchEntretiens()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">Objet Entretien</th>
    <th class="border-top-0">Lieu Entretien</th>
    <th class="border-top-0">Cout Entretien</th>
    <th class="border-top-0">Date Début </th>
    <th class="border-top-0">Date Fin </th>
    <th class="border-top-0"> Prochain entretien  </th>
    <th class="border-top-0">Commentaire</th>
    <th class="border-top-0">Actions</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM entretien,voiture
        WHERE  entretien.id_voiture =voiture.id_voiture
        AND etat_voiture ='Entretien'
        AND (id_entretien LIKE ('%" . $search . "%')
                OR objet_entretien LIKE ('%" . $search . "%')       
                OR lieu_entretien LIKE ('%" . $search . "%')                         
                OR cout_entretien LIKE ('%" . $search . "%')       
                OR date_entretien LIKE ('%" . $search . "%')       
                OR date_fin_entretien LIKE ('%" . $search . "%')       
                OR prochaine_entretien LIKE ('%" . $search . "%')       
                OR commentaire LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_entretien'] . '</td>
                        <td class="border-top-0">Voiture</td>
                        <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                        <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                        <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                        <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
                        <td class="border-top-0">' . $row['commentaire'] . '</td> 
                        <td class="border-top-0">
                          <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-Entretien" data-id=' . $row['id_entretien'] . '><i class="fas fa-edit"></i></button>
                           <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-Entretien" data-id1=' . $row['id_entretien'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordVoiture();
    }
}

function searchContratVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Agence de départ</th>
    <th class="border-top-0">Agence de retour</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">Email de client</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Actions</th>  
    </tr>';
    
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,C.KMPrevu,
        CL.id_client,CL.nom,CL.email,A.lieu_agence As lieu_dep,
        AR.lieu_agence As lieu_agence_ret,
        V.pimm,MM.Model 
            FROM contrat_client AS C 
            LEFT JOIN client AS CL ON C.id_client =CL.id_client 
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
            LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
            WHERE DATE(NOW()) <= C.date_fin 
            AND  C.type_location = 'Vehicule'
             AND C.id_client =CL.id_client
             AND C.id_agence =   $id_agence AND
        (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')     
        OR C.date_fin LIKE ('%" . $search . "%')
        OR A.lieu_agence LIKE ('%" . $search . "%')
        OR AR.lieu_agence LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR CL.email LIKE ('%" . $search . "%')
        OR MM.Model LIKE ('%" . $search . "%')
        OR V.pimm LIKE ('%" . $search . "%')
        OR C.duree LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.caution LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td> 
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
                
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-voiture" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                </td> 
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche! </h4>";
        }
    } else {
        display_contrat_record_voiture();
    }
}
function searchContratMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    <th class="border-top-0">Action</th> 
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT DISTINCT C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution_materiel,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
         WHERE DATE(NOW()) <= C.date_fin
          AND  C.type_location = 'Materiel'
          AND C.id_agence = $id_agence AND
        (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')     
        OR C.duree LIKE ('%" . $search . "%')     
        OR C.caution LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.assurance LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . $row['date_contrat'] . '</td>
                    <td class="border-top-0">' . $row['type_location'] . '</td>
                    <td class="border-top-0">' . $row['duree'] . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>                 
                    <td class="border-top-0">' . $row['date_debut'] . '</td>
                    <td class="border-top-0">' . $row['date_fin'] . '</td>
                    <td class="border-top-0">' . $row['prix'] . '</td>
                    <td class="border-top-0">' . $row['assurance'] . '</td>
                    <td class="border-top-0">' . $row['caution'] . '</td>
                    <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
                    <td class="border-top-0">' . $row['nom'] . '</td>                
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                    <td class="border-top-0">
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                    </td>  
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_record_materiel();
    }
}

function searchContratPack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Véhicule</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">N° de chéque Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">Action</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,V.pimm,V.type
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
         WHERE DATE(NOW()) <= C.date_fin
          AND  C.type_location = 'Pack'
          AND C.id_agence = $id_agence AND
        (C.id_contrat LIKE ('%" . $search . "%')
        OR C.type_location LIKE ('%" . $search . "%')
        OR V.pimm LIKE ('%" . $search . "%')
        OR V.type LIKE ('%" . $search . "%')
        OR C.duree LIKE ('%" . $search . "%') 
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.assurance LIKE ('%" . $search . "%')
        OR C.caution LIKE ('%" . $search . "%')     
        OR C.num_cheque_caution LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . $row['type_location'] . '</td>
                    <td class="border-top-0">' . $row['pimm'] . '</td>
                    <td class="border-top-0">' . $row['type'] . '</td>
                    <td class="border-top-0">' . $row['duree'] . '</td>                 
                    <td class="border-top-0">' . $row['date_debut'] . '</td>
                    <td class="border-top-0">' . $row['date_fin'] . '</td>
                    <td class="border-top-0">' . $row['prix'] . '</td>
                    <td class="border-top-0">' . $row['assurance'] . '</td>
                    <td class="border-top-0">' . $row['caution'] . '</td>
                    <td class="border-top-0">' . $row['num_cheque_caution'] . '</td>
                    <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
                    <td class="border-top-0">' . $row['nom'] . '</td>                
                    <td class="border-top-0">
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                    </td>  
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_record_pack();
    }
}

function searchEntretienMateriel()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">Objet Entretien</th>
    <th class="border-top-0">Lieu Entretien</th>
    <th class="border-top-0">Cout Entretien</th>
    <th class="border-top-0">Date Début </th>
    <th class="border-top-0">Date Fin </th>
    <th class="border-top-0"> Prochain entretien  </th>
    <th class="border-top-0">Commentaire</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM entretien,materiels_agence
        WHERE entretien.id_materiel = materiels_agence.id_materiels_agence
        AND `entretien`.`type` ='Materiel'
        AND(id_entretien LIKE ('%" . $search . "%')
        OR objet_entretien LIKE ('%" . $search . "%')
        OR lieu_entretien LIKE ('%" . $search . "%')
        OR cout_entretien LIKE ('%" . $search . "%')
        OR date_entretien LIKE ('%" . $search . "%')
        OR date_fin_entretien LIKE ('%" . $search . "%')
        OR prochaine_entretien LIKE ('%" . $search . "%')
        OR commentaire LIKE ('%" . $search . "%'))
                  ORDER BY id_entretien ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_entretien'] . '</td>
                    <td class="border-top-0">Matériel</td>
                    <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                    <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                    <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                    <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
                    <td class="border-top-0">' . $row['commentaire'] . '</td>
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordMateriel();
    }
}
function searchEntretienVoiture()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Objet Entretien</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0"> Prochain entretien  </th>
        <th class="border-top-0">Commentaire</th>
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM entretien,voiture
        WHERE  entretien.id_voiture =voiture.id_voiture
        AND `entretien`.`type` ='Vehicule'
        AND(id_entretien LIKE ('%" . $search . "%')
        OR objet_entretien LIKE ('%" . $search . "%')
        OR lieu_entretien LIKE ('%" . $search . "%')
        OR cout_entretien LIKE ('%" . $search . "%')
        OR date_entretien LIKE ('%" . $search . "%')
        OR date_fin_entretien LIKE ('%" . $search . "%')
        OR prochaine_entretien LIKE ('%" . $search . "%')
        OR commentaire LIKE ('%" . $search . "%'))
        ORDER BY id_entretien ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                        <tr>
                            <td class="border-top-0">' . $row['id_entretien'] . '</td>
                            <td class="border-top-0">Voiture</td>
                            <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                            <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                            <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                            <td class="border-top-0">' . $row['date_entretien'] . '</td>
                            <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                            <td class="border-top-0">' . $row['prochaine_entretien'] . '</td>
                            <td class="border-top-0">' . $row['commentaire'] . '</td>      
                        </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordVoitures();
    }
}

//search Devis
function searchGestionDevis()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Nom devis</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Commentaire</th>
    <th class="border-top-0">Date devis</th>
    <th class="border-top-0">Remise</th>
    <th class="border-top-0">Escompte</th>
    <th class="border-top-0">Nom client</th>
    <th class="border-top-0">Actions</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM devis,client
         WHERE devis.id_client_devis =client.id_client
         And (  id_devis LIKE ('%" . $search . "%')
                OR nom_devis LIKE ('%" . $search . "%')
                OR date_devis LIKE ('%" . $search . "%')       
                OR remise LIKE ('%" . $search . "%')       
                OR escompte LIKE ('%" . $search . "%')       
                OR nom LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_devis'] . '</td>
                <td class="border-top-0">' . $row['nom_devis'] . '</td>
                <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                <td class="border-top-0">' . $row['date_devis'] . '</td>
                <td class="border-top-0">' . $row['remise'] . '%</td>
                <td class="border-top-0">' . $row['escompte'] . '%</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">
                <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-devis" data-id=' . $row['id_devis'] . '><i class="fas fa-edit"></i></button> 
                <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-devis" data-id1=' . $row['id_devis'] . '><i class="fas fa-trash-alt"></i></button>
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-devis" data-id2=' . $row['id_devis'] . '><i class="fas fa-list-alt"></i></i></button>
                </tr>';
                }
                $value .= '</table>';
                echo $value;
            } else {
                echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
            }
        } else {
            view_devis();
    }
}

//search Facture
function searchFactureContratVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT FC.id_facture,FC.date_facture,FC.id_contrat,C.date_contrat,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Vehicule'
        AND FC.id_client = C.id_client
        AND FC.id_agence =   $id_agence 
        AND ( FC.id_facture LIKE ('%" . $search . "%')
        OR FC.date_facture LIKE ('%" . $search . "%')     
        OR FC.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR CL.cin LIKE ('%" . $search . "%'))
        ORDER BY FC.id_facture ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche! </h4>";
        }
    } else {
        display_facture_voiture();
    }
}
function searchFactureContratMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT FC.id_facture,FC.date_facture,FC.id_contrat,C.date_contrat,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Materiel'
        AND FC.id_client = C.id_client
        AND FC.id_agence =   $id_agence 
        AND ( FC.id_facture LIKE ('%" . $search . "%')
        OR FC.date_facture LIKE ('%" . $search . "%')     
        OR FC.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR CL.cin LIKE ('%" . $search . "%'))
        ORDER BY FC.id_facture ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture-materiel" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche! </h4>";
        }
    } else {
        display_facture_materiel();
    }
}

function searchFactureContratPack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">ID FACTURE</th>
    <th class="border-top-0">DATE DE FACTURATION</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">DATE DE CONTRAT</th>
    <th class="border-top-0">Nom du client</th>
    <th class="border-top-0">CIN de client</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT FC.id_facture,FC.date_facture,FC.id_contrat,C.date_contrat,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Pack'
        AND FC.id_client = C.id_client
        AND FC.id_agence =   $id_agence 
        AND ( FC.id_facture LIKE ('%" . $search . "%')
        OR FC.date_facture LIKE ('%" . $search . "%')     
        OR FC.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR CL.cin LIKE ('%" . $search . "%'))
        ORDER BY FC.id_facture ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-facture-pack" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche! </h4>";
        }
    } else {
        display_facture_pack();
    }
}

function InsertSettingVoiture()
{
    global $conn;
    $voitureMarque = $_POST['voitureMarque'];
    $voitureModel = $_POST['voitureModel'];
    $sql_e = "SELECT * FROM marquemodel WHERE Marque='$voitureMarque' AND Model='$voitureModel'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger">
            Désolé... Marque ou Modéle est déjà existant!</div>';
    } else {
        $query = "INSERT INTO marquemodel(Marque,Model) VALUE('$voitureMarque','$voitureModel')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<div class="text-success">Marque ou Modèle est ajouté  avec succés</div>';
        } else {
            echo 'Veuillez vérifier votre requête';
        }
    }
}
function DisplaySettingVoiture()
{
    global $conn;
    $value = "";
    $value = '<table class="table">
                <tr>
                    <th class="border-top-0"> Marque </th>
                    <th class="border-top-0"> Madèle </th>
                    <th class="border-top-0"> Action</th>
                </tr>';
    $query = "SELECT * FROM marquemodel  WHERE  etat_marque!='S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <td> ' . $row['Marque'] . ' </td>
                        <td> ' . $row['Model'] . ' </td>
                        <td> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn_delete_marque" data-id6=' . $row['id_MarqueModel'] . '><span class="fa fa-trash"></span></button> </td>
                    </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function DisplaySettingVoitureHS()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date Hors service</th>
        <th class="border-top-0">Commentaire</th>    
        </tr>';
    $query = "SELECT * 
    FROM voiture,histrique_voiture 
    WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
    AND histrique_voiture.action = 'HS'
    AND histrique_voiture.id_user_HV='$id_user' 
    ORDER BY `histrique_voiture`.`date_action` DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['date_HV'] . '</td>
                <td class="border-top-0">' . $row['commentaire_HV'] . '</td>  
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function DisplaySettingVoitureTransf()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $value = "<table class='table'>
        <tr>
        <th class='border-top-0'>#</th>
        <th class='border-top-0'>N° de voiture</th>
        <th class='border-top-0'>Transférer de l'agence</th>
        <th class='border-top-0'>Transférer à l'agence</th>
        <th class='border-top-0'>Date de transfert</th>      
        </tr>";
    $query = "SELECT * FROM histrique_voiture, agence WHERE 
    action = 'Transferer' 
    AND (agence.id_agence=histrique_voiture.id_agence_em or agence.id_agence=histrique_voiture.id_agence_recv) 
    GROUP BY id_histrique_voiture ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['id_voiture_HV'] . '</td>
                <td class="border-top-0">' . $row['id_agence_em'] . '</td>
                <td class="border-top-0">' . $row['id_agence_recv'] . '</td>
                <td class="border-top-0">' . $row['date_action'] . '</td>           
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function delete_SettingVoiture_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "UPDATE marquemodel SET etat_marque='S' where id_MarqueModel='$Del_Id' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo ' Your Record Has Been Delete ';
    } else {
        echo ' Please Check Your Query ';
    }
}

function display_contrat_archived_materiel()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Contrat</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">Num Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Action</th>   
    </tr>';
    $query = "SELECT DISTINCT C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat AS C 
        LEFT JOIN contrat_materiel AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client WHERE DATE(NOW()) >= C.date_fin AND  C.type_location = 'Materiel' ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>   
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function display_contrat_archived_voiture()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date début</th>
    <th class="border-top-0">Date de fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom de client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">KM Prévu</th>
    <th class="border-top-0">Action</th>  
    </tr>';
    $query = "SELECT C.id_contrat,C.date_contrat,C.caution,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) >= C.date_fin AND  C.type_location = 'Véhicule' AND C.id_client =CL.id_client";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['KMPrevu'] . '</td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>    
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function searchContratMaterielArchive()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Durée</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">N° de client</th>
    <th class="border-top-0">CIN de client</th>
    <th class="border-top-0">Action</th>  
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT DISTINCT C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        WHERE DATE(NOW()) > C.date_fin 
        AND  C.type_location = 'Materiel'
        AND  (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')     
        OR C.caution LIKE ('%" . $search . "%')
        OR C.duree LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.assurance LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['assurance'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
                <td class="border-top-0">' . $row['nom'] . '</td>                
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                <td class="border-top-0">
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                    </td>      
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archived_materiel();
    }
}
function searchContratVoitureArchivage()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Durée de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom de client</th>
    <th class="border-top-0">CIN de lient</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">KM prévu</th>
    <th class="border-top-0">Action</th>  
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT C.id_contrat,C.date_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) > C.date_fin 
        AND  C.type_location = 'Vehicule'
         AND C.id_client =CL.id_client
         AND C.id_agence =   $id_agence
         AND
        (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')     
        OR C.duree LIKE ('%" . $search . "%')     
        OR C.caution LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR C.KMPrevu LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR V.pimm LIKE ('%" . $search . "%')
        OR MM.Model LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . $row['date_contrat'] . '</td>
                    <td class="border-top-0">' . $row['type_location'] . '</td>
                    <td class="border-top-0">' . $row['duree'] . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . $row['date_debut'] . '</td>
                    <td class="border-top-0">' . $row['date_fin'] . '</td>
                    <td class="border-top-0">' . $row['prix'] . '</td>
                    <td class="border-top-0">' . $row['assurance'] . '</td>
                    <td class="border-top-0">' . $row['caution'] . '</td>
                    <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                    <td class="border-top-0">' . $row['pimm'] . '</td>
                    <td class="border-top-0">' . $row['KMPrevu'] . '</td>
                    <td class="border-top-0">
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                    </td>  
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archivage_record_voiture();
    }
}

function searchContratPackArchivage()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Contrat</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">Num Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">N° de chéque Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">Action</th> 
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT CL.nom,CL.cin,
        C.id_contrat, C.date_contrat, C.duree,C.date_debut, C.date_fin, C.prix, C.mode_de_paiement,C.assurance, C.date_prelevement, C.caution, C.num_cheque_caution,C.type_location,
        MM.Marque, MM.Model,V.pimm
        FROM contrat_client AS C
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        LEFT JOIN client AS CL ON CL.id_client = C.id_client 
        WHERE DATE(NOW()) > C.date_fin 
        AND C.type_location = 'Pack' 
        AND C.id_agence = $id_agence
         AND
        (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')     
        OR C.duree LIKE ('%" . $search . "%')     
        OR C.caution LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR C.KMPrevu LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%')
        OR V.pimm LIKE ('%" . $search . "%')
        OR MM.Model LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['assurance'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['num_cheque_caution'] . '</td> 
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
                <td class="border-top-0">' . $row['nom'] . '</td>                
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                </td>
                
            </tr>';
            }

            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archivage_record_pack();
    }
}

// founction de notification de contrat

function ContratNotification()
{
    global $conn;
    if (isset($_POST["view"])) {
        if ($_POST["view"] != '') {
            $update_query = "UPDATE contrat SET contrat_status=1 WHERE contrat_status=0";
            mysqli_query($conn, $update_query);
        }
        $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse 
        FROM `contrat` as C 
        left JOIN client as CL 
        on C.id_client=CL.id_client 
        WHERE 
        (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
         ORDER BY C.date_fin DESC";
        $result = mysqli_query($conn, $query);
        $output = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $str1 = "Le contrat de ";
                $str2 = " avec identifiant ";
                $str3 = " se terminera bientôt";
                $output .= '
             <li>
              <div class="border-bottom border-dark p-3">
               <div class="text-secondary">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' . $row["id_contrat"] . '' . $str3 . '</div>
              </div>
             </li>
             <li class="divider"></li>
       ';
            }
        } else {
            $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
        }

        $query_1 = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse
      FROM `contrat` as C 
      left JOIN client as CL 
      on C.id_client=CL.id_client WHERE 
      C.contrat_status=0 
      AND 
      DATE(NOW()) >= DATE_SUB(C.date_fin, INTERVAL 7 DAY) 
      ORDER BY C.date_fin DESC";
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        echo json_encode($data);
    }
}

// fin  founction de notification de contrat
function EntretienNotification()
{
    global $conn;
    if (isset($_POST["view"])) {
        //  include("connect.php");
        if ($_POST["view"] != '') {
            $update_query = "UPDATE entretien SET entretien_status=1 WHERE entretien_status=0";
            mysqli_query($conn, $update_query);
        }
        $query = "SELECT E.id_entretien,E.type,E.id_voiture,E.commentaire,E.date_entretien,V.pimm 
                    FROM `entretien` AS E 
                    LEFT JOIN voiture AS V ON E.id_voiture=V.id_voiture
                    WHERE  E.type='véhicule' AND 
                    DATE(NOW()) >= DATE_SUB(E.date_entretien, INTERVAL 7 DAY) ORDER BY E.date_entretien DESC";
        $result = mysqli_query($conn, $query);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $str1 = " de la voiture ";
                $str2 = " à vérifier  ";
                $output .= '
        <li>
         <div class="border-bottom border-dark p-3">
          <div class="text-secondary">' . $row["commentaire"] . '' . $str1 . '' . $row["pimm"] . '' . $str2 . '' . date('d-m-Y', strtotime($row['date_entretien'])) . '</div>
         </div>
        </li>
        <li class="divider"></li>
        ';
            }
        } else {
            $output .= '<li><div class="text-secondary"">Aucune notification trouvée</div></li>';
        }

        $query_1 = "SELECT E.id_entretien,E.type,E.id_voiture,E.commentaire,E.date_entretien,V.pimm 
                    FROM `entretien` AS E 
                LEFT JOIN voiture AS V ON E.id_voiture=V.id_voiture  
                WHERE E.entretien_status = 0 
                AND E.type='véhicule' 
                AND DATE(NOW()) >= DATE_SUB(E.date_entretien, INTERVAL 7 DAY)";
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification_entretien' => $output,
            'unseen_notification_entretien' => $count
        );
        echo json_encode($data);
    }
}
function PaiementNotification()
{
    global $conn;
    if (isset($_POST["view"])) {
        $query = "SELECT DAY(date_prelevement)AS day_prelevement,date_prelevement,id_contrat,date_fin,type_location,paiemenet_satatus 
        FROM contrat WHERE (duree='LLD'OR duree='Standard') AND  (DATE(NOW())<=date_fin AND paiemenet_satatus=0) ";
        $result = mysqli_query($conn, $query);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $date_prelevement = $row['day_prelevement'];
                $date_today = date("d");
                if ($date_prelevement == $date_today) {
                    $str1 = " la date du paiement de contrat ";
                    $str2 = " num:  ";
                    $str3 = " est expirée!  ";
                    $output .= '<div class="alert alert-danger" id="paiement-list" style="padding-left: 3%;border-bottom: 1px solid rgba(120, 130, 140, 0.13)!important;margin-bottom:0px" role="alert">
                            ' . $str1 . '' . $row["type_location"] . '' . '' . $row['day_prelevement'] . '' . $str2 . '' . $row["id_contrat"] . '' . $str3 . '
                            <button type="button"  data-target="#exampleModal" id="contrat-paiement" class="btn btn-success" data-paiement=' . $row['id_contrat'] . '>
                            Valider paiement</button></div>';
                    $queryupdate = "UPDATE contrat SET 
                            paiemenet_satatus=0 AND date_prelevement = DATE(NOW()+1)";
                    $result_update = mysqli_query($conn, $queryupdate);
                }
            }
        } else {
            $output .= '<div class="text-secondary">Aucune notification trouvée</div>';
        }
        $query_1 = "SELECT DAY(date_prelevement)AS day_prelevement,date_prelevement,id_contrat,date_fin,type_location,paiemenet_satatus 
        FROM contrat 
        WHERE (duree='LLD'OR duree='Standard') 
        AND (DATE(NOW())<=date_fin AND paiemenet_satatus=0) 
        AND (DAY(NOW())=DAY(date_prelevement))";
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification_paiement' => $output,
            'unseen_notification_paiement' => $count
        );
        echo json_encode($data);
    }
}
function get_validate_contrat_paiement_record()
{
    global $conn;
    $contratPaiementId = $_POST['contrat_ID'];
    $query = " SELECT id_contrat FROM contrat WHERE id_contrat =$contratPaiementId ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
    }
    echo json_encode($contrat_data);
}
function update_contrat_validate_paiement()
{
    global $conn;
    $Update_Contrat_Id = $_POST['updateContratId'];
    $query = "UPDATE contrat SET 
     paiemenet_satatus = 1
     WHERE id_contrat ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_1 = "INSERT INTO archive_paiement (contrat_id,date_validation) VALUE  ('$Update_Contrat_Id',NOW())";
        $result_1 = mysqli_query($conn, $query_1);
    } else {
        echo 'maselktch';
    }
}

function display_contrat_record_mixte()
{

    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Contrat</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">N° de Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Modele Véhicule</th>
    <th class="border-top-0">PIMM Véhicule</th>
    <th class="border-top-0">KM Prévu</th>

    <th class="border-top-0">Action</th>  
    </tr>';

    $query = "SELECT
     C.id_contrat,C.date_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,C.contrat_file,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat_mixte AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) <= C.date_fin AND C.id_client =CL.id_client";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['KMPrevu'] . '</td>
          
            <td class="border-top-0">
        
            <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-mixte" data-id3=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-mixte" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-mixte" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>
            
        </tr>';
    }
    //   <td class="border-top-0">' . $row['contrat_file'] . '</td>  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-mixte" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// delete_contrat_record_mixte
function delete_contrat_record_mixte()
{
    global $conn;
    $Del_ID = $_POST['Delete_ContratID'];
    $query = "DELETE FROM contrat_mixte WHERE id_contrat='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $query = "DELETE FROM contrat_materiel_mixte WHERE id_contrat='$Del_ID'";
        $result = mysqli_query($conn, $query);
        echo "Le contrat est supprimé avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function InsertContratMixte()
{
    global $conn;

    $ContratmaterielListe = isset($_POST['ContratmaterielListe']) ? $_POST['ContratmaterielListe'] : [];
    $ContratmaterielListe = explode(',', $ContratmaterielListe);
    $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : NULL;
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : NULL;
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] : NULL;
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] : NULL;
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $ContratFileMixte = isset($_FILES['ContratFileMixte']) ? $_FILES['ContratFileMixte'] : NULL;
    $count = count($ContratmaterielListe);
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $contrat_filename = $unique_id . "_contratControl." . strtolower(pathinfo($ContratFileMixte["name"], PATHINFO_EXTENSION));
    move_uploaded_file($ContratFileMixte["tmp_name"], "./uploads/${contrat_filename}");

    if ($count >= 1) {
        $query = "INSERT INTO 
        contrat_mixte(id_client,id_voiture,date_contrat,type_location,duree,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement,contrat_file) 
        VALUES ('$ContratClient','$ContratVoiturePIMM','$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement',
        '$ContratCaution','$ContratnumCaution','$ContratVoiturekMPrevu','$ContratDatePaiement','$contrat_filename')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_contrat)
                    FROM contrat_mixte";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
                $id_contrat = $row[0];
                $materiel_table = $ContratmaterielListe;

                if ($count >= 1) {
                    for ($i = 0; $i < $count; $i++) {
                        $query_insert_materiel_list = "INSERT INTO contrat_materiel_mixte(id_contrat,id_materiel) VALUES ('$id_contrat','$materiel_table[$i]') ";
                        $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                    }
                    if ($result_query_insert_materiel_list) {
                        echo ("<div class='text-success'>Le contrat est inseré</div>");
                    } else {
                        echo ("<div class='text-danger'>échoué : lors d'ajout de contrat !</div>");
                    }
                }
            }
        } else {
            echo ("<div class='text-danger'>Erreur lors d'ajout de contrat</div>");
        }
    } else {
        echo ("<div class='text-danger'>Erreur lors d'ajout de contrat Mixte</div>");
    }
}

//contrat pack
function select_contrat_pack_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT CL.nom, CL.email, CL.tel, CL.adresse, 
    C.id_contrat, C.date_contrat, C.date_debut, C.date_fin, C.prix, C.mode_de_paiement, C.date_prelevement, C.caution, C.num_cheque_caution,
    CM.designation_contrat, CM.num_serie_contrat,
    CC.designation_composant, CC.num_serie_composant, C.id_contrat,
    MM.Marque, MM.Model,V.pimm,C.id_voiture
    FROM materiel_contrat_client AS CM 
    LEFT JOIN contrat_client AS C ON CM.id_contrat =C.id_contrat
    LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
    LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
    WHERE C.type_location = 'Pack' 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    $contrat_materiel_data = [];
    $ttc = 0;
    $t = 0;  
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($contrat_materiel_data)) {
            $contrat_materiel_data[0] = $row['id_contrat'];
            $contrat_materiel_data[1] = $row['nom'];
            $contrat_materiel_data[2] = $row['email'];
            $contrat_materiel_data[3] = $row['tel'];
            $contrat_materiel_data[4] = $row['adresse'];
            if ($row['id_voiture'] != 0) {
                $contrat_materiel_data[5] = 'Immatriculation :' . $row['pimm'];
                //   $contrat_materiel_data[5] ='Immatriculation :' $row['type'];
                $contrat_materiel_data[6] = 'Marque :' . $row['Marque'] . ' ' . $row['Model'];
            } else {
                $contrat_materiel_data[6] = "Véhicule : sans voiture";
                $contrat_materiel_data[5] = '';
            }
            $contrat_materiel_data[7] = $row['date_debut'];
            $contrat_materiel_data[8] = $row['date_fin'];
            $contrat_materiel_data[9] = $row['prix'];
            $ttc = $row['prix'] + ($row['prix'] * 0.2);
            $contrat_materiel_data[10] = $ttc;
            $contrat_materiel_data[11] =  $row['mode_de_paiement'];
            $contrat_materiel_data[12] = '';
            $contrat_materiel_data[13] = $row['caution'];
            $contrat_materiel_data[15] = $row['num_cheque_caution'];
            $contrat_materiel_data[17] = $row['date_contrat'];

            $contrat_materiel_data[18][] = $row['designation_composant'];
            $contrat_materiel_data[19][] = $row['num_serie_composant'];

            $contrat_materiel_data[21] =  $t + 1;
        } else {
            $contrat_materiel_data[18][] = $row['designation_composant'];
            $contrat_materiel_data[19][] = $row['num_serie_composant'];
            $contrat_materiel_data[21] =  $t + 1;
        }
    }
    echo json_encode($contrat_materiel_data);
}

function get_mixte_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];
    $query = " SELECT * FROM contrat_mixte WHERE id_contrat='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $Materiel_data = [];
        $Materiel_data[0] = $row['id_contrat'];
        // $Materiel_data[1] = $row['date_contrat'];
        $Materiel_data[2] = $row['duree'];
        $Materiel_data[3] = $row['date_debut'];
        $Materiel_data[4] = $row['date_fin'];
        $Materiel_data[5] = $row['prix'];
        // $Materiel_data[6] = $row['assurance'];
        $Materiel_data[7] = $row['mode_de_paiement'];
        $Materiel_data[8] = $row['caution'];
        $Materiel_data[9] = $row['num_cheque_caution'];
    }
    echo json_encode($Materiel_data);
}


function update_contrat_mixte()
{
    global $conn;
    $up_idmixte = $_POST['up_idmixte'];
    // $up_DateContratMixte = $_POST['up_DateContratMixte'];
    $up_dureeContratMixte = $_POST['up_dureeContratMixte'];
    $up_DateDebutContrat = $_POST['up_DateDebutContrat'];
    $up_DateFinContratMixte = $_POST['up_DateFinContratMixte'];
    $up_PrixContratMixte = $_POST['up_PrixContratMixte'];
    // $up_AssuranceContratMixte = $_POST['up_AssuranceContratMixte'];
    $up_ModePaiementContratMixte = $_POST['up_ModePaiementContratMixte'];
    $up_numCautionMixte = $_POST['up_numCautionMixte'];
    $up_CautionMixte = $_POST['up_CautionMixte'];

    $query = "UPDATE contrat_mixte SET 
     duree='$up_dureeContratMixte',date_debut='$up_DateDebutContrat',date_fin='$up_DateFinContratMixte',
     prix='$up_PrixContratMixte',mode_de_paiement='$up_ModePaiementContratMixte',caution='$up_CautionMixte',num_cheque_caution='$up_numCautionMixte'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

//insert Clients Records function
function InsertUser()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $nom = $_POST['nom'];
    $login = $_POST['login'];
    $password = $_POST['passord'];
    $id_user_agence = $_POST['id_user_agence'];
    $sql_e = "SELECT * FROM user WHERE (login='$login' && password='$password')";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Email est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            user(nom_user,login,password,role,id_agence) 
            VALUES ('$nom','$login','$password','admin','$id_user_agence')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>Ltilisateur est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout d'utilisateur</div>";
        }
    }
}
//End insert Clients Records function

// dispaly client data function
function display_user_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom</th>
            <th class="border-top-0">Login</th>
            <th class="border-top-0">Rôle</th>
            <th class="border-top-0">Lieu Agence</th>
            <th class="border-top-0">Etat</th>
            <th class="border-top-0">Actions</th>
            
        </tr>';
    $query = " SELECT * FROM user ,agence 
        WHERE (user.id_agence = agence.id_agence)
        AND  etat_user != 'S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_user'] == 'T') {
            $etat = "active";
        } else {
            $etat = "désactiver";
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_user'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td class="border-top-0">' . $row['login'] . '</td>
                <td class="border-top-0">' . $row['role'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $etat . '</td>
                <td class="border-top-0">
               
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-user" data-id=' . $row['id_user'] . '><i class="fas fa-edit"></i></button> ';


        if ($row['role'] != 'superadmin') {
            $value .= '   <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-user" data-id1=' . $row['id_user'] . '><i class="fas fa-trash-alt"></i></button>';
        }
        $value .= ' </td>
                            </tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly stock data function
function display_stock_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">ID</th>
            <th class="border-top-0">pimm</th>
            <th class="border-top-0">type</th>
            <th class="border-top-0">date</th>
            <th class="border-top-0">état de voiture</th>
            
        </tr>';
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
            WHERE id_agence = '$id_agence'
            ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
            ORDER BY `etat_voiture` ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['etat_voiture'] == "Loue") {
            $color = "#e7959578";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "#afd2ed";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "#dd70704d";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "#dda8704d";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $color = "#dda8000";
        }
        $value .= '
            <tr style="background:' . $color . ';border: 1px solid;">
                <td class="border-top-0  ">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['date_achat'] . '</td>
                <td class="border-top-0">' . $row['etat_voiture'] . '</td>
                <td class="border-top-0">
                </td>
            </tr>';
        $color = "";
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly stock data function
function display_stock_materiel_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">ID</th>
            <th class="border-top-0">Pimm</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">Date</th>
            <th class="border-top-0">État voiture</th>
            
        </tr>';
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
            WHERE id_agence = '$id_agence'
            ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
            ORDER BY `etat_voiture` ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_voiture =  $row['id_voiture'];
        if ($row['etat_voiture'] == "Loue") {
            $color = "#ffdcdc";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "#fff3e2";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "#dd70704d";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "#dda8704d";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $color = "#d5eef9";
        }
        $value .= '
            <tr style="background:' . $color . ';">
                <td class="border-top-0  ">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['date_achat'] . '</td>
                <td class="border-top-0">' . $row['etat_voiture'] . '</td>
                <td class="border-top-0">
                </td>
            </tr>';
        $color = "";
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//get particular client record
function get_user_record()
{
    global $conn;
    $UserId = $_POST['ClientID'];
    $query = " SELECT * FROM user WHERE id_user='$UserId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $user_data = [];
        $user_data[0] = $row['id_user'];
        $user_data[1] = $row['nom_user'];
        $user_data[2] = $row['login'];
        $user_data[3] = $row['password'];
        $user_data[4] = $row['etat_user'];
    }
    echo json_encode($user_data);
}

// update Client
function update_user_value()
{
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID utilisateur manquant ", "data" => "ID utilisateur manquant"]);
        return;
    }
    $user_id = $_POST["_id"];
    $user_query = "SELECT * FROM  user where id_user = $user_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    if (!$user) {
        echo json_encode(["error" => "Client introuvable ", "data" => "user $user_id not found."]);
        return;
    }
    $user_updated_nom = $_POST["nom"];
    $user_updated_login = $_POST["login"];
    $user_updated_password = $_POST["password"];
    $updateuseretat = $_POST["updateuseretat"];
    $update_query = "UPDATE user SET 
    nom_user='$user_updated_nom',
    login='$user_updated_login',
    etat_user='$updateuseretat',
    password='$user_updated_password'
    WHERE id_user = $user_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du utilisateur!</div>";
        return;
    }

    echo "<div class='text-success'>User a été mis à jour avec succès!</div>";
    return;
}

function delete_user_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_UserID'];
    $query = "Update   user SET etat_user='S' WHERE id_user='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "L'utilisateur est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

//insert agence  function
function InsertAgence()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $agenceLien = $_POST['agenceLien'];
    $agenceDate = $_POST['agenceDate'];
    $agenceEmail = $_POST['agenceEmail'];
    $agenceTele = $_POST['agenceTele'];
    $sql_e = "SELECT * FROM agence WHERE lieu_agence='$agenceLien'";
    $res_e = mysqli_query($conn, $sql_e);

    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... agence est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            agence(lieu_agence,date_agence,email_agence,tel_agence) 
            VALUES ('$agenceLien','$agenceDate','$agenceEmail','$agenceTele')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>L'agence est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout d'agence </div>";
        }
    }
}
//End insert Clients Records function

// dispaly client data function
function display_agence_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Lieu agence</th>
            <th class="border-top-0">Date création agence</th>
            <th class="border-top-0">E-mail agence</th>
            <th class="border-top-0">Tél agence</th>
            <th class="border-top-0">Actions</th>
            
        </tr>';
    $query = " SELECT * FROM  agence
    WHERE  etat_agence !='S' 
    AND id_agence != 0 ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_agence'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['date_agence'] . '</td>
                <td class="border-top-0">' . $row['email_agence'] . '</td>
                <td class="border-top-0">' . $row['tel_agence'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-agence" data-id=' . $row['id_agence'] . '>
                  <i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-agence" data-id1=' . $row['id_agence'] . '>
                  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
//get particular client record
function get_agence_record()
{
    global $conn;
    $AgenceId = $_POST['ClientID'];
    $query = " SELECT * FROM agence WHERE id_agence='$AgenceId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $user_data = [];
        $user_data[0] = $row['id_agence'];
        $user_data[1] = $row['lieu_agence'];
        $user_data[2] = $row['date_agence'];
        $user_data[3] = $row['email_agence'];
        $user_data[4] = $row['tel_agence'];
        $user_data[5] = $row['etat_agence'];
    }
    echo json_encode($user_data);
}
// update Client
function update_agence_value()
{
    global $conn;
    if (!array_key_exists("up_idagence", $_POST)) {
        echo json_encode(["error" => "ID utilisateur manquant ", "data" => "ID utilisateur manquant"]);
        return;
    }
    $agence_id = $_POST["up_idagence"];
    $user_query = "SELECT * FROM  agence where id_agence = $agence_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    if (!$user) {
        echo json_encode(["error" => "Agence introuvable ", "data" => "user $agence_id not found."]);
        return;
    }
    $up_agenceLien = $_POST["up_agenceLien"];
    $up_agenceDate = $_POST["up_agenceDate"];
    $up_agenceEmail = $_POST["up_agenceEmail"];
    $up_agenceTele = $_POST["up_agenceTele"];
    $update_query = "UPDATE agence SET 
    lieu_agence='$up_agenceLien',
    date_agence='$up_agenceDate',
    email_agence='$up_agenceEmail',
    tel_agence='$up_agenceTele'
    WHERE id_agence = $agence_id";
    $update_result = mysqli_query($conn, $update_query);

    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour d'agence !</div>";
        return;
    }

    echo "<div class='text-success'>Agence a été mis à jour avec succès!</div>";
    return;
}

function delete_agence_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_AgenceID'];
    $query = "Update agence SET etat_agence='S' WHERE id_agence='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "L'agence est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function InsertGroupPack()
{
    global $conn;

    $PackListe = isset($_POST['PackListe']) ? $_POST['PackListe'] : [];
    $PackListe = explode(',', $PackListe);
    $QuantiteListe = isset($_POST['QuantiteListe']) ? $_POST['QuantiteListe'] : [];
    $QuantiteListe = explode(',', $QuantiteListe);
    $VoitureType = $_POST['VoitureType'];
    $DesignationPack = isset($_POST['DesignationPack']) ? $_POST['DesignationPack'] : NULL;
    $id_user = $_SESSION['id_user'];
    $count = count($PackListe);

    if ($count >= 1) {
        $query = "INSERT INTO 
        group_packs(designation_pack,type_voiture,id_user) 
        VALUES ('$DesignationPack','$VoitureType','$id_user')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_group_packs) FROM group_packs where id_user='$id_user' ";

            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            $row = mysqli_fetch_row($result_query_get_max_id_contra);
            $id_group_packs = $row[0];

            for ($i = 0; $i < $count; $i++) {
                if ($QuantiteListe[$i] < 1 || $QuantiteListe[$i] == "")
                    $qti = 1;
                else {
                    $qti =  $QuantiteListe[$i];
                }

                $query_insert_materiel_list = "INSERT INTO materiel_group_packs(id_group_packs,id_materiels,quantite) VALUES ('$id_group_packs','$PackListe[$i]','$qti') ";
                $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
            }

            echo ("<div class='text-success'>  Le pack est ajouté avec succès </div>");
        } else {
            echo ("<div class='text-danger'>Erreur lors d'ajout de pack!</div>");
        }
    } else {
        echo ("<div class='text-danger'>Liste de matériel manquant!</div>");
    }
}

function display_grouppack_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Matériels</th>
            <th class="border-top-0">Etat Pack</th>
            <th class="border-top-0">Actions</th>
            
        </tr>';
    $query = "SELECT * FROM group_packs where etat_group_pack !='S' ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $comp = $row['id_group_packs'];
        if ($row['etat_group_pack'] == "T") {
            $etat = "Activer ";
            $colour = "";
        } elseif ($row['etat_group_pack'] == "F") {
            $etat = "Hors Service";
            $colour = "style= 'background:#ececec' ";
        }

        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                <td class="border-top-0">' . $row['designation_pack'] . '</td>
                <td class="border-top-0">' . $row['type_voiture'] . '</td>';
        $value .= '<td class="border-top-0" >';
        $querycomp = "SELECT * FROM materiel_group_packs,materiels WHERE materiels.id_materiels = materiel_group_packs.id_materiels 
                AND materiel_group_packs.id_group_packs = '$comp'";
        $resultcom = mysqli_query($conn, $querycomp);

        while ($row_materiels = mysqli_fetch_assoc($resultcom)) {
            $value .= ' <span class=" text-primary">(' . $row_materiels['quantite'] . ')' . $row_materiels['designation'] . ' </span>
            </br>  ';
        }
        $value .=   '</td>';
        $value .= ' <td class="border-top-0">' . $etat . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-pack" data-id=' . $row['id_group_packs'] . '><i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-pack" data-id1=' . $row['id_group_packs'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function delete_pack_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_PackID'];
    $query = "Update   group_packs SET etat_group_pack='S' WHERE id_group_packs='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le Pack est supprimé';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function get_pack_record()
{
    global $conn;
    $PackID = $_POST['PackID'];
    $query = " SELECT * FROM group_packs WHERE id_group_packs='$PackID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $pack_data = [];
        $pack_data[0] = $row['id_group_packs'];
        $pack_data[1] = $row['designation_pack'];
        $pack_data[2] = $row['type_voiture'];
        $pack_data[3] = $row['etat_group_pack'];
    }
    echo json_encode($pack_data);
}

function update_group_pack_value()
{
    $id_user = $_SESSION['id_user'];
    $pack_id = $_POST["pack_id"];
    global $conn;
    if (!array_key_exists("pack_id", $_POST)) {
        echo json_encode(["error" => "ID Pack manquant ", "data" => "ID pack manquant"]);
        return;
    }
    $pack_query = "SELECT * FROM group_packs WHERE id_group_packs=$pack_id";
    $pack_result = mysqli_query($conn, $pack_query);
    $pack = mysqli_fetch_assoc($pack_result);
    if (!$pack) {
        echo json_encode(["error" => "pack introuvable ", "data" => "pack $pack_id not found."]);
        return;
    }
    $up_DesignationPack = $_POST["up_DesignationPack"];
    $up_TypeVoiturePack = $_POST["up_TypeVoiturePack"];
    $up_EtatPack = $_POST["up_EtatPack"];
    $update_query = "UPDATE group_packs SET 
    designation_pack='$up_DesignationPack',
    type_voiture='$up_TypeVoiturePack',
    etat_group_pack='$up_EtatPack',
    id_user='$id_user'
    WHERE id_group_packs = $pack_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du pack!</div>";
    }
    echo "<div class='text-success'>Le pack a été mis à jour avec succès!</div>";
}

function InsertContratPack()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $ContratmaterielListe = isset($_POST['ContratmaterielListe']) ? $_POST['ContratmaterielListe'] : [];
    $ContratmaterielListe = explode(',', $ContratmaterielListe);
    $ContratquantiteListe = isset($_POST['ContratquantiteListe']) ? $_POST['ContratquantiteListe'] : [];
    $ContratquantiteListe = explode(',', $ContratquantiteListe);
    $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : "";
    $VehiculePack = isset($_POST['VehiculePack']) ? $_POST['VehiculePack'] : "";
    $id_pack = isset($_POST['id_pack']) ? $_POST['id_pack'] : "";
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : "";
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : "";
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : "";
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] :  "";
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] :  "";
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : "";
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : "";
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] :  "";
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] :  "";
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] :  "";
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] :  "";
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] :  "";
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] :  "";
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] :  "";
    $count = count($ContratmaterielListe);
    $query = "INSERT INTO 
            contrat_client(id_client,id_voiture,id_materiels_contrat,id_group_pack,date_contrat,type_location,
            duree,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement,id_user,id_agence) 
            VALUES ('$ContratClient','$VehiculePack','0','$id_pack' ,'$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratnumCaution','$ContratVoiturekMPrevu','$ContratDatePaiement','$id_user','$id_agence')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_get_max_id_contrat = "SELECT max(id_contrat)
        FROM contrat_client WHERE type_location ='Pack'";
        $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
        $row = mysqli_fetch_row($result_query_get_max_id_contra);
        $id_contrat = $row[0];
        for ($i = 0; $i < $count; $i++) {
            $Id_materiel = $ContratmaterielListe[$i];
            $quantite = $ContratquantiteListe[$i];
            $query_materiels =    "SELECT  code_materiel,`designation`, `num_serie_materiels`,id_materiels_agence FROM `materiels`,materiels_agence
         where 
         materiels.id_materiels = materiels_agence.id_materiels AND
         id_materiels_agence = '$Id_materiel'";
            $exection_materiel = mysqli_query($conn, $query_materiels);
            $resultat = mysqli_fetch_array($exection_materiel);
            $query = "INSERT INTO 
        materiel_contrat_client(id_contrat,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat) 
        VALUES ('$id_contrat','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','$quantite')";
            $result = mysqli_query($conn, $query);
            $query_materiels_comp =    "SELECT  * FROM `composant_materiels` where id_materiels_agence = '$resultat[id_materiels_agence]'";
            $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
            while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
                $query = "INSERT INTO 
        composant_materiels_contrat(id_contrat,id_materiels_agence,designation_composant,num_serie_composant) 
        VALUES ('$id_contrat','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
                $result = mysqli_query($conn, $query);
            }
        }
        echo "<div class='text-success'>Le contrat est ajouté avec succés</div>";
    } else {
        echo ("<div class='text-danger'>Erreur lors d'ajout de contrat Mixte</div>");
    }
}



function disponibilite_materiel_num_serie($id_materiels_agence, $debut, $fin)
{
    global $conn;
    $query = "SELECT * FROM contrat_client, materiel_contrat_client
    where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
    id_materiels_agence ='$id_materiels_agence' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "disponibile";
    }
}

function disponibilite_voiture($id_voiture, $debut, $fin)
{
    global $conn;
    $query = "SELECT * FROM contrat_client, voiture
    where  contrat_client.id_voiture= voiture.id_voiture and 
    contrat_client.id_voiture ='$id_voiture' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))      
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "Non disponibile";
    }
}

function disponibilite_quantite_materiel($id_materiels_agence, $debut, $fin, $quantite)
{
    global $conn;
    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $quantite_materiels_dispo = $row['quantite_materiels_dispo'];
    $query = "SELECT SUM(quantite_contrat) as quantite_loue
    FROM contrat_client, materiel_contrat_client
    where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
    id_materiels_agence ='$id_materiels_agence' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
    or (date_debut <='$fin' and date_fin >='$fin' ) 
    or (date_debut >='$debut' and date_fin <='$fin' )) ";
    $result = mysqli_query($conn, $query);
    $row_quantite = mysqli_fetch_assoc($result);
    $quantite_loue = $row_quantite['quantite_loue'];
    if ($quantite_loue == '')
        $quantite_loue = 0;
    $quantite_disponible = $quantite_materiels_dispo - $quantite_loue;
    if ($quantite <= $quantite_disponible) {
        return "disponibile";
    } else {
        return
            "Non disponibile";
    }
}

function InsertCategorie()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $code_materiel = $_POST['code_materiel'];
    $designation = $_POST['designation'];
    $famille_materiel = $_POST['famille_materiel'];
    $type_location = $_POST['type_location'];
    $num_serie_obg = $_POST['num_serie_obg'];
    $id_user = $_SESSION['id_user'];
    $sql_e = "SELECT * FROM materiels WHERE code_materiel='$code_materiel'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... catégorie est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            materiels(code_materiel,designation,famille_materiel,type_location,num_serie_obg,id_user) 
            VALUES ('$code_materiel','$designation','$famille_materiel','$type_location','$num_serie_obg','$id_user')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>Le catégorie est ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout du catégorie </div>";
        }
    }
}

function display_categorie_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Code de catégorie</th>
            <th class="border-top-0">Famille de catégorie</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0"> Type de location</th>
            <th class="border-top-0"> N° serie obligatoire</th>
            <th class="border-top-0">Actions</th>
        </tr>';
    $query = " SELECT * FROM materiels
            where etat_materiels_categorie !='S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['num_serie_obg'] == 'T') {
            $obligatoireserie = 'OUI';
        } else {
            $obligatoireserie = 'NON';
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                <td class="border-top-0">' . $row['designation'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $obligatoireserie . '</td>
          
            
                <td class="border-top-0">
                <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-categorie" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function delete_categorie_record()
{
    global $conn;
    $Del_ID = $_POST['Del_ID'];
    $query = "Update   materiels SET etat_materiels_categorie='S' WHERE id_materiels='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le catégorie est supprimé avec succés';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function InsertStock()
{
    global $conn;

    $id = $_POST['ID'];
    $signe = $_POST['signe'];
    $quitite = $_POST['value'];
    $etat = $_POST['etat'];
    if ($signe == "add") {
        $query = "update materiels_agence set quantite_materiels = quantite_materiels +$quitite, quantite_materiels_dispo =quantite_materiels_dispo +$quitite  , etat_materiels ='$etat'
        where id_materiels_agence =$id ";
    } else {
        $query = "update materiels_agence set quantite_materiels = quantite_materiels -$quitite, quantite_materiels_dispo =quantite_materiels_dispo -$quitite , etat_materiels ='$etat'
        where id_materiels_agence =$id ";
    }
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Stock mise à jour avec succès</div>";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function DisplaySettingmateriel()
{
    global $conn;
    $value = '<table class="table">
                <tr>
                    <th class="border-top-0"> Pack </th>
                    <th class="border-top-0"> Materiel </th>
                    <th class="border-top-0"> Quantite </th>
                    <th class="border-top-0"> Action</th>
                </tr>';
    $query = "SELECT * FROM `materiels` , materiel_group_packs , group_packs WHERE materiels.id_materiels=materiel_group_packs.id_materiels
and group_packs.id_group_packs=materiel_group_packs.id_group_packs ORDER BY `group_packs`.`designation_pack` ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <td> ' . $row['designation_pack'] . ' </td>
                        <td> ' . $row['code_materiel'] . ' </td>
                        <td> ' . $row['quantite'] . ' </td>
                        <td> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn_delete_materielgrp" data-id3=' . $row['id_materiel_group_packs'] . '><span class="fa fa-trash"></span></button> </td>
                    </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function delete_Settingmaterielgrp_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "DELETE from materiel_group_packs where id_materiel_group_packs='$Del_Id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo ' Votre enregistrement a été supprimé';
    } else {
        echo ' Veuillez vérifier votre requête ';
    }
}

function display_grp_pack_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
    
            <th class="border-top-0">#</th>
            <th class="border-top-0">ID de groupe pack </th>
            <th class="border-top-0">ID de materiel</th>
            <th class="border-top-0">Quantité</th>
        </tr>';
    $query = "SELECT * FROM materiel_group_packs  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>                     
                <td class="border-top-0">' . $row['id_materiel_group_packs'] . '</td>
                <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client" data-id=' . $row['id_materiels'] . '><i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-client" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function selectVoiteurDispoStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '
  <div class="table-responsive">
  <table  class="table customize-table mb-0 v-middle">
  <thead class="table-light">
          <tr>
              <th class="border-top-1">ID</th>
              <th class="border-top-1">Pimm</th>
              <th class="border-top-1">Type</th>
              <th class="border-top-1">Date Achat</th>
              <th class="border-top-1">Disponibilité</th>
              <th class="border-top-1">Transfert </th>      
          </tr>
  </thead>';
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
              WHERE id_agence = '$id_agence'
              AND actions !='S'
              ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
      WHERE actions !='S'
              ORDER BY `etat_voiture` ASC";
    }
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
              WHERE id_agence = '$id_agence'
              AND actions !='S'
              ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
      WHERE actions !='S'
              ORDER BY `etat_voiture` ASC";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_voiture'] == "Loue") {
            $color = "badge bg-light-warning text-warning fw-normal";
            $color1 = "background-color: #ffedd4!important";
            $row['etat_voiture'] = "LOUER";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $row['etat_voiture'] = "ENTRETIEN";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $row['etat_voiture'] = "VENDU";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #343a40!important";
            $row['etat_voiture'] = "HORS SERVICE";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
            if ($disponibilte == 'disponibile') {
                $color = "badge bg-light-success text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $row['etat_voiture'] = "DISPONIBLE";
            } else {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ff5050!important";
                $row['etat_voiture'] = "NON DISPONIBLE";
            }
        }
        $value .= '
      <tbody>
              <tr>
                  <td class="border-top-1  ">' . $row['id_voiture'] . '</td>
                  <td class="border-top-1">' . $row['pimm'] . '</td>
                  <td class="border-top-1">' . $row['type'] . '</td>
                  <td class="border-top-1">' . $row['date_achat'] . '</td>
                  <td><span class="' . $color . '" style ="' . $color1 . '">' . $row['etat_voiture'] . '</span></td>';
        if ($row['etat_voiture'] != "VENDU") {
            $value .= '<td><button class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert" data-id=' . $row['id_voiture'] . '><i class="fas fa-exchange-alt"></i></button></td>';
        }
        $value .= ' </tr>
      </tbody>';
    }
    $value .= '</table>
  </div>';

    echo json_encode(['status' => 'success', 'html' => $value]);
}
function disponibilite_Vehicule1($id_voiture)
{
    global $conn;
    $query = "SELECT * FROM contrat_client 
       where  
       id_voiture ='$id_voiture' and 
       ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW()) ))  ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "non disponibile";
    }
}

function selectMaterielDispoStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<div class="table-responsive">
    <table  class="table customize-table mb-0 v-middle">
    <thead class="table-light">
    <tr>
                <th class="border-top-0">ID</th>
                <th class="border-top-0">N° série de matériel </th>
                <th class="border-top-0">Quantité disponible</th>
                <th class="border-top-0">Disponibilité</th>              
    </tr>
    </thead>';
    if ($id_agence != "0") {
        $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
     and  materiels_agence.etat_materiels !='F'
    and id_agence = '$id_agence'
    ORDER BY etat_materiels ASC
    ";
    } else {
        $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
        and  materiels_agence.etat_materiels !='F'
        ORDER BY etat_materiels ASC   
        ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "HORS SERVICE";
        } elseif ($row['etat_materiels'] == "T") {
            $disponibilte =  $row['quantite_materiels_dispo'];
            if ($disponibilte > 0) {
                $color = "badge bg-light-success text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $etat = "DISPONIBLE";
            } else {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ff5050!important";
                $etat = "NON DISPONIBLE";
            }
        } else {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $etat = "NON DISPONIBLE";
        }
        $value .= '
        <tbody>          
                    <tr>
                    <td class="border-top-0">' . $row['id_materiels'] . '</td>
                    <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                    <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>           
                    <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                    <td class="border-top-0">
                    </td>
                    </tr>
                    </tbody>';
    }
    $value .= '</table> </div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function InserDevis()
{
    global $conn;
    $ClientDevis = $_POST['ClientDevis'];
    $NomDevis = $_POST['NomDevis'];
    $ModePaiementDevis = $_POST['ModePaiementDevis'];
    $CommentaireDevis = $_POST['CommentaireDevis'];
    $DateDevis = $_POST['DateDevis'];
    $RemiseDevis = $_POST['RemiseDevis'];
    $EscompteDevis = $_POST['EscompteDevis'];
    $codeListe = $_POST['codeListe'];
    $designationListe = $_POST['designationListe'];
    $quantitionListe = $_POST['quantitionListe'];
    $prixListe = $_POST['prixListe'];
    $depotListe = $_POST['depotListe'];
    $count = count($depotListe);
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $query = "INSERT INTO devis(id_client_devis,id_agence,ModePaiement_Devis,Commentaire_Devis,date_devis,nom_devis,remise,id_user_devis,escompte) 
    VALUES('$ClientDevis','$id_agence','$ModePaiementDevis','$CommentaireDevis','$DateDevis','$NomDevis','$RemiseDevis', '$id_user','$EscompteDevis')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_get_max_id_contrat = "SELECT max(id_devis)
                FROM devis ";
        $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
        while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
            $id_contrat = $row[0];
            $materiel_table = $codeListe;
            if ($count >= 1) {
                for ($i = 0; $i < $count; $i++) {
                    $query_insert_materiel_list = "INSERT INTO article_devis(id_article_devis,code_article_devis,designation_article_devis,
                    quantite_article_devis,prix_unitaire,depot)
                     VALUES ('$id_contrat','$materiel_table[$i]',
                    '$designationListe[$i]','$quantitionListe[$i]','$prixListe[$i]','$depotListe[$i]') ";
                    $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                }
                if ($result_query_insert_materiel_list) {
                    echo ("<div class='text-success'>Le contrat est ajouté  avec succés</div>");
                } else {
                    echo ("<div class='text-danger'>échoué!</div>");
                }
            }
        }
    }
}

function delete_devis()
{
    global $conn;
    $Del_ID = $_POST['Delete_DevisID'];
    $query = "DELETE FROM devis WHERE id_devis='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Le devis est supprimé";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function get_Devis()
{
    global $conn;
    $DevisID = $_POST['DevisID'];
    $query = " SELECT * FROM devis AS D LEFT JOIN client AS C ON D.id_client_devis =C.id_client
    LEFT JOIN article_devis AS AD ON AD.id_article_devis= D.id_devis
    WHERE D.id_devis='$DevisID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $devis_data = array();
        if (empty($devis_data)) {  
        $devis_data[0][] = $row['id_devis'];
        $devis_data[1][] = $row['nom_devis'];
        $devis_data[2][] = $row['ModePaiement_Devis'];
        $devis_data[3][] = $row['Commentaire_Devis'];
        $devis_data[4][] = $row['date_devis'];
        $devis_data[5][] = $row['remise'];
        $devis_data[6][] = $row['tva'];
        $devis_data[7][] = $row['escompte'];
        $devis_data[8][] = $row['id_client']; 
        $devis_data[10][] = $row['code_article_devis'];
        $devis_data[11][] = $row['designation_article_devis'];
        $devis_data[12][] = $row['quantite_article_devis'];
        $devis_data[13][] = $row['prix_unitaire'];  
        $devis_data[14][] = $row['depot'];  
        } else {
        $devis_data[10][] = $row['code_article_devis'];
        $devis_data[11][] = $row['designation_article_devis'];
        $devis_data[12][] = $row['quantite_article_devis'];
        $devis_data[13][] = $row['prix_unitaire']; 
        $devis_data[14][] = $row['depot'];  
        }
    }
    // var_dump(implode(",", $devis_data));
    // var_dump($devis_data[13]);
    echo json_encode($devis_data);
}

// update Client
function update_devis(){

    global $conn;
    if (!array_key_exists("up_idDevis", $_POST)) {
    echo json_encode(["error" => "ID Devis manquant ", "data" => "ID Devis manquant"]);
    return;
    }
    $updateDevislId = $_POST["up_idDevis"];
    $devis_query = "SELECT * FROM  devis where id_devis = $updateDevislId";
    $devis_result = mysqli_query($conn, $devis_query);
    $devis = mysqli_fetch_assoc($devis_result);
    if (!$devis) {
        echo json_encode(["error" => "Devis introuvable ", "data" => "Devis $updateDevislId not found."]);
        return;
    }
    
    $updateDevislId = $_POST['up_idDevis'];
    $updateDevisClient = $_POST['up_ClientDevis'];
    $updateDevisName = $_POST['up_NomDevis'];
    $updateDevisModePaiement = $_POST['up_ModePaiementDevis'];
    $updateDevisCommentaire = $_POST['up_CommentaireDevis'];
    $updateDevisDate = $_POST['up_DateDevis'];
    $updateDevisRemise = $_POST['up_RemiseDevis'];
    $updateDevisEscompte = $_POST['up_EscompteDevis'];
    
    $updateDeviscodeListe = $_POST['up_code_comp1'];
    $updateDevisdesignationListe = $_POST['up_designation_comp_1'];
    $updateDevisquantitionListe = $_POST['up_quantition_comp_1'];
    $updateDevisprixListe = $_POST['up_prix_comp_1'];
    $updateDevisdepotListe = $_POST['up_depot_comp_1'];
    $count = count($updateDevisdepotListe);

    $query = "UPDATE devis SET 
    id_client_devis='$updateDevisClient',nom_devis='$updateDevisName',ModePaiement_Devis='$updateDevisModePaiement',
    Commentaire_Devis='$updateDevisCommentaire',date_devis='$updateDevisDate',remise='$updateDevisRemise',escompte='$updateDevisEscompte'
    where id_devis='$updateDevislId'";

    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $query_get_max_id_contrat = "SELECT max(id_devis)
                FROM devis ";
        $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
        while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
            $id_contrat = $row[0];
            $materiel_table = $updateDeviscodeListe;
            if ($count >= 1) {
                for ($i = 0; $i < $count; $i++) {
                    $query_insert_materiel_list = "UPDATE article_devis SET 
                    id_article_devis='$id_contrat',code_article_devis='$materiel_table[$i]',designation_article_devis='$updateDevisdesignationListe[$i]',
                    quantite_article_devis='$updateDevisquantitionListe[$i]',prix_unitaire='$updateDevisprixListe[$i]',depot='$updateDevisdepotListe[$i]') ";
                    $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                }
                if ($result_query_insert_materiel_list) {
                    echo ("<div class='text-success'>Le devis est mis à jour avec succès</div>");
                } else {
                    echo ("<div class='text-danger'>échoué!</div>");
                }
            }
        }
    }

}

function view_devis()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<div class="table-responsive">
    <table class="table">
    <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom devis</th>
            <th class="border-top-0">Mode Paiement</th>
            <th class="border-top-0">Commentaire</th>
            <th class="border-top-0">Date devis</th>
            <th class="border-top-0">Remise</th>
            <th class="border-top-0">Escompte</th>
            <th class="border-top-0">Nom client</th>
            <th class="border-top-0">Actions</th>
        </tr>
        </thead>';
    $query = "SELECT * FROM devis,client 
    where devis.id_client_devis = client.id_client 
    ORDER BY id_devis ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tbody>
            <tr>
                <td class="border-top-0">' . $row['id_devis'] . '</td>
                <td class="border-top-0">' . $row['nom_devis'] . '</td>
                <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                <td class="border-top-0">' . $row['date_devis'] . '</td>
                <td class="border-top-0">' . $row['remise'] . '%</td>
                <td class="border-top-0">' . $row['escompte'] . '%</td>
                <td class="border-top-0">' . $row['nom'] . '</td>';
        $value .= '<td class="border-top-0">
            <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-devis" data-id=' . $row['id_devis'] . '><i class="fas fa-edit"></i></button> 
            <button  type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-devis" data-id1=' . $row['id_devis'] . '><i class="fas fa-trash-alt"></i></button>
            <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-devis" data-id2=' . $row['id_devis'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>
            </tr>';
    }

    $value .= ' </tbody>
    </table>
</div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}