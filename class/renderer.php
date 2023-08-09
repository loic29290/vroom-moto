<?php

class Renderer {
    public static function render($vue, $data = [], $template="vue/template.phtml") {
        require_once $template;
    }
}