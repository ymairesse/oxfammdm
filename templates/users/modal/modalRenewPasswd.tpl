<!-- Modal -->
<div
  class="modal fade"
  id="modalRenewPwd"
  tabindex="-1"
  aria-labelledby="modalRenewPwdLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalRenewPwdLabel">
          Changement du mot de passe
        </h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="formRenewPasswd">

          <input type="hidden" name="token" id="token" value="{$token}">
          <input type="hidden" name="pseudo" id="pseudo" value="{$pseudo}">

          <p>Bonjour <strong>{$distrait.prenom}</strong>. Votre identifiant est <strong>{$pseudo}</strong></p>

          <p>Veuillez entrer deux fois votre nouveau mot de passe</p>
          <div class="row">
          <div class="form-group pb-3 col-6">
            <label for="password">Mot de passe</label>
            <div class="input-group mb-3">
              <span class="input-group-text addonMdp"
                ><i class="fa fa-eye"></i
              ></span>
              <input
                type="password"
                class="form-control"
                name="pwd"
                id="pwd"
                autocomplete="off"
                value=""
                placeholder="Au moins 6 caractères"
                aria-describedby="addonMdp"
              />
            </div>
          </div>

          <div class="form-group pb-3 col-6">
            <label for="password">Mot de passe (encore)</label>
            <div class="input-group mb-3">
              <span class="input-group-text addonMdp"
                ><i class="fa fa-eye"></i
              ></span>
              <input
                type="password"
                class="form-control"
                name="pwd2"
                id="pwd2"
                autocomplete="off"
                value=""
                placeholder="Au moins 6 caractères"
                aria-describedby="addonMdp"
              />
            </div>
          </div>
        </div>
          <div class="clearfix"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annuler
        </button>
        <button type="button" class="btn btn-primary" id="btn-modalRenewPwd">
          Changer le mot de passe
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  
  $.validator.addMethod(
    "lettresEtSymboles",
    function (value, element) {
      // Expression régulière pour vérifier si le champ contient au moins 2 lettres et au plus 2 symboles non alphanumériques
      var lettreRegex = /.*[a-zA-Z].*[a-zA-Z]/;
      var symboleRegex = /[^a-zA-Z0-9]/g;
      var symboles = value.match(symboleRegex);
      var nombreSymboles = symboles ? symboles.length : 0;
      return lettreRegex.test(value) && nombreSymboles <= 2;
    },
    "Au moins deux lettres et au plus deux symboles."
  );

  $(document).ready(function () {
    $("#modalRenewPwd").modal("show");

    $("#formRenewPasswd").validate({
      rules: {
        pwd: {
          required: true,
          minlength: 6,
          maxlength: 12,
          lettresEtSymboles: true,
        },
        pwd2: {
          minlength: 6,
          equalTo: "#pwd",
        },
      },
    });
  });
</script>
