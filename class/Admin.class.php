<?php

require_once 'myPDO.include.php';

class Admin extends Utilisateur{

	/**
    *fonction permettant d'ajouter une ligne Utilisateur dans 
    *la base de donnée
	*
	*@param $params tableau a clé avec les parametres necessaire
	*a la creation
    *
    *@return une instance d'Admin
    */
    public static function createAdmin($params){
    	$id = parent::create($params);
        $pdo = myPDO::getInstance();
    	$sql = "INSERT INTO `admin`(`id_Utilisateur`,`nom`, `prenom`, `mdp`, `image`, `note_Moyenne`, `mail`) VALUES (:id,:nom, :prenom, :mdp, :image, :note_moyenne, :mail)";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute(array(':id' => $id,
    						':nom' => $params['nom'],
    						':prenom' => $params['prenom'],
    						':mdp' =>$params['mdp'],
    						':image' => $params['image'],
    						':note_moyenne' => 0,
    						':mail' => $params['mail']));

    	$sql = "SELECT LAST_INSERT_ID() FROM utilisateur";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute();

    	$id = $stmt->fetch();

    	return $id;
    }

    public static function createAdminById($id){
    	$sql = "select nom,prenom,image,note_Moyenne from Admin where id_Utilisateur = :id";
        $pdo = myPDO::getInstance();
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute(array(":id" => $id));
    	$stmt-> setFetchMode(PDO::FETCH_CLASS,'Admin');
		$retour = $stmt->fetch();
      	//verification de la presence d'un résultat
      	if($retour === FALSE){
			throw new Exception('Membre_Introuvable');
      	}

      	return $retour;
    }

    public function modif($id){
        $pdo = myPDO::getInstance();
    	$sql = "UPDATE `admin` SET `nom`=:nom,`prenom`=:prenom,`mdp`=:mdp,`image`=:image,`note_Moyenne`=:note_Moyenne WHERE id_Utilisateur = :id_Utilisateur";
    	$stmt = $pdo->prepare($pdo);
    	$stmt->execute(array(":nom" => $this->nom,":prenom"=> $this->prenom, ":image"=>$this->image,
                             ":note_Moyenne" => $this->note_Moyenne,":id_Utilisateur"=> $this->id_Utilisateur));
    	parent::modif($id);
    }

    public function deleteAdmin(){
    	$sql = "DELETE FROM `admin` WHERE id_Utilisateur = :id";
    	$stmt = $pdo->prepare($pdo);
    	$stmt->execute(array(":id"=>$this->id_Utilisateur));
    	parent::deleteUtilisateur();
    }

    public static function deleteAdminById($id){
        $pdo = myPDO::getInstance();
    	$sql = "DELETE FROM `utilisateur` WHERE id_Utilisateur = :id";
    	$stmt = $pdo->prepare($pdo);
    	$stmt->execute(array(":id"=>$id));	
    	parent::deleteUtilisateur($id);
    }

    public function isAdmin(){
        $pdo = myPDO::getInstance();
        $sql = "SELECT id_Utilisateur FROM Admin WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":id" => $this->id_Utilisateur));
        $retour = $stmt->fetch();

        if($retour !== false){
            return false;
        }

        return true;
    }

    public static function countAdmin(){
        $pdo = myPDO::getInstance();
        $sql = "select count(id_Utilisateur) from Admin";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();z
        $retour = $stmt->fetch();
        if($retour !== FALSE){
            return $retour;
        }
        return 0;
    }

    public static function getByNb($deb,$nb){
        $pdo = myPDO::getInstance() ;
      
      if(!is_integer($deb) && !is_integer($nb)){
            $nb= intval($nb);
            $deb = intval($deb);
            if ($nb == 0) {
                $nb = 5;
            }
      }
        //questionnement de la BD
      $sql=<<<SQL
      select  nom,prenom,image,note_Moyenne
      from Admin
      order by nom desc
      limit :deb , :nb
SQL;

      //execution de la commande
      $stmt = $pdo->prepare($sql) ;
      $stmt-> setFetchMode(PDO::FETCH_CLASS,__CLASS__);
      if(is_integer($nb)){
        $stmt->bindParam(':deb', $deb, PDO::PARAM_INT);
        $stmt->bindParam(':nb', $nb, PDO::PARAM_INT);
      }
    
      $stmt->execute();
      //recuperation du resultat de la commande sql
      return $stmt->fetchAll();
    }
}