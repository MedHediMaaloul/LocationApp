function FetchPIMM(id_voiture) {
  $("#EntretienPIMM").html("");
  $("#EntretienDateAchatVoiture").html(
    "<option disabled selected>Select PIMM</option>"
  );
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#EntretienPIMM").html(data);
    },
  });
}



function List_Comp_Materiel(id_materiels_agence) {

  $.ajax({
    type: "post",
    url: "selectcompmateriel.php",
    data: {
      id_materiels_agence: id_materiels_agence
    },
    success: function (data) {
      $("#list_composant").html(data);

    },
  });
}



function List_Materiel_Pack(id_pack) {

  $.ajax({
    type: "post",
    url: "selectmaterielpack.php",
    data: {
      id_pack: id_pack
    },
    success: function (data) {
      $("#list_materiel_pack").html(data);

    },
  });
}


function MaterielCategorie(id_materiel) {
  //$("#VoiturePimmMixte").html("");
  $.ajax({
    type: "post",
    url: "selectmaterielcategorie.php",
    data: {
      id_materiel: id_materiel
    },
    success: function (data) {

      //$("#VoiturePimmMixte").html(data);
      if (data == "T") {
        // alert(data);
        $("#cont_num_serie").show();
        $("#cont_composant").show();
        $("#cont_quitite").hide();
        document.getElementById("quitite").value = 1;
        document.getElementById("materielnumserie").value = "";

        //$("#quitite").val() = "1";
        //$("#materielnumserie").val() = "vide";

      } else {
        $("#cont_num_serie").hide();
        $("#cont_composant").hide();
        $("#cont_quitite").show();
        document.getElementById("materielnumserie").value = "vide";


      }
    },
  });
}


function changeTypeMatrielePack(id_materiel, id) {

  //$("#VoiturePimmMixte").html("");
  // alert(id_group_materiel);
  // alert(id);
  $.ajax({
    type: "post",
    url: "selectmaterielcategorie.php",
    data: {
      id_materiel: id_materiel
    },
    success: function (data) {
      //$("#VoiturePimmMixte").html(data);
      if (data == "T") {

        $("#quantite_" + id).hide();
        document.getElementById("quantite_" + id).value = 1;


      } else {

        $("#quantite_" + id).show();
        document.getElementById("quantite_" + id).value = "";

      }
    },
  });
}





function FetchPIMMContrat(id_voiture) {
  $("#VoiturePimm").html("");
  $.ajax({
    type: "post",
    url: "selectboxcontrat.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#VoiturePimm").html(data);
    },
  });
}

function FetchPIMMContratMixte(id_voiture) {
  $("#VoiturePimmMixte").html("");
  $.ajax({
    type: "post",
    url: "selectboxcontrat.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#VoiturePimmMixte").html(data);
    },
  });
}

// function FetchCINClientContrat(id_voiture){
//   $('#ClientCINContrat').html('');
//   $.ajax({
//     type:'post',
//     url: 'selectboxcontrat.php',
//     data : { Model_id : id_voiture},
//     success : function(data){
//        $('#ClientCINContrat').html(data);
//     }

//   })
// }

function FetchDateAchatVoiture(id_voiture) {
  $("#EntretienDateAchatVoiture").html("");
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Pimm_id: id_voiture
    },
    success: function (data) {
      $("#EntretienDateAchatVoiture").html(data);
    },
  });
}

function FetchNumSerie(id_materiel) {
  $("#EntretienNumSerieMateriel").html("");
  $("#EntretienDateAchatMateriel").html(
    "<option disabled selected>Select Num Serie</option>"
  );
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Materiel_id: id_materiel
    },
    success: function (data) {
      $("#EntretienNumSerieMateriel").html(data);
    },
  });
}

function FetchDateAchatMateriel(id_materiel) {
  $("#EntretienDateAchatMateriel").html("");
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      NumSerieMateriel: id_materiel
    },
    success: function (data) {
      $("#EntretienDateAchatMateriel").html(data);
    },
  });
}
$(function () {
  $("#EntretienType").change(function () {
    if ($(this).val() === "Vehicule") {
      $("#voiture").show();
      $("#materiel").hide();
    } else if ($(this).val() === "Materiel") {
      $("#voiture").hide();
      $("#materiel").show();
    } else {
      $("#voiture").hide();
      $("#materiel").hide();
    }
  });
});

$(function () {
  $("#EntretienTypeM").change(function () {
    if ($(this).val() === "oui") {
      $("#ProchaineEntretien").show();

    } else if ($(this).val() === "non") {

      $("#ProchaineEntretien").hide();
    }
  });
});

$(function () {
  $("#TypeContrat").change(function () {
    if ($(this).val() === "Véhicule") {
      $("#voiture").show();
      $("#materiel").hide();
    } else if ($(this).val() === "Matériel") {
      $("#voiture").hide();
      $("#materiel").show();
    } else {
      $("#voiture").hide();
      $("#materiel").hide();
    }
  });
});
// $(function () {
//   $("#ModePaiementContrat").change(function () {
//     if (
//       $(this).val() === "Prélèvements automatiques" ||
//       $(this).val() === "Virements bancaires" ||
//       $(this).val() === "Carte bancaire" ||
//       $(this).val() === "Espèces"
//     ) {
//       $("#inputDatePrelevementContrat").show();
//     } else {
//       $("#inputDatePrelevementContrat").hide();
//     }
//   });
// });
$(function () {
  $("#up_ModePaiementContrat").change(function () {
    if (
      $(this).val() === "Prélèvements automatiques" ||
      $(this).val() === "Virements bancaires" ||
      $(this).val() === "Carte bancaire" ||
      $(this).val() === "Espèces"
    ) {
      $("#up_inputDatePrelevementContrat").show();
    } else {
      $("#up_inputDatePrelevementContrat").hide();
    }
    // alert ($(this).val());
  });
});
$(function () {
  $("#dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#inputkmprevu").show();
    } else {
      $("#inputkmprevu").hide();
    }
    // alert ($(this).val());
  });
});
$(function () {
  $("#up_dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#up_inputkmprevu").show();
    } else {
      $("#up_inputkmprevu").hide();
    }
    // alert ($(this).val());
  });
});
$(function () {
  $("#dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#inputDatePrelevementContrat").hide();
    } else {
      $("#inputDatePrelevementContrat").show();
    }
    // alert ($(this).val());
  });
});
$(function () {
  $("#up_dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#up_inputDatePrelevementContrat").hide();
    } else {
      $("#up_inputDatePrelevementContrat").show();
    }
    // alert ($(this).val());
  });
});


function affichier_materiel_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();

  $.ajax({
    type: "post",
    url: "selectMaterielDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
    },
    success: function (data) {
      $("#materiel").html(data);
    },
  });
}


function affichier_voiture_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();

  $.ajax({
    type: "post",
    url: "selectVoiteurDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
    },
    success: function (data) {
      $("#materielVoiteur").html(data);
    },
  });
}


function affichier_pack_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();

  $.ajax({
    type: "post",
    url: "selectPackDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
    },
    success: function (data) {
      $("#materielPack").html(data);
    },
  });
}

function selectclient(data) {
  //$("#VoiturePimmMixte").html(data);
  if (data == "CLIENT PRO") {

    $("#cont_nom_complet").show();
    $("#cont_email").show();
    $("#cont_telephone").show();
    $("#cont_adresse").show();
    $("#cont_raison").show();
    $("#cont_siret").show();
    $("#cont_naf").show();
    $("#cont_tva").show();
    $("#cont_accompte").show();
    $("#cont_comment").show();
    $("#cont_cin").show();
    $("#cont_kbis").show();
    $("#cont_rib").show();
    $("#cont_permis").show();

    document.getElementById("nom").value = "";
    document.getElementById("email").value = "";
    document.getElementById("tel").value = "";
    document.getElementById("adresse").value = "";
    document.getElementById("cin").value = "";
    document.getElementById("raison_social").value = "";
    document.getElementById("siret").value = "";
    document.getElementById("naf").value = "";
    document.getElementById("tva").value = "";
    document.getElementById("accompte_client").value = "";
    document.getElementById("permis").value = "";
    document.getElementById("kbis").value = "";
    document.getElementById("rib").value = "";
    document.getElementById("comment").value = "";

  } else {

    $("#cont_nom_complet").show();
    $("#cont_email").show();
    $("#cont_telephone").show();
    $("#cont_adresse").show();
    $("#cont_raison").hide();
    $("#cont_siret").hide();
    $("#cont_naf").hide();
    $("#cont_tva").hide();
    $("#cont_accompte").hide();
    $("#cont_comment").show();
    $("#cont_cin").show();
    $("#cont_kbis").hide();
    $("#cont_rib").hide();
    $("#cont_permis").show();

  }

}



/*
 * view_deleteMaterielRecord
 */
function view_deleteMaterielRecord() {
  $.ajax({
    url: "viewdeletemateriel.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSettingmateriel").html(data.html);
      }
    },
  });
}


/*
 * End view_deleteMaterielRecord
 */

/*
 *delete_Settingmaterielgrprecord
 */

function delete_Settingmaterielgrprecord() {
  $(document).on("click", "#btn_delete_materielgrp", function () {
    var Delete_ID = $(this).attr("data-id8");
    $.ajax({
      url: "deleteSettingmaterielgrp.php",
      method: "post",
      data: {
        Del_ID: Delete_ID
      },
      success: function (data) {
        view_deleteMaterielRecord();
        view_group_pack_record();

      },
    });
  });
}


/*
 *  end delete_Settingmaterielgrprecord
 */



MaterielQtiDispo();


function MaterielQtiDispo() {
  $(document).ready(function () {
  if(location.pathname=="/location/disponibilite.php"){
  $.ajax({
    type: "post",
    url: "selectMaterielQtiDispo.php",
    data: {},
    success: function (data) {

      $("#QTIdispo").html(data);
    },
  });}});
}