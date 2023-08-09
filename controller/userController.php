<?php

class UserController {
    public static function getInscription() {
        $user = new User();
        
        if (isset($_POST['subscribe'])) {
            $user->addUser();
            if ($user->testFormInscription($_POST['pwd2'])) {
                echo "Inscription réussie";
                $user->addUserOnDb();
                
                 header("Location: index.php?page=connexion");
            die;
                
            }
        }
        
        Renderer::render('vue/inscription.phtml',["user" => $user]);
    }
    
    public static function getConnexion() {
        $user = new User();

        if (isset($_POST['connexion'])) {
            $user->getPostDataLogin(); // charge les données de POST dans l'objet
            
            if ($user->testFormConnexion()) {
                echo "Connexion réussie";
                
                if (isset($_GET['retour'])) {
                    header("Location: index.php?page=".$_GET['retour']);
                } else {
                    header("Location: index.php?page=motos");
                }
                
                die;
            } else {
                echo " Login ou Mot de passe incorect ou inexistant";
                header("Location: index.php?page=connexion");
                die;
            }
        }
        
        Renderer::render('vue/connexion.phtml',["user" => $user]);
    }
    
     public static function getDisconnect() {
        $_SESSION['ID'] = null;
        unset($_SESSION['ID']);
        session_destroy();
        
        Renderer::render("vue/disconnect.phtml");
    }
}