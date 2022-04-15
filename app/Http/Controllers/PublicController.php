<?php

namespace App\Http\Controllers;

use App\Models\admin\Category;
use App\Models\admin\Package;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        $categories = Category::where('status', '1')->get();
        $packages = Package::orderBy('id', 'desc')->get();
        return view('user.index', compact('categories', 'packages'));
    }
}
