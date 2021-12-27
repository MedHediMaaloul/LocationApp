$(document).ready(function () {
  insertRecord();
  view_client_record();
  get_client_record();
  get_id_client();
  get_id_client_contrat_materiel();
  get_id_client_contrat_pack();
  get_client_part_record();
  update_client_record();
  update_client_part_record();
  delete_client_record();
  view_client_inactif_record();
  //materiel
  insertMaterielRecord();
  view_Materiel_record();
  get_materiel_record();
  update_materiel_record();
  delete_materiel_record();
  //voitures
  insert_voiture_Record();
  insert_voiture_vendue_Record();
  insert_voiture_HS_Record();
  get_voiture_record();
  get_voiture_vendue_record();
  get_voiture_HS_record();
  view_SettingVoitureHSRecord();
  view_SettingVoitureTransfRecord();
  update_voiture_record();
  update_voiture_stock_record();
  view_voiture_record();
  delete_voiture_record();
  update_voiture_vendue_record();
  update_voiture_HS_record();
  view_voiture_HS_record();
  view_voiture_vendue_record();
  //entretien
  insertEntretienRecord();
  view_Entretien_record_materiel();
  view_Entretien_record_voiture()
  view_Entretien_record();
  get_Entretien_record();
  update_entretien_record();
  delete_entretien_record();
  //contrat
  //Contrat mixte-------------------
  delete_contrat_record_mixte();
  get_Mixte_record();
  update_contrat_record_mixte();
  //Contrat-------------------
  view_contrat_record_materiel();
  view_contrat_record_voiture();
  view_contrat_record_pack();
  insertContratVoitureRecord();
  insertContratMaterielRecord();
  get_Contrat_record();
  get_Contrat_Materiel_record();
  get_Contrat_Pack_record();
  update_contrat_record();
  update_contrat_materiel_record();
  update_contrat_pack_record();
  delete_contrat_record();
  delete_contrat_record_materiel();
  delete_contrat_record_pack();
  view_contrat_archivage_record_voiture();
  //Facture
  view_facture_contrat_voiture();
  view_facture_contrat_materiel();
  view_facture_contrat_pack();
  genereridfacturevoiture();
  genereridfacturemateriel();
  genereridfacturepack();
  //devis 
  insertDevisRecord();
  view_devis_record();
  genereriddevis();
  delete_devis();
  get_Devis();
  update_devis_record();
  //pdf Contrat
  showPDFModel();
  showPDFModel_materiel();
  // showfile();
  showPDFMaterielModel();
  // showPDFMixteModel();
  showPDFPackModel();
  //search
  searchAgence();
  searchUser();
  searchClient();
  searchCategorie();
  searchVoiture();
  searchVoitureVendu();
  searchVoitureHS();
  searchGestionPack();
  searchMaterielAgence();
  searchStock();
  searchStockMateriel();
  searchContratVoiture();
  searchContratMateriel();
  searchContratPack();
  searchContratVoitureArchive();
  searchContratMaterielArchive();
  searchContratPackArchive();
  searchEntretiens();
  searchEntretienMateriel();
  searchEntretienVoiture();
  searchContratVoitureArchivage();
  searchGestionDevis();
  searchFactureContratVoiture();
  searchFactureContratMateriel();
  searchFactureContratPack();
  //notification contrat
  load_unseen_notification();
  load_unseen_notification_entretien();
  load_unseen_notification_paiement();
  removeNotification();
  removeNotification_entretien();
  //setting voiture
  insertVoitureSettingRecord();
  view_SettingVoitureRecord();
  delete_SettingVoiturerecord();
  // achived Contract
  view_contrat_archived();
  view_contrat_archived_materiel();
  view_contrat_archivage_record_materiel();
  view_contrat_archivage_record_pack();
  getValidateContratPaiement();
  update_contrat_validate_record();
  //  User
  insertUserRecord();
  view_user_record();
  get_user_record();
  update_user_record();
  delete_user_record();
  //  Agence
  insertAgenceRecord();
  view_agence_record();
  get_agence_record();
  update_agence_record();
  delete_agence_record()
  //pack
  view_group_pack_record();
  insertGroupPackRecord();
  delete_pack_record();
  get_group_pack_record();
  insertContratPackRecord();
  update_group_pack_record();
  //  categorie
  insertCategorieRecord();
  view_categorie_record();
  delete_categorie_record();
  //comp
  insertStockRecord();
  get_materielstock_record();
  view_grppack_record();
  //stock 
  view_stock_record();
  get_stock_voiture();
  view_stock_materiel_record();
  view_stock_Q_record();
});

function insertRecord() {
  $(document).on("click", "#btn-register-client", function () {
    $("#Registration-Client").scrollTop(0);
    var type = $("#Clienttype").val();
    var raison_social = $("#userRaison").val();
    var num_siret = $("#userSiret").val();
    var code_naf = $("#userNaf").val();
    var code_tva = $("#userTva").val();
    var accompte = $("#userAccompte").val();
    var comment = $("#userComment").val();
    var nom = $("#userName").val();
    var email = $("#userEmail").val();
    var tel = $("#userPhone").val();
    var adresse = $("#userAdresse").val();
    var cin = $("#userCIN").prop("files")[0];
    var permis = $("#userPermis").prop("files")[0];
    var kbis = $("#userKBIS").prop("files")[0];
    var rib = $("#userRIB").prop("files")[0];
    if (
      nom == "" ||
      type == null ||
      tel == "" ||
      email == "" ||
      adresse == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (!isValidEmailAddress(email)) {
      $("#message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else if (type == "CLIENT PRO" && raison_social == "") {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir Raison social  obligatoires");
    } else {
      var form_data = new FormData();
      form_data.append("type", type);
      form_data.append("raison_social", raison_social);
      form_data.append("siret", num_siret);
      form_data.append("naf", code_naf);
      form_data.append("codetva", code_tva);
      form_data.append("accompte_client", accompte);
      form_data.append("comment", comment);
      form_data.append("nom", nom);
      form_data.append("email", email);
      form_data.append("tel", tel);
      form_data.append("adresse", adresse);
      form_data.append("cin", cin);
      form_data.append("kbis", kbis);
      form_data.append("permis", permis);
      form_data.append("rib", rib);
      $.ajax({
        url: "AjoutClient.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Client").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Client").modal("show");
            $("#clientForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_client_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#clientForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}
// dispaly client record
function view_client_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/client.php"){
  $.ajax({
    url: "viewclient.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#client-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
// get particuler client record
function get_client_record() {
  $(document).on("click", "#btn-edit-client", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclient").val(data[0]);
        $("#up_clientName").val(data[1]);
        $("#up_clientEmail").val(data[2]);
        $("#up_clientPhone").val(data[3]);
        $("#up_clientAdresse").val(data[4]);
        $("#up_clientCIN").val();
        $("#up_comment").val(data[7]);
        $("#up_clientSiret").val(data[13]);
        $("#up_clientNaf").val(data[14]);
        $("#up_clientTva").val(data[15]);
        $("#up_clientAccompte").val(data[16]);
        $("#up_clientPermis").val();
        $("#up_clientKBIS").val();
        $("#up_clientRIB").val();
        $("#up_clientRaison").val(data[11]);
        $("#up_Clienttype").val(data[12]);
        $("#updateClient").modal("show");
      },
    });
  });
}

function get_client_part_record() {
  $(document).on("click", "#btn-edit-client-part", function () {
    var ID = $(this).attr("data-id2");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclientPart").val(data[0]);
        $("#up_clientNamePart").val(data[1]);
        $("#up_clientEmailPart").val(data[2]);
        $("#up_clientPhonePart").val(data[3]);
        $("#up_clientAdressePart").val(data[4]);
        $("#up_clientCINPart").val();
        $("#up_commentPart").val(data[7]);
        $("#up_clientSiret").val(data[13]);
        $("#up_clientNaf").val(data[14]);
        $("#up_clientTva").val(data[15]);
        $("#up_clientAccompte").val(data[16]);
        $("#up_clientPermisPart").val();
        $("#up_clientRaisonPart").val(data[11]);
        $("#up_ClienttypePart").val(data[12]);
        $("#updateClientPart").modal("show");
      },
    });
  });
}

function update_client_record() {
  $(document).on("click", "#btn_update", function () {
    $("#updateClient").scrollTop(0);
    var updateclientID = $("#up_idclient").val();
    var updateclientName = $("#up_clientName").val();
    var updateclientEmail = $("#up_clientEmail").val();
    var updateclientPhone = $("#up_clientPhone").val();
    var updateclientType = $("#up_Clienttype").val();
    var updateclientAdresse = $("#up_clientAdresse").val();
    var raison_social = $("#up_clientRaison").val();
    var num_siret = $("#up_clientSiret").val();
    var code_naf = $("#up_clientNaf").val();
    var code_tva = $("#up_clientTva").val();
    var accompte = $("#up_clientAccompte").val();
    var comment = $("#up_comment").val();
    var updateclientCIN = $("#up_clientCIN").prop("files")[0];
    var updateclientPermis = $("#up_clientPermis").prop("files")[0];
    var updateclientKBIS = $("#up_clientKBIS").prop("files")[0];
    var updateclientRIB = $("#up_clientRIB").prop("files")[0];
    if (
      updateclientName == "" ||
      updateclientEmail == "" ||
      updateclientType == "" ||
      updateclientPhone == "" ||
      raison_social == "" ||
      num_siret == "" ||
      code_naf == "" ||
      code_tva == "" ||
      accompte == "" ||
      updateclientAdresse == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateClient").modal("show");
    } else if (!isValidEmailAddress(updateclientEmail)) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientID);
      form_data.append("nom", updateclientName);
      form_data.append("email", updateclientEmail);
      form_data.append("tel", updateclientPhone);
      form_data.append("adresse", updateclientAdresse);
      form_data.append("raison_social", raison_social);
      form_data.append("siret", num_siret);
      form_data.append("naf", code_naf);
      form_data.append("codetva", code_tva);
      form_data.append("accompte", accompte);
      form_data.append("comment", comment);
      form_data.append("updateclientType", updateclientType);
      form_data.append("cin", updateclientCIN);
      form_data.append("kbis", updateclientKBIS);
      form_data.append("permis", updateclientPermis);
      form_data.append("rib", updateclientRIB);
      $.ajax({
        url: "update_client.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le client est modifié avec succès");
          $("#updateClient").modal("show");
          view_client_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function update_client_part_record() {
  $(document).on("click", "#btn_update_part", function () {
    $("#updateClientPart").scrollTop(0);
    var updateclientIDPart = $("#up_idclientPart").val();
    var updateclientNamePart = $("#up_clientNamePart").val();
    var updateclientEmailPart = $("#up_clientEmailPart").val();
    var updateclientPhonePart = $("#up_clientPhonePart").val();
    var updateclientTypePart = $("#up_ClienttypePart").val();
    var updateclientAdressePart = $("#up_clientAdressePart").val();
    var num_siret = $("#up_clientSiret").val();
    var code_naf = $("#up_clientNaf").val();
    var code_tva = $("#up_clientTva").val();
    var accompte = $("#up_clientAccompte").val();
    var commentPart = $("#up_commentPart").val();
    var updateclientCINPart = $("#up_clientCINPart").prop("files")[0];
    var updateclientPermisPart = $("#up_clientPermisPart").prop("files")[0];
    if (
      updateclientNamePart == "" ||
      updateclientEmailPart == "" ||
      updateclientPhonePart == "" ||
      updateclientAdressePart == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateClientPart").modal("show");
    } else if (!isValidEmailAddress(updateclientEmailPart)) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientIDPart);
      form_data.append("nom", updateclientNamePart);
      form_data.append("email", updateclientEmailPart);
      form_data.append("tel", updateclientPhonePart);
      form_data.append("adresse", updateclientAdressePart);
      form_data.append("siret", num_siret);
      form_data.append("naf", code_naf);
      form_data.append("codetva", code_tva);
      form_data.append("accompte", accompte);
      form_data.append("comment", commentPart);
      form_data.append("updateclientType", updateclientTypePart);
      form_data.append("cin", updateclientCINPart);
      form_data.append("permis", updateclientPermisPart);
      $.ajax({
        url: "update_clientpart.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le client est modifié avec succès");
          $("#updateClientPart").modal("show");
          view_client_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientFormPart").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function delete_client_record() {
  $(document).on("click", "#btn-delete-client", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteClient").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_client.php",
        method: "post",
        data: {
          Delete_ClientID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteClient").modal("toggle");
          view_client_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
/*
*/
function view_client_inactif_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/Client_inactif.php"){
  $.ajax({
    url: "viewclientinactif.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#client-inactif-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
/*
*/
function insertMaterielRecord() {
  $(document).on("click", "#btn-register-Materiel", function () {
    $("#Registration-Materiel").scrollTop(0);
    var id_materiels = $("#IdMateriel").val();
    var materieldesignation = $("#materieldesignation").val();
    var materielnumserie = $("#materielnumserie").val();
    var quitite = $("#quitite").val();
    const selects_composant = Array.from(
      document.querySelectorAll(".materiel-list-comp")
    );
    const selects_num_composant = Array.from(
      document.querySelectorAll(".materiel-list-num_comp")
    );
    var ComposantListe = selects_composant.map((select) => select.value);
    var NumSerieListe = selects_num_composant.map((select) => select.value);
    if (
      id_materiels == "" ||
      materieldesignation == "" ||
      materielnumserie == "" ||
      quitite == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutMateriel.php",
        method: "post",
        data: {
          id_materiels: id_materiels,
          materieldesignation: materieldesignation,
          materielnumserie: materielnumserie,
          quitite: quitite,
          ComposantListe: ComposantListe,
          NumSerieListe: NumSerieListe,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Materiel").modal("show");
          $("#add-MaterielForm").trigger("reset");
          view_Materiel_record();
        },
      });
    }
    $(document).on("click", "#btn-close-add-materiel", function () {
      $("#add-MaterielForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}
/*
*/
//display materiel record
function view_Materiel_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/materiel-agence.php"){
  $.ajax({
    url: "viewMateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Materiel-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function get_materiel_record() {
  $(document).on("click", "#btn-edit-materiel", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idmateriel").val(data[0]);
        $("#up_materielNserie").val(data[1]);
        $("#up_materielEtat").val(data[2]);
        $("#updateMaterielAgence").modal("show");
      },
    });
  });
}

function get_materielstock_record() {
  $(document).on("click", "#btn-edit-materiel-stock", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idMaterielstock").val(data[0]);
        $("#up_EtatMaterielstock").val(data[2]);
        $("#Registration-Materiel-stock").modal("show");
      },
    });
  });
}

// //update materiel
function update_materiel_record() {
  $(document).on("click", "#btn_updated_materiel_agence", function () {
    $("#updateMaterielAgence").scrollTop(0);
    var updateMaterielId = $("#up_idmateriel").val();
    var up_materielEtat = $("#up_materielEtat").val();
    var updateMaterielNumSerie = $("#up_materielNserie").val();
    if (
      updateMaterielNumSerie == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "update_materiel.php",
        method: "post",
        data: {
          updateMaterielId: updateMaterielId,
          up_materielEtat: up_materielEtat,
          updateMaterielNumSerie: updateMaterielNumSerie
        },
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le Materiel est modifié avec succès");
          $("#updateMaterielAgence").modal("show");
          view_Materiel_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#MaterielForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function delete_materiel_record() {
  $(document).on("click", "#btn-delete-materiel", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteMateriel").modal("show");
    $(document).on("click", "#btn_delete_materiel_agence", function () {
      $.ajax({
        url: "delete_materiel.php",
        method: "post",
        data: {
          Del_ID: Delete_ID
        },
        success: function (data) {
          $("#delete_messagec").addClass("alert alert-success").html(data);
          $("#deleteMateriel").modal("toggle");
          view_Materiel_record();
          setTimeout(function () {
            if ($("#delete_messagec").length > 0) {
              $("#delete_messagec").remove();
            }
          }, 3000);
        },
      });
    });
  });
}
// Afficher voitures
/*
*/
function view_voiture_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/vehicule.php"){
  $.ajax({
    url: "viewvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_voiture_vendue_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/vehicule-Vendue.php"){
  $.ajax({
    url: "viewvoiturevendue.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list-vendue").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_voiture_HS_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/vehicule-HS.php"){
  $.ajax({
    url: "viewvoitureHS.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list-HS").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
/*<
*/
//Ajouter voitures in the data base
function insert_voiture_Record() {
  $(document).on("click", "#btn-register-voiture", function () {
    $("#Registration-Voiture").scrollTop(0);
    var type = $("#Voituretype").val();
    var pimm = $("#Voiturepimm").val();
    var marqueModele = $("#voitureMarqueModel").val();
    var fournisseur = $("#Voiturefournisseur").val();
    var km = $("#Voiturekm").val();
    var date_achat = $("#Voituredate_achat").val();
    var dispo = "OUI";
    var date_immatriculation = $("#date_immatriculation").val();
    var date_DPC_VGP = $("#date_DPC_VGP").val();
    var date_DPC_VT = $("#date_DPC_VT").val();
    var date_DPT_Pollution = $("#date_DPT_Pollution").val();
    var carte_grise = $("#carte_grise").prop("files")[0];
    var carte_verte = $("#carte_verte").prop("files")[0];
    var etat_voiture = "Disponible";
    var voitureAgence = $("#voitureAgence").val();
    if (
      type == null ||
      pimm == "" ||
      marqueModele == "" ||
      km == "" ||
      voitureAgence == null ||
      carte_grise == null ||
      marqueModele == null ||
      carte_verte == null
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("type", type);
      form_data.append("pimm", pimm);
      form_data.append("marqueModele", marqueModele);
      form_data.append("fournisseur", fournisseur);
      form_data.append("km", km);
      form_data.append("date_achat", date_achat);
      form_data.append("dispo", dispo);
      form_data.append("date_immatriculation", date_immatriculation);
      form_data.append("date_DPC_VGP", date_DPC_VGP);
      form_data.append("date_DPC_VT", date_DPC_VT);
      form_data.append("date_DPT_Pollution", date_DPT_Pollution);
      form_data.append("carte_grise", carte_grise);
      form_data.append("carte_verte", carte_verte);
      form_data.append("etat_voiture", etat_voiture);
      form_data.append("voitureAgence", voitureAgence);
      $.ajax({
        url: "AjoutVoiture.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture").modal("show");
          } else {
            $("#message").addClass("alert alert-success").html(data);
            $("#Registration-Voiture").modal("show");
            $("#addvoitureForm").trigger("reset");
            view_voiture_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoitureForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function insert_voiture_vendue_Record() {
  $(document).on("click", "#btn-register-voiture-vendue", function () {
    $("#Registration-Voiture-Vendue").scrollTop(0);
    var voitureMarqueModel = $("#voitureMarqueModel").val();
    var Voituredate_vendue = $("#Voituredate_vendue").val();
    var VoitureCommentaire = $("#VoitureCommentaire").val();
    if (
      voitureMarqueModel == "" ||
      Voituredate_vendue == "" ||
      VoitureCommentaire == ""
    ) {
      $("#message-VV")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("voitureMarqueModel", voitureMarqueModel);
      form_data.append("Voituredate_vendue", Voituredate_vendue);
      form_data.append("VoitureCommentaire", VoitureCommentaire);
      $.ajax({
        url: "AjoutVoitureVendue.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message-VV")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture-Vendue").modal("show");
          } else {
            $("#message-VV").addClass("alert alert-success").html(data);
            $("#Registration-Voiture-Vendue").modal("show");
            $("#addvoiturevoitureForm").trigger("reset");
            view_voiture_vendue_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoiturevoitureForm").trigger("reset");
      $("#message-VV").html("");
      $("#message-VV").removeClass("alert alert-danger");
      $("#message-VV").removeClass("alert alert-sucess");
    });
  });
}

function insert_voiture_HS_Record() {
  $(document).on("click", "#btn-register-voiture-HS", function () {
    $("#Registration-Voiture-HS").scrollTop(0);
    var voitureIDHS = $("#voitureIDHS").val();
    var Voituredate_HS = $("#Voituredate_HS").val();
    var VoitureCommentaire = $("#VoitureCommentaire").val();
    if (
      voitureIDHS == "" ||
      Voituredate_HS == "" ||
      VoitureCommentaire == ""
    ) {
      $("#message-HS")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("voitureIDHS", voitureIDHS);
      form_data.append("Voituredate_HS", Voituredate_HS);
      form_data.append("VoitureCommentaire", VoitureCommentaire);
      $.ajax({
        url: "AjoutVoitureHS.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message-HS")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture-HS").modal("show");
          } else {
            $("#message-HS").addClass("alert alert-success").html(data);
            $("#Registration-Voiture-HS").modal("show");
            $("#addvoitureHSForm").trigger("reset");
            view_voiture_HS_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoitureHSForm").trigger("reset");
      $("#message-HS").html("");
      $("#message-HS").removeClass("alert alert-danger");
      $("#message-HS").removeClass("alert alert-sucess");
    });
  });
}
//supprimer voiture
function delete_voiture_record() {
  $(document).on("click", "#btn-delete-voiture", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteVoiture").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "DeleteVoiture.php",
        method: "post",
        data: {
          id_voiture: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteVoiture").modal("toggle");
          view_voiture_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
// get particuler client record
function get_voiture_record() {
  $(document).on("click", "#btn-edit-voiture", function () {
    var ID = $(this).attr("data-id"); 
    $.ajax({
      url: "get_voiture_data.php",
      method: "post",
      data: {
        id_voiture: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Up_Voitureid").val(data[0]);
        $("#up_voitureType").val(data[1]);
        $("#up_voiturePimm").val(data[2]);
        $("#up_voiturefournisseur").val(data[5]);
        $("#up_voiturekm").val(data[6]);
        $("#up_voituredate_achat").val(data[7]);
        $("#up_voitureMarqueModel").val(data[9]);
        $("#up_date_immatriculation").val(data[10]);
        $("#up_date_DPC_VGP").val(data[11]);
        $("#up_date_DPT_Pollution").val(data[12]);
        $("#up_etat_voiture").val(data[13]);
        $("#up_voitureAgence").val(data[14]);
        $("#up_date_DPC_VT").val(data[15]);
        $("#updateVoiture").modal("show");
      },
    });
  });
}
// get particuler client record
function get_voiture_vendue_record() {
  $(document).on("click", "#btn-edit-voiture-vendue", function () {
    var ID = $(this).attr("data-id");
    console.log(ID);
    $.ajax({
      url: "get_voiture_vendue_data.php",
      method: "post",
      data: {
        id_voitureH: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Up_VoitureVendueid").val(data[0]);
        $("#Up_Voituredate_vendue").val(data[1]);
        $("#Up_VoitureCommentaire").val(data[2]);
        $("#updateVoitureVendue").modal("show");
      },
    });
  });
}
// get particuler client record
function get_voiture_HS_record() {
  $(document).on("click", "#btn-edit-voiture-HS", function () {
    var ID = $(this).attr("data-id");
    console.log(ID);
    $.ajax({
      url: "get_voiture_HS_data.php",
      method: "post",
      data: {
        id_voitureH: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Up_VoitureHSid").val(data[0]);
        $("#Up_VHSid").val(data[1]);
        $("#Up_Voituredate_HS").val(data[2]);
        $("#Up_VoitureCommentaire").val(data[3]);
        $("#up_VoitureHS").val(data[4]);
        $("#updateVoitureHS").modal("show");
      },
    });
  });
}
// Update Record
function update_voiture_record() {
  $(document).on("click", "#btn_update_voiture", function () {
    $("#updateVoiture").scrollTop(0);
    var UpdateID = $("#Up_Voitureid").val();
    var upvoitureType = $("#up_voitureType").val();
    var upvoiturePimm = $("#up_voiturePimm").val();
    var upvoitureModeleMarque = $("#up_voitureMarqueModel").val();
    var upvoiturefournisseur = $("#up_voiturefournisseur").val();
    var upvoiturekm = $("#up_voiturekm").val();
    var upvoituredate_achat = $("#up_voituredate_achat").val();
    var upvoituredispo = 'OUI';
    var up_date_immatriculation = $("#up_date_immatriculation").val();
    var up_date_DPC_VGP = $("#up_date_DPC_VGP").val();
    var up_date_DPT_Pollution = $("#up_date_DPT_Pollution").val();
    var up_etat_voiture = $("#up_etat_voiture").val();
    var up_voitureAgence = $("#up_voitureAgence").val();
    var up_date_DPC_VT = $("#up_date_DPC_VT").val();
    if (
      upvoitureType == "" ||
      upvoiturePimm == "" ||
      upvoitureModeleMarque == "" ||
      upvoiturekm == "" ||
      upvoituredispo == ""
    ) {
      $("#up_message").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoiture").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoiture.php",
        method: "POST",
        data: {
          id_voiture: UpdateID,
          type: upvoitureType,
          pimm: upvoiturePimm,
          marquemodele: upvoitureModeleMarque,
          fournisseur: upvoiturefournisseur,
          km: upvoiturekm,
          date_achat: upvoituredate_achat,
          dispo: upvoituredispo,
          up_date_immatriculation: up_date_immatriculation,
          up_date_DPC_VGP: up_date_DPC_VGP,
          up_date_DPT_Pollution: up_date_DPT_Pollution,
          up_etat_voiture: up_etat_voiture,
          up_voitureAgence: up_voitureAgence,
          up_date_DPC_VT: up_date_DPC_VT,
        },
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#upvoitureForm").modal("show");
          view_voiture_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}
// Update Record
function update_voiture_vendue_record() {
  $(document).on("click", "#btn_update_voiture_vendue", function () {
    $("#updateVoitureVendue").scrollTop(0);
    var UpdateID = $("#Up_VoitureVendueid").val();
    var Up_Voituredate_vendue = $("#Up_Voituredate_vendue").val();
    var Up_VoitureCommentaire = $("#Up_VoitureCommentaire").val();
    if (
      Up_VoitureCommentaire == ""
    ) {
      $("#up_message_vendue").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoitureVendue").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoitureVendue.php",
        method: "POST",
        data: {
          id_voiture_vendue: UpdateID,
          Up_Voituredate_vendue: Up_Voituredate_vendue,
          Up_VoitureCommentaire: Up_VoitureCommentaire,
        },
        success: function () {
          $("#up_message_vendue")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updateVoitureVendue").modal("show");
          view_voiture_vendue_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voiturevendueForm").trigger("reset");
      $("#up_message_vendue").html("");
      $("#up_message_vendue").removeClass("alert alert-danger");
      $("#up_message_vendue").removeClass("alert alert-sucess");
    });
  });
}
// Update Record
function update_voiture_HS_record() {
  $(document).on("click", "#btn_update_voiture_HS", function () {
    $("#updateVoitureHS").scrollTop(0);
    var UpdateID = $("#Up_VoitureHSid").val();
    var Up_Voituredate_HS = $("#Up_Voituredate_HS").val();
    var Up_VoitureCommentaire = $("#Up_VoitureCommentaire").val();
    var up_VoitureHS = $("#up_VoitureHS").val();
    var Up_VHSid = $("#Up_VHSid").val();
    if (
      Up_VoitureCommentaire == ""
    ) {
      $("#up_message_HS").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoitureHS").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoitureHS.php",
        method: "POST",
        data: {
          id_voiture_HS: UpdateID,
          Up_Voituredate_HS: Up_Voituredate_HS,
          Up_VoitureCommentaire: Up_VoitureCommentaire,
          up_VoitureHS: up_VoitureHS,
          Up_VHSid: Up_VHSid,
        },
        success: function () {
          $("#up_message_HS")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updateVoitureHS").modal("show");
          view_voiture_HS_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureHSForm").trigger("reset");
      $("#up_message_HS").html("");
      $("#up_message_HS").removeClass("alert alert-danger");
      $("#up_message_HS").removeClass("alert alert-sucess");
    });
  });
}

function insertEntretienRecord() {
  $(document).on("click", "#btn-register-Entretien", function () {
    $("#Registration-Entretien").scrollTop(0);
    var ObjetEntretien = $("#ObjetEntretien").val();
    var LieuEntretien = $("#LieuEntretien").val();
    var CoutEntretien = $("#CoutEntretien").val();
    var Entretiendate = $("#Entretiendate").val();
    var EntretienFindate = $("#EntretienFindate").val();
    var ProchaineEntretiendate = $("#ProchaineEntretiendate").val();
    var EntretienCommentaire = $("#EntretienCommentaire").val();
    var EntretienType = $("#EntretienType").val();
    var EntretienModelVoiture = $("#EntretienModelVoiture").val();
    var EntretienDateAchatVoiture = $("#EntretienNomMateriel").val();
    var EntretienNomMateriel = $("#EntretienNomMateriel").val();
    if (EntretienType == "" || EntretienFindate == "" || Entretiendate == "") {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (Entretiendate > EntretienFindate) {
      $("#message")
        .addClass("alert alert-danger")
        .html(" La date de début ne peut pas être postérieure à la date de fin!");
    } else {
      $.ajax({
        url: "AjoutEntretien.php",
        method: "post",
        data: {
          EntretienType: EntretienType,
          Entretiendate: Entretiendate,
          EntretienCommentaire: EntretienCommentaire,
          EntretienModelVoiture: EntretienModelVoiture,
          ObjetEntretien: ObjetEntretien,
          LieuEntretien: LieuEntretien,
          CoutEntretien: CoutEntretien,
          EntretienFindate: EntretienFindate,
          ProchaineEntretiendate: ProchaineEntretiendate,
          EntretienDateAchatVoiture: EntretienDateAchatVoiture,
          EntretienNomMateriel: EntretienNomMateriel,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Entretien").modal("show");
          $("#EntretienForm").trigger("reset");
          view_Entretien_record_materiel();
          view_Entretien_record();
          load_unseen_notification_entretien();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#EntretienForm").trigger("reset");
      $("#Registration-Entretien").modal("show");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_Entretien_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/entretien.php"){
  $.ajax({
    url: "viewentretien.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_Entretien_record_materiel() {
  $(document).ready(function () {
  if(location.pathname=="/location/entretien-materiel.php"){
  $.ajax({
    url: "viewentretienmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list-Materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_Entretien_record_voiture() {
  $(document).ready(function () {
  if(location.pathname=="/location/entretien-voiture.php"){
  $.ajax({
    url: "viewentretienvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list-voiture").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function get_Entretien_record() {
  $(document).on("click", "#btn-edit-Entretien", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_entretien_data.php",
      method: "post",
      data: {
        EntretienID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_identretien").val(data[0]);
        $("#up_EntretienType").val(data[1]);
        $("#up_Entretiendate").val(data[2]);
        $("#up_EntretienCommentaire").val(data[3]);
        $("#up_EntretienIdVoiture").val(data[5]);
        $("#up_ObjetEntretien").val(data[7]);
        $("#up_LieuEntretien").val(data[8]);
        $("#up_CoutEntretien").val(data[9]);
        $("#up_EntretiendateFin").val(data[10]);
        $("#up_ProchaineEntretien").val(data[11]);
        $("#updateEntretien").modal("show");
      },
    });
  });
}

function update_entretien_record() {
  $(document).on("click", "#btn_updated_Entretien", function () {
    var updateEntretienId = $("#up_identretien").val();
    var updateEntretienDate = $("#up_Entretiendate").val();
    var updateEntretienCommentaire = $("#up_EntretienCommentaire").val();
    var up_EntretienIdVoiture = $("#up_EntretienIdVoiture").val();
    var up_ObjetEntretien = $("#up_ObjetEntretien").val();
    var up_LieuEntretien = $("#up_LieuEntretien").val();
    var up_CoutEntretien = $("#up_CoutEntretien").val();
    var up_EntretiendateFin = $("#up_EntretiendateFin").val();
    var up_ProchaineEntretien = $("#up_ProchaineEntretien").val();
    var up_VoitureEntretien = $("#up_VoitureEntretien").val();
    if (updateEntretienDate == "") {
      $("#up-message").html("please fill in the blanks");
      $("#updateEntretien").modal("show");
    } else {
      $.ajax({
        url: "update_entretien.php",
        method: "post",
        data: {
          up_dateEntretienId: updateEntretienId,
          up_dateEntretienDate: updateEntretienDate,
          up_dateEntretienCommentaire: updateEntretienCommentaire,
          up_EntretienIdVoiture: up_EntretienIdVoiture,
          up_ObjetEntretien: up_ObjetEntretien,
          up_LieuEntretien: up_LieuEntretien,
          up_CoutEntretien: up_CoutEntretien,
          up_EntretiendateFin: up_EntretiendateFin,
          up_ProchaineEntretien: up_ProchaineEntretien,
          up_VoitureEntretien: up_VoitureEntretien,
        },
        success: function (data) {
          $("#up_message").addClass("alert alert-success").html(data);
          $("#updateEntretien").modal("show");
          view_Entretien_record();
          view_Entretien_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close-up", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}
//supprimer entretien
function delete_entretien_record() {
  $(document).on("click", "#btn-delete-Entretien", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteEntretien").modal("show");
    $(document).on("click", "#btn_delete_Entretien", function () {
      $.ajax({
        url: "DeleteEntretien.php",
        method: "post",
        data: {
          id_entretien: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteEntretien").modal("toggle");
          view_Entretien_record_materiel();
          view_Entretien_record();
          load_unseen_notification_entretien();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
//Afficher les factures 
function view_facture_contrat_voiture() {
  $(document).ready(function () {
  if(location.pathname=="/location/facture-contart-voiture.php"){
  $.ajax({
    url: "viewfacturecontratvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-voiture").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
function view_facture_contrat_materiel() {
  $(document).ready(function () {
  if(location.pathname=="/location/facture-contart-materiel.php"){
  $.ajax({
    url: "viewfacturecontratmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-materiel").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
function view_facture_contrat_pack() {
  $(document).ready(function () {
  if(location.pathname=="/location/facture-contart-pack.php"){
  $.ajax({
    url: "viewfacturecontratpack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-pack").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
//add id facture
function genereridfacturevoiture() {
  $(document).on("click", "#btn-id-client-facture", function () {
  var idFactureVoiture = $(this).attr("data-id4");
  window.open("http://localhost/location/fpdf/facture_client.php?id="+idFactureVoiture ,'_blank');
});
}

function genereridfacturemateriel() {
  $(document).on("click", "#btn-id-client-facture-materiel", function () {
    var idFactureMateriel = $(this).attr("data-id4");
    window.open("http://localhost/location/fpdf/facture_materiel_client.php?id="+idFactureMateriel ,'_blank');
  });
}
function genereridfacturepack() {
  $(document).on("click", "#btn-id-client-facture-pack", function () {
    var idFacturePack = $(this).attr("data-id4");
    window.open("http://localhost/location/fpdf/facture_pack_client.php?id="+idFacturePack ,'_blank');
  });
}
// Devis
function genereriddevis() {
  $(document).on("click", "#btn-id-client-devis", function () {
    var idDevis = $(this).attr("data-id2");
    window.open("http://localhost/location/fpdf/devis.php?id="+idDevis ,'_blank');
});
}
// Afficher contrats
function view_contrat_record_materiel() {
  $(document).ready(function () {
  if(location.pathname=="/location/contart-materiel.php"){
  $.ajax({
    url: "viewcontratmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-materiel").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_record_voiture() {
  $(document).ready(function () {
  if(location.pathname=="/location/contart-voiture.php"){
  $.ajax({
    url: "viewcontratvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-voiture").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_archivage_record_voiture() {
  $(document).ready(function () {
  if(location.pathname=="/location/archivage-contart-voiture.php"){
  $.ajax({
    url: "viewcontratarchivagevoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-voiture-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_archivage_record_materiel() {
  $(document).ready(function () {
  if(location.pathname=="/location/archivage-contart-materiel.php"){
  $.ajax({
    url: "viewcontratarchivagemateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-materiel-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_archivage_record_pack() {
  $(document).ready(function () {
  if(location.pathname=="/location/archivage-contart-pack.php"){
  $.ajax({
    url: "viewcontratarchivagepack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-pack-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_record_pack() {
  $(document).ready(function () {
  if(location.pathname=="/location/contart-pack.php"){
  $.ajax({
    url: "viewcontratpack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-pack").html(data.html);
          //  load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
//add contrats in the data base
function insertContratVoitureRecord() {
  $(document).on("click", "#btn-register-contrat-voiture", function () {
    $("#Registration-Contrat-Voiture").scrollTop(0);
    // var ContratDate = $("#DateContrat").val();
    var TypeContrat = 'Vehicule';
    var ContratDuree = $("#dureeContrat").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContrat").val();
    var ContratAssurence = $("#AssuranceContrat").val();
    var ContratPaiement = $("#ModePaiementContrat").val();
    var ContratDatePaiement = $("#DatePrelevementContrat").val();
    var Contrat_voiture = $("#list_materiel").val();
    var ContratClient = $("#ClientContrat").val();
    var AgenceDepClient = $("#ClientAgenceDep").val();
    var AgenceRetClient = $("#ClientAgenceRet").val();
    var ContratCaution = $("#CautionContrat").val();
    var ContratNumCaution = $("#numCaution").val();
    console.log(ContratDuree);
    if (
      ContratDuree == ""
    ) {
      $("#messagevoiture")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#messagevoiture")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "AjoutContratVoiture.php",
        method: "post",
        data: {
          // ContratDate: ContratDate,
          TypeContrat: TypeContrat,
          ContratDuree: ContratDuree,
          ContratDateDebut: ContratDateDebut,
          ContratDateFin: ContratDateFin,
          ContratAssurence: ContratAssurence,
          ContratPrixContrat: ContratPrixContrat,
          ContratPaiement: ContratPaiement,
          ContratDatePaiement: ContratDatePaiement,
          Contrat_voiture: Contrat_voiture,
          ContratClient: ContratClient,
          AgenceDepClient: AgenceDepClient,
          AgenceRetClient: AgenceRetClient,
          ContratCaution: ContratCaution,
          ContratNumCaution: ContratNumCaution,
        },
        success: function (data) {
          $("#messagevoiture").addClass("alert alert-success").html(data);
          $("#contratvoitureForm").trigger("reset");
          view_contrat_record_materiel();
          view_contrat_record_voiture();
          load_unseen_notification();
          load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratvoitureForm").trigger("reset");
      $("#messagevoiture").html("");
      $("#messagevoiture").removeClass("alert alert-danger");
      $("#messagevoiture").removeClass("alert alert-sucess");
    });

  });
}

//add contrats in the data base

function insertContratMaterielRecord() {
  $(document).on("click", "#btn-register-contrat", function () {
    $("#Registration-Contrat").scrollTop(0);
    // var ContratDate = $("#DateContrat").val();
    var ContratNum = $("#NumContrat").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContrat").val();
    var ContratPaiement = $("#ModePaiementContrat").val();
    var ContratDatePaiement = $("#DatePrelevementContrat").val();
    var ContratVoitureModel = $("#VoitureModele").val();
    var ContratVoiturePIMM = $("#VoiturePimm").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevu").val();
    var ContratClient = $("#ClientContrat").val();
    var AgenceDepClient = $("#ClientAgenceDep").val();
    var AgenceRetClient = $("#ClientAgenceRet").val();
    var ContratCaution = $("#CautionContrat").val();
    var ContratNumCaution = $("#numCautionMateriel").val();
    var ContratNumCautionMateriel = $("#numCautionMateriel").val();
    var ContratDuree = $("#dureeContrat").val();
    var Id_materiel = $("#list_materiel").val();
    console.log(ContratDuree);
    if (
      ContratDateDebut == "" ||
      ContratDateFin == "" ||
      ContratPrixContrat == "" ||
      ContratPaiement == "" ||
      ContratDate == "" ||
      Id_materiel == "" ||
      ContratDuree == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "AjoutContratMateriel.php",
        method: "post",
        data: {
          // ContratDate: ContratDate,
          ContratNum: ContratNum,
          ContratDateDebut: ContratDateDebut,
          ContratDateFin: ContratDateFin,
          ContratPrixContrat: ContratPrixContrat,
          ContratPaiement: ContratPaiement,
          ContratDatePaiement: ContratDatePaiement,
          ContratVoitureModel: ContratVoitureModel,
          ContratVoiturePIMM: ContratVoiturePIMM,
          ContratVoiturekMPrevu: ContratVoiturekMPrevu,
          ContratClient: ContratClient,
          AgenceDepClient: AgenceDepClient,
          AgenceRetClient: AgenceRetClient,
          ContratCaution: ContratCaution,
          ContratNumCaution: ContratNumCaution,
          ContratNumCautionMateriel: ContratNumCautionMateriel,
          ContratDuree: ContratDuree,
          Id_materiel: Id_materiel,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat").modal("show");
          $("#contratForm").trigger("reset");
          view_contrat_record_materiel();
          view_contrat_record_voiture();
          load_unseen_notification();
          load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}



function get_Contrat_record() {
  $(document).on("click", "#btn-edit-contrat-voiture", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_contrat_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateContratFin").val(data[1]);
        //$("#up_Contratde").val(data[4]);
        $("#up_ContratType").val(data[2]);
        // $("#up_DateDebutContrat").val(data[3]);
        $("#up_DateContratDebut").val(data[3]);
        $("#up_PrixContrat").val(data[5]);
        // $("#up_AssuranceContrat").val(data[6]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_Caution").val(data[8]);
        $("#up_CautionMateriel").val(data[8]);
        $("#up_DatePrelevementContrat").val(data[9]);
        $("#up_dureeContrat").val(data[10]);
        // $("#up_VoitureKMPrevu").val(data[11]);
        $("#up_numCaution").val(data[12]);
        $("#up_numCautionMateriel").val(data[13]);
        // console.log($("#up_ModePaiementContrat").val(data[7]));
        $("#update-Contrat-Voiture").modal("show");
        view_contrat_record_materiel();
        view_contrat_record_voiture();
      },
    });
  });
}

function get_Contrat_Materiel_record() {
  $(document).on("click", "#btn-edit-contrat-materiel", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_contrat_materiel_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateContratFin").val(data[1]);
        $("#up_ContratType").val(data[2]);
        $("#up_DateContratDebut").val(data[3]);
        // $("#up_DateDebutContrat").val(data[3]);
        // $("#up_DateFinContrat").val(data[4]);
        $("#up_PrixContrat").val(data[5]);
        // $("#up_AssuranceContrat").val(data[6]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_Caution").val(data[8]);
        $("#up_CautionMateriel").val(data[8]);
        $("#up_DatePrelevementContrat").val(data[9]);
        $("#up_dureeContrat").val(data[10]);
        // $("#up_VoitureKMPrevu").val(data[11]);
        $("#up_numCaution").val(data[12]);
        // $("#up_numCautionMateriel").val(data[13]);
        // console.log($("#up_ModePaiementContrat").val(data[7]));
        $("#update-Contrat-Materiel").modal("show");
        view_contrat_record_materiel();
        //   view_contrat_record_voiture();
      },
    });
  });
}


function get_Contrat_Pack_record() {
  $(document).on("click", "#btn-edit-contrat-pack", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_contrat_pack_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateContratDebut").val(data[1]);
        $("#up_DateContratFin").val(data[2]);
        $("#up_dureeContrat").val(data[3]);
        $("#up_PrixContrat").val(data[4]);
        $("#up_Caution").val(data[5]);
        $("#up_numCautionMateriel").val(data[6]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_DatePrelevementContrat").val(data[8]);
        $("#update-Contrat-pack").modal("show");
        view_contrat_record_pack();
        //   view_contrat_record_voiture();
      },
    });
  });
}




function update_contrat_record() {
  $(document).on("click", "#btn_updated_Contrat_Voiture", function () {
    $("#update-Contrat-Voiture").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateContratDebut").val();
    var up_DateContratFin = $("#up_DateContratFin").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratType = $("#up_ContratType").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratPaiement = $("#up_ModePaiementContrat").val();
    var updateContratnumCaution = $("#up_numCaution").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratPrix == "" ||
      updateContratType == ""
    ) {
      $("#up_message_voiture")
      .addClass("alert alert-danger")
      .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Voiture").modal("show");

    } else {
      $.ajax({
        url: "update_contrat.php",
        method: "post",
        data: {
          up_contraId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratType: updateContratType,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          up_contratCaution: updateContratCaution,
          updateContratnumCaution: updateContratnumCaution,
        },
        success: function (data) {
          $("#up_message_voiture").addClass("alert alert-success").html(data);
          $("#update-Contrat-Voiture").modal("show");
          view_contrat_record_voiture();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_voiture").html("");
      $("#up_message_voiture").removeClass("alert alert-danger");
      $("#up_message_voiture").removeClass("alert alert-sucess");
    });
  });
}


/*
 * update_contrat_record
 * 
 */
function update_contrat_materiel_record() {
  $(document).on("click", "#btn_updated_Contrat_Materiel", function () {
    $("#update-Contrat-Materiel").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateContratDebut").val();
    var up_DateContratFin = $("#up_DateContratFin").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratPaiement = $("#up_ModePaiementContrat").val();
    var updateContratnumCaution = $("#up_numCaution").val();
    var upDatePrelevementContrat = $("#up_DatePrelevementContrat").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratPrix == ""
    ) {
      $("#up_message_materiel").addClass("alert alert-danger")
      .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Materiel").modal("show");

    } else {
      $.ajax({
        url: "update_contrat_materiel.php",
        method: "post",
        data: {
          updateContratId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          up_contratCaution: updateContratCaution,
          updateContratnumCaution: updateContratnumCaution,
          up_DatePrelevementContrat: upDatePrelevementContrat,
        },
        success: function (data) {
          $("#up_message_materiel").addClass("alert alert-success").html(data);
          $("#update-Contrat-Materiel").modal("show");
          view_contrat_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_materiel").html("");
      $("#up_message_materiel").removeClass("alert alert-danger");
      $("#up_message_materiel").removeClass("alert alert-sucess");
    });
  });
}



function update_contrat_pack_record() {
  $(document).on("click", "#btn_updated_Contrat_Pack", function () {
    $("#update-Contrat-Pack").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateContratDebut").val();
    var up_DateContratFin = $("#up_DateContratFin").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratPaiement = $("#up_numCautionMateriel").val();
    var updateContratnumCaution = $("#up_ModePaiementContrat").val();
    var upDatePrelevementContrat = $("#up_DatePrelevementContrat").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratPrix == ""
    ) {
      $("#up_message_pack").addClass("alert alert-danger")
      .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Pack").modal("show");

    } else {
      $.ajax({
        url: "update_contrat_pack.php",
        method: "post",
        data: {
          updateContratId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          up_contratCaution: updateContratCaution,
          updateContratnumCaution: updateContratnumCaution,
          up_DatePrelevementContrat: upDatePrelevementContrat,
        },
        success: function (data) {
          $("#up_message_pack").addClass("alert alert-success").html(data);
          $("#update-Contrat-Pack").modal("show");
          view_contrat_record_pack(); 
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_pack").html("");
      $("#up_message_pack").removeClass("alert alert-danger");
      $("#up_message_pack").removeClass("alert alert-sucess");
    });
  });
}
/*
 * 
 * 
 */

function delete_contrat_record() {
  $(document).on("click", "#btn-delete-contrat-voiture", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContrat").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteContrat").modal("toggle");
          view_contrat_record_voiture();
          view_contrat_record_materiel();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
/** */
function delete_contrat_record_materiel() {
  $(document).on("click", "#btn-delete-contrat-materiel", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteContrat").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message_materiel").addClass("alert alert-success").html(data);
          $("#deleteContrat").modal("toggle");
          view_contrat_record_materiel();
          setTimeout(function () {
            if ($("#delete_message_materiel").length > 0) {
              $("#delete_message_materiel").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
/**
/** */
function delete_contrat_record_pack() {
  $(document).on("click", "#btn-delete-contrat-pack", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContratPack").modal("show");
    $(document).on("click", "#btn_delete_pack", function () {
      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#up_message_pack").addClass("alert alert-success").html(data);
          $("#deleteContratPack").modal("toggle");
          view_contrat_record_pack();  
          setTimeout(function () {
            if ($("#up_message_pack").length > 0) {
              $("#up_message_pack").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
/**
 * 
 */
function showPDFModel() {
  $(document).on("click", "#btn-show-contrat-voiture", function () {
    var ID = $(this).attr("data-id2");
    $.ajax({
      url: "selectContratVoiture.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[18]);
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }
        $("#Client-mail").text(data[2]);
        console.log(data[3]);
        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Voiture-Category").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Voiture-PIMM").text(data[7]);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        $("#Num-cheque-caution").text(data[17]);
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        $("#Contrat-Caution").text(data[12]);
        var date = new Date(data[15]);
        var day = date.getDate();
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }
        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        $("#PDF-Voiture-modal").modal("show");
      },
    });
  });
}

function get_id_client() {
  $(document).on("click", "#btn-id-client", function () {
    var ID = $(this).attr("data-id3");
    window.open("http://localhost/location/fpdf/ContratVehicule.php?id="+ID ,'_blank');
});
}
/**
 */
function showPDFModel_materiel() {
  $(document).on("click", "#btn-show-contrat-materiel", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "selectContratMateriel.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[1]);
        $("#Client-mail").text(data[2]);
        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Contrat-Designation").text(data[5]);
        $("#Contrat-numero").text(data[6]);
        $("#Composant-Designation").text(data[7]);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        $("#Contrat-Mode-Paiement").text(data[11]);
        $("#Contrat-Caution").text(data[12]);
        $("#Contrat-Date").text(data[13]);
        $("#Composant-numero").text(data[14]);
        $("#Contrat-Date-Prelevement").text(data[15]);
        $("#Num-cheque-caution").text(data[16]);
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        $("#Contrat-Caution").text(data[12]);
        var date = new Date(data[15]);
        var day = date.getDate();
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }
        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        $("#PDF-Materie-modal").modal("show");
      },
    });
  });
}
// get id client
function get_id_client_contrat_materiel() {
  $(document).on("click", "#btn-id-client-materiel", function () {
    var id_contrat_materiel = $(this).attr("data-id5");
    window.open("http://localhost/location/fpdf/ContratMateriel.php?id="+id_contrat_materiel ,'_blank');
  });
}
/**
 */
function showPDFPackModel() {
  $(document).on("click", "#btn-show-contrat-pack", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "selectContratPack.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[1]);
        $("#Client-mail").text(data[2]);
        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Voiture-PIMM").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Contrat-Date-Debut").text(data[7]);
        $("#Contrat-Date-Fin").text(data[8]);
        $("#Contrat-Prix").text(data[9]);
        $("#Contrat-prix-TTC").text(data[10]);
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Date-Prelevement").text(data[12]);
        $("#Contrat-Caution").text(data[13]);
        $("#Num-cheque-caution").text(data[15]);
        $("#Contrat-Date").text(data[17]);
        console.log(data[21]);
        var materielNamee = "<ul class ='list-unstyled'>";
        data[18].forEach((ee) => {
        materielNamee = materielNamee + `<li>${ee}</li>`;
        });
        materielNamee = materielNamee + "</ul>";
        $("#Materiel-Name").html(materielNamee);
        var SerialNumbers = "<ul class ='list-unstyled'>";
        data[19].forEach((ee) => {
        SerialNumbers = SerialNumbers + `<li>${ee}</li>`;
        });
        SerialNumbers = SerialNumbers + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumbers);
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }
        $("#PDF-Voiture-Pack-modal").modal("show");
      },
    });
  });
}
// get id client
function get_id_client_contrat_pack() {
  $(document).on("click", "#btn-id-client-pack", function () {
    var id_contrat_pack = $(this).attr("data-id3");
    window.open("http://localhost/location/fpdf/ContratPack.php?id="+id_contrat_pack ,'_blank');
  });
}

function closeImage() {
  $("#appear_image_div").remove();
}

function showPDFMaterielModel() {
  $(document).on("click", "#btn-show-contrat-materiel", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "selectContratMateriel.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-number").text(data[1]);
        $("#Client-Company").text(data[2]);
        $("#Client-Address").text(data[3]);
        $("#Client-Siret").text(data[4]);
        var numCautionMateriel = data[16];
        if (numCautionMateriel == null) {
          $("#Num-cheque-caution-materiel").text(" ");
        } else {
          $("#Num-cheque-caution-materiel").text(data[16]);
        }
        if (data[5] === "SOUDEUSES") {
          $("#changement-electrode").text("- Changement d'électrodes");
        } else {
          $("#changement-electrode").text(" ");
        }
        var materielName = "<ul class ='list-unstyled'>";
        data[6].forEach((e) => {
          materielName = materielName + `<li>${e}</li>`;
        });
        materielName = materielName + "</ul>";
        $("#Materiel-Name").html(materielName);
        var SerialNumber = "<ul class ='list-unstyled'>";
        data[7].forEach((e) => {
          SerialNumber = SerialNumber + `<li>${e}</li>`;
        });
        SerialNumber = SerialNumber + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumber);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        var date = new Date(data[14]);
        var day = date.getDate();
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        var duree = data[15];
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        }
        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        $("#PDF-Soudeuses-modal").modal("show");
      },
    });
  });
}
/*
 * searchAgence
 */
function searchAgence() {
  $("#searchAgence").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchAgence.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#agence-list").html(response);
      },
    });
  });
}
/*
 * searchUser
 */
function searchUser() {
  $("#searchUser").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchUser.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#user-list").html(response);
      },
    });
  });
}
/*
 *   searchClient
*/
function searchClient() {
  $("#searchClientA").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchClient.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#client-list").html(response);
      },
    });
  });
}
/*
 *  searchCategorie
 */
function searchCategorie() {
  $("#searchCategorie").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchCategorie.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Categorie-list").html(response);
      },
    });
  });
}
/*
 *  searchVoiture
*/
function searchVoiture() {
  $("#searchVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVehicule.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list").html(response);
      },
    });
  });
}
/*
 *  searchVoitureVendu
*/
function searchVoitureVendu() {
  $("#searchVoitureVendu").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoitureVendu.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list-vendue").html(response);
      },
    });
  });
}
/*
 *  searchVoitureVendu
*/
function searchVoitureHS() {
  $("#searchVoitureHS").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoitureHS.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list-HS").html(response);
      },
    });
  });
}
/*
 * end searchVoitureHS
*/
function searchGestionPack() {
  $("#searchGestionPack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchGestionPack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#group-pack-list").html(response);
      },
    });
  });
}
/*
 *  searchMaterielAgence
*/
function searchMaterielAgence() {
  $("#searchMaterielAgence").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Materiel-list").html(response);
      },
    });
  });
}
/*
 *  searchStock
*/
function searchStock() {
  $("#searchStock").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchStock.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#stock-list").html(response);
      },
    });
  });
}
/*
 *  searchStockMateriel  
*/
function searchStockMateriel() {
  $("#searchStockMateriels").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchStockMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (data) {
        try {
          data = $.parseJSON(data);
          if (data.status == "success") {
            $("#stock-list-materiel").html(data.html);
          }
        } catch (e) {
          console.error("Invalid Response!");
        }
      },
    });
  });
}
/*
 * end searchStockMateriel
*/
function searchContratVoiture() {
  $("#searchContratVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-voiture").html(response);
      },
    });
  });
}

function searchContratMateriel() {
  $("#searchContratMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-materiel").html(response);
      },
    });
  });
}

function searchContratPack() {
  $("#searchContratPack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratPack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-pack").html(response);
      },
    });
  });
}
/*
 * searchEntretiens
*/
function searchEntretiens() {
  $("#searchEntretiens").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretiens.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list").html(response);
      },
    });
  });
}
/*
 * end searchEntretiens
*/
function searchEntretienMateriel() {
  $("#searchEntretienMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretienMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list-Materiel").html(response);
      },
    });
  });
}

function searchEntretienVoiture() {
  $("#searchEntretienVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretienVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list-voiture").html(response);
      },
    });
  });
}

function searchContratVoitureArchivage() {
  $("#searchContratVoitureArchivage").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoitureArchivage.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-voiture-archivage").html(response);
      },
    });
  });
}

// search devis
function searchGestionDevis() {
  $("#searchGestionDevisid").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchGestionDevis.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#devis-list").html(response);
      },
    });
  });
}

// search facture
function searchFactureContratVoiture() {
  $("#searchFactureContratVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFactureContratVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-voiture").html(response);
      },
    });
  });
}

function searchFactureContratMateriel() {
  $("#searchFactureContratMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFactureContratMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-materiel").html(response);
      },
    });
  });
}

function searchFactureContratPack() {
  $("#searchFactureContratPack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFactureContratPack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-pack").html(response);
      },
    });
  });
}

// founction de notification de contrat
function load_unseen_notification(view = "") {
  $.ajax({
    url: "contratnotification.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-contrat").html(data.notification);
      if (data.unseen_notification > 0) {
        $("#count-contrat").html(data.unseen_notification);
      } else {
        $("#count-contrat").css("display", "none");
      }
    },
  });
}

function removeNotification() {
  $(document).on("click", "#toggle-contrat", function () {
    $("#count-contrat").html("0").css("display", "none");
    load_unseen_notification("yes");
  });
}

function removeNotification_entretien() {
  $(document).on("click", "#toggle-entretien", function () {
    $("#count-entretien").html("0").css("display", "none");
    load_unseen_notification_entretien("yes");
  });
}

function load_unseen_notification_entretien(view = "") {
  $.ajax({
    url: "contratnotificationEntretien.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-entretien").html(data.notification_entretien);
      if (data.unseen_notification_entretien > 0) {
        $("#count-entretien").html(data.unseen_notification_entretien);
      } else {
        $("#count-entretien").css("display", "none");
      }
    },
  });
}

function load_unseen_notification_paiement(view = "") {

  $.ajax({
    url: "contratnotificationPaiement.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-paiement").html(data.notification_paiement);
      if (data.unseen_notification_paiement > 0) {
        $("#count-paiement").html(data.unseen_notification_paiement);
      } else {
        $("#count-paiement").css("display", "none");
      }
    },
  });
}

function insertVoitureSettingRecord() {
  $(document).on("click", "#btn-Setting-Voiture", function () {
    var voitureMarque = $("#Setting_voitureMarque").val();
    var voitureModel = $("#Setting_voitureModele").val();
    if (voitureMarque == "" || voitureModel == "") {
      $("#message-setting")
        .addClass("text-danger")
        .html("Veuillez remplirdd tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutSettingVoiture.php",
        method: "post",
        data: {
          voitureMarque: voitureMarque,
          voitureModel: voitureModel,
        },
        success: function (data) {
          $("#message-setting").addClass("text-success").html(data);
          $("#Setting-Voiture").modal("show");
          $("#setting-voitureForm").trigger("reset");
          view_SettingVoitureRecord();
        },
      });
    }
  });

  $(document).on("click", "#btn-close-voiture_setting", function () {
    $("#setting-voitureForm").trigger("reset");
    $("#message-setting").remove();
  });
}

function view_SettingVoitureRecord() {
  $(document.location.url).ready(function () {
  $.ajax({
    url: "viewSettingVoiture.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSetting").html(data.html);
      }
    },
  });});
}

function view_SettingVoitureHSRecord() {
  $(document.location.url).ready(function () {
  $.ajax({
    url: "viewSettingVoitureHS.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSettingHS").html(data.html);
      }
    },
  });});
}

function view_SettingVoitureTransfRecord() {
  $(document.location.url).ready(function () {
  $.ajax({
    url: "viewSettingVoitureTransf.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSettingTransf").html(data.html);
      }
    },
  });});
}

function delete_SettingVoiturerecord() {
  $(document).on("click", "#btn_delete_marque", function () {
    var Delete_ID = $(this).attr("data-id6");
    $.ajax({
      url: "deleteSettingVoitur.php",
      method: "post",
      data: {
        Del_ID: Delete_ID
      },
      success: function (data) {
        view_SettingVoitureRecord();
      },
    });
  });
}

function view_contrat_archived() {
  $(document).ready(function () {
  if(location.pathname=="/location/archivage-contart-voiture.php"){
  $.ajax({
    url: "viewcontratArchivedVoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-archived").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function view_contrat_archived_materiel() {
  $(document).ready(function () {
  if(location.pathname=="/location/archivage-contart-materiel.php"){
  $.ajax({
    url: "viewcontratarchivagemateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-archived-materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function searchContratVoitureArchive() {
  $("#searchContratVoitureArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoitureArchive.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-archived").html(response);
      },
    });
  });
}

function searchContratMaterielArchive() {
  $("#searchContratMaterielArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratMaterielArchive.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-materiel-archivage").html(response);
      },
    });
  });
}

function searchContratPackArchive() {
  $("#searchContratPackArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratPackArchive.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-pack-archivage").html(response);
      },
    });
  });
}

function getValidateContratPaiement() {
  $(document).on("click", "#contrat-paiement", function () {
    var contrat_ID = $(this).attr("data-paiement");
    console.log(contrat_ID);
    $("#validatePaiementContrat").modal("show");
    $.ajax({
      url: "ValidateContratPaiement.php",
      method: "post",
      data: {
        contrat_ID: contrat_ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#validate-contrat-id").val(data[0]);
        $("#validatePaiementContrat").modal("show");
      },
    });
  });
}

function update_contrat_validate_record() {
  $(document).on("click", "#btn_validatePaiement", function () {
    var updateContratId = $("#validate-contrat-id").val();
    location.reload();
    $.ajax({
      url: "update_validate_paiement_contrat.php",
      method: "post",
      data: {
        updateContratId: updateContratId,
      },
      success: function (data) {
        location.reload();
      },
    });
  });
}
// view contrat record mixte
function view_contrat_record_mixte() {
  $(document).ready(function () {
  if(location.pathname=="/location/contart-pack.php"){
  $.ajax({
    url: "viewcontratMixte.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-mixte").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function insertContratMixteRecord() {
  $(document).on("click", "#btn-register-contrat-m1", function () {
    $("#Registration-Contrat-mixte").scrollTop(0);
    const selects = Array.from(
      document.querySelectorAll(".materiel-list-contrat-mixte")
    );
    const ContratmaterielListe = selects.map((select) => Number(select.value));
    // var ContratDate = $("#DateContratMixte").val();
    var ContratType = $("#TypeContratMixte").val();
    var ContratDateDebut = $("#DateDebutContratMixte").val();
    var ContratDateFin = $("#DateFinContratMixte").val();
    var ContratPrixContrat = $("#PrixContratMixte").val();
    // var ContratAssurence = $("#AssuranceContratMixte").val();
    var ContratPaiement = $("#ModePaiementContratMixte").val();
    var ContratDatePaiement = null;
    var ContratVoitureModel = $("#VoitureModeleMixte").val();
    var ContratVoiturePIMM = $("#VoiturePimmMixte").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevuMixte").val();
    var ContratVoiturekMPrevu = null;
    var ContratClient = $("#ClientContratMixte").val();
    var ContratCaution = $("#CautionContratMixte").val();
    var ContratNumCaution = $("#numCautionMixte").val();
    var ContratDuree = $("#dureeContratMixte").val();
    var ContratFileMixte = $("#ControlFileMixte").prop("files")[0] ?
      $("#ControlFileMixte").prop("files")[0] :
      "no file";
    if (
      ContratDate == "" ||
      ContratDateDebut == "" ||
      ContratDateFin == "" ||
      ContratPrixContrat == "" ||
      ContratPaiement == "" ||
      ContratDuree == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      var form_data = new FormData();
      form_data.append("ContratDate", ContratDate);
      form_data.append("ContratType", ContratType);
      form_data.append("ContratDateDebut", ContratDateDebut);
      form_data.append("ContratDateFin", ContratDateFin);
      form_data.append("ContratPrixContrat", ContratPrixContrat);
      form_data.append("ContratAssurence", ContratAssurence);
      form_data.append("ContratPaiement", ContratPaiement);
      form_data.append("ContratDatePaiement", ContratDatePaiement);
      form_data.append("ContratVoitureModel", ContratVoitureModel);
      form_data.append("ContratVoiturePIMM", ContratVoiturePIMM);
      form_data.append("ContratVoiturekMPrevu", ContratVoiturekMPrevu);
      form_data.append("ContratmaterielListe", ContratmaterielListe);
      form_data.append("ContratClient", ContratClient);
      form_data.append("ContratCaution", ContratCaution);
      form_data.append("ContratNumCaution", ContratNumCaution);
      form_data.append("ContratDuree", ContratDuree);
      form_data.append("ContratFileMixte", ContratFileMixte);
      $.ajax({
        url: "AjoutContratMixte.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat").modal("show");
          $("#contratForm").trigger("reset");
          view_contrat_record_mixte();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });

  });
}

function delete_contrat_record_mixte() {
  $(document).on("click", "#btn-delete-contrat-mixte", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteContratMixte").modal("show");
    $(document).on("click", "#btn_delete_mixte", function () {
      $.ajax({
        url: "delete_contrat_mixte.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteContratMixte").modal("toggle");
          view_contrat_record_mixte();
          view_contrat_record_materiel();
          load_unseen_notification(); 
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}

function showPDFMixteModel() {
  $(document).on("click", "#btn-show-contrat-mixte", function () {
    var ID = $(this).attr("data-id2");
    $.ajax({
      url: "selectContratMixte.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-Siret").text(data[1]);
        $("#Client-Address").text(data[2]);
        $("#Client-Company").text(data[3]);
        $("#Voiture-PIMM").text(data[4]);
        $("#Voiture-Category").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Contrat-Date-Debut").text(data[7]);
        $("#Contrat-Date-Fin").text(data[8]);
        $("#Contrat-Prix").text(data[9]);
        $("#Contrat-prix-TTC").text(data[10]);
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Date-Prelevement").text(data[12]);
        $("#Contrat-Caution").text(data[13]);
        $("#Num-cheque-caution").text(data[15]);
        $("#Contrat-Date").text(data[17]);
        console.log(data[21]);
        var materielNamee = "<ul class ='list-unstyled'>";
        data[18].forEach((ee) => {
          materielNamee = materielNamee + `<li>${ee}</li>`;
        });
        materielNamee = materielNamee + "</ul>";
        $("#Materiel-Name").html(materielNamee);
        var SerialNumbers = "<ul class ='list-unstyled'>";
        data[19].forEach((ee) => {
          SerialNumbers = SerialNumbers + `<li>${ee}</li>`;
        });
        SerialNumbers = SerialNumbers + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumbers);

        $("#PDF-Voiture-Mixte-modal").modal("show");
      },
    });
  });
}
//contrat pack
function get_Mixte_record() {
  $(document).on("click", "#btn-edit-contrat-pack", function () {
    var ID = $(this).attr("data-id3");
    $("#update-Contrat-Pack").modal("show");
  });
}

function update_contrat_record_mixte() {
  $(document).on("click", "#btn_updated_Contrat_Mixte", function () {
    $("#update-Contrat-Mixte").scrollTop(0);
    var up_idmixte = $("#up_idmixte").val();
    // var up_DateContratMixte = $("#up_DateContratMixte").val();
    var up_dureeContratMixte = $("#up_dureeContratMixte").val();
    var up_DateDebutContrat = $("#up_DateDebutContrat").val();
    var up_DateFinContratMixte = $("#up_DateFinContratMixte").val();
    var up_PrixContratMixte = $("#up_PrixContratMixte").val();
    // var up_AssuranceContratMixte = $("#up_AssuranceContratMixte").val();
    var up_ModePaiementContratMixte = $("#up_ModePaiementContratMixte").val();
    var up_CautionMixte = $("#up_CautionMixte").val();
    var up_numCautionMixte = $("#up_numCautionMixte").val();
    if (
      // up_DateContratMixte == "" ||
      up_dureeContratMixte == "" ||
      up_DateDebutContrat == "" ||
      up_DateFinContratMixte == "" ||
      up_PrixContratMixte == ""
    ) {
      $("#up-message").html("please fill in the blanks");
      $("#update-Contrat-Mixte").modal("show");
    } else if (up_DateDebutContrat > up_DateFinContratMixte) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat_mixte.php",
        method: "post",
        data: {
          up_idmixte: up_idmixte,
          // up_DateContratMixte: up_DateContratMixte,
          up_dureeContratMixte: up_dureeContratMixte,
          up_DateDebutContrat: up_DateDebutContrat,
          up_DateFinContratMixte: up_DateFinContratMixte,
          up_PrixContratMixte: up_PrixContratMixte,
          // up_AssuranceContratMixte: up_AssuranceContratMixte,
          up_ModePaiementContratMixte: up_ModePaiementContratMixte,
          up_numCautionMixte: up_numCautionMixte,
          up_CautionMixte: up_CautionMixte,
        },
        success: function (data) {
          $("#up_message").addClass("alert alert-success").html(data);
          $("#update-Contrat-Mixte").modal("show");
          view_contrat_record_mixte();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}
//insert Record in the data base 
function insertUserRecord() {
  $(document).on("click", "#btn-register-user", function () {
    $("#Registration-User").scrollTop(0);
    var nom = $("#userName").val();
    var login = $("#userLogin").val();
    var passord = $("#userPassword").val();
    var id_user_agence = $("#UserAgence").val();
    if (
      nom == "" ||
      login == "" ||
      id_user_agence == "" ||
      passord == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("nom", nom);
      form_data.append("login", login);
      form_data.append("passord", passord);
      form_data.append("id_user_agence", id_user_agence);
      $.ajax({
        url: "AjoutUser.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-User").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-User").modal("show");
            $("#userForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_user_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#userForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_user_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/utilisateur.php"){
  $.ajax({
    url: "viewuser.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#user-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}
/*
 */
function view_stock_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/stock.php"){
  $.ajax({
    url: "selectVoiteurDispoStock1.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#stock-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}
});}
/*
 */
function get_stock_voiture() {
  $(document).on("click", "#btn-transfert", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_voiture_data.php",
      method: "post",
      data: {
        id_voiture: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idvoiture").val(data[0]);
        $("#up_voitureAgence").val(data[14]);
        $("#updatevoiturestock").modal("show");
      },
    });
  });
}
// Update Record
function update_voiture_stock_record() {
  $(document).on("click", "#btn_update_voiture_stock", function () {
    $("#updatevoiturestock").scrollTop(0);
    var UpdateID = $("#up_idvoiture").val();
    var up_voitureAgence = $("#up_voitureAgence").val();
    if (up_voitureAgence == null) {
      $("#up_message").html("Veuillez  Agence obligatoires !");
      $("#updatevoiturestock").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoiturestock.php",
        method: "POST",
        data: {
          id_voiture: UpdateID,
          up_voitureAgence: up_voitureAgence,
        },
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updatevoiturestock").modal("show");
          view_stock_record()
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function view_stock_Q_record() {
  $.ajax({
    url: "selectVoiteurDispoStock.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#stock-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_stock_materiel_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/stock_matreiel.php"){
  $.ajax({
    url: "selectMaterielDispoStock1.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#stock-list-materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}});
}
// get particuler user record
function get_user_record() {
  $(document).on("click", "#btn-edit-user", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_user_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_iduser").val(data[0]);
        $("#up_userName").val(data[1]);
        $("#up_userLogin").val(data[2]);
        $("#up_userPassword").val(data[3]);
        $("#updateuseretat").val(data[4]);
        $("#updateUser").modal("show");
      },
    });
  });
}
// update  user record
function update_user_record() {
  $(document).on("click", "#btn_update_user", function () {
    $("#updateUser").scrollTop(0);
    var updateuserID = $("#up_iduser").val();
    var updateuserName = $("#up_userName").val();
    var updateuserLogin = $("#up_userLogin").val();
    var updateuserPassword = $("#up_userPassword").val();
    var updateuseretat = $("#updateuseretat").val();
    if (
      updateuserID == "" ||
      updateuserName == "" ||
      updateuserLogin == "" ||
      updateuserPassword == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateUser").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateuserID);
      form_data.append("nom", updateuserName);
      form_data.append("login", updateuserLogin);
      form_data.append("password", updateuserPassword);
      form_data.append("updateuseretat", updateuseretat);
      $.ajax({
        url: "update_user.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le utilisateur est modifié avec succès");
          $("#updateUser").modal("show");
          view_user_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-userForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function delete_user_record() {
  $(document).on("click", "#btn-delete-user", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteUser").modal("show");
    $(document).on("click", "#btn_delete_user", function () {
      $.ajax({
        url: "delete_user.php",
        method: "post",
        data: {
          Delete_UserID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteUser").modal("toggle");
          view_user_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
// ============================================================
//            Agence Ajouter
//==============================================
function insertAgenceRecord() {
  $(document).on("click", "#btn-register-agence", function () {
    $("#Registration-Agence").scrollTop(0);
    var agenceLien = $("#agenceLien").val();
    var agenceDate = $("#agenceDate").val();
    var agenceEmail = $("#agenceEmail").val();
    var agenceTele = $("#agenceTele").val();
    if (
      agenceLien == "" ||
      agenceDate == "" ||
      agenceEmail == "" ||
      agenceTele == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (!isValidEmailAddress(agenceEmail)) {
      $("#message")
        .addClass("alert alert-danger")
        .html("  Email  est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("agenceLien", agenceLien);
      form_data.append("agenceDate", agenceDate);
      form_data.append("agenceEmail", agenceEmail);
      form_data.append("agenceTele", agenceTele);
      $.ajax({
        url: "AjoutAgence.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Agence").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Agence").modal("show");
            $("#agenceForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_agence_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#agenceForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_agence_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/agence.php"){
  $.ajax({
    url: "viewagence.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#agence-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function get_agence_record() {
  $(document).on("click", "#btn-edit-agence", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_agence_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idagence").val(data[0]);
        $("#up_agenceLien").val(data[1]);
        $("#up_agenceDate").val(data[2]);
        $("#up_agenceEmail").val(data[3]);
        $("#up_agenceTele").val(data[4]);
        $("#updateAgence").modal("show");
      },
    });
  });
}
/*
 * update agence
 */
function update_agence_record() {
  $(document).on("click", "#btn_update_agence", function () {
    $("#updateAgence").scrollTop(0);
    var up_idagence = $("#up_idagence").val();
    var up_agenceLien = $("#up_agenceLien").val();
    var up_agenceDate = $("#up_agenceDate").val();
    var up_agenceEmail = $("#up_agenceEmail").val();
    var up_agenceTele = $("#up_agenceTele").val();
    if (
      up_agenceLien == "" ||
      up_agenceDate == "" ||
      up_agenceEmail == "" ||
      up_agenceTele == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#id_agence").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("up_idagence", up_idagence);
      form_data.append("up_agenceLien", up_agenceLien);
      form_data.append("up_agenceDate", up_agenceDate);
      form_data.append("up_agenceEmail", up_agenceEmail);
      form_data.append("up_agenceTele", up_agenceTele);
      $.ajax({
        url: "update_agence.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le Agence est modifié avec succès");
          $("#updateAgence").modal("show");
          view_agence_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateAgence").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}
/*
 * delete_agence_record
 */
function delete_agence_record() {
  $(document).on("click", "#btn-delete-agence", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteAgence").modal("show");
    $(document).on("click", "#btn_delete_agence", function () {
      $.ajax({
        url: "delete_agence.php",
        method: "post",
        data: {
          Delete_AgenceID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteAgence").modal("toggle");
          view_agence_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
//-------------------------------------------------------
function insertGroupPackRecord() {
  $(document).on("click", "#btn-register-pack", function () {
    $("#Registration-Pack").scrollTop(0);
    const selects_pack = Array.from(
      document.querySelectorAll(".materiel-list-pack")
    );
    const selects_quantite = Array.from(
      document.querySelectorAll(".materiel-list-quantite")
    );
    const PackListe = selects_pack.map((select) => Number(select.value));
    const QuantiteListe = selects_quantite.map((select) => Number(select.value));
    var DesignationPack = $("#DesignationPack").val();
    var VoitureType = $("#VoitureType").val();
    if (
      DesignationPack == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if ((selects_pack[0].value == "Nom Matériel") && (VoitureType == "sans vehicule")) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs Matériel ou vehicule obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("DesignationPack", DesignationPack);
      form_data.append("VoitureType", VoitureType);
      form_data.append("PackListe", PackListe);
      form_data.append("QuantiteListe", QuantiteListe);
      $.ajax({
        url: "AjoutGroupPack.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Pack").modal("show");
          $("#grouppackForm").trigger("reset");
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#grouppackForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_group_pack_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/gestion_pack.php"){
  $.ajax({
    url: "viewgrouppack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#group-pack-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}
});
}
/*
 * delete_agence_record
 */
function delete_pack_record() {
  $(document).on("click", "#btn-delete-pack", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deletePack").modal("show");
    $(document).on("click", "#btn_delete_pack", function () {
      $.ajax({
        url: "delete_pack.php",
        method: "post",
        data: {
          Delete_PackID: Delete_ID
        },
        success: function (data) {
          $("#delete_message_pack").addClass("alert alert-success").html(data);
          $("#deletePack").modal("toggle");
          view_group_pack_record();
          setTimeout(function () {
            if ($("#delete_message_pack").length > 0) {
              $("#delete_message_pack").remove();
            }
          }, 2500);
        },
      });
    });
  });
}
/*
 * Get group pack record 
 */
function get_group_pack_record() {
  $(document).on("click", "#btn-edit-pack", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_group_pack_data.php",
      method: "post",
      data: {
        PackID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idPack").val(data[0]);
        $("#up_DesignationPack").val(data[1]);
        $("#up_TypeVoiturePack").val(data[2]);
        $("#up_EtatPack").val(data[3]);
        $("#update-Pack").modal("show");
      },
    });
  });
}
/*
 *  update group pack record
 */
function update_group_pack_record() {
  $(document).on("click", "#btn_updated_Group_Pack", function () {
    $("#updatePackForm").scrollTop(0);
    var pack_id = $("#up_idPack").val();
    var up_DesignationPack = $("#up_DesignationPack").val();
    var up_TypeVoiturePack = $("#up_TypeVoiturePack").val();
    var up_EtatPack = $("#up_EtatPack").val();
    if (
      up_DesignationPack == "" ||
      up_TypeVoiturePack == "" ||
      up_EtatPack == ""
    ) {
      $("#up_message_pack")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#update-Pack").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("pack_id", pack_id);
      form_data.append("up_DesignationPack", up_DesignationPack);
      form_data.append("up_TypeVoiturePack", up_TypeVoiturePack);
      form_data.append("up_EtatPack", up_EtatPack);
      $.ajax({
        url: "update_group_pack.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message_pack")
            .addClass("alert alert-success")
            .html("Le pack est Modifié avec succès");
          $("#update-Pack").modal("show");
          view_group_pack_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updatePackForm").trigger("reset");
      $("#up_message_pack").html("");
      $("#up_message_pack").removeClass("alert alert-danger");
      $("#up_message_pack").removeClass("alert alert-sucess");
    });
  });
}
// insertContratMixteRecord
function insertContratPackRecord() {
  $(document).on("click", "#btn-register-contrat-mixte", function () {
    $("#Registration-Contrat-mixte").scrollTop(0);
    const selects = Array.from(
      document.querySelectorAll(".materiel-list-pack")
    );
    const ContratmaterielListe = selects.map((select) => Number(select.value));
    const quantite = Array.from(
      document.querySelectorAll(".quantite-list-pack")
    );
    const ContratquantiteListe = quantite.map((select) => Number(select.value));
    // var ContratDate = $("#DateContratMixte").val();
    var ContratType = "Pack";
    var VehiculePack = $("#vehicule_pack").val();
    var id_pack = $("#id_pack").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContratMixte").val();
    // var ContratAssurence = $("#AssuranceContratMixte").val();
    var ContratPaiement = $("#ModePaiementContratMixte").val();
    var ContratDatePaiement = null;
    var ContratVoitureModel = $("#VoitureModeleMixte").val();
    var ContratVoiturePIMM = $("#VoiturePimmMixte").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevuMixte").val();
    var ContratVoiturekMPrevu = null;
    var ContratClient = $("#ClientContratMixte").val();
    var ContratCaution = $("#CautionContratMixte").val();
    var ContratNumCaution = $("#numCautionMixte").val();
    var ContratDuree = $("#dureeContratMixte").val();
    if (
      // ContratDate == "" ||
      ContratDateDebut == "" ||
      ContratDateFin == "" ||
      ContratPrixContrat == "" ||
      ContratPaiement == "" ||
      ContratDuree == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      var form_data = new FormData();
      form_data.append("ContratDate", ContratDate);
      form_data.append("ContratType", ContratType);
      form_data.append("ContratDateDebut", ContratDateDebut);
      form_data.append("ContratDateFin", ContratDateFin);
      form_data.append("ContratPrixContrat", ContratPrixContrat);
      form_data.append("ContratAssurence", ContratAssurence);
      form_data.append("ContratPaiement", ContratPaiement);
      form_data.append("ContratDatePaiement", ContratDatePaiement);
      form_data.append("ContratVoitureModel", ContratVoitureModel);
      form_data.append("ContratVoiturePIMM", ContratVoiturePIMM);
      form_data.append("ContratVoiturekMPrevu", ContratVoiturekMPrevu);
      form_data.append("ContratmaterielListe", ContratmaterielListe);
      form_data.append("ContratClient", ContratClient);
      form_data.append("ContratCaution", ContratCaution);
      form_data.append("ContratNumCaution", ContratNumCaution);
      form_data.append("VehiculePack", VehiculePack);
      form_data.append("id_pack", id_pack);
      form_data.append("ContratquantiteListe", ContratquantiteListe);
      form_data.append("ContratDuree", ContratDuree);
      $.ajax({
        url: "AjoutContratPack.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat-mixte").modal("show");
          $("#contratpackForm").trigger("reset");
          view_contrat_record_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratpackForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}
/*
 * insertCategorieRecord
 */
function insertCategorieRecord() {
  $(document).on("click", "#btn-register-Materiel-Categorie", function () {
    $("#Registration-Categorie").scrollTop(0);
    var code_materiel = $("#code_materiel").val();
    var designation = $("#designation").val();
    var famille_materiel = $("#famille_materiel").val();
    var type_location = $("#type_location").val();
    var num_serie_obg = $("#num_serie_obg").val();
    if (
      code_materiel == "" ||
      designation == "" ||
      famille_materiel == "" ||
      type_location == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("code_materiel", code_materiel);
      form_data.append("designation", designation);
      form_data.append("famille_materiel", famille_materiel);
      form_data.append("type_location", type_location);
      form_data.append("num_serie_obg", num_serie_obg);
      $.ajax({
        url: "AjoutCategorie.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Categorie").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Categorie").modal("show");
            $("#add-CategorieForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_categorie_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-CategorieForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_categorie_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/categorie.php"){
  $.ajax({
    url: "viewcategorie.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Categorie-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });}});
}

function delete_categorie_record() {
  $(document).on("click", "#btn-delete-categorie", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteCategorie").modal("show");
    $(document).on("click", "#btn_delete_categorie", function () {
      $.ajax({
        url: "delete_categorie.php",
        method: "post",
        data: {
          Del_ID: Delete_ID
        },
        success: function (data) {
          $("#deleteCategorie").addClass("alert alert-success").html(data);
          $("#deleteCategorie").modal("toggle");
          view_categorie_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 3000);
        },
      });
    });
  });
}
/*
 *  insert Stock Record
 */
function insertStockRecord() {
  $(document).on("click", "#btn-register-Materiel-stock", function () {
    $("#Registration-Materiel-stock").scrollTop(0);
    var ID = $("#up_idMaterielstock").val();
    var signe = $("#stockSigne").val();
    var value = $("#value").val();
    var etat = $("#up_EtatMaterielstock").val();
    if (
      etat == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("ID", ID);
      form_data.append("signe", signe);
      form_data.append("value", value);
      form_data.append("etat", etat);
      $.ajax({
        url: "AjoutStock.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#messagest")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Materiel-stock").modal("show");
          } else {
            $("#messagest")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#add-MaterielStockForm").trigger("reset");
            $("#messagest").removeClass("text-danger").addClass("text-success");
            view_Materiel_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-MaterielStockForm").trigger("reset");
      $("#messagest").html("");
      $("#messagest").removeClass("alert alert-danger");
      $("#messagest").removeClass("alert alert-sucess");
    });
  });
}

function view_grppack_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/materiel-grppack.php"){
  $.ajax({
    url: "viewgrppack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#grppack-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
  }});
}

function isValidEmailAddress(emailAddress) {
  var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
  return pattern.test(emailAddress);
}

function insertDevisRecord() {
  $(document).on("click", "#btn-register-Devis", function () {
    $("#Registration-Devis").scrollTop(0);
    var ClientDevis = $("#ClientDevis").val();
    var NomDevis = $("#NomDevis").val();
    var ModePaiementDevis = $("#ModePaiementDevis").val();
    var CommentaireDevis = $("#CommentaireDevis").val();
    var DateDevis = $("#DateDevis").val();
    var RemiseDevis = $("#RemiseDevis").val();
    var EscompteDevis = $("#EscompteDevis").val();
    const selects_code = Array.from(
      document.querySelectorAll(".code-list-comp")
    );
    const selects_designation = Array.from(
      document.querySelectorAll(".designation-list-num_comp")
    );
    const selects_quantition = Array.from(
      document.querySelectorAll(".quantition-list-num_comp")
    );
    const selects_prix = Array.from(
      document.querySelectorAll(".prix-list-num_comp")
    );
    const selects_depot = Array.from(
      document.querySelectorAll(".depot-list-num_comp")
    );
    var codeListe = selects_code.map((select) => select.value);
    var designationListe = selects_designation.map((select) => select.value);
    var quantitionListe = selects_quantition.map((select) => select.value);
    var prixListe = selects_prix.map((select) => select.value);
    var depotListe = selects_depot.map((select) => select.value);
    if (
      ClientDevis == "" ||
      NomDevis == "" ||
      ModePaiementDevis == "" ||
      CommentaireDevis == "" ||
      DateDevis == "" ||
      RemiseDevis == "" ||
      EscompteDevis == "" ||
      codeListe == "" ||
      designationListe == "" ||
      prixListe == "" 
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutDevis.php",
        method: "post",
        data: {
          ClientDevis: ClientDevis,
          NomDevis: NomDevis,
          ModePaiementDevis: ModePaiementDevis,
          CommentaireDevis: CommentaireDevis,
          DateDevis: DateDevis,
          RemiseDevis: RemiseDevis,
          EscompteDevis: EscompteDevis,
          codeListe: codeListe,
          designationListe: designationListe,
          quantitionListe: quantitionListe,
          prixListe: prixListe,
          depotListe: depotListe
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Devis").modal("show");
          $("#add-DevisForm").trigger("reset");
          view_devis_record()
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-MaterielForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function delete_devis() {
  $(document).on("click", "#btn-delete-devis", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteDevis").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_devis.php",
        method: "post",
        data: {
          Delete_DevisID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteDevis").modal("toggle");
          view_devis_record();
          load_unseen_notification(); 
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}

function view_devis_record() {
  $(document).ready(function () {
  if(location.pathname=="/location/devis.php"){
  $.ajax({
    url: "viewdevis.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#devis-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response Devis !");
      }
    },
  });}});
}

function get_Devis() {
  $(document).on("click", "#btn-edit-devis", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_devis_data.php",
      method: "post",
      data: {
        DevisID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idDevis").val(data[0]);
        $("#up_NomDevis").val(data[1]);
        $("#up_ModePaiementDevis").val(data[2]);
        $("#up_CommentaireDevis").val(data[3]);
        $("#up_DateDevis").val(data[4]);
        $("#up_RemiseDevis").val(data[5]);
        $("#up_EscompteDevis").val(data[7]);
        $("#up_ClientDevis").val(data[8]);
        $("#up_code_comp1").val(data[10]);
        $("#up_designation_comp_1").val(data[11]);
        $("#up_quantition_comp_1").val(data[12]);
        $("#up_prix_comp_1").val(data[13]);
        $("#up_depot_comp_1").val(data[14]);

        $("#updateDevis").modal("show");
        view_devis_record();
      },
    });
  });
}

function update_devis_record() {
  $(document).on("click", "#btn_update_devis", function () {
    $("#updateDevis").scrollTop(0);
    var updateDevislId = $("#up_idDevis").val();
    var updateDevisName = $("#up_NomDevis").val();
    var updateDevisModePaiement = $("#up_ModePaiementDevis").val();
    var updateDevisCommentaire = $("#up_CommentaireDevis").val();
    var updateDevisDate = $("#up_DateDevis").val();
    var updateDevisRemise = $("#up_RemiseDevis").val();
    var updateDevisEscompte = $("#up_EscompteDevis").val();
    var updateDevisClient = $("#up_ClientDevis").val();
    if (
      updateDevisName == "" ||
      updateDevisModePaiement == "" ||
      updateDevisCommentaire == "" ||
      updateDevisDate == "" ||
      updateDevisRemise == "" ||
      updateDevisEscompte == "" ||
      updateDevisClient == ""
    ) {
      $("#up_message_Devis")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateDevis").modal("show");
    } else {
      $.ajax({
        url: "update_devis.php",
        method: "post",
        data: {
          up_idDevis: updateDevislId,
          up_NomDevis: updateDevisName,
          up_ModePaiementDevis: updateDevisModePaiement,
          up_CommentaireDevis: updateDevisCommentaire,
          up_DateDevis: updateDevisDate,
          up_RemiseDevis: updateDevisRemise,
          up_EscompteDevis: updateDevisEscompte,
          up_ClientDevis: updateDevisClient,
        },
        success: function (data) {   
          $("#up_message_Devis").addClass("alert alert-success").html(data);
          $("#updateDevis").modal("show");
          view_devis_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateDevisForm").trigger("reset");
      $("#up_message_Devis").html("");
      $("#up_message_Devis").removeClass("alert alert-danger");
      $("#up_message_Devis").removeClass("alert alert-success");
    });
  });
}