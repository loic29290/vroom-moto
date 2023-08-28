<?php

class Renderer
{
    public static function render($vue, $data = [], $template = "vue/template.phtml")
    {
        $user = null;
        if (isset($_SESSION['ID'])) {
            $user = User::findUser();
        }

        require_once $template;
    }
}
