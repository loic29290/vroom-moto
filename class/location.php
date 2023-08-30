<?php

class Location
{
    use Assainit;

    private $id;
    private $moto_id;
    private $locataire_id;
    private $debut;
    private $fin;


    public function __construct()
    {
        $this->setId(null);
        $this->setMotoId(null);
        $this->setLocataireId(null);
        $this->setDebut(date("Y-m-d"));
        $this->setFin(date("Y-m-d"));
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setMotoId(?int $moto_id): void
    {
        $this->moto_id = $moto_id;
    }
    public function getMotoId(): ?int
    {
        return $this->moto_id;
    }
    public function setLocataireId(?int $locataire_id): void
    {
        $this->locataire_id = $locataire_id;
    }
    public function getLocataireId(): ?int
    {
        return $this->locataire_id;
    }
    public function setDebut(string $debut): void
    {
        $this->debut = $debut;
    }
    public function getDebut(): string
    {
        return $this->debut;
    }
    public function getDebutFormate(): string
    {
        $date = new DateTime($this->debut);
        return $date->format('d/m/Y');
    }
    public function setFin(string $fin): void
    {
        $this->fin = $fin;
    }
    public function getFin(): string
    {
        return $this->fin;
    }
    
    public function getFinFormate(): string
    {
        $date = new DateTime($this->debut);
        return $date->format('d/m/Y');
    }

    public function checkPost(): bool
    {
        if (!isset($this->debut, $this->fin)) {
            return false;
        }
        if (empty($this->debut)) {
            return false;
        }
        if (empty($this->fin)) {
            return false;
        }

        return true;
    }
    

    public function getMoto(): ?Moto
    {
        return Moto::findById($this->moto_id);
    }

    // récupere une location
    public static function findLocationById(int $id): mixed
    {
        $query = "SELECT * FROM location WHERE id=:id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":id" => $id,
        ]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
        return $sth->fetch();
    }

    // récupere les locations d'une moto appartenant à un propriétaire spécifique.
    public static function findLocation(): mixed
    {
        $query = "SELECT location.* FROM location, moto WHERE moto.id = location.moto_id AND moto.proprietaire_id=:proprietaire_id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":proprietaire_id" => $_SESSION['ID'],
        ]);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
    }
    
  
    
    // récupère les réservations en cours et futures pour une moto spécifique.
    public static function verifDate(int $motoId): array
    {
        // Requête pour récupérer les réservations en cours et futures de la moto spécifiée.
        $query = "SELECT * FROM location WHERE moto_id = :moto_id AND fin >= NOW()";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":moto_id" => $motoId,
        ]);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
    }


    // Récupere la location effectué comme loueur
    public static function findReservation(): mixed
    {
        $query = "SELECT location.* FROM location WHERE locataire_id=:locataire_id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":locataire_id" => $_SESSION['ID'],
        ]);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
    }

    // compare les dates de locations
    public static function findMotoReservations(int $motoId, string $debut, string $fin): mixed
    {
        $query = "SELECT location.* FROM location 
              WHERE moto_id = :moto_id 
              AND (('date_debut' BETWEEN :debut AND :fin) OR ('date_fin'  BETWEEN :debut AND :fin))";

        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":moto_id" => $motoId,
            ":debut" => $debut,
            ":fin" => $fin
        ]);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
    }



    public function loadFromPost(): void
    {
        $this->setDebut($this->assainit($_POST['debut']));
        $this->setFin($this->assainit($_POST['fin']));
    }



    public function save(): void
    {
        $query = "INSERT INTO location
        (moto_id, locataire_id, debut, fin )
        VALUES
        (:moto_id, :locataire_id, :debut, :fin)";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":moto_id" => $this->getMotoId(),
            ":locataire_id" => $_SESSION["ID"],
            ":debut" => $this->getDebut(),
            ":fin" => $this->getFin()
        ]);
    }
    
    public static function locationMoto($motoId): mixed {
        $query = "SELECT location.* FROM location 
              WHERE moto_id = :moto_id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":moto_id" => $motoId,
        ]);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Location");
    }
     
}
