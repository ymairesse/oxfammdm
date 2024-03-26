$(function () {
  $("body").on("click", "#gestInscriptions", function (event) {
    testSession(event);
    $.post("inc/gestion/getCalendar4gestion.inc.php", {}, function (resultat) {
      $("#corpsPage").html(resultat);
    });
  });

  // -------------------------------------------------------------------------
  // sélection d'un utilisateur dans le sélecteur latéral gauche
  // -------------------------------------------------------------------------
  $("body").on("click", "#selectUsersInscription table tr", function (event) {
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
      var pseudo = $(this).data("pseudo");
      Cookies.set("pseudo", pseudo, { sameSite: "strict" });
      $("#selectUsersInscription table tr").removeClass("choosen");
      $(this).addClass("choosen");
      $.post(
        "inc/gestion/restoreCalendar4gestion.inc.php",
        {
          pseudo: pseudo,
        },
        function (resultat) {
          $("#calendarInscription").html(resultat);
        }
      );
    }
  });

  // -------------------------------------------------------------------------
  // Tri de la liste des noms des utilisateur dans le sélecteur
  // -------------------------------------------------------------------------

  $("body").on("click", ".btn-sortGestion", function (event) {
    testSession();
    $(".btn-sortGestion").removeClass("btn-primary");
    $(this).addClass("btn-primary");
    var sortUsers = $(this).hasClass("parNom") ? "parNom" : "parPrenom";
    Cookies.set("sortUsers", sortUsers, { sameSite: "strict" });

    var pseudo = $("table#listeUsers tr.choosen").data("pseudo");
    $.post(
      "inc/gestion/refreshListeUsers.inc.php",
      {
        pseudo: pseudo,
      },
      function (resultat) {
        $("#selectUsersInscription").html(resultat);
      }
    );
  });

  // -------------------------------------------------------
  // Navigation de mois en mois
  // -------------------------------------------------------

  $("body").on("click", ".navigationAdmin", function (event) {
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

      $(".navigationAdmin").data("month", month);
      $(".navigationAdmin").data("year", year);

      Cookies.set("year", year, { sameSite: "strict" });
      Cookies.set("month", month, { sameSite: "strict" });

      $("#gestInscriptions").trigger("click");
    }
  });
  // ---------------------------------------------------------------------

  // -----------------------------------------------------------
  // Nouvelle inscription admin
  // -----------------------------------------------------------
  $("body").on("click", "#calendarGestion .btn-inscription", function (event) {
    testSession(event);

    var ceci = $(this);
    var pseudo = $("table#listeUsers tr.choosen").data("pseudo");
    var periode = ceci.data("periode");
    var date = ceci.data("date");
    var cb = ceci.closest("td").find("input:checkbox");
    cb.prop("checked", !cb.is(":checked"));

    ceci.closest("td").toggleClass("modified");

    if (cb.is(":checked")) {
      // on vient donc de demander une inscription
      // prévoyons l'avenir
      ceci.text("Désinscription");
      ceci.removeClass("btn-success").addClass("btn-danger");

      if (ceci.closest("td").find(".toDelete").length == 1) {
        // une demande d'inscription était marquée "to delete"; on va la réactiver
        ceci.closest("td").find(".me").removeClass("toDelete");
      } else {
        // c'est une nouvelle inscription; on prévoit donc l'inscription
        // avec le bouton "rose" ajouté à la liste des bénévoles
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
      // le bouton n'était pas "checked"; c'est qu'on vient de demander une désinscription
      // prévoyons l'avenir
      ceci.text("Inscription");
      ceci.removeClass("btn-danger").addClass("btn-success");

      // S'il y avait un candidat (en rose), le supprimer
      if (ceci.closest("td").find(".candidat").length == 1) {
        ceci.closest("td").find(".candidat").remove();
      } else {
        // marquer une vraie inscription comme temporairement désactivée et à supprimer
        ceci.closest("td").find(".me").addClass("toDelete");
      }
    }
  });

  // ----------------------------------------------------------------
  // Remise à zéro des demandes de modification du planning
  // ----------------------------------------------------------------
  $("body").on("click", "#resetCalendarGestion", function (event) {
    testSession(event);
    // suppression de l'attribut de classe
    $(".me").removeClass("toDelete");
    // suppression de tous les boutons temporaires
    $(".candidat").remove();

    $("#gestInscriptions").trigger("click");
  });

  // ---------------------------------------------------------------------
  //  Enregistrement des modifications apportées au planning des permanences
  // ---------------------------------------------------------------------
  $("body").on("click", "#saveCalendarGestion", function (event) {
    testSession(event);
    var month = $("input#month").val();
    var year = $("input#year").val();
    var formulaire = $("#formGrid").serialize();
    var title = "Enregistrement des permanences";
    // si la colonne des users est présente (mode admin),
    // on récupère le pseudo de l'utilisateur visé
    if ($("#listeUsers tr.choosen").length == 1)
      var pseudo = $("#listeUsers tr.choosen").data("pseudo");
    else var pseudo = Null;

    $.post(
      "inc/inscriptions/getModifications.inc.php",
      {
        month: month,
        year: year,
        formulaire: formulaire,
        pseudo: pseudo,
      },
      function (message) {
        bootbox.confirm({
          title: title,
          message: message,
          callback: function (result) {
            if (result == true) {
              // procédure semblable mais différente de celle de la branche "inscriptions"
              $.post(
                "inc/gestion/saveCalendar.inc.php",
                {
                  month: month,
                  year: year,
                  formulaire: formulaire,
                  pseudo: pseudo,
                },
                function (message2) {
                  bootbox.alert({
                    title: title,
                    message: message2,
                  });
                  $("#resetCalendarGestion").trigger("click");
                  $("#selectUsersInscription table tr.choosen").trigger(
                    "click"
                  );
                }
              );
            }
          },
        });
      }
    );
  });
});
