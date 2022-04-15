<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Blog;
use App\Models\admin\Blogcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(10);
        return view('administrator.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Blogcategory::orderBy('id', 'desc')->get();
        return view('administrator.blog.create', compact('categories'));
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
                'article' => 'required|min:5',
                'thumbnail' => 'required|max:2000'
            ]
        );
        if($request->file('thumbnail')){
            $imagefile = $request->file('thumbnail');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->title, '-').".webp";

                Blog::create(
                    [
                        'user_id' => 1,
                        'blogcategory_id' => $request->category,
                        'title' => $request->title,
                        'article' => $request->article,
                        'thumbnail' => $filename,
                        'slug' => Str::slug($request->title, '-')
                    ]
                );

                $destinationPath = public_path('/images/blog/');
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

                return redirect('/admin/system/blogs')->with('success', 'Blog added successfull !');
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
        $blog = Blog::where('id', $id)->first();
        return view('administrator.blog.edit', compact('blog'));
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
                'article' => 'required|min:5',
            ]
        );
        if($request->file('thumbnail')){
            $imagefile = $request->file('thumbnail');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->title, '-').".webp";

                Blog::find($id)->update(
                    [
                        'user_id' => 1,
                        'blogcategory_id' => $request->category,
                        'title' => $request->title,
                        'article' => $request->article,
                        'thumbnail' => $filename,
                        'slug' => Str::slug($request->title, '-')
                    ]
                );

                $blog = Blog::where('id', $id)->first();
                if ($blog->thumbnail) {
                    if (file_exists(public_path() . '/images/blog/' . $blog->thumbnail)) {
                        unlink(public_path() . '/images/blog/' . $blog->thumbnail);
                    }
                }

                $destinationPath = public_path('/images/blog/');
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

                return redirect('/admin/system/blogs')->with('success', 'Blog updated successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }else{
            Blog::find($id)->update(
                [
                    'user_id' => 1,
                    'blogcategory_id' => $request->category,
                    'title' => $request->title,
                    'article' => $request->article,
                    'slug' => Str::slug($request->title, '-')
                ]
            );
            return redirect('/admin/system/blogs')->with('success', 'Blog updated successfull !');
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
        $blog = Blog::where('id', $id)->first();
        if ($blog->thumbnail) {
            if (file_exists(public_path() . '/images/blog/' . $blog->thumbnail)) {
                unlink(public_path() . '/images/blog/' . $blog->thumbnail);
            }
        }
        Blog::find($id)->delete();
    }
}
