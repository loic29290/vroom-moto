<?php

class MotoController {
    // Récupérer les motos 
    public static function getMotos() {
        // Appel au Modèle moto
        $motos = Moto::findAll(); // Chargement depuis la BDD
        
        // Affichage de la Vue Motos
        Renderer::render("vue/motos.php", [
            "motos" => $motos
        ]);
    }
        // Afficher une moto
    public static function getMoto() {
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            die;
        }
        
        $moto = Moto::findById($_GET['id']);
        
        if (!$moto) {
            header("Location: index.php");
            die;
        }
        
        Renderer::render("vue/moto.php", [
            "moto" => $moto
        ]);
    }
    
    public static function getFormulaire() {
        
          //Si pas conecté retour à la page connexion puis aprés connexion retour à la page formulaire
                if (!isset($_SESSION['ID'])){
                     header("Location: index.php?page=connexion&retour=formulaire_moto");
                die;
                }
        
        //Créer l'objet
        $moto = new Moto();
        
        if (isset($_POST['submit'])) {
            //Charger dans l'objet
            $moto->loadFromPost();
            //Vérifier la conformité des données POST
            if ($moto->checkPost()) {
                
                 // Ajout de la liaison utilisateur - propriétaire_id
                $id = $_SESSION['ID']; 
                $moto->setProprietaire_Id($id);
                
                //Enregistrer
                $moto->save();
                
                // si conexion ok retour à la page motos
                header("Location: index.php?page=motos");
                die;
            }
        }
        
        
        Renderer::render("vue/formulaire_moto.php", [
            "moto" => $moto
        ]);
    }
    
       // Afficher les motos d'un propriétaire
    public static function motoProprietaire() {
        
        if (!isset($_SESSION['ID'])) {
            header("Location: index.php?page=connexion&retour=mes_motos");
            die;
        }
        
        $mesMotos = Moto::proprietaireAnnonces($_SESSION['ID']);
        
        if (!$mesMotos) {
            header("Location: index.php");
            die;
        }
        
        Renderer::render("vue/mes_motos.phtml", [
            "motos" => $mesMotos
        ]);
    }
 
 
         // Supprimer une moto d'un propriétaire
    public static function motoDelete() {
        
        if (!isset($_SESSION['ID'])) {
            header("Location: index.php?page=connexion&retour=mes_motos");
            die;
        }
        
       
        
         if (isset($_POST['supprimerMoto'])) {
         // Obtenez l'ID de la moto à supprimer à partir des données du formulaire
        $motoID = $_POST['supprimerMoto'];
        
        
        // Supprimez la moto et obtenez les motos restantes
        $mesMotos = Moto::supprimerMoto( $motoID);
        
        // Rendez la vue mise à jour
        Renderer::render("vue/mes_motos.phtml", [
            "motos" => $mesMotos
        ]);
    }
 
    } 
}