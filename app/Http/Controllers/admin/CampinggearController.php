<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Campinggear;
use App\Models\admin\Campinggearcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class CampinggearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campinggears = Campinggear::orderBy('id', 'desc')->paginate(10);
        return view('administrator.campinggear.index', compact('campinggears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campinggearcats = Campinggearcategory::orderBy('id', 'desc')->get();
        return view('administrator.campinggear.create', compact('campinggearcats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:20|min:5',
                'image' => 'required',
                'price' => 'required|min:3|max:10',
                'stok' => 'required'
            ]
        );

        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Campinggear::create(
                    [
                        'user_id' => 1,
                        'campinggearcategory_id' => $request->category,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'stok' => $request->stok,
                        'price' => $request->price
                    ]
                );

                $destinationPath = public_path('/images/campinggear/');
                $img = ImageInt::make($imagefile)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($imagefile)->width()/8;
                    $height = ImageInt::make($imagefile)->height()/8;
                }else{
                    $width = ImageInt::make($imagefile)->width()/5;
                    $height = ImageInt::make($imagefile)->height()/5;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.$filename);

                return redirect('/admin/system/campinggear')->with('success', 'campinggear added successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campinggear = Campinggear::where('id', $id)->first();
        return view('administrator.campinggear.edit', compact('campinggear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:20|min:5',
                'price' => 'required|min:3|max:10',
                'stok' => 'required'
            ]
        );

        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Campinggear::find($id)->update(
                    [
                        'user_id' => 1,
                        'campinggearcategory_id' => $request->category,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'stok' => $request->stok,
                        'price' => $request->price
                    ]
                );

                $campinggear = Campinggear::where('id', $id)->first();
                if ($campinggear->image) {
                    if (file_exists(public_path() . '/images/campinggear/' . $campinggear->image)) {
                        unlink(public_path() . '/images/campinggear/' . $campinggear->image);
                    }
                }

                $destinationPath = public_path('/images/campinggear/');
                $img = ImageInt::make($imagefile)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($imagefile)->width()/8;
                    $height = ImageInt::make($imagefile)->height()/8;
                }else{
                    $width = ImageInt::make($imagefile)->width()/5;
                    $height = ImageInt::make($imagefile)->height()/5;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.$filename);

                return redirect('/admin/system/campinggear')->with('success', 'campinggear updated successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }else{
            Campinggear::find($id)->update(
                [
                    'user_id' => 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' => Str::slug($request->name, '-'),
                    'stok' => $request->stok,
                    'price' => $request->price
                ]
            );
            return redirect('/admin/system/campinggear')->with('success', 'campinggear updated successfull !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campinggear = Campinggear::where('id', $id)->first();
        if ($campinggear->image) {
            if (file_exists(public_path() . '/images/campinggear/' . $campinggear->image)) {
                unlink(public_path() . '/images/campinggear/' . $campinggear->image);
            }
        }
        Campinggear::find($id)->delete();
    }
}
