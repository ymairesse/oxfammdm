<?php

class Conges
{


    public function __construct()
    {

    }

    /**
     * Renvoie la liste des jours et périodes de congés hebdomadaires 
     * dans le contexte $idContexte
     * 
     * @param int $idContexte
     * 
     * @return array
     */
    public function getListeCongesHebdo($idContexte=Null)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT idContexte, jour, periode, conge ';
        $sql .= 'FROM ' . PFX . 'congesHebdo ';
        if ($idContexte != Null)
            $sql .= 'WHERE idContexte = :idContexte ';
        $sql .= 'ORDER BY jour, periode ';
        $requete = $connexion->prepare($sql);
        if ($idContexte != Null)
            $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $resultat = $requete->execute();
        $listeCongesHebdo = array();

        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $idContexte = $ligne['idContexte'];
                $jour = $ligne['jour'];
                $periode = $ligne['periode'];
                $listeCongesHebdo[$idContexte][$jour][$periode] = $ligne['conge'];
            }
        }

        Application::DeconnexionPDO($connexion);

        return $listeCongesHebdo;
    }

    /** 
     * renvoie la liste des congés fériés dans le contexte $idContexte
     * durant le mois $mois (si précisé)
     * 
     * @param int $idContexte
     * @param int $mois
     * 
     * @return array
     */
    public function getListeCongesFeries($idContexte=Null, $mois=Null){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT idContexte, dateConge, periode, conge ';
        $sql .= 'FROM '.PFX.'congesFeries ';
        if ($idContexte != Null) 
            $sql .= 'WHERE idContexte = :idContexte ';
        if ($mois != Null)
            $sql .= 'AND dateConge LIKE "%-'.$mois.'"-%" ';
        $sql .= 'ORDER BY dateConge, periode ';
        $requete = $connexion->prepare($sql);

        if ($idContexte != Null)
            $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $resultat = $requete->execute();
        $listeCongesFeries = array();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $idContexte = $ligne['idContexte'];
                $dateConge = $ligne['dateConge'];
                $periode = $ligne['periode'];
                $conge = $ligne['conge'];
                $listeCongesFeries[$idContexte][$dateConge][$periode] = $conge;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $listeCongesFeries;
    }


    /**
     * Supprime toutes les périodes pour un jour férié $laDate donné
     * 
     * @param string $date
     * @param int $idContexte
     * 
     * @return int
     */
    public function delConge($date, $idContexte)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'DELETE FROM ' . PFX . 'congesFeries ';
        $sql .= 'WHERE dateConge = :date AND idContexte = :idContexte ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Ajoute un jour de congé dans le contexte $idContexte pour le jour $jourFerie
     * 
     * @param int $idContexte
     * @param string $dateCong
     * 
     * @return int
     */
    public function addJourFerie($idContexte, $dateConge){
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO '.PFX.'congesFeries ';
        // il suffit d'une valeur de période pour initialiser le jour de conge
        $sql .= 'SET idContexte = :idContexte, dateConge = :dateConge, periode = 1 ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':dateConge', $dateConge, PDO::PARAM_STR, 10);

        $resultat = $requete->execute();

        $nb = $requete->rowCount();

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Inverse la valeur du champ "congé" pour la $période le jour férié $date
     * dans l'époque $idContexte
     * 
     * @param int $idContexte
     * @param int $periode
     * @param string $date
     * 
     * @return int
     */
    public function toggleCongeFerie($idContexte, $periode, $date)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'congesFeries ';
        $sql .= 'SET periode = :periode, conge = 1, dateConge = :date, idContexte = :idContexte ';
        $sql .= 'ON DUPLICATE KEY UPDATE ';
        $sql .= 'conge = 1 - conge ';
        
        $requete = $connexion->prepare($sql);
        
        $requete->bindParam(':date', $date, PDO::PARAM_STR, 10);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $resultat = $requete->execute();

        $nb = 0;
        if ($resultat) {
            $nb = $requete->rowCount();
        }

        Application::DeconnexionPDO($connexion);

        return $nb;
    }

    /**
     * Inverse la valeur du champ "congé" hebdomadaire pour la $période et le jour $jour
     * dans l'époque $idContexte
     * 
     * @param int $idContexte
     * @param int $periode
     * @param int $jour
     * 
     * @return int
     */
    public function toggleCongeHebdo($idContexte, $periode, $jour)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'INSERT INTO ' . PFX . 'congesHebdo ';
        $sql .= 'SET periode = :periode, conge = 1, jour = :jour, idContexte = :idContexte ';
        $sql .= 'ON DUPLICATE KEY UPDATE ';
        $sql .= 'conge = 1 - conge ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':jour', $jour, PDO::PARAM_INT);
        $requete->bindParam(':periode', $periode, PDO::PARAM_INT);
        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);

        $resultat = $requete->execute();

        $nb = 0;
        if ($resultat) {
            $nb = $requete->rowCount();
        }

        Application::DeconnexionPDO($connexion);

        return $nb;
    }



    /**
     * vérifie que le jour $date de l'époque est fermé (return 1)
     * que ce soit pour un jour férié ($noPeriode) ou 
     * une fermeture hebdomadaire ($noPeriode)
     * 
     * @param int $idContexte
     * @param string $date
     * @param int $noJourSemaine
     * @param int $noPeriode
     * 
     * @return bool
     */
    public function isClosed($idContexte, $date, $noJourSemaine, $noPeriode)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT conge FROM ' . PFX . 'conges ';
        $sql .= 'WHERE (idContexte = :idContexte AND jour = :noJourSemaine AND periode = :noPeriode) ';
        $sql .= 'OR (dateConge = :date AND periode = :noPeriode) ';
        $requete = $connexion->prepare($sql);
        // echo $sql;
        $requete->bindParam(':noJourSemaine', $noJourSemaine, PDO::PARAM_INT);
        $requete->bindParam(':noPeriode', $noPeriode, PDO::PARAM_INT);
        $requete->bindParam(':idContexte', $idContexte, PDO::PARAM_INT);
        $requete->bindParam(':date', $date, PDO::PARAM_INT);

        $resultat = $requete->execute();

        $conge = 0;
        $ligne = $requete->fetch();
        if ($ligne != Null)
            $conge = $ligne['conge'];
        else
            $conge = 0;

        Application::DeconnexionPDO($connexion);

        return $conge;
    }

}