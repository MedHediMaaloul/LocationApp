<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (!isset($_SESSION['User'])) {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
} else {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
}
?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    ENTRETIENS
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">Liste des entretiens </div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <button class="btn btn-success"  data-toggle="modal"
                            data-target="#Registration-Entretien" style="font-size:25px;margin:5px;width: 50px;height:50px"
                        >+</button>


                               <!-- search box -->

                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchEntretiens"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">


                                    <div class="table-responsive" id="Entretien-list"></div>

                                    <!-- delete Entretien model -->
                                    <div class="modal fade" id="deleteEntretien" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Entretien
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer l'entretien ?</p>
                                                    <button class="btn btn-success" id="btn_delete_Entretien">Supprimer
                                                        Entretien</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->



                                    <!-- update Entretien model -->
                                    <div class="modal fade" id="updateEntretien" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Entretien
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="updateEntretienForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_identretien">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_EntretienIdVoiture">
                                                        </div>


                                                        <!-- <div class="form-group mb-4">

                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input id="up_identretien" name="up_identretien"
                                                                    disabled>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Objet
                                                                Entretien
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_ObjetEntretien"
                                                                placeholder="Objet entretien" class="form-control p-0 border-0"
                                                                    name="up_ObjetEntretien">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Lieu
                                                                entretien
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_LieuEntretien" placeholder="Paris"
                                                                    class="form-control p-0 border-0"
                                                                    name="up_LieuEntretien">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Cout
                                                                entretien *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_CoutEntretien" placeholder="1000 £"
                                                                    class="form-control p-0 border-0"
                                                                    name="up_CoutEntretien">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date
                                                                entretien*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_Entretiendate"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date
                                                                entretien fin *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_EntretiendateFin"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="up_ProchaineEntretienp">
                                                            <label for="example-email" class="col-md-12 p-0">Prochaine
                                                                date
                                                                entretien *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_ProchaineEntretien"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>



                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type Entretien*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_EntretienType"
                                                                    placeholder="nom de Entretien"
                                                                    class="form-control p-0 border-0" required disabled>
                                                                 <select class="form-control form-control p-0 border-0" id="up_EntretienType">
                                                                <option value="" disabled selected>Selectionner Type Entretien</option>
                                                                <option>véhicule</option>
                                                                <option>Materiel</option>
                                                                </select> 
                                                            </div>
                                                        </div>
                                                        -->


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienfournisseur" placeholder="fournisseur de Entretien" class="form-control p-0 border-0"> -->
                                                                <textarea class="form-control p-0 border-0"
                                                                placeholder="Votre commentaire" id="up_EntretienCommentaire" rows="3"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Disponible<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="up_VoitureHS" id="up_VoitureEntretien"
                                                                    class="form-control p-0 border-0" required="">
                                                                    
                                                                    <option value="Entretien">En cours d'entretien </option>
                                                                    <option value="Disponible"> Disponible</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Entretien">Modifier
                                                        Entretien</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->




                                    <!-- Modal add Entretien -->
                                    <div class="modal fade" id="Registration-Entretien" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Entretien
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="EntretienForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Objet
                                                               entretien
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="ObjetEntretien" placeholder="Objet entretien"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Lieu
                                                                entretien
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="LieuEntretien" placeholder="Paris"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Cout
                                                                entretien *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CoutEntretien" placeholder="1000 £"
                                                                    class="form-control p-0 border-0"
                                                                    name="CoutEntretien">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date début
                                                                entretien*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="Entretiendate" 
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date fin
                                                                entretien*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="EntretienFindate"
                                                                    class="form-control p-0 border-0"
                                                                    name="EntretienFindate">
                                                            </div>
                                                        </div>





                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Maintenance récurrente*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienname" placeholder="nom de Entretien" class="form-control p-0 border-0" required> </div> -->
                                                                <select class="form-control form-control p-0 border-0"
                                                                    id="EntretienTypeM">
                                                                    <option value="" disabled selected>Selectionner type
                                                                        entretien </option>
                                                                    <option>oui</option>
                                                                    <option>non</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="ProchaineEntretien"
                                                            style="display: none">
                                                            <label for="example-email" class="col-md-12 p-0">Prochaine
                                                                date
                                                                entretien *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="ProchaineEntretiendate"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienfournisseur" placeholder="fournisseur de Entretien" class="form-control p-0 border-0"> -->
                                                                <textarea class="form-control p-0 border-0"
                                                                placeholder="Votre commentaire .."  id="EntretienCommentaire" rows="3"></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienname" placeholder="nom de Entretien" class="form-control p-0 border-0" required> </div> -->
                                                                <select class="form-control form-control p-0 border-0"
                                                                    id="EntretienType">
                                                                    <option value="" disabled selected>Selectionner type
                                                                    </option>
                                                                    <option>Vehicule</option>
                                                                    <option>Materiel</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="voiture" style="display: none">
                                                            <div class="form-group mb-4">
                                                                <label class="col-md-12 p-0"> Véhicule</label>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <?php
                                                                    include('Gestion_location/inc/connect_db.php');
                                                                    $id_agence = $_SESSION['id_agence'];
                                                                    $query = "SELECT * FROM `voiture` where (etat_voiture != 'Vendue' and etat_voiture != 'Entretien') 
                                                                        and id_agence ='$id_agence'
                                                                        and actions !='S'
                                                                        ORDER BY `id_voiture` ASC";
                                                                    $result = mysqli_query($conn, $query);
                                                                    ?>
                                                                    <select id="EntretienModelVoiture"
                                                                        name="EntretienModelVoiture"
                                                                        class="form-control p-0 border-0">
                                                                        <option value="" disabled selected>Selectionner
                                                                        véhicule</option>
                                                                        <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_voiture'] . '">' .  $row['type'] . ' - ' . $row['pimm'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="materiel" style="display: none">
                                                            <div class="form-group mb-4">
                                                                <label class="col-md-12 p-0">Nom matériel</label>
                                                                <?php
                                                                include('Gestion_location/inc/connect_db.php');
                                                                $query = "SELECT * FROM `materiels_agence`  
                                                                WHERE id_agence ='$id_agence' 
                                                                And etat_materiels='T'
                                                                ORDER BY `id_materiels`  ASC";
                                                                $result = mysqli_query($conn, $query);
                                                                ?>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <select id="EntretienNomMateriel"
                                                                        name="EntretienNomMateriel"
                                                                        onchange="FetchNumSerie(this.value)"
                                                                        class="form-control p-0 border-0">
                                                                        <option value="" disabled selected>Selectionner
                                                                        matériel</option>
                                                                        <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_materiels_agence'] . '">' . $row['num_serie_materiels'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Entretien">Ajouter
                                                        Entretien</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <?php
    include('Gestion_location/inc/footer.php')
    ?>

    </body>

    </html>