<?php

namespace App\Http\Controllers;

use App\Models\admin\Campinggear;
use App\Models\admin\Category;
use App\Models\admin\Package;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        $categories = Category::where('status', '1')->get();
        $packages = Package::orderBy('id', 'desc')->get();
        $campinggears = Campinggear::orderBy('id', 'desc')->get();

        return view('user.index', compact('categories', 'packages', 'campinggears'));
    }

    public function showpackage($slug){
        $categories = Category::where('status', '1')->get();
        $package = Package::where('slug', $slug)->first();
        $packages = Package::where('subcategory_id', $package->subcategory_id)->where('id', '<>', $package->id)->get();
        return view('user.packages.show', compact('package', 'categories', 'packages'));
    }

    public function showcampinggear($slug){
        $categories = Category::where('status', '1')->get();
        $campinggear = Campinggear::where('slug', $slug)->first();
        $campinggears = Campinggear::orderBy('id', 'desc')->where('id', '<>', $campinggear->id)->get();
        return view('user.campinggear.show', compact('campinggear', 'categories', 'campinggears'));
    }

    public function showbycategory($slug){

    }
}
