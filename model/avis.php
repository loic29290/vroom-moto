<?php

class Avis
{

    private $id;
    private $location_id;
    private $auteur_id;
    private $note;
    private $commentaire;



    public function __construct()
    {
        $this->setId(null);
        $this->setLocationId(null);
        $this->setAuteurId(null);
        $this->setNote(0);
        $this->setCommentaire("");
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setLocationId(?int $location_id): void
    {
        $this->location_id = $location_id;
    }
    public function getLocationId(): ?int
    {
        return $this->location_id;
    }
    public function setAuteurId(?int $auteur_id): void
    {
        $this->auteur_id = $auteur_id;
    }
    public function getAuteurId(): ?int
    {
        return $this->auteur_id;
    }
    public function setNote(float $note): void
    {
        $this->note = $note;
    }
    public function getNote(): float
    {
        return $this->note;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }




    public function checkPost(): bool
    {
        if (!isset($this->note, $this->commentaire)) {
            return false;
        }
        if (empty($this->note)) {
            return false;
        }
        if (empty($this->commentaire)) {
            return false;
        }

        return true;
    }


    // Charger les données d'un avis depuis les données POST
    public function loadFromPost(): void
    {
        $this->setNote(floatval($_POST['note']));
        $this->setCommentaire(trim($_POST['commentaire']));
    }

    // Vérifier si une moto a été réservée par un utilisateur 
    public static function MotoReservee(int $motoId, int $userId): bool
    {
        // Compter le nombre de réservations pour une moto et un utilisateur
        $query = "SELECT COUNT(*) FROM location WHERE moto_id = :motoId AND locataire_id = :userId";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":motoId" => $motoId,
            ":userId" => $userId
        ]);

        // Récupérer le nombre de lignes résultantes
        $rowCount = $sth->fetchColumn();

        // Si le nombre de réservations est supérieur à 0, la moto a été réservée par l'utilisateur
        return $rowCount > 0;
    }

    // Envoyer un avis
    public function envoyerAvis(): void
    {
        if ($this->getId()) {
            // Mettre à jour l'avis dans la base de données
            $query = "UPDATE avis SET note=:note, commentaire=:commentaire, date=NOW()
            WHERE location_id=:location_id AND auteur_id=:auteur_id";
        } else {
            // Insérer un nouvel avis dans la base de données
            $query = "INSERT INTO avis 
            (location_id, auteur_id, note, commentaire, date) 
            VALUES 
            (:location_id, :auteur_id, :note, :commentaire, NOW())";
        }

        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":location_id" => $this->getLocationId(),
            ":auteur_id" => $_SESSION["ID"],
            ":note" => $this->getNote(),
            ":commentaire" => $this->getCommentaire()
        ]);
        
    }

    // Récupérer les avis liés à une moto
    public static function getAvisByMotoLocation(int $motoId): mixed
    {
        // Récupérer les avis liés à une moto spécifique
        $query = "
            SELECT avis.*
            FROM avis, location
            WHERE avis.location_id = location.id AND location.moto_id = :motoId";

        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ':motoId' => $motoId
        ]);

        // Récupérer les résultats sous forme d'objets Avis
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Avis");
    }

    // Récupérer les avis liés à une location
    public static function getAvisByLocation(int $locationId): mixed
    {
        // Récupérer les avis liés à une location spécifique
        $query = "
            SELECT avis.*
            FROM avis
            WHERE avis.location_id = :locationId";

        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ':locationId' => $locationId
        ]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Avis");
        // Récupérer le résultats sous forme d'objet Avis
        return $sth->fetch();
    }

    // Récupérer les avis d'un utilisateur pour une moto
    public static function avisUser(): void
    {
        $query = "SELECT location_id FROM avis ";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute();
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $originalDate = $row['date'];
            $newDate = date("d/m/Y à H:i:s", strtotime($originalDate));
            echo "Commentaire de : " . $row['auteur_id'] . "<br>" . $row['commentaire'] . "<br>Le " . $newDate . "<br><br>";
        }
    }
    // Récupérer tous les avis 
    public static function allAvis(): mixed
    {
        $query = "SELECT * FROM avis";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Avis");
    }

    // Supprimer un avis en utilisant une requête SQL DELETE
    public static function supprimerAvis($avisID): void
    {
        $query = "DELETE FROM avis WHERE id = :id";
        $sth = Db::getDbh()->prepare($query);

        // Utilisez $avisID pour lier la valeur de l'ID à supprimer
        $sth->bindParam(':id', $avisID, PDO::PARAM_INT);
        $sth->execute();
    }
    
}
