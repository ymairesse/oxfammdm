<?php

setlocale(LC_TIME, 'fr_FR.UTF-8'); // Définit le local en français


class Planning
{

    public function __construct()
    {

    }

    /**
     * renvoie la date pivot de début d'un "contexte" $idContexte
     * 
     * @param int $idContexte
     * 
     * @return string
     */
    public function getDate4idContexte($idContexte)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT dateDebutContexte ';
        $sql .= 'FROM ' . PFX . 'contextes ';
        $sql .= 'WHERE idContexte = :idContexte ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_STR, 100);

        $date = Null;
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
            $date = $ligne['dateDebutContexte'];
        }

        Application::DeconnexionPDO($connexion);

        return $date;
    }


    /**
     * Renvoie la liste des contextes définis dans le planning
     * 
     * @return array
     * 
     */
    public function getListeContextes()
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT DISTINCT idContexte, dateDebutContexte ';
        $sql .= 'FROM ' . PFX . 'contextes ';
        $sql .= 'ORDER BY dateDebutContexte ';
        $requete = $connexion->prepare($sql);

        $liste = array();

        $resultat = $requete->execute();

        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $idContexte = $ligne['idContexte'];
                $liste[$idContexte] = $ligne['dateDebutContexte'];
            }
        }

        Application::DeconnexionPDO($connexion);

        return $liste;
    }

    /**
     * Construis une liste double des dates de début et de fin de chaque contexte
     * 
     * @param array $listeContextes
     * 
     * @return array
     */
    public function getListeDoubleContextes($listeContextes)
    {
        $listeDouble = array();

        // Récupérer les clés de $listeContextes
        $keys = array_keys($listeContextes);

        // Parcourir les clés jusqu'à l'avant-dernière clé
        // on n'a pas besoin de la dernière car cette période est ouverte
        $count = count($keys);
        for ($i = 0; $i < $count - 1; $i++) {
            // Obtenir la clé actuelle et la clé suivante
            $cleActuelle = $keys[$i];
            $cleSuivante = $keys[$i + 1];

            // Obtenir les dates correspondantes et formater chacune d'elles
            $dateActuelle = $listeContextes[$cleActuelle];
            // $date = explode('-', $dateActuelle);
            // $dateActuelle = sprintf('%s/%s/%s', $date[2], $date[1], $date[0]);

            $dateSuivante = $listeContextes[$cleSuivante];
            // $date = explode('-', $dateSuivante);
            // $dateSuivante = sprintf('%s/%s/%s', $date[2], $date[1], $date[0]);

            // Ajouter les dates à $listeDouble avec la clé d'origine
            $listeDouble[$cleActuelle] = array($dateActuelle, $dateSuivante);
        }

        // récupérer la date de début du contexte final
        $dateFinale = $listeContextes[end($keys)];
        
        // // formater la date finale
        // $date = explode('-', $dateFinale);
        // $dateFinale = sprintf('%s/%s/%s', $date[2], $date[1], $date[0]);
        // Ajouter la dernière date avec une marque représentant la fin
        $listeDouble[end($keys)] = array($dateFinale, '...');

        return $listeDouble;
    }

    /**
     * Trouver dans quel "contexte" défini dans le tableau $liste
     * se trouve une date donnée
     * 
     * @param string $date
     * 
     * @return int
     * 
     */
    public function getContexte4date($date)
    {
        $listeContextes = $this->getListeContextes();
        $listeDouble = $this->getListeDoubleContextes($listeContextes);

        // pas de date avant le commencement du monde
        if ($date < current($listeDouble)[0])
            return -1;

        // Parcourir le tableau $listeDates
        foreach ($listeDouble as $cle => $contexte) {
            $dateDebut = $contexte[0];
            $dateFin = $contexte[1];
            // Vérifier si la date recherchée est dans cet intervalle
            if ($date >= $dateDebut && $date < $dateFin) {
                break;
            }
        }

        // Si la date ne correspond à aucun intervalle, on est donc dans le dernier contexte
        if (!isset ($cle)) {
            $cle = end($listeDouble);
        }

        return $cle;
    }

    /**
     * recherche la liste des périodes de permanences définies dans un $idContexte 
     * 
     * @param string $date
     * 
     * @return array
     */
    public function getPermanences4contexte($idContexte)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT contextes.idContexte, dateDebutContexte, numeroPermanence, heureDebut, heureFin ';
        $sql .= 'FROM ' . PFX . 'heuresPermanences AS heuresPermanences ';
        $sql .= 'JOIN ' . PFX . 'contextes AS contextes ON contextes.idContexte = heuresPermanences.idContexte ';
        $sql .= 'WHERE contextes.idContexte = :idContexte ';
        $sql .= 'ORDER BY numeroPermanence ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $listePeriodes = array();
        $resultat = $requete->execute();

        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $numeroPermanence = $ligne['numeroPermanence'];
                $listePeriodes[$numeroPermanence] = $ligne;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $listePeriodes;
    }

    /**
     * retourne les détails de la permanence $numeroPermanence
     * du contexte $idContexte
     * 
     * @param int $idContexte
     * @param int $numeroPermanence
     * 
     * @return array
     */
    public function getPermanence($idContexte, $numeroPermanence)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT contextes.idContexte, dateDebutContexte, numeroPermanence, heureDebut, heureFin ';
        $sql .= 'FROM  ' . PFX . 'heuresPermanences  AS heuresPermanences ';
        $sql .= 'JOIN ' . PFX . 'contextes AS contextes ON heuresPermanences.idContexte = contextes.idContexte ';
        $sql .= 'WHERE  contextes.idContexte = :idContexte AND numeroPermanence = :numeroPermanence ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':numeroPermanence', $numeroPermanence, PDO::PARAM_INT);

        $dataPeriode = array();

        $resultat = $requete->execute();

        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $dataPeriode = $requete->fetch();
        }

        Application::DeconnexionPDO($connexion);

        return $dataPeriode;
    }

    /**
     * Enregistre les caractéristiques d'une période de permanence $idContexte, $numeroPermanence
     * 
     * @param int $idContexte
     * @param int $numeroPermanence
     * @param string $heureDebut
     * @param string $heureFin
     */
    public function savePeriodePermanence($idContexte, $numeroPermanence, $heureDebut, $heureFin)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'heuresPermanences SET idContexte = :idContexte, ';
        $sql .= 'numeroPermanence = :numeroPermanence, heureDebut = :heureDebut, heureFin = :heureFin ';
        $sql .= 'ON DUPLICATE KEY UPDATE heureDebut = :heureDebut, heureFin = :heureFin ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':numeroPermanence', $numeroPermanence, PDO::PARAM_INT);
        $requete->bindParam(':heureDebut', $heureDebut, PDO::PARAM_STR, 5);
        $requete->bindParam(':heureFin', $heureFin, PDO::PARAM_STR, 5);

        $resultat = $requete->execute();

        $nb = 0;
        if ($resultat) {
            $nb = $requete->rowCount();
        }

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * créer $nbPermanences avec des numéros commençant à $numeroPermanence + 1 pour la $idContexte
     * 
     * @param int $idContexte
     * @param int $nbPermanences nombre de permanences à créer
     * @param int $numeroPermanence plus grand numéro actuel de permanence
     * 
     * @return int
     */
    public function saveNewPermanences($idContexte, $nbPermanences, $numeroPermanence)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'heuresPermanences ';
        $sql .= 'SET idContexte = :idContexte, numeroPermanence = :numeroPermanence ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $n = 0;
        while ($n < $nbPermanences) {
            $numeroPermanence++;
            $requete->bindParam(':numeroPermanence', $numeroPermanence, PDO::PARAM_INT);
            $resultat = $requete->execute();
            $n++;
        }

        Application::DeconnexionPDO($connexion);

        return $n;
    }

    /**
     * Supprimer la permanence $numeroPermanence du contexte $idContexte
     * 
     * @param int $numeroPermanence
     * @param int $idContexte
     * 
     * @return int
     */
    public function delPermanence($idContexte, $numeroPermanence)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'heuresPermanences ';
        $sql .= 'WHERE idContexte = :idContexte AND numeroPermanence = :numeroPermanence ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':numeroPermanence', $numeroPermanence, PDO::PARAM_INT);
        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Enregistre la date pivot d'un nouveau contexte $dateDebutContexte
     * 
     * @param string $dateDebutContexte
     * 
     * @return int
     */
    public function saveDateContexte($dateDebutContexte)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'contextes ';
        $sql .= 'SET dateDebutContexte = :dateDebutContexte ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':dateDebutContexte', $dateDebutContexte, PDO::PARAM_STR, 12);

        $resultat = $requete->execute();

        $nb = 0;

        $id = $connexion->lastInsertId();

        if ($resultat) {
            $nb = $requete->rowCount();
        }

        Application::DeconnexionPDO($connexion);

        return $id;
    }

    /**
     * Récupère la liste des périodes journalières pour le contexte $idContexte
     * 
     * @return array
     */
    public function getPeriodes4contexte($idContexte)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT idContexte, numeroPermanence, heureDebut, heureFin ';
        $sql .= 'FROM ' . PFX . 'heuresPermanences ';
        $sql .= 'WHERE idContexte = :idContexte ';
        $sql .= 'ORDER BY heureDebut ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $liste = array();
        $resultat = $requete->execute();
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        while ($ligne = $requete->fetch()) {
            $numeroPermanence = $ligne['numeroPermanence'];
            $liste[$numeroPermanence] = $ligne;
        }

        Application::DeconnexionPDO($connexion);

        return $liste;
    }

    /**
     * jour de la semaine en français depuis le numéro du jour (1 à 7)
     * 
     * @param int $numJour
     * 
     * @return string
     */
    public function getNomJour($numJour)
    {
        $semaine = array(
            1 => 'lundi',
            2 => 'mardi',
            3 => 'mercredi',
            4 => 'jeudi',
            5 => 'vendredi',
            6 => 'samedi',
            7 => 'dimanche'
        );
        return $semaine[$numJour];
    }

    /**
     * Constitue la grille des périodes de permanence du mois $month de l'année $year
     * 
     * @param int $year
     * @param int month
     * 
     * @return array
     */
    public function getMonthGrid($month, $year)
    {
        // À quel contexte correspond la date du début de mois?
        $dateFirstOfMonth = sprintf('%d-%02d-01', $year, $month);

        // quel est le numéro du dernier jour du mois?
        $lastDay4month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dateLastOfMonth = sprintf('%d-%02d-%02d', $year, $month, $lastDay4month);

        // création du tableau des jours
        $grid = array();

        for ($jour = 1; $jour <= $lastDay4month; $jour++) {
            $grid[$jour] = array();
            // combien de périodes pour ce jour?
            $laDate = sprintf('%d-%02d-%02d', $year, $month, $jour);

            $listeContextes = $this->getListeContextes();
            $idContexte = $this->getContexte4date($laDate);

            $listePeriodesActuelles = $this->getPermanences4contexte($idContexte);
            $nbPeriodes = count($listePeriodesActuelles);

            $noJourSemaine = date("N", strtotime($laDate));

            $grid[$jour]['noJourSemaine'] = $noJourSemaine;

            $nom_jour_fr = $this->getNomJour($noJourSemaine);
            $grid[$jour]['nomDuJour'] = $nom_jour_fr;
            $grid[$jour]['date'] = $laDate;
            $grid[$jour]['idContexte'] = $idContexte;

            // chaque période est initialisée
            for ($periode = 1; $periode <= $nbPeriodes; $periode++) {
                $dataPeriode = $listePeriodesActuelles[$periode];
                $data = array(
                    'heureDebut' => $dataPeriode['heureDebut'],
                    'heureFin' => $dataPeriode['heureFin'],
                );
                $grid[$jour]['periodes'][$periode] = $data;
            }
        }

        return $grid;
    }

    /**
     * Supprime la permanence prévue du bénévole $pseudo à la date $date
     * pour la période $periode
     * 
     * @param string $pseudo
     * @param string $date
     * @param int periode
     * 
     * @return int
     */
    public function deletePeriode($date, $periode, $pseudo){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'calendar ';
        $sql .= 'WHERE date = :date AND periode = :periode AND pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;

    }

    /**
     * Ajoute une inscription pour la permanence $periode ($numérique) à la date $date (YYYY-mm-dd)
     * pour l'utilisateur $pseudo dans le contexte $idContexte
     * 
     * @param int $idContexte
     * @param string $date
     * @param int $periode
     * @param string $pseudo
     * 
     * @return int
     */
    public function addPeriode($idContexte, $date, $periode, $pseudo){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT IGNORE INTO '.PFX.'calendar ';
        $sql .= 'SET idContexte = :idContexte, date = :date, periode = :periode, pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::deconnexionPDO($connexion);

        return $nb;
    }

  /**
     * recherche des inscriptions au calendrier pour le mois $month de l'année $year et le contexte $idContexte
     * 
     * @param int $month : numéro du mois
     * @param int $year : millésime
     * @param string $pseudo : limitation  éventuelle à l'utilisateur $pseudo
     * 
     * @return array
     */
    public function getInscriptions($month, $year, $pseudo = Null)
    {
        // À quel contexte correspond la date du début de mois?
        $dateFirstOfMonth = sprintf('01-%02d-%d', $month, $year);

        $listeContextes = $this->getListeContextes();
        $idContexte = $this->getContexte4date($dateFirstOfMonth);

        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT date, periode, calendar.pseudo, dateInscription, confirme, ';
        $sql .= 'civilite, nom, prenom ';
        $sql .= 'FROM ' . PFX . 'calendar as calendar ';
        $sql .= 'LEFT JOIN ' . PFX . 'users AS users ON users.pseudo = calendar.pseudo ';
        $sql .= 'WHERE date LIKE :yearMonth ';
        if ($pseudo != Null)
            $sql .= 'AND calendar.pseudo = :pseudo ';
        $sql .= 'ORDER BY date, periode, dateInscription ';

        $requete = $connexion->prepare($sql);

        // mois sous la forme YYYYY-MM (avec deux signes pour le mois)
        $yearMonth = sprintf('%d-%02d', $year, $month) . '%';
        // Application::afficher($yearMonth, true);
        $requete->bindParam(':yearMonth', $yearMonth, PDO::PARAM_STR, 7);
        if ($pseudo != Null)
            $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $liste = array();
        $resultat = $requete->execute();

        while ($ligne = $requete->fetch()) {
            $date = $ligne['date'];
            $periode = $ligne['periode'];
            $pseudo = $ligne['pseudo'];
            $noJour = intval(substr($date, 8, 2));
            $liste[$noJour][$periode][$pseudo] = array(
                'pseudo' => $ligne['pseudo'],
                'date' => $ligne['date'],
                'civilite' => Application::civilite($ligne['civilite']),
                'nom' => $ligne['nom'],
                'prenom' => $ligne['prenom'],
            );
        }

        Application::deconnexionPDO($connexion);

        return $liste;
    }

    /**
     * renvoie les inscriptions de l'utilisateur $pseudo sous la forme d'un tableau
     * comprenant toutes ses inscriptions sous la forme YYYY-mm-dd_p (où p est la période)
     *     // array (
     * //     0 => '2024-03-01_1',
     * //     1 => '2024-03-01_2',
     * //     2 => '2024-03-01_3',
     * //     3 => '2024-03-01_4',
     * //     4 => '2024-03-01_5',
     * //     5 => '2024-03-01_6',
     * //     6 => '2024-03-02_1',
     * //     7 => '2024-03-02_2',
     * //     8 => '2024-03-07_4',
     * //   )
     * 
     * @param int $month : numéro du mois
     * @param int $year : millésime
     * @param string $pseudo : limitation  éventuelle à l'utilisateur $acronyme
     * 
     * @return array
     */
    public function getInscriptionsArray($month, $year, $pseudo){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT date, periode ';
        $sql .= 'FROM '.PFX.'calendar ';
        $sql .= 'WHERE date LIKE :date AND pseudo = :pseudo ';
        $sql .= 'ORDER BY date, periode ';
        $requete = $connexion->prepare($sql);
// echo $sql;
        $date = sprintf('%d-%02d-', $year, $month);
        $date = $date.'%';
        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);
        // Application::afficher(array($date, $pseudo), true);
        $liste = array();
        $resultat = $requete->execute();

        if ($resultat){
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()){
                $inscription = sprintf('%s_%d', $ligne['date'], $ligne['periode']);
                $liste[] = $inscription;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $liste;
    }

    /**
     * Enregistre une inscription à la $permanence YYYY-mm-dd_P pour 
     * le bénévole $pseudo
     * 
     * @param int $idContexte
     * @param string $date
     * @param int $periode
     * @param string $pseudo
     * 
     * @return int
     */
    public function savePermanence ($idContexte, $date, $periode, $pseudo) {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT IGNORE INTO '.PFX.'calendar ';
        $sql .= 'SET date = :date, periode = :periode, pseudo = :pseudo, idContexte = :idContexte ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);


        $resultat = $requete->execute();;

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

     /**
     * Supprimer une inscription à la $permanence de la période $periode pour 
     * le bénévole $pseudo dans le contexte $idContexte
     * 
     * @param int $idContexte
     * @param string $date
     * @param int $periode
     * @param string $pseudo
     * 
     * @return int
     */
    public function deletePermanence($date, $periode, $pseudo){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM '.PFX.'calendar ';
        $sql .= 'WHERE date = :date AND periode = :periode AND pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);


        $resultat = $requete->execute();;

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb; 
    }




}