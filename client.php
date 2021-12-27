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
                    CLIENT
                </h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">Liste des clients actifs</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        
                        <button class="btn btn-success"  data-toggle="modal"
                            data-target="#Registration-Client" style="font-size:25px;margin:5px;width: 50px;height:50px"
                        >+</button>

                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchClientA"
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
                                    <div class="table-responsive" id="client-list"></div>
                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end file modal -->
                                    <!-- delete Client model -->
                                    <div class="modal fade" id="deleteClient" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer le client ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->

                                    <!-- update Client model -->
                                    <div class="modal fade" id="updateClient" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="up_Clienttype" name="up_Clienttype">

                                                                    <option value="CLIENT PRO">CLIENT PRO </option>
                                                                    <option value="CLIENT PARTICULIER"> CLIENT
                                                                        PARTICULIER</option>
                                                                </select>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_Clienttype">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientName"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclient">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmail"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhone"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdresse"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Raison social<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientRaison"
                                                                    placeholder="Raison social"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">SIRET<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientSiret"
                                                                    placeholder="Num Siret"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code NAF<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNaf"
                                                                    placeholder="Code NAF"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code TVA<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientTva"
                                                                    placeholder="User TVA"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Accompte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" min="0" id="up_clientAccompte"
                                                                    placeholder="User Accompte"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_comment"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CIN</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientCIN"
                                                                    placeholder="CIN de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientPermis"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientKBIS"
                                                                    placeholder="KBIS de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientRIB"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update">Modifier
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->


                                    <!-- update Client model -->
                                    <div class="modal fade" id="updateClientPart" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-clientFormPart" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="up_Clienttype" name="up_Clienttype">

                                                                    <option value="CLIENT PRO">CLIENT PRO </option>
                                                                    <option value="CLIENT PARTICULIER"> CLIENT
                                                                        PARTICULIER</option>
                                                                </select>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_ClienttypePart">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNamePart"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclientPart">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmailPart"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhonePart"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdressePart"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">SIRET<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientSiret"
                                                                    placeholder="Num Siret"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code NAF<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNaf"
                                                                    placeholder="Code NAF"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code TVA<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientTva"
                                                                    placeholder="User TVA"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Accompte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" min="0" id="up_clientAccompte"
                                                                    placeholder="User Accompte"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire

                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_commentPart"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CIN</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientCINPart"
                                                                    placeholder="CIN de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientPermisPart"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>



                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_part">Modifier
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->


                                    <!-- Modal add client -->
                                    <div class="modal fade" id="Registration-Client" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="btn-close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <!-- <div class="form-group mb-4">


                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="Clienttype"
                                                                    onchange="selectclient(this.value)"
                                                                    name="Clienttype">
                                                                    <option value="" disabled selected>Selectionner Type
                                                                    </option>
                                                                    <option value="CLIENT PRO">CLIENT PRO </option>
                                                                    <option value="CLIENT PARTICULIER"> CLIENT
                                                                        PARTICULIER</option>
                                                                </select>
                                                            </div>
                                                        </div> -->

                                                        <div class="col-md-12 border-bottom p-0">
                                                            <select id="Clienttype" name="Clienttype"
                                                                onchange="selectclient(this.value)"
                                                                placeholder="Clienttype"
                                                                class="form-control p-0 border-0" required="">
                                                                <option value="Selectionner" disabled selected>
                                                                    Selectionner type de
                                                                    client
                                                                </option>
                                                                <option value="CLIENT PRO">CLIENT PRO </option>
                                                                <option value="CLIENT PARTICULIER"> CLIENT
                                                                    PARTICULIER</option>
                                                            </select>
                                                        </div>


                                                        <div class="form-group mb-4" id="cont_nom_complet"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Nom Conducteur<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userName" placeholder="User Name"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_email"
                                                            style="display:none">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="userEmail"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                            <div id="massgemail"></div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_telephone"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userPhone"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_adresse"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userAdresse"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4" id="cont_raison"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Raison Social<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userRaison"
                                                                    placeholder="Raison sociale"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_siret"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">SIRET<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userSiret"
                                                                    placeholder="Num Siret"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_naf"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Code NAF<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userNaf"
                                                                    placeholder="Code NAF"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_tva"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Code TVA<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userTva"
                                                                    placeholder="User TVA"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_accompte"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Accompte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" min="0" id="userAccompte"
                                                                    placeholder="User Accompte"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_comment"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Commentaire</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userComment"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_cin" style="display:none">
                                                            <label class="col-md-12 p-0">CIN</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userCIN"
                                                                    placeholder="CIN de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_permis"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userPermis" name="Permis-client"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_kbis"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userKBIS"
                                                                    placeholder="KBIS de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_rib" style="display:none">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userRIB"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-client">Ajouter
                                                        Client</button>
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
        </div>
        <!-- /.col -->
    </div>
</div>

<?php
include('Gestion_location/inc/footer.php')
?>
</body>

</html>