<table class="table table-condensed" id="tableFeries">
  <tbody>
    <tr>
      <th>
        Date<br />
        <button
          type="button"
          class="btn btn-sm btn-warning w-100"
          id="btn-addFerie"
          title="Ajouter une date"
          data-idcontexte="{$idContexte}"
        >
          <i class="fa fa-plus"></i>
        </button>
      </th>
      {foreach from=$listePeriodes key=numeroPermanence item=permanence}
      <th>
        <span class="d-none d-xl-inline"
          >{$permanence.heureDebut} - {$permanence.heureFin}</span
        >
        <span class="d-inline d-xl-none">{$numeroPermanence}</span>
      </th>
      {/foreach}
      <td style="width: 1em">&nbsp;</td>
    </tr>

    {foreach from=$listeCongesFeries key=laDate item=lesPeriodes}

    <tr class="congesFeries">
      <td>
        <div class="form-group">
          <input
            type="date"
            name="datesConge[]"
            class="form-control"
            placeholder="date"
            value="{$laDate}"
            readonly
          />
        </div>
      </td>

      {foreach from=$listePeriodes key=noPeriode item=permanence}
      <td>
        <div class="form-check form-switch">
          <input class="form-check-input switchFerie"
          data-periode="{$noPeriode}" type="checkbox" role="switch"
          value="{$noPeriode}" id="switch_{$laDate}_{$noPeriode}"
          data-ladate="{$laDate}" {if
          isset($listeCongesFeries.$laDate.$noPeriode) &&
          ($listeCongesFeries.$laDate.$noPeriode == 1)}checked{/if} 
          />

          <label
            class="form-check-label"
            for="switch_{$laDate}_{$noPeriode}"
          ></label>
        </div>
        
      </td>
      {/foreach}
      <td>
        <button
          type="button"
          class="btn btn-sm btn-danger btn-delConge"
          title="Suppression de la ligne"
        >
          <i class="fa fa-times"></i>
        </button>
      </td>
    </tr>
    {/foreach}
  </tbody>
</table>
