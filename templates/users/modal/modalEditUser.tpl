<div
  class="modal fade"
  id="modalEditUser"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="modalEditUserLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 w-100" id="modalEditUserLabel">Fiche Utilisateur</h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">

        <form id="modalFormUser" autocomplete="false">

          <div class="row">
            <div class="pb-3 col-2">
              <label for="civilite">
                <i class="fa fa-female" aria-hidden="true"></i> 
                <i class="fa fa-male" aria-hidden="true"></i> 
                <i class="fa fa-genderless" aria-hidden="true"></i>
              </label>
              <select name="civilite" id="civilite" class="form-control">
                <option value="">Choisir</option>
                <option value="F"{if $dataUser.civilite == 'F'} selected{/if}>Madame</option>
                <option value="M"{if $dataUser.civilite == 'M'} selected{/if}>Monsieur</option>
                <option value="X"{if $dataUser.civilite == 'X'} selected{/if}>MX</option>
              </select>
              
            </div>
            <div class="form-group pb-3 col-4">
              <label for="nom">
                  Nom
              </label>
              <input
                type="text"
                class="form-control"
                name="nom"
                id="nom"
                value="{$dataUser.nom|default:''}"
                autocomplete="off"
                placeholder="Nom"
              />
            </div>
            <div class="form-group pb-3 col-4">
              <label for="prenom">
                Prénom
              </label>
              <input
                type="text"
                class="form-control"
                name="prenom"
                id="prenom"
                value="{$dataUser.prenom|default:''}"
                autocomplete="off"
                placeholder="Prénom"
              />
            </div>

            <div class="form-group pb-3 col-2">

              <label for="approuve">Approuvé</label>
              <input type="hidden" id="approuve" name="approuve" value="{$dataUser.approuve|default:0}">
              <div class="btn-group" role="group" aria-label="Approuvé">
                <button 
                  type="button" 
                  class="btn btn-approuve {if $dataUser.approuve == 1}btn-success{else}btn-outline-success{/if}" 
                  data-value="1"
                  {if $dataUser == $self} disabled title="Vous ne pouvez pas modifier cet item"{/if}>
                  Oui
                </button>
                <button 
                  type="button" 
                  class="btn btn-approuve {if $dataUser.approuve == 0}btn-danger{else}btn-outline-danger{/if}" 
                  data-value="0"
                  {if $dataUser == $self} disabled title="Vous ne pouvez pas modifier cet item"{/if}>
                  Non
                </button>
              </div>
              {if $dataUser == $self}
              <span class="helpBlock form-text">Non modifiable</span>
              {/if}
   
            </div>

            <div class="form-group pb-3 col-4">
              <label for="pseudo"><i class="fa fa-user-secret"></i> Pseudo</label>
              <input type="text"
              class="form-control"
              name="pseudo"
              id="pseudo"
              value="{$dataUser.pseudo|default:''}"
              autocomplete="off"
              readonly
              >
              <div class=">helpBlock form-text">Non modifiable</div>
            </div>

            <div class="form-group pb-3 col-4">
              <label for="pwd">M. passe</label>
              <div class="input-group mb-3">
                <span class="input-group-text addonMdp"><i class="fa fa-eye"></i></span>
                  <input type="password" 
                    class="form-control" 
                    name="pwd" 
                    id="pwd" 
                    autocomplete="off" 
                    value="" 
                    placeholder="Laisser vide si inchangé" 
                    aria-describedby="addonMdp">
              </div>
            </div>

            <div class="form-group pb-3 col-4">
              <label for="pwd2">M. passe (encore)</label>
              <div class="input-group mb-3">
                <span class="input-group-text addonMdp"><i class="fa fa-eye"></i></span>
            <input type="password" 
              class="form-control" 
              name="pwd2" 
              id="pwd2" 
              autocomplete="off" 
              value="" 
              placeholder="Laisser vide si inchangé" 
              aria-describedby="addonMdp">
              </div>
            </div>

            <div class="form-group pb-3 col-4">
              <label for="droits"><i class="fa fa-user-plus" aria-hidden="true"></i> Droits
              </label>
              <!-- Il est impossible de modifier ses propres droits -->
              {if $self.pseudo == $dataUser.pseudo}
              <input type="text" id="droits" name="droits" class="form-control" readonly value="{$dataUser.droits}">
              <span class="form-text">Non modifiable par vous</span>
              {else} 
              <select name="droits" class="form-control" id="droits">
                <option value="oxfam" {if $dataUser.droits == "oxfam"}selected{/if}>oxfam</option>
                <option value="admin" {if $dataUser.droits == "admin"}selected{/if}>admin</option>
              </select>
              {/if}

            </div>
            
            <div class="form-group pb-3 col-6 col-md-4">
              <label for="mail">
                <i class="fa fa-send" aria-hidden="true"></i> Mail
              </label
              >
              <input
                type="mail"
                class="form-control"
                name="mail"
                id="mail"
                value="{$dataUser.mail|default:''}"
                autocomplete="off"
                placeholder="Adresse mail"
              />
            </div>

             <div class="form-group pb-3 col-6 col-md-4">
              <label for="telephone"
                ><i class="fa fa-phone" aria-hidden="true"></i> 
                Téléphone
                </label
              >
              <input
                type="text"
                class="form-control contact phone"
                name="telephone"
                id="telephone"
                value="{$dataUser.telephone|default:''}"
                autocomplete="off"
                placeholder="Téléphone"
              />
            </div>

          <div class="form-group pb-3 col-6 col-md-5">
            <label for="adresse">
              Adresse
            </label>
            <input
              type="text"
              class="form-control"
              name="adresse"
              id="adresse"
              value="{$dataUser.adresse|default:''}"
              autocomplete="off"
              placeholder="Adresse rue / numéro"
            />
            <div id=">adresseHelpBlock" class="form-text">Optionnel</div>
          </div>

          <div class="form-group pb-3 col-5 col-md-3">
            <label for="cpost">
              Code postal
            </label>
            <input
              type="text"
              class="form-control"
              name="cpost"
              id="cpost"
              value="{$dataUser.cpost|default:''}"
              autocomplete="off"
              placeholder="Code Postal"
            />
            <div id="cpostHelpBlock" class="form-text">Optionnel</div>
          </div>
          
            <div class="form-group pb-3 col-7 col-md-4">
              <label for="commune">
                Commune
              </label>
              <input
                type="text"
                class="form-control"
                name="commune"
                id="commune"
                value="{$dataUser.commune|default:''}"
                autocomplete="off"
                placeholder="Commune"
              />
              <div id="communeHelpBlock" class="form-text">Optionnel</div>
            </div>
           
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annuler
        </button>
        <button type="button" class="btn btn-primary" id="btn-modalSaveProfile">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<style>

  div.error {
    color: red;
  }

</style>

<script>

  function phoneFormatter() {
      $('.phone').on('input', function() {
        var number = $(this).val().replace(/[^\d+]/g, '')
        if (number.length == 9) {
            var pfx = number.substr(0,2);
            var no = number.substr(2,)
            number = pfx + " " + no;
        } else if (number.length == 10) {
            var pfx = number.substr(0,4);
            var no = number.substr(4,)
            number = pfx + " " + no;
        }
        $(this).val(number)
      });
    };

  $(document).ready(function () {

    $(phoneFormatter);

    $('.btn-approuve').click(function() {
      var value = $(this).data('value');
      $('#approuve').val(value);
      if (value == 1) {
        $('.btn-approuve[data-value="1"]').addClass('btn-success').removeClass('btn-outline-success');
        $('.btn-approuve[data-value="0"]').addClass('btn-outline-danger').removeClass('btn-danger');
      }
      else {
        $('.btn-approuve[data-value="0"]').addClass('btn-danger').removeClass('btn-outline-danger');
        $('.btn-approuve[data-value="1"]').addClass('btn-outline-success').removeClass('btn-success');
        }
    });

    $("#modalFormUser").validate({
      lang: "fr",
      errorElement: "div",
      rules: {
        nom: {
          required: true,
        },
        prenom: {
          required: true,
        },
        telephone: {
          required: true,
        },
          pwd: {
          required: false,
          minlength: 6,
          pwcheck: true,
        },
        pwd2: {
          equalTo: "#pwd",
        },
        mail: {
          required: true,
          email: true,
        },
        droits: {
          required: true,
        }
      },
      errorPlacement: function (error, element) {
        if (element.parent().hasClass("input-group")) {
          error.insertAfter(element.parent(".input-group"));
        } else {
          error.insertAfter(element);
        }
      },
      messages: {
        pwd: {
          pwcheck: "Au moins deux lettres et au moins 2 chiffres",
        },
      },
    });

    $.validator.addMethod("pwcheck", function (value, element) {
      var countNum = (value.match(/[0-9]/g) || []).length;
      var countLet = (value.match(/[a-zA-Z]/g) || []).length;
      // un mot de passe n'est pas obligatoire pour un compte déjà défini
      var pseudo = $('#pseudo').val();
      if ((element.value == "") && (pseudo != "")) return true;
      else return countNum >= 2 && countLet >= 2;
    });

  });
</script>
