<form id="form-conges">
  <h2>Jours de congés</h2>

  {include file="conges/inc/selecteurContexte.tpl"}

  <div class="row">
    <div class="col-12 col-xl-6">
      <h3>Fermetures hebdomadaires</h3>

      {include file='conges/inc/hebdomadaires.tpl'}

    </div>

    <div class="col-12 col-xl-6">
      <h3>Jours fériés ou de fermeture extraordinaire</h3>

      {include file='conges/inc/feries.tpl'}
    </div>
  </div>
</form>
