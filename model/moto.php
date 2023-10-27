<?php



class Moto
{

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
        if (!$this->checkImageMoto()) {
            return false;
        }
        return true;
    }

    private function checkImageMoto(): mixed
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

        $extensions = ['jpg', 'png', 'jpeg', 'webp'];
        $maxSize = 1024 * 1024 * 5;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
            
            require_once("lib/Tinify/Exception.php");
            require_once("lib/Tinify/ResultMeta.php");
            require_once("lib/Tinify/Result.php");
            require_once("lib/Tinify/Source.php");
            require_once("lib/Tinify/Client.php");
            require_once("lib/Tinify.php");
            
            \Tinify\setKey("8t2xhbGcrfw33Tk8Wq9H6kWvgJG2K8Xj");
            
            
            $uniqueName = uniqid('', true);
            //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
            $file = $uniqueName . ".webp" ;
            //$file = 5f586bf96dcd38.73540086.jpg
            
            $source = \Tinify\fromFile($tmpName);
            $destination = $source->resize(["method" => "cover", "width" => 250, "height" => ceil(250 / (160 / 200))]);
            $destination = $destination->convert(["type" => "image/webp"]);
            $destination->toFile('./upload/' . $file);

            //move_uploaded_file($tmpName, './upload/' . $file);

            // Le fichier a bien été sauvé sur le serveur
            $this->setImage('./upload/' . $file);

            return true;
        }

        return false;
    }

    public function loadFromPost(): void
    {
        $this->setMarque(trim($_POST['marque']));
        $this->setModele(trim($_POST['modele']));
        $this->setCategorie(trim($_POST['categorie']));
        $this->setAnnee(floatval($_POST['annee']));
        $this->setBridee(trim($_POST['bridee']));
        $this->setDescription(trim($_POST['description']));
        $this->setPrix(floatval($_POST['prix']));
        //$this->setProprietaire_id(trim($_POST['proprietaire_id']));
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
    public static function proprietaireAnnonces(int $proprietaire_id): mixed
    {
        $query = "SELECT * FROM moto WHERE proprietaire_id = :proprietaire_id";
        $stmt = Db::getDbh()->prepare($query);
        $stmt->bindParam(':proprietaire_id', $proprietaire_id, PDO::PARAM_INT);
        $stmt->execute();
        $annonces = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
        return $annonces;
    }
    
    // pour ajax
    public static function searchByCategoryAndBridage(?string $categorie = null, ?string $bridee = null): array
    {
        if($categorie !== null && $bridee !== null) {
            $query = "SELECT * FROM moto WHERE categorie=:categorie AND bridee=:bridee";
            $sth = Db::getDbh()->prepare($query);
            $sth->bindParam(':categorie', $categorie, PDO::PARAM_STR);
            $sth->bindParam(':bridee', $bridee, PDO::PARAM_STR);
        }
        elseif($categorie !== null) {
            $query = "SELECT * FROM moto WHERE categorie=:categorie";
            $sth = Db::getDbh()->prepare($query);
            $sth->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        }
        elseif($bridee !== null) {
            $query = "SELECT * FROM moto WHERE bridee=:bridee";
            $sth = Db::getDbh()->prepare($query);
            $sth->bindParam(':bridee', $bridee, PDO::PARAM_STR);
        }
        else {
            $query = "SELECT * FROM moto";
            $sth = Db::getDbh()->prepare($query);
        }
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Moto");
    }
}
