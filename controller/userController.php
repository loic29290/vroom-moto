<?php

class UserController
{
    // Méthode pour gérer l'inscription d'un utilisateur
    public static function getInscription()
    {
        // Créer l'objet User
        $user = new User();

        // Vérifier si le formulaire d'inscription a été soumis
        if (isset($_POST['subscribe'])) {
            // Préparer les données de l'utilisateur
            $user->addUser();

            // Vérifier la validité du formulaire d'inscription
            if ($user->testFormInscription($_POST['pwd2'])) {
                echo "Inscription réussie";

                // Ajouter l'utilisateur à la base de données
                $user->addUserOnDb();

                // Rediriger vers la page de connexion
                header("Location: index.php?page=connexion");
                die; // Arrêter l'exécution du script
            }
        }

        // Afficher la vue d'inscription avec l'objet utilisateur
        Renderer::render('vue/inscription.phtml', ["user" => $user]);
    }

    // Méthode pour gérer la connexion de l'utilisateur
    public static function getConnexion()
    {
        // Créer l'objet User
        $user = new User();

        // Vérifier si le formulaire de connexion a été soumis
        if (isset($_POST['connexion'])) {
            // Charger les données POST dans l'objet User
            $user->getPostDataLogin();

            // Vérifier la validité du formulaire de connexion
            if ($user->testFormConnexion()) {
                echo "Connexion réussie";

                // Vérifier si une page de retour est spécifiée
                if (isset($_GET['retour'])) {
                    // Rediriger vers la page de retour
                    header("Location: index.php?page=" . urldecode($_GET['retour']));
                } else {
                    // Rediriger vers la page des motos
                    header("Location: index.php?page=motos");
                }

                die; // Arrêter l'exécution du script
            } else {

                //echo "Login ou Mot de passe incorrect ou inexistant";
               
                $errorMessage = "Login ou Mot de passe incorrect ou inexistant";
                echo "<script>alert('$errorMessage');</script>";
            
                // Rediriger vers la page de connexion en cas d'échec de connexion
                //header("Location: index.php?page=connexion");
                //die; // Arrêter l'exécution du script
            }
        }

        // Afficher la vue de connexion avec l'objet utilisateur
        Renderer::render('vue/connexion.phtml', ["user" => $user]);
    }

    // Méthode pour gérer la déconnexion de l'utilisateur
    public static function getDisconnect()
    {
        // Effacer les données de session liées à l'ID de l'utilisateur
        $_SESSION['ID'] = null;
        unset($_SESSION['ID']);
        unset($_SESSION['ADMIN']);
        session_destroy();

        // Redirection vers la page d'accueil après 3 secondes
        header("refresh:3;url=index.php");

        // Afficher la vue de déconnexion
        Renderer::render("vue/disconnect.phtml");
    }
    // Méthode pour vérifier si l'utilisateur est admin
    public static function getAdmin()
    {
        if (isset($_SESSION['ID']) && isset($_SESSION['ADMIN'])) {
            if ($_SESSION['ADMIN'] === 1) {

                $allUsers = User::findUsers();
                $motos =  Moto::findAll();
                $avis = Avis::allAvis();

                // L'utilisateur est un administrateur
                Renderer::render(
                    "vue/administrateur.phtml",
                    [
                        "allUsers" => $allUsers,
                        "motos" => $motos,
                        "avis" => $avis,
                    ]
                );
                return true;
            }
        }

        // L'utilisateur n'est pas un administrateur
        Renderer::render("vue/mes_motos.phtml");
        return false;
    }
}
