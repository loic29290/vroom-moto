<?php

class Router {
    // Le rôle du routeur est d'appeler la bonne méthode du bon contrôleur
    public static function route(): void {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == "formulaire_moto") {
                MotoController::getFormulaire();
            }
            
             if ($_GET['page'] == "inscription") {
                UserController::getInscription();
            }
            
            
            if ($_GET['page'] == "connexion") {
                UserController::getConnexion();
            }
            
            if ($_GET['page'] == "motos") {
                MotoController::getMotos();
            }
            
            if ($_GET['page'] == "moto") {
                MotoController::getMoto();
            }
           
            if ($_GET['page'] == "mes_motos") {
               MotoController::motoProprietaire();
            }
            
            if ($_GET['page'] == "disconnect") {
                UserController::getDisconnect();
            }
            
            if ($_GET['page'] == "mes_motos") {
                MotoController::motoDelete();
            }
            if ($_GET['page'] == "accueil") {
                IndexController::getIndex();
            }
            if ($_GET['page'] == "moto") {
                AvisController::getAvis();
            }
            if ($_GET['page'] == "moto") {
                LocationController::getLocation();
            }
            
           
            
        } else {
            // Défaut
          MotoController::getMotos();
        }
    }
}