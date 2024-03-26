$(function () {

  
  // ------------------------------------------------
  // gestion des congés
  // ------------------------------------------------
  $("body").on("click", "#gestConges", function (event) {
    testSession(event);

    $.post("inc/conges/editConges.inc.php", {}, function (resultat) {
      $("#corpsPage").html(resultat);
    });
  });

  // ------------------------------------------------
  // changement de l'époque et rechargement des congés
  // ------------------------------------------------
  $("body").on("change", "select#idContexte", function (event) {
    testSession(event);
    var idContexte = $(this).val();
    if (idContexte > 0) {
      Cookies.set("idContexte", idContexte, { sameSite: "strict" });
      $.post("inc/conges/editConges.inc.php", {}, function (resultat) {
        $("#corpsPage").html(resultat);
      });
    }
  });

  // --------------------------------------------------
  // Ajout d'une date fériée
  // --------------------------------------------------
  $("body").on("click", "#btn-addFerie", function (event) {
    testSession(event);
    var idContexte = $(this).data("idcontexte");

    if (idContexte > 0) {
      $.post(
        "inc/conges/modalAddFerie.inc.php",
        {
          idContexte: idContexte,
        },
        function (resultat) {
          $("#modal").html(resultat);
          $("#modalAddFerie").modal("show");
        }
      );
    }
  });

  // -------------------------------------------------
  // Enregistrement d'une nouvelle date fériée
  // -------------------------------------------------
  $("body").on("click", "#btn-modalSaveAddFerie", function (event) {
    testSession(event);
    if ($("#form-addFerie").valid()) {
      var formulaire = $("#form-addFerie").serialize();
      $.post(
        "inc/conges/saveCongeFerie.inc.php",
        {
          formulaire: formulaire,
        },
        function (resultat) {
          if (resultat > 0) {
            $("#modalAddFerie").modal("hide");
            $("#gestConges").trigger("click");
          }
        }
      );
    }
  });

  // -------------------------------------------------
  // Modification du statut d'une date de conge férié (O/N)
  // -------------------------------------------------
  $("body").on("change", ".switchFerie", function (event) {
    testSession(event);
    var idContexte = $("select#idContexte").val();
    var periode = $(this).data("periode");
    var date = $(this).closest("tr").find("input").val();
    $.post(
      "inc/conges/toggleCongeFerie.inc.php",
      {
        periode: periode,
        date: date,
        idContexte: idContexte,
      },
      function (resultat) {
        console.log(resultat);
      }
    );
  });

  // -------------------------------------------------
  // Modification du statut d'une date de conge hebdo (O/N)
  // -------------------------------------------------
  $("body").on("change", ".switchHebdo", function (event) {
    testSession(event);
    var idContexte = $("select#idContexte").val();
    var jour = $(this).data("jour");
    var periode = $(this).data("periode");
    $.post(
      "inc/conges/toggleCongeHebdo.inc.php",
      {
        periode: periode,
        jour: jour,
        idContexte: idContexte,
      },
      function (resultat) {
        console.log(resultat);
      }
    );
  });

  // --------------------------------------------------
  // suppression d'une date fériée
  // --------------------------------------------------
  $("body").on("click", ".btn-delConge", function (event) {
    testSession(event);
    var idContexte = $("select#idContexte").val();
    var date = $(this).closest("tr").find("input").val();
    var dateFr = date.split("-");
    var jour = dateFr[2];
    var mois = dateFr[1];
    var annee = dateFr[0];
    dateFr = jour + "/" + mois + "/" + annee;

    bootbox.confirm({
      title: "Suppression d'un congé",
      message:
        "Confirmez la suppression du congé férié du <strong>" +
        dateFr +
        "</strong>",
      callback: function (result) {
        if (result == true) {
          $.post(
            "inc/conges/delConge.inc.php",
            {
              idContexte: idContexte,
              date: date,
            },
            function (resultat) {
              $('#gestConges').trigger('click');
            }
          );
        }
      },
    });
  });


  $("body").on("click", "#btn-setContexte2day", function (event) {
    testSession(event);
    $.post("inc/conges/setContexte2day.inc.php", {}, function (idContexte) {
      $("select#idContexte").val(idContexte);

      if (idContexte > 0) {
        Cookies.set("idContexte", idContexte, { sameSite: "strict" });
        $.post("inc/conges/editConges.inc.php", {}, function (resultat) {
          $("#corpsPage").html(resultat);
        });
      }
    });
  });
});
