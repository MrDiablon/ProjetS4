<?php
require_once 'myPDO.include.php';
require_once 'tosql.function.php';
abstract class Utilisateur {
    protected $id_Utilisateur;
    protected $nom;
    protected $prenom;
    protected $image;
    protected $note_moyenne;
    protected $mail;
    static $pdo = null;
    /**
    *fonction permettant d'ajouter une ligne Utilisateur dans 
    *la base de donnée
    *
    *param $params tableau a clé avec les parametres necessaire
    *a la creation
    */
    public static function createUtilisateur($params){
        $pdo = myPDO::getInstance();
        $sql = "INSERT INTO `utilisateur`(`id_Utilisateur`,`nom`, `prenom`, `mdp`, `image`, `note_Moyenne`,mail) VALUES (null,:nom, :prenom, :mdp, :image, 0, :mail)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':nom' => $params['nom'],
                            ':prenom' => $params['prenom'],
                            ':mdp' =>$params['mdp'],
                            ':mail' => $params['mail'],
                            ':image' => (isset($params['image'])) ? $params['image'] : null,));
        $sql = "SELECT LAST_INSERT_ID() FROM utilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetch();
        return $id['LAST_INSERT_ID()'];
    }
    public function modif($id){
        $sql = "UPDATE `utilisateur` SET `nom`=:nom,`prenom`=:prenom,`mdp`=:mdp,`image`=:image,`note_Moyenne`=:note_Moyenne, `mail` = :mail WHERE id_Utilisateur = :id_Utilisateur";
        $stmt = $pdo->prepare($pdo);
        $stmt->execute(array(":nom" => $this->nom,":prenom"=> $this->prenom,":image"=>$this->image,":note_Moyenne" => $this->note_Moyenne,":mail"=>$this->mail,":id_Utilisateur"=> $this->id_Utilisateur));
    }
    public function deleteUtilisateur(){
        $sql = "DELETE FROM `utilisateur` WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($pdo);
        $stmt->execute(array(":id"=>$this->id_Utilisateur));
    }
    public static function deleteUtilisateurById($id){
        $sql = "DELETE FROM `utilisateur` WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($pdo);
        $stmt->execute(array(":id"=>$id));  
    }
    public function AccederCompetences(){
        $competences = array();
        $pdo = myPDO::getInstance();
        $sql = "SELECT id_Competence AS id FROM Posseder WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $this->id_Utilisateur));
        $res = $stmt->fetchAll();
        
        foreach ($res as $re){
            $competences[] = Competence::createFromID($re['id'] +0);
        }
        return $competences;
    }
}