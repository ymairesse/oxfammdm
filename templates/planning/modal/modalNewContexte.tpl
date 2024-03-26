<!-- Modal -->
<div
  class="modal fade"
  id="modalNewContexte"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="modalNewContexteLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalNewContexteLabel">
          Nouveau contexte
        </h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="formNewContexte">
          <input
            type="hidden"
            name="lastContexte"
            id="lastContexte"
            value="{$lastContexte}"
          />

          <label for="dateDebut" class="form-label"
            >Date de début <u>après le {$lastContexte|date_format:"%d/%m/%Y"}</u>
          </label>
          <input
            type="date"
            class="form-control"
            id="dateDebutContexte"
            name="dateDebutContexte"
            placeholder="Date de début du contexte"
            value="{$lastContexte}"
          />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annuler
        </button>
        <button
          type="button"
          class="btn btn-primary"
          id="btn-modalSaveNewContexte"
        >
          Enregistrer
        </button>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function () {

  $.validator.addMethod(
    "minDate",
    function (value, element) {
      var minDate = new Date($("input#lastContexte").val());
      var inputDate = new Date(value);
      if (inputDate > minDate) return true;
      return false;
    },
    "Date invalide"
  ); // error message

    $("#formNewContexte").validate({
      rules: {
        dateDebutContexte: {
          required: true,
          date: true,
          minDate: true,
        },
      },
    });


  });
</script>
