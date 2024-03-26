<?php

class Application
{
    public function __construct()
    {
        self::lireConstantes();
        // sorties PHP en français
        setlocale(LC_ALL, 'fr_FR.utf8');
    }

    /**
     * relire les constantes de l'application
     *
     * @param
     *
     * @return array : constantes globales
     */
    public static function lireConstantes()
    {
        // lecture des paramètres généraux dans le fichier .ini, y compris la constante "PFX"
        $constantes = parse_ini_file(INSTALL_DIR . '/config.ini');

        foreach ($constantes as $key => $value) {
            define("$key", $value);
        }

        // lecture dans la table PFX."config" de la BD
        $connexion = self::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT parametre, valeur ';
        $sql .= 'FROM ' . PFX . 'config ';
        $requete = $connexion->prepare($sql);

        $resultat = $requete->execute();
        if ($resultat) {
            while ($ligne = $requete->fetch()) {
                $key = $ligne['parametre'];
                $valeur = $ligne['valeur'];
                define("$key", $valeur);
            }
        } else {
            die('config table not present');
        }
        self::DeconnexionPDO($connexion);
    }


    /**
     * afficher proprement le contenu d'une variable précisée
     * le programme est éventuellement interrompu si demandé.
     *
     * @param :    $data n'importe quel tableau ou variable
     * @param bool $die  : si l'on souhaite interrompre le programme avec le dump
     *
     * @return string
     */
    public static function afficher($data, $die = false)
    {
        if (func_num_args() > 0) {
            $data = func_get_args();
        }

        foreach ($data as $wtf => $unData) {
            echo '<pre>';
            var_export($unData);
            echo '</pre>';
        }
        if ($die == true) {
            die();
        }
    }
    public static function afficherSilent($data, $die = false)
    {
        foreach ($data as $wtf => $unData) {
            echo '<!-- ';
            echo '<pre>';
            var_export($unData);
            echo '</pre>';
            echo ' -->';
        }
        if ($die == true) {
            die();
        }
    }

    /**
     * Connexion à la base de données précisée.
     *
     * @param string PARAM_HOST : serveur hôte
     * @param string PARAM_BD : nom de la base de données
     * @param string PARAM_USER : nom d'utilisateur
     * @param string PARAM_PWD : mot de passe
     *
     * @return 
     */
    public static function connectPDO($host, $bd, $user, $mdp)
    {
        try {
            // indiquer que les requêtes sont transmises en UTF8
            // INDISPENSABLE POUR EVITER LES PROBLEMES DE CARACTERES ACCENTUES
            $connexion = new PDO(
                'mysql:host=' . $host . ';dbname=' . $bd,
                $user,
                $mdp,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
        } catch (Exception $e) {
            $date = date('d/m/Y H:i:s');
            echo "<style type='text/css'>";
            echo '.erreurBD {width: 500px; margin-left: auto; margin-right: auto; border: 1px solid red; padding: 1em;}';
            echo '.erreurBD .erreur {color: green; font-weight: bold}';
            echo '</style>';

            echo "<div class='erreurBD'>";
            echo '<h3>A&iuml;e, a&iuml;e, a&iuml;e... Caramba...</h3>';
            echo "<p>Une erreur est survenue lors de l'ouverture de la base de donn&eacute;es.<br>";
            echo "Si vous &ecirc;tes l'administrateur et que vous tentez d'installer le logiciel, veuillez v&eacute;rifier le fichier config.inc.php </p>";
            echo "<p>Si le probl&egrave;me se produit durant l'utilisation r&eacute;guli&egrave;re du programme, essayez de rafra&icirc;chir la page (<span style='color: red;'>touche F5</span>)<br>";
            echo "Dans ce cas, <strong>vous n'&ecirc;tes pour rien dans l'apparition du souci</strong>: le serveur de base de donn&eacute;es est sans doute trop sollicit&eacute;...</p>";
            echo "<p>Veuillez rapporter le message d'erreur ci-dessous &agrave; l'administrateur du syst&egrave;me.</p>";
            echo "<p class='erreur'>Le $date, le serveur dit: " . $e->getMessage() . '</p>';
            echo '</div>';
            die();
        }

        return $connexion;
    }

    /**
     * Déconnecte la base de données.
     *
     * @param $connexion
     */
    public static function DeconnexionPDO($connexion)
    {
        $connexion = null;
    }

    /**
     * convertir les dates au format usuel jj/mm/AAAA en YY-mm-dd pour MySQL.
     *
     * @param string $date date au format usuel
     *
     * @return string date au format MySQL
     */
    public static function dateMysql($date)
    {
        $dateArray = explode('/', $date);
        $sqlArray = array_reverse($dateArray);
        $date = implode('-', $sqlArray);

        return $date;
    }

    /**
     * convertir les date au format MySQL vers le format usuel.
     *
     * @param string $date date au format MySQL
     *
     * @return string date au format usuel français
     */
    public static function datePHP($dateMysql)
    {
        $dateArray = explode('-', $dateMysql);
        $phpArray = array_reverse($dateArray);
        $date = implode('/', $phpArray);

        return $date;
    }


    /**
     * renvoie les informations d'identification réseau
     *
     * @param void
     *
     * @return array ip, hostname, date, heure
     */
    public function getNetid()
    {
        $data = array();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['date'] = date('d/m/Y');
        $data['heure'] = date('H:i');

        return $data;
    }



    /**
     * Suppression des accents
     * 
     * @param string $input
     * 
     * @return string
     */
    public function accentsOut($input)
    {
        $unwanted_array = array(
            'Š' => 'S',
            'š' => 's',
            'Ž' => 'Z',
            'ž' => 'z',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y'
        );
        $input = strtr($input, $unwanted_array);
        return $input;
    }

    /**
     * calcule l'acronyme sur base du nom et du prénom
     * 
     * @param string $nom
     * @param string $prenom
     * 
     * @return string
     */
    public function pseudo4nomPrenom($nom, $prenom)
    {
        $nom = $this->accentsOut(mb_strtolower(str_replace(' ', '', $nom), 'UTF-8'));
        $prenom = $this->accentsOut(mb_strtolower(str_replace(' ', '', $prenom), 'UTF-8'));

        $acronyme = mb_substr($nom, 0, 3) . mb_substr($prenom, 0, 3);
        $acronyme = $acronyme . mb_substr('123456', 0, 6 - mb_strlen($acronyme));

        return $acronyme;
    }

    /**
     * Vérifie si un pseudo est déjà utilisé dans l'application
     * 
     * @param string $pseudo
     * 
     * @return bool
     */
    public function pseudoExiste($pseudo)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT pseudo ';
        $sql .= 'FROM ' . PFX . 'users ';
        $sql .= 'WHERE pseudo = :pseudo ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);

        $pseudoExiste = false;
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
            if ($ligne['pseudo'] == $pseudo)
                $pseudoExiste = true;
        }

        Application::DeconnexionPDO($connexion);

        return $pseudoExiste;
    }

    /**
     * Traitement de la civilité
     * 
     * @param string $civilite
     * 
     * @return string
     */
    public static function civilite($mfx){
        switch ($mfx) {
            case 'F':
                return 'Mme';
                break;
            case 'M':
                return 'M.';
                break;
            default: 
                return 'Mme/M.';
        }
    }

    /**
     * retourne la liste des administrateurs de l'application
     * 
     * @param void
     * 
     * @return array
     */
    public function getListeAdmins()
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT * FROM ' . PFX . 'users ';
        $sql .= 'ORDER BY nom, prenom ';
        $requete = $connexion->prepare($sql);

        $listeAdmins = array();
        $resultat = $requete->execute();

        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            while ($ligne = $requete->fetch()) {
                $pseudo = $ligne['pseudo'];
                $listeAdmins[$pseudo] = $ligne;
            }
        }

        Application::DeconnexionPDO($connexion);

        return $listeAdmins;
    }

    /**
     * recherche les données d'identité d'un utilisateur dont on fournit l'adresse mail
     *
     * @param string $mail
     *
     * @return array
     */
    public function getInfoUser($mail)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT nom, prenom, mail, statut ';
        $sql .= 'FROM users ';
        $sql .= 'WHERE mail = :mail ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':mail', $mail, PDO::PARAM_STR, 60);
        $ligne = array();
        $resultat = $requete->execute();
        if ($resultat) {
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            $ligne = $requete->fetch();
        }

        Application::deconnexionPDO($connexion);

        return $ligne;
    }

    /**
     * vérifie que le duo $pseud / $token existe bien dans la table des lostPasswd
     * 
     * @param string $pseudo
     * @param string $token
     * 
     * @return bool
     */
    public static function checkValidPseudoToken($pseudo, $token)
    {
        $connexion = Application::connectPDO(SERVEUR, BASE, NOM, MDP);
        $sql = 'SELECT pseudo, token, date ';
        $sql .= 'FROM ' . PFX . 'lostPasswd ';
        $sql .= 'WHERE pseudo = :pseudo AND token = :token AND date > DATE_SUB(NOW(), INTERVAL 48 HOUR) ';
        $requete = $connexion->prepare($sql);

        $requete->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 7);
        $requete->bindParam(':token', $token, PDO::PARAM_STR, 40);

        $resultat = $requete->execute();
        if ($resultat) {
            $ligne = $requete->fetch();
        }

        Application::DeconnexionPDO($connexion);

        return ($ligne != Null);
    }

    /**
     * Envoie un mail de rappel de mot de passe à l'utlisateur dont on a l'adresse.
     *
     * @param string $adresse adresse du destinataire
     * @param string $texte texte du mail
     *
     * @return bool
     */
    public function mailPasswd($adresse, $texte)
    {
        // Créer une nouvelle instance de PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsHTML(true);
        $mail->SMTPDebug = 2;
        $mail->CharSet = 'UTF-8';
        $mail->From = MAILADMIN;
        $mail->FromName = NOMADMIN;
        $mail->AddAddress($adresse);
        $mail->Subject = "Réinitialisation de votre mot de passe";
        $mail->Body = $texte;

        return !$mail->Send();
    }

     /**
     * renvoie le nom du mois en français depuis le numéro du mois
     * 
     * @param int $month
     * 
     * @return string
     */
    public function monthName ($month){
        $listeMois = [
            1 => 'Janvier', 
            2 => 'Février', 
            3 => 'Mars', 
            4 => 'Avril', 
            5 => 'Mai', 
            6 => 'Juin', 
            7 => 'Juillet', 
            8 => 'Août', 
            9 => 'Septembre', 
            10 => 'Octobre', 
            11 => 'Novembre', 
            12 => 'Décembre'];

        return $listeMois[$month];
    }

    /**
     * renvoie les noms des jours de la semaine en français
     * 
     * @param void
     * 
     * @return array
     */
    public function getDaysName (){
        $daysOfWeek = array(
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche'
        );
        return $daysOfWeek;
    }

}
