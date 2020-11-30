<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class RandomController extends Controller
{

    public function randomInteger() {
        return response()->json(['status_code' => 200, 'data' => random_int(1, 99)]);
    }

}