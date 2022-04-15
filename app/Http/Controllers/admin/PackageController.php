<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('id', 'desc')->paginate(10);
        return view('administrator.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $countries = json_decode($response);

        return view('administrator.packages.create', compact('categories', 'countries'));
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
                'name' => 'required',
                'include' => 'required',
                'minimal' => 'required',
                'price' => 'required',
                'description' => 'required',
                'images' => 'required',
                'category' => 'required',

            ]
        );
        if ($request->file('images')) {
            $files = $request->file('images');
            $x = 1;
            foreach ($files as $file) {
                $extentionnya = $file->getClientOriginalExtension();
                if ($extentionnya == 'jpg' && 'png' || 'jpeg') {

                    $filename = Str::slug($request->name, '-')."-".$x++.".webp";

                    $data[] = $filename;

                    $destinationPath = public_path('/images/packages/');
                    $img = ImageInt::make($file)->encode('webp', 90);
                    $width = 0;
                    $height = 0;
                    if($img->width() >= 500){
                        $width = ImageInt::make($file)->width()/8;
                        $height = ImageInt::make($file)->height()/8;
                    }else{
                        $width = ImageInt::make($file)->width()/5;
                        $height = ImageInt::make($file)->height()/5;
                    }

                    $img->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$filename);

                } else {
                    return redirect()->back()->with('error', 'Please Select Image File !');
                }
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country.'/states/'.$request->state.'/cities',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            echo $response;
            echo "<br><br>".$request->city;
            die();

            if (isset($data)) {
                Package::create(
                    [
                        'user_id' => 1,
                        'category_id' => $request->category,
                        'name' => $request->name,
                        'include' => $request->include,
                        'minimal' => $request->minimal,
                        'price' => $request->price,
                        'description' => $request->description,
                        'images' => json_encode($data),
                        'slug' => Str::slug($request->name, '-'),
                        'status' => '1',
                        'country' => $request->country,
                        'states' => $request->staes,
                        'city' => $request->city,
                        'area' => $request->area,
                    ]
                );


                return redirect('/admin/system/packages')->with('success', 'Package Data Added Successful !');
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
    {;
        $package = Package::where('id', $id)->first();
        return view('administrator.packages.edit', compact('package'));
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
                'name' => 'required',
                'include' => 'required',
                'minimal' => 'required',
                'price' => 'required',
                'description' => 'required',
            ]
        );
        if ($request->file('images')) {
            $files = $request->file('images');
            $x = 1;

            $data = Package::where('id', $id)->first();
            $file = json_decode($data->images);
            foreach($file as $fileloc){
                if (file_exists(public_path() . '/images/packages/' . $fileloc)) {
                    unlink(public_path() . '/images/packages/' . $fileloc);
                }
            }

            foreach ($files as $file) {
                $extentionnya = $file->getClientOriginalExtension();
                if ($extentionnya == 'jpg' && 'png' || 'jpeg') {
                    $filename = Str::slug($request->name, '-')."-".$x++.".webp";

                    $data[] = $filename;

                    $destinationPath = public_path('/images/packages/');
                    $img = ImageInt::make($file)->encode('webp', 90);
                    $width = 0;
                    $height = 0;
                    if($img->width() >= 500){
                        $width = ImageInt::make($file)->width()/8;
                        $height = ImageInt::make($file)->height()/8;
                    }else{
                        $width = ImageInt::make($file)->width()/5;
                        $height = ImageInt::make($file)->height()/5;
                    }

                    $img->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$filename);
                } else {
                    return redirect()->back()->with('delete', 'Please Select Image File !');
                }
            }

            if (isset($data)) {
                Package::find($id)->update(
                    [
                        'user_id' => 1,
                        'category_id' => $request->category,
                        'name' => $request->name,
                        'include' => $request->include,
                        'minimal' => $request->minimal,
                        'price' => $request->price,
                        'description' => $request->description,
                        'images' => json_encode($data),
                        'slug' => Str::slug($request->name, '-'),
                        'status' => '1'
                    ]
                );
                return redirect('/admin/system/packages')->with('success', 'Package Data Updated Successful !');
            }
        }else{
            Package::find($id)->update(
                [
                    'user_id' => 1,
                    'category_id' => $request->category,
                    'name' => $request->name,
                    'include' => $request->include,
                    'minimal' => $request->minimal,
                    'price' => $request->price,
                    'description' => $request->description,
                    'slug' => Str::slug($request->name, '-'),
                    'status' => '1'
                ]
            );
            return redirect('/admin/system/packages')->with('success', 'Package Data Updated Successful !');
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
        $data = Package::where('id', $id)->first();
        $files = json_decode($data->images);
        foreach($files as $file){
            if (file_exists(public_path() . '/images/packages/' . $file)) {
                unlink(public_path() . '/images/packages/' . $file);
            }
        }
        Package::find($id)->delete();
    }
}
