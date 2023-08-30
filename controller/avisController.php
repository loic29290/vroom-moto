<?php

class AvisController
{
    // Méthode pour afficher le formulaire de soumission d'avis
    public static function getAvis()
    {
        // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
        if (!isset($_SESSION['ID'])) {
            // Permet le retour à la page de la moto sélectionnée après connexion
            $retour_string = urlencode("avis&id=" . $_GET['id']);
            header("Location: index.php?page=connexion&retour=$retour_string");
            die;
        }

        // Vérifier si le formulaire d'envoi d'avis a été soumis
        if (isset($_POST['envoyerAvis'])) {
            // Chercher la location liée à l'avis
            $location = Location::findLocationById($_GET['id']);

            if ($location->getLocataireId() != $_SESSION['ID']) {
                // On n'est pas le locataire
                header("Location: index.php?page=mes_reservations");
                die;
            }

            // Vérifier si l'utilisateur a réservé la moto pour laisser un avis
            $motoId = $location->getMotoId();
            $avis = Avis::getAvisByLocation($location->getId());

            if ($avis) {
                // Charger et mettre à jour l'avis existant au lieu d'en créer un nouveau
                $avis->loadFromPost();
                // Vérifier la validité des données POST
                if ($avis->checkPost()) {
                    $avis->envoyerAvis();

                    // Message de confirmation
                    echo "Avis modifié";

                    // Redirection vers la page des motos
                    header("Location: index.php?page=mes_reservations");
                    die;
                }
            } else {
                // Créer un nouvel avis
                $avis = new Avis();

                // Charger les données POST dans l'objet Avis
                $avis->loadFromPost();

                // Ajout de la liaison utilisateur - auteur_id
                $id = $_SESSION['ID'];
                $avis->setAuteurId($id);

                // Ajout de la liaison avis - location
                $avis->setLocationId($_GET['id']);

                // Vérifier la validité des données POST
                if ($avis->checkPost()) {
                    // Enregistrer l'avis
                    $avis->envoyerAvis();

                    // Message de confirmation
                    echo "Avis envoyé";

                    // Redirection vers la page des motos
                    header("Location: index.php?page=mes_reservations");
                    die;
                }
            }
        }
        // Afficher la vue d'envoi d'avis avec l'objet Avis
        Renderer::render("vue/avis.phtml");
    }

    // Afficher les avis d'une moto 
    public static function avisMoto()
    {
        // Appeler le modèle Avis pour afficher les avis liés à une moto
        $avisMoto = Avis::afficherAvis();

        // Afficher la vue des avis
        Renderer::render("vue/avis.php", [
            "avisMotos" => $avisMoto
        ]);
    }

    // Afficher les avis d'un utilisateur spécifique
    public static function avisUser()
    {
        // Appeler le modèle Avis pour afficher les avis d'un utilisateur
        $avisUser = Avis::findAvis();

        // Afficher la vue des avis
        Renderer::render("vue/avis.php", [
            "avisUsers" => $avisUser
        ]);
    }
    // Afficher les avis de tous utilisateur 
    public static function allAvis()
    {
        // Appeler le modèle Avis pour afficher les avis d'un utilisateur
        $allAvis = Avis::findAllAvis();

        // Afficher la vue des avis
        Renderer::render("vue/administrateur.php", [
            "allAvis" => $allAvis
        ]);
    }

    // Méthode pour supprimer un avis
    public static function supprimerAvis()
    {
        // Vérifier si le formulaire de suppression d'avis a été soumis
        if (isset($_POST['supprimerAvis'])) {
            // Obtenir l'ID de l'avis à supprimer depuis les données du formulaire
            $avisID = $_POST['supprimerAvis'];

            // Supprimer l'avis en appelant la méthode supprimerAvis() de la classe Avis
            Avis::supprimerAvis($avisID);
        }
    }
}
