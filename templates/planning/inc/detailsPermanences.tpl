<h3>Date pivot: {$date|date_format:"%d/%m/%Y"} pour le contexte n° {$idContexte}</h3>

<table class="table table-condensed" id="tableContextes">
  <tr>
    <th style="width: 1em">&nbsp;</th>
    <th>n°</th>
    <th>Heure de début</th>
    <th>Heure de fin</th>
    <th style="width: 1em">&nbsp;</th>
  </tr>

  {foreach $permanences key=numeroPermanence item=unContexte}
  <tr
    data-idcontexte="{$idContexte}"
    data-numeropermanence="{$unContexte.numeroPermanence}"
  >
    <td>
      <button
        class="btn btn-danger btn-sm btn-delPermanence"
        title="Supprimer cette permanence"
      >
        <i class="fa fa-times"></i>
      </button>
    </td>
    <td>{$numeroPermanence}</td>
    <td class="hdebut">{$unContexte.heureDebut}</td>
    <td class="hfin">{$unContexte.heureFin}</td>
    <td>
      <button
        class="btn btn-warning btn-sm btn-editPermanence"
        title="Modifier cette permanence"
      >
        <i class="fa fa-edit"></i>
      </button>
    </td>
  </tr>
  {/foreach}
</table>
<button class="btn btn-warning w-100" id="btn-addPermanence">
  <i class="fa fa-plus"></i> Ajouter des permanences
</button>
