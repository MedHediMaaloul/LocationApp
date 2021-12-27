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
                    MATÉRIELS
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
                    <div class="card-heading">Liste des matériels</div>
                    <div class="card-body">
                        <p id="delete_messagec"></p>
                        <?php
                        if (($_SESSION['Role']) == "admin") {

                        ?>
                        <button class="btn btn-success" data-toggle="modal"
                            data-target="#Registration-Materiel" style="font-size:25px;margin:5px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- <button class="rounded-pill border border-dark" type="button" data-toggle="modal" data-target="#Registration-Materiel" style="height: 50px;;width: 120px" >AJOUTER<span style="border-radius:50% ; width: 50px;width: 50px;width: 50px;border:1px" >+</span></button> -->
                        <!-- <a href="ExportMateriel.php"><button type="button" class="btn btn-primary"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 150px;width: 50px;height:50px"><i
                                    class="far fa-file-excel"></i></button></a> -->


                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchMaterielAgence"
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
                                    <div class="table-responsive" id="Materiel-list"></div>
                                    <!-- delete materiel model -->
                                    <div class="modal fade" id="deleteMateriel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Matériel
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer le Matériel ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn_delete_materiel_agence">Supprimer
                                                        Matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->


                                    <!-- update materiel model -->
                                    <div class="modal fade" id="updateMaterielAgence" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Matériel
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="MaterielForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idmateriel">
                                                        </div>



                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> N° serie matériel</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielNserie"
                                                                    placeholder="fournisseur de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Matériel État</label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="up_materielEtat" name="up_materielEtat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="HS"> Hors Service </option>
                                                                    <option value="T"> Activer</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_updated_materiel_agence">Modifier
                                                        matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->


                                    <!-- Modal add materiel -->
                                    <div class="modal fade" id="Registration-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Matériel
                                                        Agence</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="add-MaterielForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <!-- <div class="form-group mb-4">
                              <input type="hidden" id="up_idMateriel">
                            </div> -->


                                                        <div class="form-group mb-4">

                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM materiels where etat_materiels_categorie!='S'  ORDER BY code_materiel,designation ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">
                                                                Materiel*</label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="IdMateriel" name="IdMateriel"
                                                                                onchange="MaterielCategorie(this.value)"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="" disabled selected>
                                                                                    Selectionner
                                                                                    Materiel</option>
                                                                                <?php
                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        echo '<option value="' . $row['id_materiels'] . '">' . $row['code_materiel'] . ' -- ' . $row['designation'] . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>

                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <a href="categorie.php"><button
                                                                                    type="button"
                                                                                    class="btn btn-primary"><i>+</i></button></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>


                                                        </div>


                                                        <div class="form-group mb-4" id="cont_num_serie"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">N° Serie<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" placeholder="Ns° A3452 "
                                                                    id="materielnumserie"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_quitite"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Quantité<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="quitite" placeholder="l"
                                                                    class="form-control p-0 border-0" min="1" step="1"
                                                                    required>
                                                            </div>
                                                        </div>



                                                        <div class="form-group mb-2" id="cont_composant"
                                                            style="display:none">


                                                            <label class="col-md-12 p-0">Composant Matériel </label>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field">

                                                                    <tr>
                                                                        <td style="width:40%;">
                                                                            <input type="text" name="skill[]"
                                                                                id="fetch-materiel_comp1"
                                                                                placeholder="Composant"
                                                                                class="form-control materiel-list-comp">


                                                                        </td>
                                                                        <td style="width:40%;"> <input type="text"
                                                                                id="num_serie_comp_1"
                                                                                placeholder="Num serie"
                                                                                class="form-control p-0  materiel-list-num_comp"
                                                                                required>
                                                                        </td>
                                                                        <td><button type="button" name="add" id="add"
                                                                                class="btn btn-success">+</button></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Materiel">Ajouter
                                                        Matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->





                                    <div class="modal fade" id="Registration-Materiel-Comp" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Matériel
                                                        Agence</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="add-MaterielCompForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <!-- <div class="form-group mb-4">
                              <input type="hidden" id="up_idMateriel">
                            </div> -->

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-Materiel-comp">Ajouter
                                                        Materiel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="modal fade" id="Registration-Materiel-stock" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Stock</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagest"></p>
                                                    <form id="add-MaterielStockForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idMaterielstock">
                                                        </div>


                                                        <div class="form-group mb-2">


                                                            <label class="col-md-12 p-0">Stock Matériel <span
                                                                    class="text-danger"></span></label>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="">

                                                                    <tr>
                                                                        <td style="width:40%;">
                                                                            <select id="stockSigne" name="stockSigne"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="add"> + </option>
                                                                                <option value="moins"> - </option>

                                                                            </select>


                                                                        </td>
                                                                        <td style="width:40%;"> <input type="text"
                                                                                id="value" value="0"
                                                                                placeholder="quantite"
                                                                                class="form-control p-0 " required>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <div class="form-group mb-4">
                                                                <label class="col-md-12 p-0"> État Matériel</label>
                                                                <div class="col-md-12 border-bottom p-0">

                                                                    <select id="up_EtatMaterielstock"
                                                                        name="up_EtatMaterielstock"
                                                                        class="form-control p-0 border-0" required>
                                                                        <option value="HS"> Hors Service </option>
                                                                        <option value="T"> Activer</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>




                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Materiel-stock">
                                                        Modifier stock</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>






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

    <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            // alert('cvbcvb');
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"> <td><input type="text" name="skill[]" id="fetch-materiel_comp' + i +
                '" placeholder="Composant" class="form-control materiel-list-comp"> </td> <td style="width:100px;"> <input type="text" id="num_serie_comp_' +
                i +
                '" placeholder="Num serie"class="form-control p-0 materiel-list-num_comp"  required> </td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });




    });
    </script>
    </body>

    </html>