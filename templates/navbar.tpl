<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"
      ><img src="images/logo-oxfam-mdm.png" alt="MDM Oxfam"
    /></a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarScroll"
      aria-controls="navbarScroll"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll">
        {if isset($user)}

        <li class="nav-item">
          <a class="nav-link" id="gestCalendrier" href="#"><i class="fa fa-calendar"></i> Calendrier des permanences</a>
        </li>

        {if  ($user.droits == 'admin')}
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            >Planning et Périodes</a
          >

          <ul class="dropdown-menu">
            <li>
              <a href="#" class="dropdown-item" id="gestInscriptions">
                <i class="fa fa-calendar"></i> Gestion des inscriptions
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item" id="gestPeriodes">
                <i class="fa fa-hourglass" aria-hidden="true"></i> Gestion des
                périodes
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item" id="gestConges">
                <i class="fa fa-key" aria-hidden="true"></i>
                Gestion des congés
              </a>
            </li>
          </ul>
        </li>
        {/if}

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            Préférences
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" id="editProfilPerso" href="#"
                ><i class="fa fa-user"></i> Profil personnel</a
              >
            </li>

            {if isset($user) && ($user.droits == 'admin')}
            <li>
              <a class="dropdown-item" id="gestUsers" href="#"
                ><i class="fa fa-users"></i> Gestion des utilisateurs</a
              >
            </li>

            {/if}
          </ul>
        </li>

        {/if}
        <li>
          <i
            id="ajaxLoader"
            style="display: none"
            class="fa fa-spinner fa-spin fa-3x fa-fw d-none"
          ></i>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <!-- Utilisation de ms-auto pour déplacer les boutons à droite -->

        {if !(isset($user))}
        <li class="nav-item">
          <a
            type="button"
            class="btn btn-warning btn-sm"
            href="#"
            id="creationCompte"
            title="Création d'un compte"
          >
            Créer un compte</a
          >
        </li>
        {/if}
        <li class="nav-item">
          {if isset($user)}
          <a
            role="button"
            class="btn btn-danger btn-sm"
            href="#"
            id="btn-logout"
            title="Déconnexion"
          >
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            <span id="loggedUser">
              <span id="never"></span>
              {$user.civilite} {$user.nom} {$user.prenom}</span
            >
          </a>
          {else}
          <a
            type="button"
            class="btn btn-success btn-sm"
            href="#"
            id="btn-login"
            title="Connexion"
          >
            <i class="fa fa-user"></i> Connexion</a
          >
          {/if}
        </li>
      </ul>
    </div>
  </div>
</nav>
