<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
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
                    Devis
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
                    <div class="card-heading">Liste des Devis</div>
                    <div class="card-body">
                    <button class="btn btn-success"  data-toggle="modal"
                            data-target="#Registration-Devis" style="font-size:25px;margin:5px;width: 50px;height:50px"
                        >+</button>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchGestionDevisid"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <p id="delete_message_Devis"></p>
                
                        <!-- modal delet devis -->
                                    <div class="modal fade" id="deleteDevis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Devis</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>voulez-vous supprimer le devis ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer Devis</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <!-- end delet devis -->
                
                                    <div class="table-responsive" id="devis-list"> </div>



                                    <div class="modal fade" id="Setting-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Matériel </h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="tableSettingmateriel"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end  modal view contrat -->



                                    <!-- update Modal -->
                                    <div class="modal fade" id="updateDevis" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Devis</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_Devis"></p>
                                                    <form id="updateDevisForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                       
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idDevis">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM client where etat_client !='S'";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Client<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_ClientDevis" 
                                                                    class="form-control p-0 border-0" required>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_client'] . '">' . $row['nom'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_NomDevis" placeholder="Nom"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_ModePaiementDevis"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Mode
                                                                        Paiement</option>
                                                                    <option value="Carte bancaire">Carte bancaire
                                                                    </option>
                                                                    <option value="Virements bancaires">Virements
                                                                        bancaires</option>
                                                                    <option value="Prélèvements automatiques">
                                                                        Prélèvement automatique</option>
                                                                    <option value="Espèces">Espèces</option>
                                                                    <option value="Chèque">Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>
                        

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_CommentaireDevis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateDevis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Remise<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" min="0" max="100" id="up_RemiseDevis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Escompte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" min="0" max="100"
                                                                    id="up_EscompteDevis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-2" id="up_cont_composant">


                                                        <label class="col-md-12 p-0">Article </label>
                                                                                                                        
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dynamic_field">
                                                                                                                        
                                                                <tr>
                                                                    <td style="width:15%;">
                                                                        <input type="text" name="skill[]"
                                                                            id="up_code_comp1" placeholder="code"
                                                                            class="form-control code-list-comp">
                                                                    </td>
                                                                                                                        
                                                                    <td style="width:25%;"> <input type="text"
                                                                            id="up_designation_comp_1"
                                                                            placeholder="Designation"
                                                                            class="form-control p-0  designation-list-num_comp"
                                                                            required>
                                                                    </td>
                                                                                                                        
                                                                                                                        
                                                                    <td style="width:20%;"> <input type="number"
                                                                            id="up_quantition_comp_1"
                                                                            placeholder="Quantité"
                                                                            class="form-control p-0  quantition-list-num_comp"
                                                                            required>
                                                                    </td>
                                                                                                                        
                                                                    <td style="width:15%;"> <input type="number"
                                                                            min="0" id="up_prix_comp_1"
                                                                            placeholder="Prix"
                                                                            class="form-control p-0  prix-list-num_comp"
                                                                            required>
                                                                    </td>
                                                                    <td style="width:15%;"> <input type="text"
                                                                            id="up_depot_comp_1" placeholder="Depot"
                                                                            class="form-control p-0  depot-list-num_comp"
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
                                                    <button class="btn btn-success" id="btn_update_devis">Modifier
                                                        Devis</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->



                                    <!-- Modal add contrat -->
                                    <div class="modal fade" id="Registration-Devis" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Devis</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="groupDevisForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_Devisid">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM client where etat_client !='S'";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Client<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientDevis" name="ClientDevis"
                                                                    class="form-control p-0 border-0">
                                                                    <option value=" " selected>Selectionnez Un Client</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_client'] . '">' . $row['nom'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="NomDevis" placeholder="Nom"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ModePaiementDevis"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Mode
                                                                        Paiement</option>
                                                                    <option value="Carte bancaire">Carte bancaire
                                                                    </option>
                                                                    <option value="Virements bancaires">Virements
                                                                        bancaires</option>
                                                                    <option value="Prélèvements automatiques">
                                                                        Prélèvement automatique</option>
                                                                    <option value="Espèces">Espèces</option>
                                                                    <option value="Chèque">Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>
                        

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="CommentaireDevis" placeholder="Commentaire"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateDevis"
                                                                    placeholder="12/12/2020"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Remise<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" min="0" max="100" id="RemiseDevis"
                                                                    placeholder="Remise Devis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Escompte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" min="0" max="100"
                                                                    id="EscompteDevis" placeholder="Escompte Devis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-2" id="cont_composant">


                                                            <label class="col-md-12 p-0">Article </label>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field">

                                                                    <tr>
                                                                        <td style="width:15%;">
                                                                            <input type="text" name="skill[]"
                                                                                id="code_comp1" placeholder="code"
                                                                                class="form-control code-list-comp">
                                                                        </td>

                                                                        <td style="width:25%;"> <input type="text"
                                                                                id="designation_comp_1"
                                                                                placeholder="Designation"
                                                                                class="form-control p-0  designation-list-num_comp"
                                                                                required>
                                                                        </td>


                                                                        <td style="width:20%;"> <input type="number"
                                                                                id="quantition_comp_1"
                                                                                placeholder="Quantité"
                                                                                class="form-control p-0  quantition-list-num_comp"
                                                                                required>
                                                                        </td>

                                                                        <td style="width:15%;"> <input type="number"
                                                                                min="0" id="prix_comp_1"
                                                                                placeholder="Prix"
                                                                                class="form-control p-0  prix-list-num_comp"
                                                                                required>
                                                                        </td>
                                                                        <td style="width:15%;"> <input type="text"
                                                                                id="depot_comp_1" placeholder="Depot"
                                                                                class="form-control p-0  depot-list-num_comp"
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
                                                    <button class="btn btn-success" id="btn-register-Devis">Ajouter
                                                        Devis</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>
    <script>
    $(document).ready(function() {
        // $(document).on('click', '.add', function() {
        //     var html = '';
        //     html += '<tr>';
        //     html +=
        //         '<td><input type="text" name="item_code[]" id="row" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><input type="text" name="item_designation[]" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><input type="number" name="item_quantite[]" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><input type="number" name="item_prixu[]" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><input type="number" name="item_montant[]" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><input type="text" name="item_depot[]" class="form-control item_panne" /></td>';
        //     html +=
        //         '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus">-</span></button></td></tr>';
        //     $('#item_table').append(html);
        // });




        // $(document).on('click', '.remove', function() {
        //     $(this).closest('tr').remove();
        // });



        var i = 1;
        $('#add').click(function() {
            // alert('cvbcvb');
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"> <td><input type="text" name="skill[]" id="code_comp' +
                i +
                '" placeholder="code" class="form-control code-list-comp"> </td>    <td> <input type="text" id="designation_comp_' +
                i +
                '" placeholder="designation" class="form-control p-0 designation-list-num_comp"  required> </td>     <td> <input type="number" min="0" id="quantition_comp_' +
                i +
                '" placeholder="quantition" class="form-control p-0 quantition-list-num_comp"  required> </td>        <td> <input type="number" min="0"  id="prix_comp_' +
                i +
                '" placeholder="prix" class="form-control p-0 prix-list-num_comp"  required> </td>       <td> <input type="number" min="0"  id="montant_comp_' +
                i +
                '" placeholder="montant" class="form-control p-0 montant-list-num_comp"  required> </td>        <td> <input type="text" id="depot_comp_1' +
                i +
                '" placeholder="depot" class="form-control p-0 depot-list-num_comp"  required> </td>        <td><button type="button" name="remove" id="' +
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