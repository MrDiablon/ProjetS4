<?php
require_once 'myPDO.include.php';

/**
* Classe Annonce
*
*/
class Annonce
{
								//Attributs
	//ID de l'Annonce - int
	private $id_annonce = null; 
	//ID de l'annonceur - int
	private $id_annonceur = null; 
	//ID du travailleur - int
	private $id_travailleur = null;
	//ID de la compétence - int
	private $id_competence = null;
	//Titre de l'annonce - String 
	private $titre = null; 
	//Description de l'annonce faite par l'annonceur - String
	private $description = null; 
	//Date du postage de l'annonce - date
	private $date = null; 
	//Prix proposé pour le travail effectué - int
	private $remuneration = null; 
	//Note mise par l'annonceur au sujet du travailleur
	private $note = null; 
	//Commentaire fait par l'annonceur au sujet du travailleur - String
	private $commentaire = null; 


	/**
	*Constructeur de la classe Annonce
	*param - $ID_Annonce: l'ID de l'annonce
	*/
	public static function CreateFromID($id_annonce)
	{
		$pdo = myPDO::getInstance();
		//Faire une requête en fonction de l'ID de l'annonce
		$stmt = $pdo->prepare (<<<SQL
			SELECT *
			FROM Annonce
			WHERE id_Annonce = ?
SQL
			);

		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute(array($id_annonce));
		if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception("Impossible de créer l'annonce") ;
		}


						//GETTERS

	/**
	*
	* Fonction permettant de retourner toutes les annonces postées
	* Tri par date
	*/
	public static function getAll() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM Annonce
			ORDER BY date;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public static function getAllPostulation() {
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM Accepter
			ORDER BY remuneration_Souhaite;
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		return $stmt->fetchAll();		
	}
	public static function getPostulantByIdAnnonce($id_annonce){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT *
			FROM Accepter
			WHERE id_Annonce=:id
SQL
		);
		$stmt->execute(array(":id"=> $id_annonce));
		return $stmt->fetchAll();
		
	}
	
	public function getPourquoi(){
		return $this->pourquoi;
	}
	public function getremuneration_Souhaite(){
		return $this->remuneration_Souhaite;
	}
	
	public function getIdAnnonce(){
		return $this->id_Annonce;
	}

	public function getIdAnnonceur(){
		return $this->id_Utilisateur;
	}

	public function getIdTravailleur(){
		return $this->Uti_id_Utilisateur;
	}

	public function getTitre(){
		return $this->titre;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getDate(){
		return $this->date;
	}

	public function getRemuneration(){
		return $this->remuneration;
	}

	public function getNote(){
		return $this->note;
	}

	public function getCommentaire(){
		return $this->commentaire;
	}

	public function getIdCompetence(){
		return $this->id_competence;
	}

						//gettersByID
	//gettersByID
    public static function getIdAnnonceurByID($id){
        $sql = "SELECT id_Utilisateur FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getIdTravailleurByID($id){
        $sql = "SELECT Uti_id_Utilisateur FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getTitreByID($id){
        $sql = "SELECT titre FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getDescriptionByID($id){
        $sql = "SELECT description FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getDateByID($id){
        $sql = "SELECT 'date' FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getRemunerationByID($id){
        $sql = "SELECT remuneration FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getNoteByID($id){
        $sql = "SELECT note FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getCommentaireByID($id){
        $sql = "SELECT commentaire FROM Annonce WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }

    public static function getCompetenceByID($id){
        $sql = "SELECT id_Competence FROM Necessiter WHERE id_Annonce = :id";
        $pdo = myPDO::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
        }


						//Setters 


public function setTitre($value){
        $this->titre = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET titre = :titre
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':titre' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;

    }

    public function setDescription($value){
        $this->description = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET description = :descr
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':descr' => $value,
                            ':id_Annonce' => $this->id_Annonce));
    }

    public function setDate($value){
        $this->date = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET 'date' = ':date'
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':date' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }

    public function setRemuneration($value){
        $this->remuneration = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET remuneration = :remu
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':remu' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }

    public function setNote($value){
        $this->note = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET note = :note
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':note' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }

    public function setCommentaire($value){
        $this->commentaire = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET commentaire = :commentaire
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':commentaire' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }

    public function setIdTravailleur($value){
        $this->id_travailleur = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Annonce SET Uti_id_Utilisateur = :Uti_id_Utilisateur
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':Uti_id_Utilisateur' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }

    public function setIdCompetence($value){
        $this->id_competence = $value;

        $pdo = myPDO::getInstance();
        $sql = "UPDATE Necessiter SET id_Competence = :id_Competence
                                  WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $req->execute(array(':id_Competence' => $value,
                            ':id_Annonce' => $this->id_Annonce)) ;
    }
    
    public static function setEtatAccepter($etat,$id_annonce){
      $pdo = myPDO::getInstance();
      $sql = <<<SQL
	  UPDATE `Accepter`
	  SET `etat`= :etat
	  WHERE id_Annonce = :id
SQL;
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(":etat"=>$etat,
                          ":id"=>$id_annonce));
                          
    }


                /**********************************
                            METHODES
                **********************************/
    /**
    * Fonction permettant la création d'une annonce dans la BD
    * Création d'une instance de l'annonce créee
    * return: l'instance
    */
    public static function addAnnonce($title, $desc, $dat,$remun){
        $pdo = myPDO::getInstance();
        $sql1 = (<<<SQL
            INSERT INTO `Annonce`(`id_Utilisateur`,`Uti_id_Utilisateur`,`note`,`commentaire`,`titre`,`description`,
                                  `date`,`remuneration`) VALUES (1,2,0,"",?,?,?,?)
SQL
    );

        $stmt = $pdo->prepare($sql1);
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $stmt->execute(array($title, $desc, $date,$remun));

        /*$sql2 = "SELECT id_Annonce FROM Annonce WHERE id_Annonce = :id_Annonce";
        $stmt = $pdo->prepare($sql2);
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        // COMMENT SELECTIONNER l'id_Annonce crée précedemmet ?
        $idAnnonce = $stmt->execute(array(':id_Annonce' => $pdo->lastInsertID()));
        $instance  = self::createFromID($idAnnonce);

        return $instance;*/
    }
    
    public static function deleteNotAccept($idA,$idU){
	$pdo = myPDO::getInstance();
	$sql = <<<SQL
	    DELETE FROM `Accepter` 
	    WHERE id_Annonce = :id
	    and id_Utilisateur != :idU
SQL;
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(":id"=>$idA,":idU"=>$idU));
    }
    
    public static function addPostulation($id_Annonce,$id_Postulant,$pourquoi,$remuneration_souhaite){
       $pdo = myPDO::getInstance();
       $sql1 = (<<<SQL
            INSERT INTO `Accepter`(`id_Annonce`, `id_Utilisateur`, `etat`, `pourquoi`, `remuneration_Souhaite`) VALUES (:id_Annonce,:id_Utilisateur,null,:pourquoi,:remuneration)
SQL
    );

        $stmt = $pdo->prepare($sql1);
        $stmt->execute(array(":id_Annonce"=>$id_Annonce,
			     ":id_Utilisateur"=>$id_Postulant,
			     ":pourquoi"=>$pourquoi,
			     ":remuneration"=>$remuneration_souhaite));
    
    }
    


    /**
    *Fonction permettant de supprimer une Annonce dans la BD
    *param - idAnnonce = ID de l'annonce à supprimer
    *
    */
    public function removeAnnonce($idAnnonce){
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            DELETE *
            FROM  Annonce
            WHERE id_Annonce = :id_Annonce
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $stmt->execute(array(':id_Annonce' => $this->id_Annonce)) ;

    }

    /**
    * Fonction permettant de compter le nombre d'annonces dans la BD
    * return: le nombre d'annonces
    */
    public static function count(){
        $pdo = myPDO::getInstance();
        $sql="COUNT(id_Annonce) FROM Annonce";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch();

        if($res != FALSE){
            return $res;
        }
        else {
            return 0;
        }
    }

    /**
    * Fonction permettant selectionner un certain nombre d'annonces dans la BD
    * en sélectionnant la 1ère ligne et stock les annonces dans un tableau
    * param $deb: La 1ère ligne à prendre en compte dans la BD
    * param $nb: le nombre de lignes à prendre dans la BD en partant de $deb
    * return: le tableau contenant les annonces selectionnées
    */
    public static function getByNb($deb, $nb){
        $pdo = myPDO::getInstance();

        if(!is_integer($deb) && !is_integer($nb)){
            $nb = intval($nb);
            $deb = intval($deb);
            if($nb == 0) {
                $nb = 10;
            }
        }

        $sql  = "SELECT * FROM Annonce ORDER BY 'date' desc limit :deb , :nb";
        $stmt = $pdo->prepare($sql);
        $stmt-> setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        if(is_integer($nb)){
            $stmt->bindParam(':deb', $deb, PDO::PARAM_INT);
            $stmt->bindParam(':nb', $nb, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();

        }

}
