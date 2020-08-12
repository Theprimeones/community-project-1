<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class WelcomeController extends Controller
{
    public $PAGE_LOAD_MAX = 50;

    public function stats() {
        // get: params
        $user = Auth::user();

        // return: view
        return view('welcomes/stats', compact('user'));
    }
}
