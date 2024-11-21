<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {       
        // echo('hii');
        // exit;
        return view('web/index');        
    }
    public function post()
    {
        return view('web/post');
    }
    
}
