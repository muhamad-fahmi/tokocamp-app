<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('administrator.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.category.create');
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
                'description' => 'required|max:300|min:5',
                'image' => 'required'
            ]
        );

        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Category::create(
                    [
                        'user_id' => 1,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'status' => 1
                    ]
                );

                $destinationPath = public_path('/images/category/');
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

                return redirect('/admin/system/category')->with('success', 'Category added successfull !');
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
        $category = Category::where('id', $id)->first();
        return view('administrator.category.edit', compact('category'));
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
                'description' => 'required|max:300|min:5'
            ]
        );
        $status = "";
        if($request->status == "1"){
            $status = "1";
        }else{
            $status = "0";
        }
        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Category::find($id)->update(
                    [
                        'user_id' => 1,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'status' => $status
                    ]
                );

                $category = Category::where('id', $id)->first();
                if ($category->image) {
                    if (file_exists(public_path() . '/images/category/' . $category->image)) {
                        unlink(public_path() . '/images/category/' . $category->image);
                    }
                }

                $destinationPath = public_path('/images/category/');
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

                return redirect('/admin/system/category')->with('success', 'Category updated successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }else{
            Category::find($id)->update(
                [
                    'user_id' => 1,
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' => Str::slug($request->name, '-'),
                    'status' => $status
                ]
            );
            return redirect('/admin/system/category')->with('success', 'Category updated successfull !');
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
        $category = Category::where('id', $id)->first();
        if ($category->image) {
            if (file_exists(public_path() . '/images/category/' . $category->image)) {
                unlink(public_path() . '/images/category/' . $category->image);
            }
        }
        Category::find($id)->delete();
    }
}
