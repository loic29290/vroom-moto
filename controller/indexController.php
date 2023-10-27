<?php

class IndexController
{
    // Méthode pour afficher la page d'accueil
    public static function getIndex()
    {
        // Afficher la vue de la page d'accueil
        Renderer::render("vue/accueil.phtml");
    }

    // Méthode pour afficher la page du compte utilisateur
    public static function getCompte()
    {
       
        // Afficher la vue de la page du compte utilisateur
        Renderer::render("vue/mon_compte.phtml");
    }
}
