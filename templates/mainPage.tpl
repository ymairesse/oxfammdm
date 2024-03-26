<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button
      class="nav-link active"
      id="home-tab"
      data-bs-toggle="tab"
      data-bs-target="#home"
      type="button"
      role="tab"
      aria-controls="home"
      aria-selected="true"
    >
      Page d'accueil
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      class="nav-link"
      id="profile-tab"
      data-bs-toggle="tab"
      data-bs-target="#profile"
      type="button"
      role="tab"
      aria-controls="profile"
      aria-selected="false"
    >
      Mon profil
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      class="nav-link"
      id="messages-tab"
      data-bs-toggle="tab"
      data-bs-target="#planning"
      type="button"
      role="tab"
      aria-controls="planning"
      aria-selected="false"
    >
      Planning
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      class="nav-link"
      id="messages-tab"
      data-bs-toggle="tab"
      data-bs-target="#messages"
      type="button"
      role="tab"
      aria-controls="messages"
      aria-selected="false"
    >
      Messages
    </button>
  </li>
  {if $user['statut'] == 'admin'}
  <li class="nav-item" role="presentation">
    <button
      class="nav-link"
      id="settings-tab"
      data-bs-toggle="tab"
      data-bs-target="#settings"
      type="button"
      role="tab"
      aria-controls="settings"
      aria-selected="false"
    >
      Paramètres
    </button>
  </li>
  {/if}
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div
    class="tab-pane active"
    id="home"
    role="tabpanel"
    aria-labelledby="home-tab"
    tabindex="0"
  >
    {include file="start.tpl"}
  </div>
  <div
    class="tab-pane"
    id="profile"
    role="tabpanel"
    aria-labelledby="profile-tab"
    tabindex="0"
  >
    {include file="users/profilPerso.tpl"}
  </div>
  <div
    class="tab-pane"
    id="planning"
    role="tabpanel"
    aria-labelledby="profile-tab"
    tabindex="0"
  >
  Planning 
  </div>
  
  <div
    class="tab-pane"
    id="messages"
    role="tabpanel"
    aria-labelledby="messages-tab"
    tabindex="0"
  >
    Page 3
  </div>
  <div
    class="tab-pane"
    id="settings"
    role="tabpanel"
    aria-labelledby="settings-tab"
    tabindex="0"
  >
    Page 4
  </div>
</div>
