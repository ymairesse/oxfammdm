<table class="table table-condensed">
  <thead>
    <tr>
      <th style="width: 10%">Jour</th>
      {foreach from = $listePeriodes key=noPeriode item=permanence}
      <th>
        <span class="d-none d-xl-inline"
          >{$permanence.heureDebut} - {$permanence.heureFin}</span
        >
        <span class="d-inline d-xl-none">{$noPeriode}</span>
      </th>
      {/foreach}
    </tr>
  </thead>

  <tbody>
    {foreach from=$daysOfWeek key=noJour item=jourFR}
    <tr data-jour="{$jourFR}">
      <th>{$jourFR}</th>
      {foreach from=$listePeriodes key=noPeriode item=permanence}
      <td data-jour="{$noJour}" data-periode="{$noPeriode}">
        <div class="form-check form-switch">
          <input 
            class="form-check-input switchHebdo" 
            type="checkbox" 
            role="switch"
            value="{$noJour}_{$noPeriode}" 
            data-jour="{$noJour}"
            data-periode="{$noPeriode}" 
            id="switch_{$noJour}_{$noPeriode}" 
            {if isset($listeCongesHebdo.$noJour.$noPeriode) && ($listeCongesHebdo.$noJour.$noPeriode == 1)} checked{/if}>
          <label class="form-check-label" for="switch_{$noJour}_{$noPeriode}"></label>
        </div>

      </td>
      {/foreach}
    </tr>

    <tr>
      {/foreach}
    </tr>
  </tbody>
</table>
