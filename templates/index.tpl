<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Oxfam - Magasin du Monde</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/screen.css" />
    <link rel="stylesheet" href="css/boutons.css" />
    <link
      rel="stylesheet"
      href="fa/css/font-awesome.min.css"
      type="text/css"
      media="screen, print"
    />
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <script src="bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/jsCookie/src/js.cookie.js"></script>

    <script src="js/javascript.js"></script>
    <script src="js/javascriptUsers.js"></script>
    <script src="js/javascriptPlanning.js"></script>
    <script src="js/javascriptConges.js"></script>
    <script src="js/javascriptInscriptions.js"></script>
    <script src="js/javascriptGestion.js"></script>

    <script src="js/jqvalidate/dist/jquery.validate.min.js"></script>
    <script src="js/jqvalidate/dist/additional-methods.min.js"></script>
    <script src="js/jqvalidate/dist/localization/messages_fr.js"></script>
    
    <script src="js/bootbox.all.min.js"></script>
  </head>
  <body>
    <div class="container-fluid" id="menu">
      <div class="row">{include file="navbar.tpl"}</div>
    </div>

    <div class="container-fluid" id="corpsPage">{include file="start.tpl"}</div>

    {if $action == 'renewPasswd'} {include
    file="users/modal/modalRenewPasswd.tpl"} {/if}

    <div id="modal"></div>

    {include file="footer.tpl"}
  </body>
</html>
