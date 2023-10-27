<?php

class Router
{
    // Le rôle du routeur est d'appeler la bonne méthode du bon contrôleur
    public static function route(): void
    {
        if (isset($_GET['page'])) {

            if ($_GET['page'] == "accueil") {
                IndexController::getIndex();
            }

            if ($_GET['page'] == "motos") {
                MotoController::getMotos();
            }

            if ($_GET['page'] == "moto") {
                MotoController::getMoto();
            }

            if ($_GET['page'] == "inscription") {
                UserController::getInscription();
            }

            if ($_GET['page'] == "connexion") {
                UserController::getConnexion();
            }
// ajax
            if ($_GET['page'] == "searchAction") {
                MotoController::searchAction();
            }


            if ($_GET['page'] == "mon_compte") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {

                    header("Location: index.php?page=connexion&retour=mon_compte");
                    die;
                }
                IndexController::getCompte();
            }

            if ($_GET['page'] == "disconnect") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {

                    header("Location: index.php?page=connexion");
                    die;
                }

                UserController::getDisconnect();
            }

            if ($_GET['page'] == "formulaire_moto") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    header("Location: index.php?page=connexion&retour=formulaire_moto");
                    die;
                }

                MotoController::getFormulaire();
            }

            if ($_GET['page'] == "mes_motos") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    header("Location: index.php?page=connexion&retour=mes_motos");
                    die;
                }
                MotoController::motoProprietaire();
            }

            if ($_GET['page'] == "mes_reservations") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    header("Location: index.php?page=connexion&retour=mes_reservations");
                    die;
                }
                ReservationController::getReservations();
            }

            if ($_GET['page'] == "mes_locations") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    header("Location: index.php?page=connexion&retour=mes_locations");
                    die;
                }

                LocationController::getMesLocations();
            }

            if ($_GET['page'] == "reservation") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    // Permet le retour à la page de la moto sélectionnée après connexion
                    $retour_string = urlencode("moto&id=" . $_GET['id']);
                    header("Location: index.php?page=connexion&retour=$retour_string");
                    die;
                }


                LocationController::getLocation();
            }

            // pour ajax
            if ($_GET['page'] == "verifDateAction") {
                LocationController::verifDateAction();
            }


            if ($_GET['page'] == "avis") {
                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    // Permet le retour à la page de la moto sélectionnée après connexion
                    $retour_string = urlencode("avis&id=" . $_GET['id']);
                    header("Location: index.php?page=connexion&retour=$retour_string");
                    die;
                }

                AvisController::getAvis();
            }

            if ($_GET['page'] == "avisMotos") {

                // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
                if (!isset($_SESSION['ID'])) {
                    // Permet le retour à la page de la moto sélectionnée après connexion
                    $retour_string = urlencode("avis&id=" . $_GET['id']);
                    header("Location: index.php?page=connexion&retour=$retour_string");
                    die;
                }

                AvisController::avisMoto();
            }


            if ($_GET['page'] == "administrateur") {
                //si tu n'est pas admin  
                if (!(isset($_SESSION['ID']) && isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === 1)) {
                    header("Location: index.php?page=connexion");
                    die;
                }
                UserController::getAdmin();
            }

            if ($_GET['page'] == "administrateur") {
                //si tu n'est pas admin  
                if (!(isset($_SESSION['ID']) && isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === 1)) {
                    header("Location: index.php?page=connexion");
                    die;
                }
                AvisController::supprimerAvis();
            }
        } else {
            // Défaut
            IndexController::getIndex();
        }
    }
}
