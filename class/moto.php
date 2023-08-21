<?php



class Moto
{
    use Assainit;

    private $id;
    private $marque;
    private $modele;
    private $categorie;
    private $annee;
    private $bridee;
    private $description;
    private $prix;
    private $image;
    private $proprietaire_id;

    public function __construct()
    {
        $this->setId(null);
        $this->setMarque("");
        $this->setModele("");
        $this->setCategorie("");
        $this->setAnnee(0);
        $this->setBridee("");
        $this->setDescription("");
        $this->setPrix(0);
        $this->setImage("");
        $this->setProprietaire_id(null);
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setMarque(string $marque): void
    {
        $this->marque = $marque;
    }
    public function getMarque(): string
    {
        return $this->marque;
    }
    public function setModele(string $modele): void
    {
        $this->modele = $modele;
    }
    public function getModele(): string
    {
        return $this->modele;
    }
    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }
    public function getCategorie(): string
    {
        return $this->categorie;
    }
    public function setAnnee(float $annee): void
    {
        $this->annee = $annee;
    }
    public function getAnnee(): float
    {
        return $this->annee;
    }
    public function setBridee(string $bridee): void
    {
        $this->bridee = $bridee;
    }
    public function getBridee(): string
    {
        return $this->bridee;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }
    public function getPrix(): float
    {
        return $this->prix;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function setProprietaire_Id(?int $proprietaire_id): void
    {
        $this->proprietaire_id = $proprietaire_id;
    }
    public function getProprietaire_Id(): ?int
    {
        return $this->proprietaire_id;
    }


    public static function findById(int $id): ?Moto
    {
        $query = "SELECT * FROM moto WHERE id=:id";
        $sth = Db::getDbh()->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
        $sth->execute([
            ":id" => $id
        ]);
        $moto = $sth->fetch();
        if ($moto) {
            return $moto;
        }
        return null;
    }

    public static function findAll()
    {
        $query = "SELECT * FROM moto";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
    }

    public function checkPost(): bool
    {
        if (!isset($this->marque, $this->modele, $this->categorie, $this->annee, $this->bridee, $this->description, $this->prix)) {
            return false;
        }
        if (empty($this->marque)) {
            return false;
        }
        if (empty($this->modele)) {
            return false;
        }
        if (empty($this->categorie)) {
            return false;
        }
        if (empty($this->annee)) {
            return false;
        }
        if (empty($this->bridee)) {
            return false;
        }
        if (empty($this->description)) {
            return false;
        }
        if (empty($this->prix)) {
            return false;
        }
        // if (empty($this->proprietaire_id)) {
        //     return false;
        // }
        if (!$this->checkImageMoto()) {
            return false;
        }
        return true;
    }

    private function checkImageMoto()
    {
        if (!isset($_FILES['file'])) {
            return false;
        }
        $tmpName = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $error = $_FILES['file']['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $maxSize = 1024 * 1024 * 5;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
            $uniqueName = uniqid('', true);
            //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
            $file = $uniqueName . "." . $extension;
            //$file = 5f586bf96dcd38.73540086.jpg

            move_uploaded_file($tmpName, './upload/' . $file);

            // Le fichier a bien été sauvé sur le serveur
            $this->setImage('./upload/' . $file);

            return true;
        }

        return false;
    }

    public function loadFromPost(): void
    {
        $this->setMarque($this->assainit($_POST['marque']));
        $this->setModele($this->assainit($_POST['modele']));
        $this->setCategorie($this->assainit($_POST['categorie']));
        $this->setAnnee($this->assainitFloat($_POST['annee']));
        $this->setBridee($this->assainit($_POST['bridee']));
        $this->setDescription($this->assainit($_POST['description']));
        $this->setPrix($this->assainitFloat($_POST['prix']));
        //$this->setProprietaire_id($this->assainit($_POST['proprietaire_id']));
    }

    public function save(): void
    {
        $query = "INSERT INTO moto
        (marque, modele, categorie, annee, bridee, image, description, prix, proprietaire_id )
        VALUES
        (:marque, :modele, :categorie, :annee, :bridee, :image, :description, :prix, :proprietaire_id)";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":marque" => $this->getMarque(),
            ":modele" => $this->getModele(),
            ":categorie" => $this->getCategorie(),
            ":annee" => $this->getAnnee(),
            ":bridee" => $this->getBridee(),
            ":image" => $this->getImage(),
            ":description" => $this->getDescription(),
            ":prix" => $this->getPrix(),
            ":proprietaire_id" => $this->getProprietaire_id()
        ]);
    }
    // Recuperé les annonces d'un propriétaire
    public static function proprietaireAnnonces($proprietaire_id)
    {
        $query = "SELECT * FROM moto WHERE proprietaire_id = :proprietaire_id";
        $stmt = Db::getDbh()->prepare($query);
        $stmt->bindParam(':proprietaire_id', $proprietaire_id, PDO::PARAM_INT);
        $stmt->execute();
        $annonces = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
        return $annonces;
    }


    // Supprimer une annonce d'un propriétaire
    public static function supprimerMoto($id)
    {

        $query = "DELETE FROM moto WHERE id = :id AND proprietaire_id = :proprietaire_id";
        $stmt = Db::getDbh()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        //suppression ne peux se faire que par le propriétaire de l'annonce
        $stmt->bindParam(':proprietaire_id', $_SESSION['ID'], PDO::PARAM_INT);
        $stmt->execute();
        $listeMoto = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
        return $listeMoto;
    }
}
