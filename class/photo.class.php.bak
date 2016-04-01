<?php

require_once 'myPDO.class.php' ;

class Photo {
    /// Identifiant
    private $id   = null ;
    /// Données binaires de l'image JPEG
    private $jpeg = null ;

    private function Photo($id, $jpeg) {
        $this->id = $id;
        $this->jpeg = $jpeg;
    }

    /**
     * Usine pour fabriquer une instance à partir d'un identifiant
     * Les données sont issues de la base de données
     * @param int $id identifiant BD de la jaquette à créer
     * @return Photo instance correspondant à $id
     * @throws Exception si la jaquette ne peut pas être trouvée dans la base de données
     */
    public static function createFromId($id) {
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT image
            FROM particulier
            WHERE id_Utilisateur = ?
SQL
        ) ;
        $stmt->execute(array($id)) ;
        if (($object = $stmt->fetch()) !== false) {
            return new Photo($id, $object['image']);
        }
        throw new Exception('Photo not found') ;
    }

    /**
     * Accesseur sur id
     * @return string Identifiant
     */
    public function getId() {
        return $this->id ;
    }

    /**
     * Accesseur sur jpeg
     * @return string Données binaires de l'image JPEG
     */
    public function getJPEG() {
        return $this->jpeg ;
    }
}
