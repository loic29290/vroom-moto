<?php

class LocationController
{
    // Méthode pour gérer l'ajout d'une location
    public static function getLocation()
    {
        $error = false;
        $error_msg = [];
        
        

        // Vérifier si l'ID de la moto est défini dans l'URL
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            die;
        }

        // Créer un objet Location
        $location = new Location();

        // Récupération de la date du jour
        $dateJour = date("Y-m-d");

        // Vérifier si le formulaire de réservation a été soumis
        if (isset($_POST['submit'])) {
            // Charger les données POST dans l'objet Location
            $location->loadFromPost();

            // Vérifier la validité des données POST
            if ($location->checkPost()) {
                $error  = false;


                // Vérification de la date de réservation
                if ($location->getDebut() < $dateJour) {
                     $error_msg[] = "La date de réservation ne peut pas être antérieure à la date du jour.";
                     $error = true;
                }
                // Validation des dates
                if ($location->getDebut() >= $location->getFin()) {
                     $error_msg[] = "La date de début doit être antérieure à la date de fin.";
                     $error = true;
                }

                // Vérification si la moto est déjà réservée pour cette date
                $tableau_reservations = Location::findMotoReservations($_GET['id'], $location->getDebut(), $location->getFin());
                if (!empty($tableau_reservations)) {
                    $error_msg[] = "La moto est déjà réservée pour cette période.";
                $error = true;
                }

                if (!$error) {
                    // Ajout de la liaison utilisateur - locataire_id
                    $id = $_SESSION['ID'];
                    $location->setLocataireId($id);
    
                    // Ajout de la liaison moto
                    $location->setMotoId($_GET['id']);
    
                    // Enregistrer la réservation
                    $location->save();
    
                    // Redirection vers la page des motos
                    header("Location: index.php?page=motos");
                    die;
                }
            }
        }

        $locationMoto = Location::locationMoto($_GET['id']);

        // Afficher la vue de réservation avec l'objet Location
        Renderer::render("vue/reservation.phtml", [
            "locationMoto" => $locationMoto,
            "errors" => $error_msg,
        ]);
    }

    // Méthode pour afficher les locations effectuées par l'utilisateur
    public static function getMesLocations()
    {
        

        // Appel au modèle Location pour récupérer les locations de l'utilisateur
        $locations = Location::findLocation();

        // Afficher la vue des locations de l'utilisateur
        Renderer::render("vue/mes_locations.phtml", [
            "locations" => $locations
        ]);
    }  
    
    // Méthode pour afficher les locations effectuées par l'utilisateur
    public static function locationMoto()
    {
 

        // Appel au modèle Location pour récupérer les locations de l'utilisateur
        $locationMoto = Location::findReservation();

        // Afficher la vue des locations de l'utilisateur
        Renderer::render("vue/reservation.phtml", [
            "locationMoto" => $locationMoto
        ]);
    }

    // Méthode pour afficher les détails d'une location spécifique
    public static function getMaLocation()
    {
        // Vérifier si l'ID de la location est défini dans l'URL
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            die;
        }

        // Récupérer la location par son ID
        $maLocation = Location::findLocationById($_GET['id']);

        // Vérifier si la location existe
        if (!$maLocation) {
            header("Location: index.php");
            die;
        }

        // Afficher la vue des détails de la location
        Renderer::render("vue/mes_moto.phtml", [
            "location" => $maLocation
        ]);
    }
    
     // Afficher l'avis sur une location
    public static function locationAvis()
    {
        // Appeler le modèle auteurAvis pour afficher les avis liés à une moto
        $auteurAvis = User::avisName($_GET['id']);

        // Afficher le nom de l'auteur d'un avis
        Renderer::render("vue/moto.php", [
            "auteurAvis" => $auteurAvis
        ]);
    }
  // a revoir
  public function verifDateAction() {
   header('Content-Type: application/json');
   echo json_encode(Location::locationMoto($_GET['id']));
}

    
}
