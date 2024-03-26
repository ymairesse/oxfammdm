<div class="d-flex">
    
    <label for="idContexte" class="me-3 text-danger" style="font-size:16pt">Contexte</label>
    <select class="form-select" name="idContexte" id="idContexte" aria-label="Contexte">
      <option>Choix du contexte</option>
      {foreach from=$listeDoubleContextes key=unIdContexte item=datesContexte} 
      <option value="{$unIdContexte}"{if $unIdContexte == $idContexte} selected{/if}>

        Depuis le {$datesContexte[0]} 
         
        {if $datesContexte[1] != "..." }
          jusqu'au 
          {$datesContexte[1]} exclu
          {else} 
          ... 
        {/if} 
        </option>
      {/foreach}
    </select>
    <button type="button" class="btn btn-warning" id="btn-setContexte2day">Aujourd'hui</button>
    
  </div>