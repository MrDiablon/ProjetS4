<?php

require_once 'myPDO.include.php';

class Competence{

	private $id_Competence;
	private $libelle;
	private $niveau=null;
	private $competence_Parent;
	// private $etat=null;

	public function getId(){
		return $this->id_Competence;
	}

	//Créer une competence à l'aide d'un id
  	public static function createFromID($id) {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM Competence
            WHERE id_Competence = ?
SQL
				) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $stmt->execute(array($id)) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('Impossible de créer la compétence.');
    }

		//Retourne toutes les compétences de la base de données.
   public static function getAll() {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM Competence
            ORDER BY 'libelle'
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
        $stmt->execute() ;
        return $stmt->fetchAll() ;
    }



		//Récupère le libelle
		public function getLibelle(){
			return $this->libelle;
		}

		//Récupère le libelle à partir d'un id
		public function getLibelleById($id){
			$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT libelle FROM `Competence` WHERE id_Competence = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute(array($id));
		}


		//Retourne les competences pour le niveau en parametre
		public static function getCompetenceByNiveau($niv){
			$stmt = myPDO::getInstance()->prepare(<<<SQL
				SELECT *
				FROM `Competence`
				WHERE niveau = ?
SQL
		);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Competence') ;
			$stmt->execute(array($niv+0));
			return $stmt->fetchAll();
			throw new Exception('Aucune competence pour ce niveau.');
		}

		public static function getCompetenceByParents($id){
			$pdo = myPDO::getInstance();
			$sql = <<<SQL
				SELECT libelle, id_Competence as id 
				FROM Competence
				WHERE competence_Parent = :id
SQL;

			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":id"=>$id));
			return $stmt->fetchAll();
		}


		//Récupère le niveau de la compétence
		public function getNiveau(){
			return $this->niveau;
		}

		//Récupère le niveau de la compétence à partir d'un id
		public function getNiveauById($id){
			$stmt = myPDO::getInstance()->prepare(<<<SQL
			SELECT niveau FROM `Competence` WHERE id_Competence = ?
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute(array($id));
		}

		/**
        *Fonction permettant de retourer les annonces en fonction des compétences
        * de l'utilisateur connecté
        *return: un tableau d'ID annonces
        */
        public function getIdAnnoncesByIdCompetence(){
            $annonces = array();
            $pdo  = myPDO::getInstance();
            $sql  = "SELECT id_Annonce FROM Necessiter
                    WHERE id_Competence =:id_Competence";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(':id_Competence' => $this->id));

            $annonces = $stmt->fetchAll();

            return $annonces;
        }

        /**
        *Fonction retournant un tableau contenant toutes les compétences
        *return : un tableau de compétences
        **/
        public static function getAllInstances(){
            $competences = array();
            $pdo  = myPDO::getInstance();
            $sql  = "SELECT id_Competence FROM Competence";
            $stmt = $pdo->prepare($sql);
            $stmt->execute;
            $stmt->fetchAll();

            foreach($competences as $comp){
                $competences[] = self::createFromID($comp);
            }

            return $competences;
        }


		//Récupère l'id de la competence par libelle



		//****************************************************************
		//
		// Récupération de données
		//
		//****************************************************************



		//Redéfinir une compétence
		public static function setCompetence($lib,$niv){
			$stmt = myPDO::getInstance()->prepare(<<<SQL
			UPDATE `Competence` SET `libelle`= ? ,`niveau` =  WHERE id_Competence = ?
SQL
			);
			$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
			$stmt->execute(array($lib, $niv));
		}

		//Modifier le libelle d'une competence
		public function setLibelle($id, $lib) {
			$stmt = myPDO::getInstance()->prepare(<<<SQL
				UPDATE Competence
				SET libelle = '$lib'
				WHERE id_Competence = (SELECT id_Competence
																FROM Competence
																WHERE id_Competence = '$id');
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute() ;
		}

		//Modifier le niveau d'une compétence
		public function setNiveau($id, $niv) {
			$stmt = myPDO::getInstance()->prepare(<<<SQL
				UPDATE Competence
				SET niveau = '$niv'
				WHERE id_Competence = (SELECT id_Competence
																FROM Competence
																WHERE id_Competence = '$id');
SQL
		);
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
		$stmt->execute() ;
		}


		//****************************************************************
		//
		// Ajout de données
		//
		//****************************************************************

		//Ajouter une compétence à la base de données
		public function addCompetence($lib,$niv){
			$stmt = myPDO::getInstance()->prepare(<<<SQL
			INSERT INTO `Competence`(`libelle`, `niveau`) VALUES (?,?)
SQL
			);
			$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__) ;
	    $stmt->execute(array($lib,$niv));
		}












}
