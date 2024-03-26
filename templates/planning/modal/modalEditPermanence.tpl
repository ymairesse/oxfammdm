<!-- Modal -->
<div
  class="modal fade"
  id="modalEditPermanence"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="modalEditPermanenceLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditPermanenceLabel">
          Modal title
        </h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="formEditPermanence">
          <input type="hidden" name="idContexte" value="{$permanence.idContexte}" />
          <input
            type="hidden"
            name="numeroPermanence"
            value="{$permanence.numeroPermanence}"
          />
          <p>Permanence n° <strong>{$permanence.numeroPermanence}</strong> à partir du <strong>{$permanence.dateDebutContexte|date_format:"%d/%m/%Y"}</strong></p>
          <div class="row">
            <div class="col-6">
              <label for="heureDebut" class="form-label"
                >Heure de début</label
              >
              <input
                type="time"
                class="form-control"
                id="heureDebut"
                name="heureDebut"
                placeholder="Heure de début"
                value="{$permanence.heureDebut|default:''}"
              />
            </div>

            <div class="col-6">
              <label for="heureFin" class="form-label"
                >Heure de fin</label
              >
              <input
                type="time"
                class="form-control"
                id="heureFin"
                name="heureFin"
                placeholder="Heure de Fin"
                value="{$permanence.heureFin|default:''}"

              />
            </div>
          </div>
        </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annuler
        </button>
        <button type="button" class="btn btn-primary" id="btn-modalSavePeriodePermanence">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
