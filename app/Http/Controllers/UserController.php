<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function logout() {
        session()->forget('code');
        session()->forget('token');
        session()->forget('user');
        session()->forget('guilds');
        return redirect('/');
    }

    public function darkmode() {
        $darkmode = session()->get('darkmode');
        if ($darkmode) {
            session(['darkmode' => 0]);
        } else {
            session(['darkmode' => 1]);
        }
        return back();
    }
}

?>
