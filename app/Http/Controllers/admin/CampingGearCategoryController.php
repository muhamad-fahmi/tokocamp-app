<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Campinggearcategory;
use App\Models\admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class CampingGearCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campinggearcats = Campinggearcategory::orderBy('id', 'desc')->get();
        return view('administrator.campinggearcat.index', compact('campinggearcats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('administrator.campinggearcat.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Campinggearcategory::create(
                    [
                        'user_id' => 1,
                        'category_id' => $request->category,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                    ]
                );

                $destinationPath = public_path('/images/subcategory/');
                $img = ImageInt::make($imagefile)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($imagefile)->width()/5;
                    $height = ImageInt::make($imagefile)->height()/5;
                }else{
                    $width = ImageInt::make($imagefile)->width()/2;
                    $height = ImageInt::make($imagefile)->height()/2;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.$filename);

                return redirect('/admin/system/campinggearcat')->with('success', 'Sub Category added successfull !');
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
        $campinggearcat = Campinggearcategory::where('id', $id)->first();
        return view('administrator.campinggearcat.edit', compact('campinggearcat'));
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
        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Campinggearcategory::find($id)->update(
                    [
                        'user_id' => 1,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                    ]
                );

                $campinggeardata = Campinggearcategory::where('id', $id)->first();
                if ($campinggeardata->image) {
                    if (file_exists(public_path() . '/images/subcategory/' . $campinggeardata->image)) {
                        unlink(public_path() . '/images/subcategory/' . $campinggeardata->image);
                    }
                }

                $destinationPath = public_path('/images/subcategory/');
                $img = ImageInt::make($imagefile)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($imagefile)->width()/5;
                    $height = ImageInt::make($imagefile)->height()/5;
                }else{
                    $width = ImageInt::make($imagefile)->width()/2;
                    $height = ImageInt::make($imagefile)->height()/2;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.$filename);

                return redirect('/admin/system/campinggearcat')->with('success', 'Sub Category updated successfull !');
            }else{
                return redirect()->with('error', 'Select image file !');
            }
        }else{
            Campinggearcategory::find($id)->update(
                [
                    'user_id' => 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' => Str::slug($request->name, '-'),
                ]
            );
            return redirect('/admin/system/campinggearcat')->with('success', 'Sub Category updated successfull !');
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
        $campinggeardata = Campinggearcategory::where('id', $id)->first();
        if ($campinggeardata->image) {
            if (file_exists(public_path() . '/images/subcategory/' . $campinggeardata->image)) {
                unlink(public_path() . '/images/subcategory/' . $campinggeardata->image);
            }
        }
        Campinggearcategory::find($id)->delete();
    }
}
