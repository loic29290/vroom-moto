<?php

class Renderer
{
    public static function render($vue, $data = [], $template = "vue/template.phtml")
    {
        // Initialise la variable $user à null.
        $user = null;
        // Vérifie si la clé 'ID' est définie dans la session.
        if (isset($_SESSION['ID'])) {
            $user = User::findUser();
        }

        require_once $template;
    }
}
