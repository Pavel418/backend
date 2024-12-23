<?php

namespace App\Core;

class View {
    public static function render($view, $data = []) {
        extract($data);
        
        ob_start();
        
        require "../app/Views/{$view}.php";
        
        return ob_get_clean();
    }
}
