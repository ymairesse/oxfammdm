<!-- Modal -->
<div class="modal fade" id="modalLostPwd" tabindex="-1" aria-labelledby="modalLostPwdLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLostPwdLabel">Changement du mot de passe</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRenewPasswd">

          <div class="form-group">
            <label for="passwd">Veuillez indiquer votre identifiant (6 ou 7 signes) ou l'adresse mail de votre profil</label>
            <input type="text" class="form-control" id="identifiantMDP" name="identifiantMDP" minlength="6" maxlength="60"
              placeholder="Votre identifiant" value="">
          </div>
        
        <div class="clearfix"></div>

      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="btn-modalLostPwd">Envoyer la demande</button>
      </div>
    </div>
  </div>
</div>


<script>

  $(document).ready(function(){

    $('#modalLostPwd').modal('show');

  })

</script>

