<?php

class User
{
    private $mail;
    private $pseudo;
    private $applicationName;

    // --------------------------------------------
    // fonction constructeur
    public function __construct($identifiant, $md5passwd)
    {
        if (isset ($identifiant)) {
            $this->applicationName = APPLICATION;
            $identite = $this->getIdentite($identifiant, $md5passwd);
            $this->mail = $identite['mail'];
            $this->pseudo = $identite['pseudo'];
        }
    }

    /**
     * retourne toutes les informations de la table des utilisateurs $identifiant
     * @param string $$identifiant
     * @param string $md5pwd
     *
     * @return array
     */
    public function getIdentite($identifiant, $md5pwd)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT pseudo, civilite, nom, prenom,  droits, mail, telephone, ';
        $sql .= 'adresse, cpost, commune, homonyme, md5pwd, approuve ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE (mail = :identifiant OR pseudo = :identifiant) AND md5pwd = :md5pwd ';

        $requete = $connexion->prepare($sql);

        $requete->bindParam(':identifiant', $identifiant, PDO::PARAM_STR, 100);
        $requete->bindParam(':md5pwd', $md5pwd, PDO::PARAM_STR, 40);

        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $identite = $requete->fetch();
        }
        Application::DeconnexionPDO($connexion);

        return $identite;
    }

    /**
     * retourne nom, prénom et mail de l'utilisateur actif
     *
     * @param void
     *
     * @return array
     */
    public function getUser()
    {
        return ($this->identite);
    }

    /**
     * retourne le pseudo de l'utilisateur actif
     * 
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * retourne l'adresse mail de l'utilisateur actif
     * 
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
    /**
     * retourne $pseudo et $mail de l'utilisateur dont le mail est $mail
     * 
     * @param string $mail
     * 
     * @return array
     */
    public static function getIdentite4mail($mail)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT mail, pseudo ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE mail = :mail LIMIT 1';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 60);

        $resultat = $requete->execute();

        $ligne = array();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
            switch ($ligne['civilite']) {
                case 'M':
                    $ligne['civilite'] = 'M. ';
                    break;
                case 'F':
                    $ligne['civilite'] = 'Mme ';
                    break;
                default:
                    $ligne['civilite'] = 'Mme/M.';
                    break;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $ligne;
    }

    /**
     * retourne toutes les informations d'identité d'un utilisateur
     * quelconque dont on fournit le pseudo
     *
     * @param string $pseudo
     *
     * @return array
     */
    public static function getIdentiteUser($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT civilite, pseudo, nom, prenom, droits, mail, adresse, cpost, commune, ';
        $sql .= 'telephone, homonyme, approuve ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $ligne = array();
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
            switch ($ligne['civilite']) {
                case 'M':
                    $ligne['civilite'] = 'M. ';
                    break;
                case 'F':
                    $ligne['civilite'] = 'Mme ';
                    break;
                default:
                    $ligne['civilite'] = 'Mme/M. ';
                    break;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $ligne;
    }

    /**
     * renvoie les informations d'identification réseau de l'utilisateur courant.
     *
     * @return array ip, hostname, date, heure
     */
    public static function identiteReseau()
    {
        $data = array();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['date'] = date('d/m/Y');
        $data['heure'] = date('H:i');

        return $data;
    }

    /**
     * nettoie tous les tokens plus anciens que 48 heures dans la table lostPasswd
     *
     * @return int : nombre de suppressions
     */
    public static function clearTokens()
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'lostPasswd ';
        $sql .= 'WHERE date < DATE_SUB(NOW(), INTERVAL 48 HOUR) ';
        $requete = $connexion->prepare($sql);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;
    }

    /**
     * supprime les tokens de l'utilisateur $pseudo
     *
     * @param string $pseudo
     *
     * @return int
     */
    public static function clearToken($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'lostPasswd ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Création d'un lien enregistré dans la base de données pour la récupération du mdp
     *
     * @param void
     *
     * @return string
     */
    public static function createPasswdLink($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'lostPasswd ';
        $sql .= 'SET pseudo = :pseudo, token = :link, date = NOW() + INTERVAL 2 DAY ';
        $sql .= 'ON DUPLICATE KEY UPDATE token = :link, date = NOW() + INTERVAL 2 DAY ';
        $requete = $connexion->prepare($sql);

        $link = md5(microtime());
        $requete->bindParam(':link', $link, PDO::PARAM_STR, 40);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        Application::DeconnexionPDO($connexion);

        return $link;
    }

    /**
     * Enregistrer le mot de passe $passwd pour l'utilisateur $pseudo
     *
     * @param string $pseudo
     * @param string $passwd
     *
     * @return int
     */
    public static function savePasswd4pseudo($pseudo, $passwd)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'UPDATE ' . PFX . 'users ';
        $sql .= 'SET md5pwd = :md5pwd ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $md5pwd = md5($passwd);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);
        $requete->bindParam(':md5pwd', $md5pwd, PDO::PARAM_STR, 32);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Supprimer l'enregistrement du token de mdp pour l'utilisateur $pseudo
     * 
     * @param string $pseudo
     * 
     * @return int
     */
    public static function delToken4pseudo($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'lostPasswd ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * renvoie la liste de tous les utilisateurs qui ont les droits $droits
     *
     * @param array $droits (type array('root', 'oxfam')) ou array('client')
     *
     * @return array
     */
    public function getListeUsers($sort)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT pseudo, civilite, nom, prenom, droits, approuve ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE droits != "nobody" ';

        if ($sort == 'parNom')
            $sql .= 'ORDER BY TRIM(nom) ASC, prenom, mail ';
        else
            $sql .= 'ORDER BY TRIM(prenom) ASC, nom, mail ';

        $requete = $connexion->prepare($sql);

        $resultat = $requete->execute();
        $liste = array();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $pseudo = $ligne['pseudo'];
                $liste[$pseudo] = $ligne;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $liste;
    }


    /**
     * renvoie la fiche perso de l'utilisateur dont on donne le $pseudo
     *
     * @param string $mail
     *
     * @return array
     */
    public function getDataUser($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT * ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE pseudo = :pseudo ';

        $requete = $connexion->prepare($sql);

        $data = null;
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $data = $requete->fetch();
        }

        Application::DeconnexionPDO($connexion);

        return $data;
    }

    /**
     * Enregistre le profil utilisateur présenté dans $form
     *
     * @param array $form
     *
     * @return int
     */
    public function saveUser($form, $partiel = true)
    {
        $civilite = isset ($form['civilite']) ? $form['civilite'] : null;
        $nom = isset ($form['nom']) ? trim($form['nom']) : null;
        $prenom = isset ($form['prenom']) ? trim($form['prenom']) : null;

        $telephone = isset ($form['telephone']) ? $form['telephone'] : null;
        $mail = isset ($form['mail']) ? trim($form['mail']) : null;
        $pseudo = isset ($form['pseudo']) ? trim($form['pseudo']) : null;

        $adresse = isset ($form['adresse']) ? $form['adresse'] : null;
        $commune = isset ($form['commune']) ? $form['commune'] : null;
        $cpost = isset ($form['cpost']) ? $form['cpost'] : null;
        $md5pwd = (isset ($form['pwd']) && $form['pwd'] != '') ? md5($form['pwd']) : null;
        $droits = isset ($form['droits']) ? $form['droits'] : 'oxfam';
        if (!$partiel)
            $approuve = isset ($form['approuve']) ? $form['approuve'] : 0;

        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'UPDATE ' . PFX . 'users ';
        $sql .= 'SET civilite = :civilite, nom = :nom, prenom = :prenom, ';
        $sql .= 'telephone = :telephone, mail = :mail, ';
        $sql .= 'adresse = :adresse, commune = :commune, cpost = :cpost ';
        // si enregistrement partiel (auto-enregistrement), ne pas modifier les droits
        // ni le statut "approuvé"
        if (!$partiel)
            $sql .= ', droits = :droits, approuve = :approuve ';
        if ($md5pwd != null) {
            $sql .= ', md5pwd = :md5pwd ';
        }
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':civilite', $civilite, PDO::PARAM_STR, 1);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR, 60);
        $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR, 60);
        $requete->bindParam(':telephone', $telephone, PDO::PARAM_STR, 15);
        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 6);
        $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR, 100);
        $requete->bindParam(':commune', $commune, PDO::PARAM_STR, 50);
        $requete->bindParam(':cpost', $cpost, PDO::PARAM_STR, 6);

        if (!$partiel) {
            $requete->bindParam(':approuve', $approuve, PDO::PARAM_INT);
            $requete->bindParam(':droits', $droits, PDO::PARAM_STR, 6);
        }

        if ($md5pwd != null) {
            $requete->bindParam(':md5pwd', $md5pwd, PDO::PARAM_STR, 32);
        }

        // echo($sql);
        // Application::afficher(array($civilite, $nom, $prenom, $telephone, $mail, $pseudo, $adresse, $commune, $cpost, $droits, $md5pwd), true);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    public static function saveNewUser($form)
    {
        $civilite = $form['civilite'] != '' ? $form['civilite'] : null;
        $nom = isset ($form['nom']) ? $form['nom'] : null;
        $prenom = isset ($form['prenom']) ? $form['prenom'] : null;

        $telephone = isset ($form['telephone']) ? $form['telephone'] : null;
        $mail = isset ($form['mail']) ? $form['mail'] : null;
        $pseudo = isset ($form['pseudo']) ? $form['pseudo'] : null;

        $adresse = isset ($form['adresse']) ? $form['adresse'] : null;
        $commune = isset ($form['commune']) ? $form['commune'] : null;
        $cpost = isset ($form['cpost']) ? $form['cpost'] : null;

        $droits = isset ($form['droits']) ? $form['droits'] : 'oxfam';
        $md5pwd = (isset ($form['pwd']) && $form['pwd'] != '') ? md5($form['pwd']) : null;

        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'users ';
        $sql .= 'SET civilite = :civilite, nom = :nom, prenom = :prenom, ';
        $sql .= 'telephone = :telephone, mail = :mail, pseudo = :pseudo, ';
        $sql .= 'adresse = :adresse, commune = :commune, cpost = :cpost, ';
        $sql .= 'droits = :droits, md5pwd = :md5pwd ';

        $requete = $connexion->prepare($sql);

        $requete->bindParam(':civilite', $civilite, PDO::PARAM_STR, 1);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR, 60);
        $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR, 60);
        $requete->bindParam(':telephone', $telephone, PDO::PARAM_STR, 15);
        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 100);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 6);
        $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR, 100);
        $requete->bindParam(':commune', $commune, PDO::PARAM_STR, 50);
        $requete->bindParam(':cpost', $cpost, PDO::PARAM_STR, 6);
        $requete->bindParam(':droits', $droits, PDO::PARAM_STR, 6);
        $requete->bindParam(':md5pwd', $md5pwd, PDO::PARAM_STR, 32);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * suppression de l'utilisateur $pseudo de la base de données
     *
     * @param string $pseudo
     *
     * @return int
     */
    public function delUser($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'users ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $n = 0;
        if ($resultat) {
            $n = $requete->rowCount();
        }

        Application::DeconnexionPDO($connexion);

        return $n;
    }

}
