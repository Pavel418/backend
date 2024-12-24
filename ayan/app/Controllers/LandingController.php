<?php

namespace App\Controllers;

use App\Core\View;

class LandingController {
    public function get() {
        $data = [];

        echo View::render('landing', $data);
    }
}
