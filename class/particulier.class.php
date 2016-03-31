<?php

require_once 'autoload.include.php';

class Particulier extends Utilisateur{
	//protected $id_Utilisateur;
	private $ville_id;
	private $date_Naissance;
	private $adresse;
	private $situation_Professionnelle;
	private $num_Tel;

	public static function createParticulier($params){
		self::$pdo = myPDO::getInstance();
		$id = parent::createUtilisateur($params);
		self::create($params, $id);
		$retour = self::createParticulierById($id);

		return $retour;
	}

	public static function createParticulierById($id){
		if(!is_int($id)){
			$id = intval($id);
			if($id <= 0){
				$id = 1;
			}
		}
		$sql = "select id_Utilisateur, ville_id, nom, prenom, image, note_Moyenne, date_Naissance, adresse, situation_Professionnelle, num_Tel, mail from Particulier where id_Utilisateur = :id";
		$stmt = myPDO::getInstance()->prepare($sql);
		$stmt-> setFetchMode(PDO::FETCH_CLASS,'Particulier');
		$stmt->execute(array(':id'=>$id));
      	//recuperation du resultat de la commande sql
      	$retour = $stmt->fetch();
      	//verification de la presence d'un résultat
      	if($retour === FALSE){
					throw new Exception('Membre_Introuvable');
      	}

      	return $retour;
	}

	public static function create($params, $id){
		if(!is_int($id)){
			$id = intval($id);
			if($id <= 0){
				$id = 1;
			}
		}
		$sql = "INSERT INTO
			   `particulier`(`id_Utilisateur`, `ville_id`, `nom`, `prenom`, `mdp`, `image`, `note_Moyenne`, `date_Naissance`, `adresse`, `situation_Professionnelle`, `num_Tel`, `mail`)
			    VALUES (:id_Utilisateur, :ville_id, :nom, :prenom, :mdp, :image, :note_Moyenne, :date_Naissance, :adresse, :situation_Professionnelle, :num_Tel, :mail)";
		$stmt = self::$pdo->prepare($sql);
//var_dump($params['mail']);
		$stmt->execute(array(':id_Utilisateur' => $id,
							 ':ville_id' => $params['ville_id'],
							 ':nom' => $params['nom'],
							 ':prenom' => $params['prenom'],
							 ':mdp' => $params['mdp'],
							 ':image' => (isset($params['image'])) ? $params['image'] : null,
							 ':note_Moyenne' => 0,
							 ':date_Naissance' => $params['date_Naissance'],
							 ':adresse' => $params['adresse'],
							 ':situation_Professionnelle' => $params['situation_Professionnelle'],
							 ':num_Tel' => $params['num_Tel'],
							 ':mail' => $params['mail'])
		);

	}

	public static function deleteParticulierById($id){
		if(!is_int($id)){
			$id = intval($id);
			if($id <= 0){
				$id = 1;
			}
		}
		$sql = "DELETE FROM `particulier` WHERE id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		parent::deleteUtilisateur($id);
	}

	public function deleteParticulier(){
		$sql = "DELETE FROM `particulier` WHERE id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($this->id_Utilisateur));
		parent::deleteUtilisateur($this->id_Utilisateur);
	}

	public function modif($mdp){
		if($mdp != null){
			$sql = "UPDATE `particulier`
			        SET `ville_id`=:ville_id,`nom`= :nom,`prenom`= :prenom,
			            `image`= :image,`note_Moyenne`=:note_Moyenne,
			            `date_Naissance`=:date_Naissance,`adresse`=:adresse,
			            `situation_Professionnelle`=:situation_Professionnelle,`num_Tel`=:num_Tel,`mail`=:mail
			        WHERE id_Utilisateur = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(':ville_id' => $this->ville_id,':nom' => $this->nom,
								 ':prenom' => $this->prenom,
								 ':image' => $this->image,
								 ':note_Moyenne' => $this->note_Moyenne,
								 ':date_Naissance' => $this->date_Naissance,
								 ':adresse' => $this->adresse,
								 ':situation_Professionnelle' => $this->situation_Professionnelle,
								 ':num_Tel' => $this->num_Tel,
								 ':mail' => $this->mail));
		}else{
			$sql = "UPDATE `particulier`
			        SET `ville_id`=:ville_id,`nom`= :nom,`prenom`= :prenom,
			            `mdp`=:mdp,`image`= :image,`note_Moyenne`=:note_Moyenne,
			            `date_Naissance`=:date_Naissance,`adresse`=:adresse,
			            `situation_Professionnelle`=:situation_Professionnelle,`num_Tel`=:num_Tel,`mail`=:mail
			        WHERE id_Utilisateur = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(':ville_id' => $this->ville_id,':nom' => $this->nom,
								 ':prenom' => $this->prenom,
								 ':mdp' => $this->mdp,
								 ':image' => $this->image,
								 ':note_Moyenne' => $this->note_Moyenne,
								 ':date_Naissance' => $this->date_Naissance,
								 ':adresse' => $this->adresse,
								 ':situation_Professionnelle' => $this->situation_Professionnelle,
								 ':num_Tel' => $this->num_Tel,
								 ':mail' => $this->mail));
		}
	}

	public function count(){
		$sql = "count(id_Utilisateur) from Particulier";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$retour = $stmt->fetch();

		if($retour !== FALSE){
			return $retour;
		}
		return 0;

	}

	public static function verifCo($value,$gds){
		$sql ="select id_Utilisateur as id from Particulier where concat(sha1(mail),:gds,mdp) = :value";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":gds" => $gds, ":value" => $value));
		$retour = $stmt->fetch();
		
		if(!$retour){
			return -1;
		}

		return $retour['id'];
	}

	public static function getAll(){
		$sql = "select id_Utilisateur as id from Particulier";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();
		$retour = array();
		foreach($res as $re){
			$retour[] = createParticulierById($re['id']);
		}

		return $retour;
	}

	public static function getListVilleHtmlByDepartement($id){
		if(!is_int($id)){
			$id = intval($id);
			if($id <= 0){
				$id = 1;
			}
		}
		$pdo = myPDO::getInstance();
        $sql = "select ville_id as id , ville_nom_reel as ville from Villes_france where ville_departement = :id order by ville";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id",$id , PDO::PARAM_INT);
        $stmt->execute();
//var_dump($stmt->fetchAll());
        return $stmt->fetchAll();
    }

    public static function getListDepartement(){
    	$pdo = myPDO::getInstance();
    	$sql = "select departement_id as id, departement_nom as departement from Departement order by departement";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute();
    	return $stmt->fetchAll();
    }

    public static function countParticulier(){
    	$pdo = myPDO::getInstance();
    	$sql = "select count(id_Utilisateur) from Utilisateur";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute();
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
	  select *
	  from Evenement
	  order by dateEve desc
	  limit :deb , :nb
SQL;

      //execution de la commande
      $stmt = $pdo->prepare($sql) ;
      $stmt-> setFetchMode(PDO::FETCH_CLASS,'Evenement');
      if(is_integer($nb)){
      	$stmt->bindParam(':deb', $deb, PDO::PARAM_INT);
      	$stmt->bindParam(':nb', $nb, PDO::PARAM_INT);
  	  }
  	
      $stmt->execute();
      //recuperation du resultat de la commande sql
      return $stmt->fetchAll();
    }

    public function isAdmin(){
        $sql = "SELECT id_Utilisateur FROM Admin WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($pdo);
        $stmt->execute(array(":id" => $this->id_Utilisateur));
        $retour = $stmt->fetch();

        if($retour !== false){
            return false;
        }

        return true;
    }

    /**
    * Fonction permettant de retourner les annonces selon les compétences
    * du particulier
    * Prise en compte de son département
    * return: le tableau des annonces le concernant
    */
    public function getAnnoncesParticulier(){
    	if(User::isConnected()){

	    	$annoncesParticulier = array(); //Le tableau qui recevra les instances d'annonces annonces et sera retourné
	    	$competencesParticulier = array(); //le tableau qui recevra les instances de competences
	    	$idAnnonces = array(); //le tableau qui recevra les ID des annonces

	    	$pdo  = myPDO::getInstance();
	    	$sql  = "SELECT id_Competence FROM Posseder WHERE id_Utilisateur = :id";
	    	$stmt = $pdo->prepare($sql);
	    	$stmt-> execute(array(':id' => $this->id_Utilisateur));
	    	$idComps = $stmt->fetchAll(); //les id competences entrées dans $idComps
	    	foreach ($idComps as $idComp){
	    		//création des competences par ID et stockage dans un tableau
	            $competencesParticulier[] = Competence::createFromID($idComp);

		    	//l'ajout à la fin du tableau de l'id annonce contenant les compétences du tableau
		    	$idAnnonces[] = end($competencesParticulier)->getIdAnnoncesByIdCompetence();	
	    	}
	    	
	    	foreach ($idAnnonces as $idAnnonce) {
	    		//Selection du département de l'annonceur
				$sql2 = "SELECT departement_id
						 FROM Situer
						 WHERE ville_id = (SELECT ville_id
						 					FROM Particulier
						 					WHERE id_Utilisateur = (SELECT id_Utilisateur
						 											FROM Utilisateur
						 											WHERE id_Utilisateur = (SELECT id_Utilisateur
						 																	FROM Annonce
						 																	Where id_Annonce = :id_Annonce";
				$stmt2 = $pdo->prepare($sql2);
				$stmt2->execute(array(':id_Annonce' => $idAnnonce));
				$idDepartAnnonce = $stmt2->fetch();

				//Si le departement de l'annonceur est celui du particulier en cours
				if($idDepartAnnonce = $this->getDepartement_id()){
					//création des annonces par ID et stockage dans un tableau
					$annoncesParticulier[] = Annonce::createFromID($idAnnonce);
				}
    			
	    	}

	    	return $annoncesParticulier;

    	}
    }

	/*****************************************************
		GETTER
	******************************************************/


	

	public function getNom(){
		return $this->nom;
	}

	public function getPrenom(){
		return $this->prenom;
	}

    public function getImage(){
    	return $this->image;
    }

    public function getNote_moyenne(){
    	return $this->note_Moyenne;
    }

	public function getVille_id(){
		return $this->ville_id;
	}

	public function getVille(){
		$pdo = myPDO::getInstance();
		$sql = "select ville_nom_reel from Villes_france where ville_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':id' => $this->ville_id ));
		$retour = $stmt->fetch();
		if($retour !== false){
			return $retour['ville_nom_reel'];
		}
		return "";
	}


	public function getDepartement_id(){
		$pdo = myPDO::getInstance();
		$sql = "select departement_id as dep_id from departement where departement_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':id' => $this->ville_id ));
		$retour = $stmt->fetch();
		if($retour !== false){
			return $retour['dep_id'];
		}
		return "";
	}


	public function getDepartementNom(){
		$pdo = myPDO::getInstance();
		$sql = "select departement_nom as dep from departement where departement_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':id' => $this->ville_id ));
		$retour = $stmt->fetch();
		if($retour !== false){
			return $retour['dep'];
		}
		return "";
	}
/*
	 public function accederCompetences(){
        $competences = array();

        $pdo = myPDO::getInstance();
        $sql = "SELECT id_Competence AS id FROM Posseder WHERE id_Utilisateur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $this->id_Utilisateur));

        $res = $stmt->fetchAll();
        
        foreach ($res as $re){
            $competences[] = Competence::createFromID($res['id']);
        }
        return $competences;
    }
*/
	public function getDate_Naissance(){
		return $this->date_Naissance;
	}

	public function getAdresse(){
		return $this->adresse;
	}

	public function getSituation_Professionnelle(){
		return $this->situation_Professionnelle;
	}

	public function getNum_Tel(){
		return $this->num_Tel;
	}

	public function getMail(){
		return $this->mail;
	}

	/*****************************************************
		SETTER
	******************************************************/

	public function setNom($value){
		$this->nom = $value;
	}

	public function setPrenom($value){
		$this->prenom = $value;
	}

    public function setImage($value){
    	$this->image = $value;
    }

    public function setNote_moyenne($value){
    	$this->note_Moyenne = $value;
    }

	public function setVille_id($value){
		$this->ville_id = $value;
	}

	public function setDate_Naissance($value){
		$this->date_Naissance = $value;
	}

	public function setAdresse($value){
		$this->adresse = $value;
	}

	public function setSituation_Professionnelle($value){
		$this->situation_Professionnelle = $value;
	}

	public function setNum_Tel($value){
		$this->num_Tel = $value;
	}

	public function setMail($value){
		$this->mail = $value;
	}


	/*****************************************************
		GETTER BY ID
	******************************************************/

	public function getNomById($id){
		$sql = "select value from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute($id);
		return $stmt->fetch();
	}

	public function getPrenomById($id){
		$sql = "select value from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute($id);
		return $stmt->fetch();
	}

    public function getImageById($id){
    	$sql = "select image from Particulier where id_Utilisateur = :id";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute($id);
    	return $stmt->fetch();
    }

    public function getNote_moyenneById($id){
    	$sql = "select value from Particulier where id_Utilisateur = :id";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute($id);
    	return $stmt->fetch();
    }

	public function getVille_idByID($id){
		$sql = "select ville_id from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	public function getDate_NaissanceByID($id){
		$sql = "select date_Naissance from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	public function getAdresseByID($id){
		$sql = "select adresse from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	public function getSituation_ProfessionnelleByID($id){
		$sql = "select situation_Professionnelle from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	public function getNum_TelByID($id){
		$sql = "select num_Tel from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

	public function getMailByID($id){
		$sql = "select mail from Particulier where id_Utilisateur = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetch();
	}

}