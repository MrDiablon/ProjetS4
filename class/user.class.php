<?php
require_once('myPDO.include.php') ;

/**
 * Classe d'Exception concernant les connexions de la Classe Utilisateur
 */
class AuthenticationException extends Exception { }

/**
 * Classe d'Exception concernant les récupération de la Classe Utilisateur dans les données de session
 */
class NotInSessionException extends Exception { }

/**
 * Classe d'Exception concernant le démarrage d'une session
 */
class SessionException extends Exception { }

/**
 * Utilisateur permettant d'effectuer des connexions client/serveur
 * Utilisateur issu de la base de données (table user)
 */
class User {
    /**
     * Identifiant base de données
     * @var string $id_Utilisateur
     */
    protected $id_Utilisateur        = null ;

    /**
     * Nom
     * @var string $nom
     */
    protected $nom  = null ;

    /**
     * Prénom
     * @var string $prenom
     */
    protected $prenom = null ;

    /**
     * Mail
     * @var string $mail
     */
    protected $mail = null ;


    /**
     * Clé de session à partir de laquelle les données sont stockées
     */
    const session_key = "__user__" ;

    /**
     * Constructeur privé
     */
    private function __construct() {
    }

    /**
     * Affiche le prénom de l'Utilisateur
     *
     * @return string prénom
     */
    public function prenom() {
        return $this->prenom ;
    }
    /**
     * Affiche le prénom et le nom de l'Utilisateur
     *
     * @return string prénom nom
     */
    public function prenomNom() {
        return $this->prenom . " " . $this->nom ;
    }

    public function id() {
        return $this->id_Utilisateur;
    }

    /**
     * Affichage
     *
     * @return string code HTML présentant les attributs de l'utilisateur
     */
    public function profile() {
            // Affichage
            return <<<HTML
    <div><span>Id   </span> : <span>{$this->id_Utilisateur} </span></div>
    <div><span>Adresse mail      </span> : <span>{$this->mail} </span></div>
    <div><span>Nom      </span> : <span>{$this->nom} </span></div>
    <div><span>Prénom   </span> : <span>{$this->prenom}</span></div>
HTML;
    }

    /**
     * Production d'un formulaire de connexion
     * @param string $action URL cible du formulaire
     * @param string $submitText texte du bouton d'envoi
     *
     * @return string code HTML du formulaire
     */
    static public function loginForm($action, $submitText = 'OK') { //Supprimer les paramètres inutiles ici
        return <<<HTML
        <form name="connexion" action="connexion.php" method="POST">
            <div class="form-group">
                <label for="mailInput">Adresse e-mail</label>
                <input class='form-control' id="mailInput"  type="email" name="mail" placeholder="E-mail" required>
            </div>
            <div class="form-group">
                <label for="passInput">Mot de passe</label>
                <input class='form-control' type="password" name="password" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn btn-success" id="valider" value="Connexion">Connexion</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        </form>
HTML;
    }

    /**
     * Validation de la connexion de l'utilisateur
     * @param array $data tableau contenant les clés 'login' et 'pass' associées au login et au mot de passe
     * @throws AuthenticationException si l'authentification échoue
     *
     * @return User utilisateur authentifié
     */
    public static function createFromAuth(array $data) {
        if (!isset($data['mail']) || !isset($data['password'])) {
            throw new AuthenticationException("Adresse mail / Mot de passe absent") ;
        }

        // Préparation de la requête
         $stmt = myPDO::getInstance()->prepare(<<<SQL
    SELECT id_Utilisateur, nom, prenom, mail
    FROM Particulier
    WHERE mail    = :mail
    AND   mdp = SHA1(:password)
SQL
    ) ;

        $stmt->execute(array(
            ':mail' => $data['mail'],
            ':password'  => $data['password'])) ;
        // Test de réussite de la sélection
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        if (($utilisateur = $stmt->fetch()) !== false) {
            self::startSession() ;
            $_SESSION[self::session_key]['connected'] = true ;
            return $utilisateur ;
        }
        else {
            throw new AuthenticationException("Adresse email / mot de passe incorrect") ;
        }
    }

    /**
     * Forumlaire de déconnexion de l'utilisateur
     * @param string $text texte du bouton de déconnexion
     * @param string $action URL cible du formulaire
     *
     * @return void
     */
    public static function logoutForm($text, $action) {
        $text = htmlspecialchars($text, ENT_COMPAT, 'utf-8') ;
        return <<<HTML
    <form action='$action' method='POST'>
        <input type='submit' value="$text" class="btn btn-danger" name='logout'>
    </form>
HTML;
    }

    /**
     * Déconnecter l'utilisateur
     *
     * @return void
     */
    public static function logoutIfRequested() {
        if (isset($_REQUEST['logout'])) {
            self::startSession() ;
            unset($_SESSION[self::session_key]) ;
        }
    }

    /**
     * Un utilisateur est-il connecté ?
     *
     * @return bool connecté ou non
     */
    static public function isConnected() {
        self::startSession() ;
        return (   isset($_SESSION[self::session_key]['connected'])
                && $_SESSION[self::session_key]['connected'])
            || (   isset($_SESSION[self::session_key]['user'])
                && $_SESSION[self::session_key]['user'] instanceof User) ;
    }

    /**
     * Sauvegarde de l'objet Utilisateur dans la session
     *
     * @return void
     */
    public function saveIntoSession() {
        // Mise en place de la session
        self::startSession() ;
        // Mémorisation de l'Utilisateur
        $_SESSION[self::session_key]['user'] = $this ;
    }

    /**
     * Lecture de l'objet User dans la session
     * @throws NotInSessionException si l'objet n'est pas dans la session
     *
     * @return User
     */
    static public function createFromSession() {
        // Mise en place de la session
        self::startSession() ;
        // La variable de session existe ?
        if (isset($_SESSION[self::session_key]['user'])) {
            // Lecture de la variable de session
            $u = $_SESSION[self::session_key]['user'] ;
            // Est-ce un objet et un objet du bon type ?
            if (is_object($u) && get_class($u) == get_class()) {
                // OUI ! on le retourne
                return $u ;
            }
        }
        // NON ! exception NotInSessionException
        throw new NotInSessionException() ;
   }

   /**
    * Démarrer une session
    * @throws SessionException si la session ne peut être démarrée
    *
    * @return void
    */
    static protected function startSession() {
        // Vision la plus contraignante et donc la plus fiable
        // Si les en-têtes ont deja été envoyés, c'est trop tard...
        if (headers_sent())
            throw new SessionException("Impossible de démarrer une session si les en-têtes HTTP ont été envoyés") ;
        // Si la session n'est pas demarrée, le faire
        if (!session_id()) session_start() ;

        // Vision la moins contraignante qui peut amener des comportements changeants
        // Si la session n'est pas demarrée, le faire
        /*
        if (!session_id()) {
            // Si les en-têtes ont deja été envoyés, c'est trop tard...
            if (headers_sent())
                throw new Exception("Impossible de démarrer une session si les en-têtes HTTP ont été envoyés") ;
            // Démarrer la session
            session_start() ;
        }
        */
   }

    /**
     * Production d'un code aléatoire (minuscule, majuscule et chiffre)
     * @param $size taille de la chaîne
     *
     * @return string chaîne aléatoire
     */
    public static function randomString($size) {
        $s = '' ;
        for ($i=0; $i<$size; $i++) {
            switch (rand(0, 2)) {
            case 0 :
                $s .= chr(rand(ord('A'), ord('Z'))) ;
                break ;
            case 1 :
                $s .= chr(rand(ord('a'), ord('z'))) ;
                break ;
            case 2 :
                $s .= chr(rand(ord('1'), ord('9'))) ;
                break ;
            }
        }
	}

	public function getnom(){
        return $s ;
    }

    /**
     * Production d'un formulaire de connexion contenant un challenge et une méthode JavaScript de hachage
     * @param string $action URL cible du formulaire
     * @param string $submitText texte du bouton d'envoi
     *
     * @return string code HTML du formulaire
     */
    static public function loginFormSHA1($action, $submitText = 'OK') {
        $texte_par_defaut = 'login' ;
        // Mise en place de la session
        self::startSession() ;
        // Mémorisation d'un challenge dans la session
        $_SESSION[self::session_key]['challenge'] = self::randomString(16) ;
        // Le formulaire avec le code JavaScript permettant le hachage SHA1
        // Le retour attendu par le serveur est SHA1(SHA1(pass)+challenge+SHA1(login))
        return <<<HTML
<script type='text/javascript' src='sha1.js'></script>
<script type='text/javascript'>
function crypter(f, challenge) {
    if (f.login.value.length && f.pass.value.length) {
        f.code.value = SHA1(SHA1(f.pass.value)+challenge+SHA1(f.login.value)) ;
        f.login.value = f.pass.value = '' ;
        return true ;
    }
    return false ;
}
</script>
<!--
Le formulaire est envoyé selon la méthode GET à des fins de compréhension.
Il faut utiliser la méthode POST dans la pratique.
-->
<form name='auth' action='$action' method='GET' onSubmit="return crypter(this, '{$_SESSION[self::session_key]['challenge']}')" autocomplete='off'>
    <input type='text' name='login' value='{$texte_par_defaut}'
     onClick="if (this.value == '$texte_par_defaut') this.value = ''"
     onFocus="if (this.value == '$texte_par_defaut') this.value = ''">
    <input type='password' name='pass'  >
    <input type='hidden'   name='code'>
    <input type='submit'   value='{$submitText}'>
</form>
HTML;
    }

    /**
     * Validation de la connexion de l'Utilisateur
     * @param array $data tableau contenant la clé 'code' associée au condensat du login et au mot de passe
     * @throws AuthenticationException si l'authentification échoue
     *
     * @return User utilisateur authentifié
     */
    public static function createFromAuthSHA1(array $data) {
        if (!isset($data['code'])) {
            throw new AuthenticationException("pas de login/pass fournis") ;
        }

        // Mise en place de la session
        self::startSession() ;
        // Préparation de la requête
        $stmt = myPDO::getInstance()->prepare(<<<SQL
    SELECT id, prenom, nom, login, phone
    FROM user
    WHERE SHA1(CONCAT(sha1pass, :challenge, SHA1(login))) = :code
SQL
    ) ;

        $stmt->execute(array(
            ':challenge' => isset($_SESSION[self::session_key]['challenge']) ? $_SESSION[self::session_key]['challenge'] : '',
            ':code'      => $data['code'])) ;
        // Effacement du challenge
        // Toute la sécurité repose sur lui, il doit rester valide le moins longtemps possible
        unset($_SESSION[self::session_key]['challenge']) ;
        // Test de réussite de la sélection
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        if (($utilisateur = $stmt->fetch()) !== false) {
            return $utilisateur ;
        }
        else {
            throw new AuthenticationException("Login/pass incorrect") ;
        }
    }
}
