function testSession() {
  $.post("inc/testSession.inc.php", {}, function (resultat) {
    if (resultat == "") {
      bootbox.alert({
        title: "Dépassement du délai",
        message: "Votre session s'est achevée. Veuillez vous reconnecter.",
        callback: function () {
          window.location.replace("index.php");
        },
      });
    }
  });
}

function isDoubleClicked(element) {
  //if already clicked return TRUE to indicate this click is not allowed
  console.log("double click prevented");
  if (element.data("isclicked")) return true;
  //mark as clicked for 1 second
  element.data("isclicked", true);
  setTimeout(function () {
    element.removeData("isclicked");
  }, 1000);

  //return FALSE to indicate this click was allowed
  return false;
}

$(function () {
  
  bootbox.setDefaults({
    locale: "fr",
    backdrop: true,
  });

  $(document).ajaxStart(function () {
    // Affiche l'image de chargement au début de chaque appel ajax
    $("#ajaxLoader").show();
  });
  $(document).ajaxStop(function () {
    // Cache l'image de chargement à la fin de chaque appel ajax
    $("#ajaxLoader").hide();
  });

  // login - logout ------------------------------------------------
  //
  $("body").on("click", "#btn-login", function () {
    if (isDoubleClicked($(this))) return;
    $.post("inc/modalLogin.inc.php", {}, function (resultat) {
      $("#modal").html(resultat);
      $("#modalLogin").modal("show");
    });
  });

  $("body").on("click", "#btn-modalLogin", function () {
    if ($("#form-login").valid()) {
      var identifiant = $("#identifiant").val();
      var passwd = $("#passwd").val();
      $.post(
        "inc/login.inc.php",
        {
          identifiant: identifiant,
          passwd: passwd,
        },
        function (resultat) {
          var title = "Connexion";
          switch (resultat) {
            case "ko":
              message = "Adresse mail, pseudo et/ou mot de passe incorrect.";
              bootbox.alert({
                title: title,
                message: message,
              });
              break;
            case "unapproved":
              message = "Votre accès doit encore être approuvé. Patience.";
              bootbox.alert({
                title: title,
                message: message,
              });
              break;
            default:
              bootbox.alert({
                title: title,
                message: "Bienvenue au magasin Oxfam",
                callback: function () {
                  window.location.assign("index.php");
                },
              });
          }

          $("#modalLogin").modal("hide");
        }
      );
    }
  });

  // -----------------------------------------------
  // fermeture de l'application
  // -----------------------------------------------
  $("body").on("click", "#btn-logout", function () {
    if (isDoubleClicked($(this))) return;
    bootbox.confirm({
      title: "Déconnexion",
      message: "Veuillez confirmer la déconnexion",
      callback: function (result) {
        if (result == true) {
          $.post("inc/logout.inc.php", {}, function () {
            window.location.reload("index.php");
          });
        }
      },
    });
  });

  // -----------------------------------------------
  // visualisation du mot de passe dans un champ "password"
  // -----------------------------------------------
  $("body").on("click", ".addonMdp", function () {
    if ($(this).next().prop("type") == "password") {
      $(this).next().prop("type", "text");
    } else $(this).next().prop("type", "password");
  });

  // -------------------------------------------------
  // Mot de passe perdu
  // -------------------------------------------------
  $("body").on("click", "#btn-lostMDP", function () {
    $("#modalLogin").modal("hide");
    var title = "Changement de mot de passe";
    bootbox.prompt({
      title: title,
      message:
        "Veuillez indiquer votre identifiant (6 caractères) ou l'adresse mail de votre profil",
      callback: function (identifiant) {
        // préparation d'un token
        $.post(
          "inc/prepareNewPasswd.inc.php",
          {
            identifiant: identifiant,
          },
          function (resultat) {
            bootbox.alert(resultat);
          }
        );
      },
    });
  });

  $("body").on("click", "#btn-modalRenewPwd", function () {
    var formulaire = $("#formRenewPasswd").serialize();
    $.post(
      "inc/users/saveNewPassword.inc.php",
      {
        formulaire: formulaire,
      },
      function (message) {
        $("#modalRenewPwd").modal("hide");
        bootbox.alert({
          title: "Changement du mot de passe",
          message: message,
        });
      }
    );
  });
});
