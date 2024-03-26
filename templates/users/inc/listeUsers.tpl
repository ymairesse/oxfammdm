<button type="button" id="creationCompte" class="btn btn-success text-truncate w-100"><i class="fa fa-edit"></i> Nouvel Utilisateur Oxfam</button>

<label class="w-100" for="listeUsers">Liste des utilisateurs
    <div class="btn-group float-end">
        <button
          class="btn btn-sm btn-sort parNom py-0 {if (isset($sortUsers) && ($sortUsers == 'parNom') || (!(isset($sortUsers))))}btn-primary{else}btn-default{/if}"
          title="Par ordre des noms"
        >
        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Noms
        </button>
        <button
          class="btn btn-sm btn-sort parPrenom py-0 {if isset($sortUsers) && ($sortUsers == 'parPrenom')}btn-primary{else}btn-default{/if}"
          title="Par ordre des prénoms"
        >
        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prénoms
        </button>

      </div>
</label>

<table class="table table-sm w-100" id="listeUsers">

    <tr>
        <th class="w-65">Nom</th>
        <th class="w-15">Droits</th>
        <th class="w-20">Pseudo</th>
    </tr>
        <!-- L'utlisateur actif ne peut modifier son propre profil -->
    {foreach from=$listeUsers key=pseudoOneUser item=user}

        <tr class="{if $pseudoOneUser == $pseudo}choosen{/if}" data-pseudo="{$pseudoOneUser}">
            <td>
                {if $sortUsers == 'parNom'}
                {$user.nom} {$user.prenom}
                {else} 
                {$user.prenom} {$user.nom}
                {/if}
            </td>
            <td>{$user.droits}</td>
            <td>{$pseudoOneUser}</td>
        </tr>

    {/foreach}

</table>

<button type="button" class="btn btn-danger text-truncate w-100" id="btn-delUser"><i class="fa fa-times"></i> Supprimer cet utilisateur</button>