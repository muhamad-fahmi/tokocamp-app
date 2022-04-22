<?php

namespace App\Http\Controllers;

use App\Models\admin\Category;
use App\Models\admin\Package;
use App\Models\Campinggearcart;
use App\Models\Packagecart;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $categories = Category::where('status', '1')->get();
        $packages = Package::orderBy('id', 'desc')->get();
        return view('user.index', compact('categories', 'packages'));
    }

    public function cart(Request $request)
    {
        //1 = package
        //2 = logistic
        if ($request->type == '1') {
            //$package = package::where('id', $request->id)->first();
            // dd($request->qty);
            Packagecart::create(
                [
                    'package_id' => $request->id,
                    'user_id' => auth()->user()->id,
                    'total' => $request->qty,
                    'status' => '0'
                ]
            );
            return redirect()->back()->with('success', '1 Package added to your cart !');
        } elseif ($request->type == '2') {
            Campinggearcart::create([
                'logistic_id' => $request->id,
                'user_id' => auth()->user()->id,
                'total' => $request->qty,
                'status' => '0'
            ]);
            return redirect()->back()->with('success', '1 Logistic added to your cart !');
        } else {
            return redirect()->back()->with('error', 'type product is invalid !');
        }
    }
    public function mycart()
    {
        $categories = Category::where('status', '1')->get();
        // $blogs = Blog::orderBy('id', 'desc')->limit(3)->get();
        // $packages = Package::where('status', '1')->limit(4)->get();
        if (isset(auth()->user()->id)) {
            $packagecart = Packagecart::where('user_id', auth()->user()->id)->where('status', '0')->get();
            $campinggearcart = Campinggearcart::where('user_id', auth()->user()->id)->where('status', '0')->get();
            // $packageorder = Packagecart::where('user_id', auth()->user()->id)->where('status', '1')->get();
            // $logisticorder = Logisticcart::where('user_id', auth()->user()->id)->where('status', '1')->get();
        }
        $packagecart = Packagecart::where('user_id', '1')->where('status', '0')->get();
        $campinggearcart = Campinggearcart::where('user_id', '1')->where('status', '0')->get();

        if (isset(auth()->user()->id)) {
            return view('user.cart.index', compact('packagecart', 'categories', 'campinggearcart'));
        } else {
            return view('user.cart.index', compact('packagecart', 'categories', 'campinggearcart'));
        }
    }
}
