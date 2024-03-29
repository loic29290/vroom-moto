<?php

class ReservationController
{
    // Méthode pour afficher les réservations liées à une moto
    public static function getReservations()
    {
        

        // Appel au modèle Location pour récupérer les réservations liées à l'utilisateur
        $reservations = Location::findReservation();

        // Afficher la vue des réservations de l'utilisateur
        Renderer::render("vue/mes_reservations.phtml", [
            "reservations" => $reservations
        ]);
    }

    // Méthode pour afficher les détails d'une réservation 
    public static function getReservation()
    {
        // Vérifier si l'ID de la réservation est défini dans l'URL
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            die;
        }

        // Récupérer la réservation par son ID
        $reservation = Location::findLocationById($_GET['id']);

        // Vérifier si la réservation existe
        if (!$reservation) {
            header("Location: index.php");
            die;
        }

        // Afficher la vue des détails de la réservation
        Renderer::render("vue/mes_motos.php", [
            "reservation" => $reservation
        ]);
    }
}
