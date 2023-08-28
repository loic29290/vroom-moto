<?php

class User
{
    private $id;
    private $nom;
    private $email;
    private $password;
    private $admin;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setAdmin(?int $admin): void
    {
        $this->admin = $admin;
    }
    public function getAdmin(): ?int
    {
        return $this->admin;
    }

    // Méthode pour ajouter les données utilisateur
    public function addUser()
    {
        $this->setNom($this->clearForm($_POST['nom']));
        $this->setPassword($this->clearForm($_POST['pwd']));
        $this->setEmail($this->clearForm($_POST['email']));
    }
    // Méthode pour obtenir les données de connexion
    public function getPostDataLogin()
    {
        $this->setNom($this->clearForm($_POST['nom']));
        $this->setPassword($this->clearForm($_POST['pwd']));
    }
    // Méthode pour nettoyer les valeurs des champs de formulaire
    public function clearForm($valeur)
    {
        if (isset($valeur)) {
            if (!empty($valeur)) {
                return $valeur;
            }
        }
        return;
    }

    //Vérifie que tout les champs du fomrulaire soit remplis
    public function testFormInscription($password2)
    {
        $error = false;

        if (empty($this->getNom())) {
            echo "Nom vide";
            $error = true;
        }
        if (empty($this->getEmail())) {
            echo "Email vide";
            $error = true;
        }

        if (empty($this->getPassword())) {
            echo " Mot de passe vide";
            $error = true;
        }

        if (strlen($this->getNom()) < 1) {
            echo " Le nom doit faire 4 caractères ou plus";
            $error = true;
        }

        if (strlen($this->getPassword()) < 1) {
            echo " Le mot de passe doit faire 4 caractères ou plus";
            $error = true;
        }

        if (!($this->getPassword() == $password2)) {
            echo " Les mots de passes de correspondent pas";
            $error = true;
        }

        if (!$error) {
            $query = "SELECT nom FROM user WHERE nom=:nom";
            $sth = Db::getDbh()->prepare($query);
            $sth->execute([
                ":nom" => $this->getNom()
            ]);

            if ($sth->rowCount() > 0) {
                echo "Erreur : Un nom similaire est déjà présent dans la base de données";
                $error = true;
            }
        }

        if ($error) {
            return false;
        }
        return true;
    }
    // Méthode pour valider le formulaire de connexion utilisateur
    public function testFormConnexion()
    {
        $error = false;


        if (empty($this->getNom())) {
            $error = true;
        }

        if (empty($this->getPassword())) {
            $error = true;
        }


        //Vérifier si un compte avec le nom d'utilisateur existe
        if (!$this->userExists()) {
            echo "Ce compte n'existe pas.";
            $error = true;
        }

        if (!$error) {
            $query = "SELECT id, password,admin FROM user WHERE nom=:nom";
            $sth = Db::getDbh()->prepare($query);
            $sth->execute([
                ":nom" => $this->getNom()
            ]);

            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if (password_verify($this->getPassword(), $row['password'])) {
                    $_SESSION['ID'] = $row['id'];
                    $_SESSION['ADMIN'] = $row['admin'];

                    return true;
                }
            }
        }
        return false;
    }
    // Ajouter les informations a la BDD
    public function addUserOnDb()
    {
        $query = "INSERT INTO user (nom, password, mail) VALUES (:nom, :password, :mail)";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":nom" => $this->getNom(),
            ":password" => password_hash($this->getPassword(), PASSWORD_DEFAULT),
            ":mail" => $this->getEmail()
        ]);
    }

    // Méthode pour vérifier si un compte avec le nom d'utilisateur existe
    public function userExists()
    {
        $query = "SELECT COUNT(*) as count FROM user WHERE nom=:nom";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":nom" => $this->getNom()
        ]);

        $row = $sth->fetch(PDO::FETCH_ASSOC);

        return ($row['count'] > 0); // Retourne true si au moins un compte existe
    }
    // Méthode pour récupérer tous les utilisateurs de la base de données
    public static function findUsers()
    {
        $query = "SELECT * FROM user";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
    }
    // Méthode pour récupérer un utilisateur de la base de données
    public static function findUser()
    {
        $query = "SELECT * FROM user WHERE id=:id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":id" => $_SESSION['ID']
        ]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
        return $sth->fetch();
    }
    
     // Méthode pour récupérer le nom d'un utilisateur par rapport à l'avis
      public static function avisName(int $location_id) : mixed
        
    {
        $query = "SELECT user.* FROM user, avis WHERE user.id = avis.auteur_id AND avis.location_id = :location_id";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":location_id" => $location_id,
        ]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "User");
        return $sth->fetch();
    }
   
    
}
