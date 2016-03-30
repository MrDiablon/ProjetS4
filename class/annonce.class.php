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
		$this->description = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET titre = )
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);

	}

	public function setDescription($value){
		$this->description = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET description =:description);
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setDate($value){
		$this->date = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET date = );
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setRemuneration($value){
		$this->remuneration = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET remuneration = );
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setNote($value){
		$this->note = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET note = );
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setCommentaire($value){
		$this->commentaire = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET commentaire = );
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setIdTravailleur($value){
		$this->id_travailleur = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE Annonce 
			SET Uti_id_Utilisateur = );
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public function setIdCompetence($value){
		$this->id_competence = $value;

		$stmt = myPDO::getInstance();
		$req  = $stmt->prepare(<<<SQL
			UPDATE 	Necessiter
			SET 	id_Competence = 
			WHERE 	id_Annonce = '$this->id_annonce');
SQL
		);
		$req->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$req->execute($value);
	}

	public static function addAnnonce($title, $desc, $dat,$remun){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO `Annonce`(`id_Utilisateur`,`Uti_id_Utilisateur`,`note`,`commentaire`,`titre`,`description`,
								  `date`,`remuneration`) VALUES (1,2,0,"",?,?,?,?)
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute(array($title, $desc, $dat,$remun));
	}

	public function removeAnnonce($idannonce){;
		$stmt = myPDO::getInstance()->prepare(<<<SQL
			DELETE *
			FROM  Annonce
			WHERE id_Annonce = '$idannonce';
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute();

	}
}

?>
