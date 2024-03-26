$(function () {

  // --------------------------------------------------------
  //  Présentation du calendrier planning
  // --------------------------------------------------------
  $("body").on("click", "#gestCalendrier", function (event) {
    testSession(event);
    var today = new Date();
    var month =
      Cookies.get(month) != undefined
        ? Cookies.get("month")
        : today.getMonth() + 1;
    var year =
      Cookies.get("year") != undefined
        ? Cookies.get("year")
        : today.getFullYear();
    $.post(
      "inc/inscriptions/getCalendar.inc.php",
      {
        month: month,
        year: year,
      },
      function (resultat) {
        $("#corpsPage").html(resultat);
      }
    );
  });

  
  // -------------------------------------------------------
  // Navigation de mois en mois
  // -------------------------------------------------------

  $("body").on("click", ".navigation", function (event) {
    testSession(event);

    var nbCandidat = $(".listeBenevoles .candidat").length;
    var nbToDelete = $(".listeBenevoles .toDelete").length;
    var total = nbCandidat + nbToDelete;
    if (total > 0) {
      bootbox.alert({
        title: "Attention",
        message:
          "Vous avez <strong> " +
          total +
          "</strong> modification(s) non enregistrée(s).<br>Veuillez la/les annuler.",
      });
    } else {
      var gap = $(this).data("gap");
      var month = $(this).data("month");
      var year = $(this).data("year");

      month = parseInt(month) + parseInt(gap);
      if (parseInt(month) == 0) {
        month = 12;
        year = year - 1;
      }
      if (parseInt(month) == 13) {
        month = 1;
        year = year + 1;
      }

      $(".navigation").data("month", month);
      $(".navigation").data("year", year);

      Cookies.set("year", year, { sameSite: "strict" });
      Cookies.set("month", month, { sameSite: "strict" });

      $("#gestCalendrier").trigger("click");
    }
  });
  // ---------------------------------------------------------------------

  // --------------------------------------------------------
  // retour au mois actuel
  // --------------------------------------------------------
  $("body").on("click", "#btn-today", function (event) {
    testSession(event);
    var month = $(this).data("month");
    var year = $(this).data("year");

    Cookies.set("year", year, { sameSite: "strict" });
    Cookies.set("month", month, { sameSite: "strict" });

    $("#gestCalendrier").trigger("click");
  });

  // ---------------------------------------------------------------------


  // ------------------------------------------------
  // inscription à une permanence
  // ------------------------------------------------
  $("body").on("click", "#calendar .btn-inscription", function (event) {
    testSession(event);
    var ceci = $(this);
    var periode = ceci.data("periode");
    var date = ceci.data("date");
    var cb = ceci.closest("td").find("input:checkbox");
    cb.prop("checked", !cb.is(":checked"));

    ceci.closest('td').toggleClass('modified');

    if (cb.is(":checked")) {
      // on vient de demander une inscription
      ceci.text("Désinscription");
      ceci.removeClass("btn-success").addClass("btn-danger");

      if (ceci.closest("td").find(".toDelete").length == 1) {
        // le cas échéant, réactiver l'inscription temporairement désactivée
        ceci.closest("td").find(".me").removeClass("toDelete");
      } else {
        // si nécessaire, ajouter un bouton en attente d'enregistrement pour cette inscription
        $.post(
          "inc/gestion/getBoutonInscr4pseudo.inc.php",
          {
            pseudo: pseudo,
          },
          function (resultat) {
            ceci.closest("td").find(".listeBenevoles").append(resultat);
          }
        );
      }
    } else {
      // on vient de demander une désinscription
      ceci.text("Inscription");
      ceci.removeClass("btn-danger").addClass("btn-success");

      // supprimer une éventuelle inscription en attente
      if (ceci.closest("td").find(".candidat").length == 1) {
        ceci.closest("td").find(".candidat").remove();
      } else {
        // marquer une véritable inscription comme temporairement désactivée
        ceci.closest("td").find(".me").addClass("toDelete");
      }
    }
  });
  // ---------------------------------------------------------------------

  // ---------------------------------------------------------------------
  //  Enregistrement des modifications apportées au planning des permanences
  // ---------------------------------------------------------------------
  $("body").on("click", "#saveCalendar", function (event) {
    testSession(event);
    var month = $("input#month").val();
    var year = $("input#year").val();
    var formulaire = $("#formGrid").serialize();
    var title = "Enregistrement des permanences";
    // si la colonne des users est présente (mode admin),
    // on récupère le pseudo de l'utilisateur visé
    if ($('#selectUsersInscription table tr.choosen').length == 1)
      var pseudo = $('#selectUsersInscription table tr.choosen').data('pseudo');
      else var pseudo = Null;

    $.post(
      "inc/inscriptions/getModifications.inc.php",
      {
        month: month,
        year: year,
        formulaire: formulaire,
        pseudo: pseudo
      },
      function (message) {
        bootbox.confirm({
          title: title,
          message: message,
          callback: function (result) {
            if (result == true) {
              $.post(
                "inc/inscriptions/saveCalendar.inc.php",
                {
                  month: month,
                  year: year,
                  formulaire: formulaire,
                  pseudo: pseudo
                },
                function (message2) {
                  bootbox.alert({
                    title: title,
                    message: message2,
                  });
                  $("#gestCalendrier").trigger("click");
                }
              );
            }
          },
        });
      }
    );
  });

  // ----------------------------------------------------------
  // Annulation des inscriptions en attente de confirmation
  // ----------------------------------------------------------
  $('body').on('click', '#resetCalendar', function(){
    $('#gestCalendrier').trigger('click');
  })

  //--------------------------------------------------------------------------
});
