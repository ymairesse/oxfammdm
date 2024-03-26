<h2>Profil personnel</h2>

<div class="container">
  <form action="#" id="formProfilPerso">
    <div class="row">
      <div class="col-2 col-md-1">
        <div class="mb-3">
          <label for="nom">Civilité *</label>
          <input
            type="text"
            name="civilite"
            id="civilite"
            class="form-control"
            value="{$user.civilite|default:''}"
            readonly
          />
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label for="nom">Nom *</label>
          <input
            type="text"
            name="nom"
            id="nom"
            class="form-control"
            value="{$user.nom|default:''}"
            readonly
          />
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label for="prenom">Prénom *</label>
          <input
            type="text"
            name="prenom"
            id="prenom"
            class="form-control"
            value="{$user.prenom|default:''}"
            readonly
          />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="mb-3">
          <label for="mail">Adresse mail *</label>
          <input
            type="mail"
            name="mail"
            id="mail"
            class="form-control"
            value="{$user.mail|default:''}"
            readonly
          />
          <div id="mailHelpBlock" class="form-text">
            Une adresse mail valide est requise
          </div>
        </div>
      </div>

      <div class="col">
        <div class="mb-3">
          <label for="pseudo">Pseudo</label>
          <input
            type="text"
            name="pseudo"
            id="pseudo"
            class="form-control"
            value="{$user.pseudo|default:''}"
            readonly
          />
          <div id="pseudoHelpBlock" class="form-text">Non modifiable</div>
        </div>
      </div>

      <div class="col">
        <div class="mb-3">
            <label for="statut">Statut</label>
            <input type="text" name="statut" id="statut" class="form-control" value="{$user.statut|default:'Oxfam'}" readonly />
            <div id="statutHelpBlock" class="form-text">Modifiable par un·e admin</div>
        </div>
      </div>

      </div>

      <div class="row">
      <div class="col">
        <div class="mb-3">
          <label for="adresse">Adresse (rue, n°)</label>
          <input
            type="text"
            name="adresse"
            id="adresse"
            class="form-control"
            value="{$user.adresse|default:''}"
            readonly
          />
          <div id="adresseHelpBlock" class="form-text">Optionnel</div>
        </div>
      </div>

      <div class="col-2">
        <div class="mb-3">
          <label for="cpost">C. Postal</label>
          <input
            type="text"
            name="cpost"
            id="cpost"
            class="form-control"
            value="{$user.cpost|default:''}"
          />
          <div id="cpostHelpBlock" class="form-text">Optionnel</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="mb-3">
          <label for="commune">Commune</label>
          <input
            type="text"
            name="commune"
            id="commune"
            class="form-control"
            value="{$user.commune|default:''}"
          />
          <div id="communeHelpBlock" class="form-text">Optionnel</div>
        </div>
      </div>
    </div>

    <button type="button" class="btn btn-warning float-end" id="btn-editProfilPerso">Modifier mon profil</button>

  </form>

  <p>Les champs marqués d'une * sont obligatoires.</p>
  <p>
    Aucune de ces informations ne sera communiquée hors de l'application de
    gestion du planning.
  </p>
</div>
