<h1 title="{$pseudo}">Calendrier des permanences: {$identite.civilite} {$identite.prenom} {$identite.nom}</h1>

<div class="pull-left button-group">

  <button type="button" id="saveCalendarGestion" class="btn btn-sm btn-danger"><i class="fa fa-floppy-o" aria-hidden="true"></i> N'oubliez pas d'enregistrer</button>
  <button type="button" id="resetCalendarGestion" class="btn btn-sm btn-beige"><i class="fa fa-eraser" aria-hidden="true"></i> Annuler les modifications</button>
</div>

<h2 class="text-center">
  {$monthName} {$year}
  <span class="pull-right"
    ><button
      class="btn btn-primary btn-sm navigationAdmin"
      data-gap="-1"
      title="Mois précédent"
      data-month="{$month}"
      data-year="{$year}"
    >
      <i class="fa fa-hand-o-left" aria-hidden="true"></i>
    </button>
    <button
      type="button"
      class="btn btn-secondary btn-sm"
      id="btn-todayAdmin"
      title="Ce mois-ci"
    >
      Mois actuel
    </button>
    <button
      class="btn btn-primary btn-sm navigationAdmin"
      data-gap="+1"
      title="Mois suivant"
      data-month="{$month}"
      data-year="{$year}"
    >
      <i class="fa fa-hand-o-right" aria-hidden="true"></i>
    </button>
  </span>
</h2>

<form id="formGrid">

<input type="hidden" name="month" id="month" value="{$month}">
<input type="hidden" name="year" id="year" value="{$year}">

<table class="table table-condensed" id="calendarGestion">
  {foreach from=$monthGrid key=jourDuMois item=dataJournee}
  <tr
    data-jourdumois="{$jourDuMois}"
    data-jourSemaine="{$dataJournee.noJourSemaine}"
    data-date="{$dataJournee.date}"
    data-idcontexte="{$dataJournee.idContexte}"
  >
    {assign var=idContexte value=$dataJournee.idContexte}
    <td class="jourDate px-0 py-0" style="width: 10%">
      <p>
        {$dataJournee.nomDuJour|upper|substr:0:2}<br />{$dataJournee.date|date_format:"%d"}/{$dataJournee.date|date_format:"%m"}<br />
      </p>

      <div class="d-grid">
        <button type="button" class="btn btn-sm btn-success btn-confirm py-0 w-100" data-nombre="1">1</button>
        <button type="button" class="btn btn-sm btn-warning btn-confirm py-0 w-100" data-nombre="2">2</button>
        <button type="button" class="btn btn-sm btn-info btn-confirm py-0 w-100" data-nombre="3">3</button>
      </div>

    </td>

    {foreach from=$dataJournee.periodes key=noPeriode item=dataPeriode name=boucle}

    <td class="tdwidth {if $dataPeriode.closed} conge{/if}">
      
      <!--  checkbox invisible pour conserver l'information ----------------------------------------------- -->
      {if !($dataPeriode.closed)} 
        <input type="checkbox" name="inscriptions[]" class="inscription" value="{$dataJournee.date}_{$noPeriode}"
          data-date="{$dataJournee.date}" data-periode="{$noPeriode}"  
          {if isset($dataPeriode.benevoles) && in_array($pseudo, array_keys($dataPeriode.benevoles))} checked{/if} 
          hidden
          > 
      {/if}
      <!--  checkbox invisible pour conserver l'information ----------------------------------------------- -->

      <div class="mb-2">
        <span class="badge bg-primary">{$dataPeriode.heureDebut}</span>

        <!-- si c'est un jour de congé, on laisse la cellule vide -->
        {if $dataPeriode.closed != 1}
          <!-- S'il y a des inscriptions et que l'utilisateur actuel est dans la liste  -->
          
          <button 
            type="button" 
            class="btn btn-sm btn-inscription pull-right 
            {if isset($dataPeriode.benevoles) && in_array($pseudo, array_keys($dataPeriode.benevoles))} btn-danger{else} btn-success{/if}"
            data-placement="left" 
            data-toggle="tooltip" 
            title="Inscription ou désinscription"
            data-date="{$dataJournee.date}"
            data-periode="{$noPeriode}"
            >
            <!-- Si l'utilisateur actif est déjà inscrit, on lui propose la désinscription   -->
            {if isset($dataPeriode.benevoles) && in_array($pseudo, array_keys($dataPeriode.benevoles))}
            Désinscription
            {else} 
            <!-- Sinon, l'inscription                                                         -->
            Inscription
            {/if}
          </button>

        {/if}
        
      </div>

      <div class="listeBenevoles">
        
      {if isset($dataPeriode.benevoles)}
       {foreach from=$dataPeriode.benevoles key=unPseudo item=dataBenevole}

      <button
        type="button"
        data-pseudo="{$unPseudo}"
        class="btn btn-sm w-100 {if $pseudo == $unPseudo}me{else}benevole{/if}"
      >
        <span class="d-none d-md-block">
          {$dataBenevole.civilite} {$dataBenevole.prenom} {$dataBenevole.nom}
        </span>
        <span
          class="d-md-none d-sm-block"
          title="{$dataBenevole.civilite} {$dataBenevole.prenom} {$dataBenevole.nom}"
        >
          {$dataBenevole.prenom}
        </span>
      </button>
      {/foreach} 
      {/if}
      </div>
    </td>

    {/foreach}
  </tr>
  {/foreach}
</table>
</form>


<style>
  td {
    border: 1px solid black;
  }
</style>

<script>
  function largeurTd() {
    var tableau = $("table#calendarGestion");
    var nbCols = tableau.find("tr:first-child td").length - 1;
    var width = 90 / nbCols;
    var strWidth = width + "%";
    $(".tdwidth").prop("width", strWidth);
  }

  function dateNavigation() {
    const date = new Date();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    $("#btn-today").data("year", year);
    $("#btn-today").data("month", month);
  }

  $(document).ready(function () {

    largeurTd();
    dateNavigation();

  });
</script>
