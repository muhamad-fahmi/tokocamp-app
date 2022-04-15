<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('administrator.index');
    }

    public function accounts(){
        $users = User::orderBy('id', 'desc')->paginate(15);
        return view('administrator.users.index', compact('users'));
    }
}
