<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function showLoginForm()
    {
        echo('hii');
        exit;
        return view('admin/pages/login');
    }
}
