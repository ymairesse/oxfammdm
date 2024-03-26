<!-- Modal -->
<div
  class="modal fade"
  id="modalAddFerie"
  tabindex="-1"
  aria-labelledby="modalAddFerieLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAddFerieLabel">
          Edition d'un jour férié
        </h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="form-addFerie">
          <input
            type="hidden"
            name="dateDebut"
            id="dateDebut"
            value="{$datesLimites.0}"
          />
          <input
            type="hidden"
            name="dateFin"
            id="dateFin"
            value="{$datesLimites.1}"
          />
          <input type="hidden" name="idContexte" value="{$idContexte}" />

          <p>
            Depuis le
            <strong>{$datesLimites.0|date_format:'%d/%m/%Y'}</strong> {if
            $datesLimites.1 != '...'}jusqu'au
            <strong>{$datesLimites.1|date_format:'%d/%m/%Y'}</strong>
            exclus{/if}
          </p>

          <div class="form-group">
            <label for="jourFerie">Jour férié (même partiellement)</label>
            <input
              type="date"
              name="jourFerie"
              id="jourFerie"
              class="form-control"
              value="{$jourFerie|default:''}"
            />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annuler
        </button>
        <button
          type="button"
          class="btn btn-primary"
          id="btn-modalSaveAddFerie"
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
      var minDate = new Date($("input#dateDebut").val());
      var inputDate = new Date(value);
      if (inputDate >= minDate) return true;
      return false;
    },
    "Date passée"
  ); // error message

  $.validator.addMethod(
    "maxDate",
    function (value, element) {
      var maxDate = new Date($("input#dateFin").val());
      var inputDate = new Date(value);
      if (inputDate < maxDate) return true;
      return false;
    },
    "Date trop éloignée"
  ); // error message

  {if ($datesLimites[1] == '...')}

    $('#form-addFerie').validate({
        rules: {
          jourFerie: {
            required: true,
            date: true,
            minDate: true,
          },
        },
      })

  {else}

    $('#form-addFerie').validate({
        rules: {
          jourFerie: {
            required: true,
            date: true,
            minDate: true,
            maxDate: true,
          },
        },
      })

    {/if}

  })
</script>
