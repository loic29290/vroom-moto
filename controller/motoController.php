<?php

class MotoController
{
    // Méthode pour afficher la liste de toutes les motos
    public static function getMotos()
    {
        // Appel au modèle Moto pour récupérer toutes les motos depuis la base de données
        $motos = Moto::findAll();

        // Afficher la vue de la liste de motos avec les données récupérées
        Renderer::render("vue/motos.phtml", [
            "motos" => $motos
        ]);
    }

    // Méthode pour afficher les détails d'une moto 
    public static function getMoto()
    {
        // Vérifier si l'ID de la moto est défini dans l'URL
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            die;
        }

        // Récupérer la moto par son ID
        $moto = Moto::findById($_GET['id']);

        // Vérifier si la moto existe
        if (!$moto) {
            header("Location: index.php");
            die;
        }

        // Récupérer les avis liés à la moto
        $avis = Avis::getAvisByMotoLocation($moto->getId());

        // Afficher la vue des détails de la moto avec les données récupérées
        Renderer::render("vue/moto.phtml", [
            "moto" => $moto,
            "avis" => $avis
        ]);
    }

    // Méthode pour afficher le formulaire d'ajout de moto
    public static function getFormulaire()
    {
        

        // Créer un objet Moto
        $moto = new Moto();

        // Vérifier si le formulaire d'ajout de moto a été soumis
        if (isset($_POST['submit'])) {
            // Charger les données POST dans l'objet Moto
            $moto->loadFromPost();

            // Vérifier la validité des données POST
            if ($moto->checkPost()) {
                // Ajout de la liaison utilisateur - propriétaire_id
                $id = $_SESSION['ID'];
                $moto->setProprietaire_Id($id);

                // Enregistrer la moto dans la base de données
                $moto->save();

                // Redirection vers la page des motos
                header("Location: index.php?page=motos");
                die;
            }
        }

        // Afficher la vue du formulaire d'ajout de moto avec l'objet Moto
        Renderer::render("vue/formulaire_moto.phtml", ["moto" => $moto, "sauvegarde" => $_POST ]);
    }

    // Méthode pour afficher les motos d'un propriétaire spécifique
    public static function motoProprietaire()
    {
        

        // Appel au modèle Moto pour récupérer les motos du propriétaire actuellement connecté
        $mesMotos = Moto::proprietaireAnnonces($_SESSION['ID']);

        // Vérifier si le propriétaire a des annonces de moto
        if (!$mesMotos) {
            header("Location: index.php");
            die;
        }

        // Afficher la vue des motos du propriétaire avec les données récupérées
        Renderer::render("vue/mes_motos.phtml", [
            "motos" => $mesMotos
        ]);
    }
    
    // Ajax
    public static function searchAction() {
        // Récupérer les valeurs postées
        $categorie = !empty($_POST['categorieRecherche']) ? $_POST['categorieRecherche'] : null;
        $bridee = !empty($_POST['bridageRecherche']) ? $_POST['bridageRecherche'] : null;
    
        // Faire la recherche en utilisant les paramètres
        $resultats = Moto::searchByCategoryAndBridage($categorie, $bridee);
    
        // Charger la vue spécifique à l'AJAX et passer les résultats
        include 'vue/recherche.phtml';
    }
}
