<?php

namespace App\Controllers;

use App\Core\View;

class HomeController {
    public function index() {
        $data = [];

        echo View::render('home', $data);
    }
}
