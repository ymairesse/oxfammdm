<h3>Liste des contextes</h3>
<table class="table table-condensed" id="listeContextes">
  <tbody>
    {foreach from=$listeContextes key=unContexte item=$date}
    <tr
      data-idcontexte="{$unContexte}"
      data-date="{$date}"
      class="{if $idContexte == $unContexte}choosen{/if}"
    >
      <td>{$unContexte}</td>
      <td>Depuis le {$date|date_format:"%d/%m/%Y"}</td>
    </tr>

    {/foreach}
  </tbody>
</table>
<button type="button" class="btn btn-warning w-100" id="btn-addEpoque"><i class="fa fa-plus"></i> Ajouter un contexte</button>
