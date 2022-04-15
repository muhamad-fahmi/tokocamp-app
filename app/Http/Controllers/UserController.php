<?php

namespace App\Http\Controllers;

use App\Models\admin\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $categories = Category::orderBy('id', 'desc')->get();
        return view('user.index', compact('categories'));
    }
}
