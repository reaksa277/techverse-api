<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function view () {
        return view('Admin.Dashboard.index');
    }
}
