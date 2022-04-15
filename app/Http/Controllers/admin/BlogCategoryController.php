<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Blogcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Blogcategory::orderBy('id', 'desc')->paginate(10);
        return view('administrator.blog.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.blog.category.create');
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
                'title' => 'required|min:3|max:30',
                'description' => 'required|min:5|max:300',
                'image' => 'required|max:2000'
            ]
        );
        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->title, '-').".webp";

                Blogcategory::create(
                    [
                        'user_id' => 1,
                        'title' => $request->title,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->title, '-')
                    ]
                );

                $destinationPath = public_path('/images/blogcategory/');
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

                return redirect('/admin/system/blogcategory')->with('success', 'Blog Category added successfull !');
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
        $category = Blogcategory::where('id', $id)->first();
        return view('administrator.blog.category.edit', compact('category'));
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
                'title' => 'required|min:3|max:30',
                'description' => 'required|min:5|max:300',
            ]
        );
        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->title, '-').".webp";

                Blogcategory::find($id)->update(
                    [
                        'user_id' => 1,
                        'title' => $request->title,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->title, '-')
                    ]
                );

                $category = Blogcategory::where('id', $id)->first();
                if ($category->image) {
                    if (file_exists(public_path() . '/images/blogcategory/' . $category->image)) {
                        unlink(public_path() . '/images/blogcategory/' . $category->image);
                    }
                }

                $destinationPath = public_path('/images/blogcategory/');
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

                return redirect('/admin/system/blogcategory')->with('success', 'Blog Category updated successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }else{
            Blogcategory::find($id)->update(
                [
                    'user_id' => 1,
                    'title' => $request->title,
                    'description' => $request->description,
                    'slug' => Str::slug($request->title, '-')
                ]
            );
            return redirect('/admin/system/blogcategory')->with('success', 'Blog Category updated successfull !');
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
        $category = Blogcategory::where('id', $id)->first();
        if ($category->image) {
            if (file_exists(public_path() . '/images/blogcategory/' . $category->image)) {
                unlink(public_path() . '/images/blogcategory/' . $category->image);
            }
        }
        Blogcategory::find($id)->delete();
    }
}
