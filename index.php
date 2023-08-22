<?php

// Démarrer une session 
session_start();

// Inclure le fichier d'autoloader pour charger automatiquement les classes
require_once "autoloader.php";

// Appeler la méthode router pour gérer les requêtes 
Router::route();