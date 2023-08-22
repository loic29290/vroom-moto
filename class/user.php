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
    public function setAdmin(?int $admin): void {
        $this->admin = $admin;
    }
    public function getAdmin(): ?int {
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

        echo "test";

        if (empty($this->getNom())) {
            $error = true;
        }

        if (empty($this->getPassword())) {
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
    // Méthode pour récupérer tous les utilisateurs de la base de données
    public static function allUsers()
    {
        $query = "SELECT * FROM user";
        $sth = Db::getDbh()->prepare($query);
        $sth->execute([
            ":nom" => $this->getNom()
            ]);
}
return $users;
}
