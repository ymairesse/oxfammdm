<button
  type="button"
  data-pseudo="{$identite.pseudo}"
  class="btn btn-pink btn-sm candidat w-100"
  title="N'oubliez pas d'enregistrer"
>
  <span class="d-none d-md-block"
    >{$identite.civilite} {$identite.prenom} {$identite.nom}
    <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span
  >
  <span class="d-md-none d-sm-block"
    >{$identite.prenom|truncate:10:"...":true}
    <span class="disk">(<i class="fa fa-floppy-o"></i>)</span></span
  >
</button>
