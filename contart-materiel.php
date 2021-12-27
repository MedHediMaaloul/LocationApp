<?php
session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    //  echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
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
                    CONTRATS
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
                    <div class="card-heading">LISTE DES CONTRATS</div>
                    <div class="card-body">
                    <button class="btn btn-success"  data-toggle="modal"
                            data-target="#Registration-Contrat" style="font-size:25px;margin:5px;width: 50px;height:50px"
                        >+</button>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchContratMateriel"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <p id="delete_message_materiel"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">

                                    <!-- PDF model  -->
                                    <div class="modal fade bd-example-modal-xl" id="PDF-Materie-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="Voiture">
                                                        <!-- <button class="btn btn-primary" id="pdf">Print PDF</button> -->
                                                        <div id="toPrint">
                                                            <page_header>
                                                                <div class="row"><img src="plugins\k2-pdf.jpg" alt="" />
                                                                </div>
                                                            </page_header>
                                                            <page>
                                                                <div class="row">CONTRAT DE LOCATION N° <span
                                                                        id="Contrat-number"></div>
                                                                <div class="row">
                                                                    <div class="col-sm info border border-dark">
                                                                        <div
                                                                            class="row content-text font-weight-bold justify-content-center">
                                                                            INFORMATIONS CLIENT</div>
                                                                        <div class="row content-text">Nom:&nbsp
                                                                            <span id="Client-nom">
                                                                        </div>
                                                                        <div class="row content-text">Mail:&nbsp <span
                                                                                id="Client-mail"></span></div>
                                                                        <div class="row content-text">Tel:&nbsp <span
                                                                                id="Client-tel"></span></div>
                                                                        <div class="row content-text">Adresse:&nbsp<span
                                                                                id="Client-address"></div>

                                                                    </div>
                                                                    <div class="col-sm info border border-dark">
                                                                        <div
                                                                            class="row content-text font-weight-bold justify-content-center">
                                                                            INFORMATIONS MATÉRIEL</div>
                                                                        <div class="row">
                                                                            <div class="col content-text">Nom de
                                                                                Matériel:&nbsp<span
                                                                                    id="Contrat-Designation"></span>
                                                                            </div>
                                                                            <div class="col content-text">Num de
                                                                                Série:&nbsp<span
                                                                                    id="Contrat-numero"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col content-text"> <br> <span
                                                                                    id="Composant-Designation"></span>
                                                                            </div>
                                                                            <div class="col content-text"> <br> <span
                                                                                    id="Composant-numero"></span>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div> <br>
                                                                <div
                                                                    class="row d-flex justify-content-center font-weight-bold">
                                                                    CONDITIONS PARTICULIERES
                                                                </div>
                                                                <br>
                                                                <div class="row content-text">
                                                                    Le locataire reconnait que le matériel loué a bien
                                                                    un rapport direct avec son activité et que ce
                                                                    faisant le code de la consommation ne s’applique
                                                                    pas.
                                                                    Le loueur et le locataire certifient, attestent et
                                                                    conviennent que le matériel est livré ce jour, qu’il
                                                                    est conforme à sa désignation, aux prescriptions des
                                                                    règlements d’hygiène et de sécurité du travail,
                                                                    qu’il est en bon état de fonctionnement sans vice
                                                                    apparent ou caché et répond aux besoins du
                                                                    locataire, qu’il n’est pas contrefaisant et qu’il
                                                                    est conforme à la réglementation relative à la
                                                                    pollution et à la protection de l’environnement.
                                                                </div>
                                                                <br>
                                                                <div class="row font-weight-bold">AUTRE INFORMATIONS
                                                                </div>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">État du matériel :
                                                                    </div>
                                                                    <div class="row content-text">
                                                                        <p>Lors de la remise du matériel et lors de sa
                                                                            restitution, une fiche de contrôle de l'état
                                                                            sera établie entre le locataire et le
                                                                            loueur.
                                                                            Le matériel devra être restitué dans le même
                                                                            état que lors de sa mise à disposition au
                                                                            locataire.
                                                                            Toutes les détériorations sur le matériel
                                                                            constatées sur le PV de sortie seront à la
                                                                            charge du locataire et/ou être déduites en
                                                                            partie ou totalité sur le montant de la
                                                                            caution.
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                                <section>
                                                                    <div class="row font-weight-bold">Durée:</div>
                                                                    <div class="row content-text">Du &nbsp<span
                                                                            id="Contrat-Date-Debut"></span> &nbsp au
                                                                        &nbsp <span id="Contrat-Date-Fin"></span> </div>
                                                                    <div class="row content-text" id="ilpourra">
                                                                    </div>
                                                                </section> <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Prix location:
                                                                    </div>
                                                                    <div class="row"><span
                                                                            id="Contrat-Prix"></span>&nbsp euros en HT
                                                                        <div id="prix-location"></div>&nbsp <span
                                                                            id="Contrat-prix-TTC"></span>&nbsp euros en
                                                                        TTC
                                                                    </div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Mode de paiement:
                                                                    </div>
                                                                    <div class="row">
                                                                        Les loyers sont dus à date échu; Le premier
                                                                        paiement s’effectuera le jour de la mise à
                                                                        disposition du matériel.</div>
                                                                    <div class="row"><span
                                                                            id="Contrat-Mode-Paiement">&nbsp</span>&nbsp<span
                                                                            id="Contrat-Date-Prelevement"></span></div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Dépôt de garantie:
                                                                    </div>
                                                                    <div class="row content-text">
                                                                        <p id="next">Le locataire verse à K2, une somme
                                                                            de &nbsp <span id="Contrat-Caution"></span>€
                                                                            à
                                                                            titre de dépôt de garantie pour répondre
                                                                            des dégâts qui pourraient être causés aux
                                                                            matériels loués. Le remboursement du dépôt
                                                                            de
                                                                            garantie sera effectué au retour du matériel
                                                                            si celui-ci n’a pas été endommagé. <br> N°
                                                                            de chèque de caution : <span
                                                                                id="Num-cheque-caution"></span>
                                                                        </p>

                                                                    </div>
                                                                </section>
                                                                <section>
                                                                    <div class="row font-weight-bold">Documents à
                                                                        fournir:</div>
                                                                    <div class="row">Pièce d’identité du gérant</div>
                                                                    <div class="row">Rib pour les prélèvements mensuels
                                                                    </div>
                                                                    <div class="row">Kbis de moins de 3 mois</div>
                                                                    <div class="row">Attestation d’assurance
                                                                        responsabilité civile</div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold ">Autres elements
                                                                        et
                                                                        accessoires:</div>
                                                                    <div class="row">
                                                                        Le locataire prendra en charge l'ensemble des
                                                                        charges afférentes au bon fonctionnement du
                                                                        matériel:
                                                                    </div>
                                                                    <div class="row">- Nettoyage</div>
                                                                    <div class="row" id="changement-electrode"></div>
                                                                    <div class="row content-text">
                                                                        La sous-location du matériel par le locataire à
                                                                        un tiers est exclue
                                                                    </div>
                                                                </section> <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Clause en cas de
                                                                        litige:</div>
                                                                    <div class="row content-text">
                                                                        <p> Les parties conviennent expressément que
                                                                            tout litige pouvant naître de l'exécution du
                                                                            présent contrat relèvera de la compétence du
                                                                            tribunal de commerce de DIJON.
                                                                            Fait en deux exemplaires originaux remis à
                                                                            chacune des parties,
                                                                            A CHEVIGNY SAINT SAUVEUR, le <span
                                                                                id="Contrat-Date"></p>
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <div class="row">
                                                                        <p
                                                                            class="content-text d-flex justify-content-center">
                                                                            Le locataire soussigné déclare accepter
                                                                            toutes les conditions générales figurant sur
                                                                            les pages
                                                                            suivantes du contrat qui été établi en
                                                                            autant d’exemplaires que de parties.
                                                                            Signature du contrat et l’autorisation de
                                                                            prélèvement ci-dessous et paraphe de chaque
                                                                            page.
                                                                        </p>

                                                                    </div>
                                                                </section>
                                                                <div class="row">
                                                                    <div
                                                                        class="col-8 signature-client border border-dark content-text d-flex justify-content-center mr-3">
                                                                        <div
                                                                            class="d-flex flex-column bd-highlight mb-3 ">
                                                                            <div
                                                                                class=" bd-highlight font-weight-bold d-flex justify-content-center">
                                                                                Cachet commercial et signature du
                                                                                LOCATAIRE</div>
                                                                            <div
                                                                                class=" bd-highlight d-flex justify-content-center">
                                                                                précédée de la mention manuscrite Bon
                                                                                pour
                                                                                accord</div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-sm signature border border-dark content-text d-flex justify-content-center font-weight-bold ml-3">
                                                                        Signature du LOUEUR</div>
                                                                </div>
                                                                <div class="row" style="margin: 15px;">
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm">Paraphe</div>
                                                                </div>
                                                                <div id="para"></div>
                                                                <?php
                                                                include 'conditionGeneral.php';
                                                                ?>

                                                            </page>
                                                        </div>

                                                        <style>
                                                        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400&display=swap');

                                                        img {
                                                            width: 86px;
                                                            height: 45px;
                                                        }

                                                        .content-text {
                                                            color: black;
                                                            /* letter-spacing: 1px; */
                                                        }

                                                        .para {
                                                            font-size: 7.3px;
                                                        }

                                                        #toPrint {
                                                            font-family: 'Roboto Slab', serif !important;
                                                            font-size: 12px;
                                                            padding: 10px;
                                                            margin: 7px;
                                                            font-weight: 400 !important;
                                                            font-stretch: condensed !important;
                                                            color: black;
                                                        }

                                                        #next {
                                                            color: black;
                                                        }

                                                        .btn-primary {
                                                            position: relative;
                                                            z-index: 1;
                                                        }

                                                        .info {
                                                            margin: 0;
                                                            padding-left: 30px;
                                                        }

                                                        .signature-client {
                                                            height: 160px;
                                                        }

                                                        .Condition {
                                                            font-family: 'Roboto Slab', serif !important;
                                                            font-size: 6.4px;
                                                        }
                                                        </style>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="modal fade loading" tabindex="-1" role="dialog"
                                                        id="spinnerModal">
                                                        <div class="modal-dialog modal-dialog-centered text-center"
                                                            role="document">
                                                            <span class="fas fa-spinner fa-spin fa-6x w-300 text-danger"
                                                                style="width: 6rem; height: 6rem; margin-left:200px"></span>
                                                            <script>
                                                            function modal() {
                                                                $('.loading').modal('show');
                                                                setTimeout(function() {
                                                                    $('.loading').modal('hide');
                                                                }, 3000);
                                                            }
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <a href = "fpdf/ContratMateriel.php?id=1">Telecharger</a>
                                                    <button type="button" id="generate-PDF"
                                                        class="btn btn-success text-white"
                                                        onclick="modal();">Télécharger PDF <i
                                                            class="far fa-file-pdf text-danger"></i></button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- END PDF model -->


                                    <!-- modal delet contrat -->
                                    <div class="modal fade" id="deleteContrat" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Contrat
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>voulez-vous supprimer le contrat ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal delet contrat -->

                                    <div class="table-responsive" id="contrat-list-materiel"> </div>

                                    <!-- update Contrat modal -->
                                    <div class="modal fade" id="update-Contrat-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_materiel"></p>
                                                    <form id="updateContratForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontrat">
                                                        </div>
                                                        <!-- <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"
                                                                style="color:black;font-size:15px">Contrat De :</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input id="up_Contratde"
                                                                    class="form-control p-0 border-0"
                                                                    style="color:black;font-size:20px"
                                                                    name="Entretiendate" disabled>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratDebut"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratFin"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Durée Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="up_dureeContrat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="Standard">Standard</option>
                                                                    <option value="Par Jour">Par Jour</option>
                                                                    <option value="Par Semaine">Par Semaine</option>
                                                                    <option value="Par Mois">Par Mois</option>
                                                                    <option value="LLD">LLD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContrat"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateDebutContrat"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div> -->
                                                        <!-- 
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateFinContrat"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group mb-4">
                                                            <input type="hidden" id="up_DateFinContrat">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_DateDebutContrat">
                                                        </div> -->
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Prix<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_PrixContrat"
                                                                    placeholder="1000€"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Caution<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_Caution" placeholder="1000€"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">N° de chèque de caution :<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_numCaution"
                                                                    placeholder="123654789"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Assurance K2<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_AssuranceContrat"
                                                                    placeholder="Assurance"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_ModePaiementContrat"
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
                                                        <div id="up_inputDatePrelevementContrat" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">Date Prélèvement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DatePrelevementContrat"
                                                                    placeholder="Date prélèvement de chaque mois"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_updated_Contrat_Materiel">Modifier
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end update Contrat modal -->


                                    <!-- Modal add contrat -->
                                    <div class="modal fade" id="Registration-Contrat" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter contrat
                                                        Matériel</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="contratForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_Contratid">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateDebutContrat"
                                                                    placeholder="01/01/2020"
                                                                    onchange="affichier_materiel_dispo()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateFinContrat"
                                                                    placeholder="01/01/2020"
                                                                    onchange="affichier_materiel_dispo()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateContrat"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div> -->

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Durée Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="dureeContrat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez
                                                                        Durée Contrat</option>
                                                                    <option value="Standard">Standard</option>
                                                                    <option value="Par Jour">Par Jour</option>
                                                                    <option value="Par Semaine">Par Semaine</option>
                                                                    <option value="Par Mois">Par Mois</option>
                                                                    <option value="LLD">LLD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM client 
                                                            
                                                            ORDER  BY nom ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Nom Complet Client<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientContrat" name="ClientContrat"
                                                                    placeholder="Nom Client"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner Un
                                                                        Client</option>
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
                                                            <input type="hidden" id="ClientAgenceDep">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM agence";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Agence retour<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientAgenceRet" name="ClientAgenceRet"
                                                                    placeholder="Agence de retour"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner Une
                                                                        Agence</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Prix<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="PrixContrat"
                                                                    placeholder="1000€"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Caution<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CautionContrat"
                                                                    placeholder="1000€"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">N° de chèque de caution :<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="numCautionMateriel"
                                                                    placeholder="123654789"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="AssuranceContrat">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ModePaiementContrat"
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
                                                        <div id="inputDatePrelevementContrat" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">Date Prélèvement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DatePrelevementContrat"
                                                                    placeholder="Date prélèvement de chaque mois"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                       <div class="form-group mb-4" id="materiel"></div>
                                                       
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-contrat">Ajouter
                                                        Contrat</button>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>

    </body>

    </html>