<?php

namespace App\Http\Controllers;

use App\Models\admin\Campinggear;
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
        $campinggears = Campinggear::orderBy('id', 'desc')->get();
        return view('user.index', compact('categories', 'packages', 'campinggears'));
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
        if (isset(auth()->user()->id)) {
            $packagecart = Packagecart::where('user_id', auth()->user()->id)->where('status', '0')->get();
            $campinggearcart = Campinggearcart::where('user_id', auth()->user()->id)->where('status', '0')->get();
        }

        if (isset(auth()->user()->id)) {
            return view('user.cart.index', compact('packagecart', 'categories', 'campinggearcart'));
        } else {
            return view('user.cart.index', compact('packagecart', 'categories', 'campinggearcart'));
        }
    }

    public function checkout(Request $request)
    {
        //status 0 = items in cart
        //status 1 = items in checkout page
        //status 2 = items in order
        if (isset($request->packages)) {
            foreach ($request->packages as $package) {
                Packagecart::find($package->id)->update(
                    [
                        'status' => '1',
                        'bookdate' => $request->bookdate
                    ]
                );
            }
        }
        if (isset($request->logistics)) {
            foreach ($request->logistics as $logistic) {
                Campinggearcart::find($logistic->id)->update(
                    [
                        'status' => '1',
                        'bookdate' => $request->bookdate
                    ]
                );
            }
        }
        $pCart = Packagecart::where('user_id', auth()->user()->id)->where('status', '1')->get();
        $cCart = Campinggearcart::where('user_id', auth()->user()->id)->where('status', '1')->get();

        // Mail::to(auth()->user()->email)->send(new Checkout($pCart, $lCart, auth()->user()->name));
        // Mail::to("tokocamp.indonesia@gmail.com")->send(new IncomingOrder($pCart, $lCart, auth()->user()->name, auth()->user()->email));
        return redirect('/order')->with('success', 'Your items has been moved to order page ! please make payment to continue your order !');
    }

    public function pcartdel(Request $request, $id){
        Packagecart::find($id)->delete();
        return redirect()->back()->with('warning', '1 item has been deleted from your cart !');
    }
}
