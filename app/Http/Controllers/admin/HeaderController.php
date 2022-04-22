<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::orderBy('id', 'desc')->paginate(10);
        return view('administrator.headers.index', compact('headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.headers.create');
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
                'image' => 'required|min:5',
                'title' => 'required|min:5',
            ]
        );
        if ($request->file('image')) {
            $files = $request->file('image');

            $extentionnya = $files->getClientOriginalExtension();
            date_default_timezone_set("Asia/Bangkok");
            if ($extentionnya == 'jpg' || $extentionnya == 'jpeg' || $extentionnya == 'jpg' || $extentionnya == 'jpeg' || $extentionnya == 'png' | $extentionnya == 'webp' | $extentionnya == 'webp') {
                $filename =  Str::slug(strtolower($request->title), '-').'-header.webp';

                Header::create(
                    [
                        'user_id' => auth()->user()->id,
                        'image' => $filename,
                        'title' => $request->title,
                        'link' => $request->link ?? '0',
                        'status' => '1'
                    ]
                );


                $destinationPath = public_path('/images/headers');
                $img = ImageInt::make($files)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($files)->width()/6;
                    $height = ImageInt::make($files)->height()/6;
                }else{
                    $width = ImageInt::make($files)->width()/3;
                    $height = ImageInt::make($files)->height()/3;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);


                return redirect('/admin/system/headers')->with('success', 'Header Data Added Successful !');
            } else {
                return redirect()->back()->with('error', 'Please Select Image File !');
            }
        } else {
            return redirect()->back()->with('error', 'Please Select Image File !');
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
        $header = Header::where('id', $id)->first();
        return view('administrator.headers.edit', compact('header'));
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
                'title' => 'required|min:5',
            ]
        );
        if ($request->file('image')) {
            $files = $request->file('image');

            $extentionnya = $files->getClientOriginalExtension();
            date_default_timezone_set("Asia/Bangkok");
            if ($extentionnya == 'jpg' || $extentionnya == 'jpeg' || $extentionnya == 'png' | $extentionnya == 'webp') {
                $filename =  Str::slug(strtolower($request->title), '-').'-header.webp';

                //remove image before update
                $datadb = Header::where('id', $id)->first();
                $filedb = $datadb->image;
                if (file_exists(public_path() . '/images/headers/' . $filedb)) {
                    unlink(public_path() . '/images/headers/' . $filedb);
                }

                Header::find($id)->update(
                    [
                        'user_id' => auth()->user()->id,
                        'image' => $filename,
                        'title' => $request->title,
                        'link' => $request->link
                    ]
                );

                $destinationPath = public_path('/images/headers');
                $img = ImageInt::make($files)->encode('webp', 90);
                $width = 0;
                $height = 0;
                if($img->width() >= 500){
                    $width = ImageInt::make($files)->width()/6;
                    $height = ImageInt::make($files)->height()/6;
                }else{
                    $width = ImageInt::make($files)->width()/3;
                    $height = ImageInt::make($files)->height()/3;
                }

                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);


                return redirect('/admin/system/headers')->with('success', 'Header Data Updated Successful !');
            } else {
                return redirect()->back()->with('error', 'Please Select Png Image File !');
            }
        } else {

            Header::find($id)->update(
                [
                    'user_id' => auth()->user()->id,
                    'title' => $request->title,
                    'link' => $request->link,
                ]
            );

            return redirect('/admin/system/headers')->with('success', 'Header Data Updated Successful !');
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
        $data = Header::find($id)->first();
        $files = $data->image;
        if (file_exists(public_path() . '/images/headers/' . $files)) {
            unlink(public_path() . '/images/headers/' . $files);
        }

        Header::find($id)->delete();
    }
}
