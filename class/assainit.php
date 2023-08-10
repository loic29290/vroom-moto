<?php

trait Assainit {
    public function assainit($val): string {
        return trim(strip_tags($val));
    }
    
    public function assainitFloat($val): float {
        return floatval($val);
    }
     public function assainitDate($val): date {
        return dateval($val);
    }
}
function assainit($post) {
    if (isset($_POST[$post])) {
        if (!empty($_POST[$post])) {
            return $_POST[$post];
        }
    }
    return "";
}