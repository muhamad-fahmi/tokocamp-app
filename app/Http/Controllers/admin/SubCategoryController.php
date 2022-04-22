<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as ImageInt;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::orderBy('id', 'desc')->get();
        return view('administrator.subcategory.index', compact('subcategories'));
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
        return view('administrator.subcategory.create', compact('categories', 'countries'));
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
                'category' => 'required',
                'description' => 'required|max:300|min:5',
                'image' => 'required'
            ]
        );

        //country
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $country = json_decode($response);
        //states
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country.'/states/'.$request->states,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $state = json_decode($response);
        //city
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country.'/states/'.$request->states.'/cities',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $cities = json_decode($response);

        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Subcategory::create(
                    [
                        'user_id' => 1,
                        'category_id' => $request->category,
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'status' => 1,
                        'country' => $country->name,
                        'state' => $state->name,
                        'city' => $cities[$request->city]->name,
                        'area' => $request->area,
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

                return redirect('/admin/system/subcategory')->with('success', 'Sub Category added successfull !');
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
        $subcategory = Subcategory::where('id', $id)->first();
        return view('administrator.subcategory.edit', compact('subcategory'));

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

         //country
         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HTTPHEADER => array(
             'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
           ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $country = json_decode($response);
         //states
         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country.'/states/'.$request->states,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HTTPHEADER => array(
             'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
           ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $state = json_decode($response);
         //city
         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->country.'/states/'.$request->states.'/cities',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_HTTPHEADER => array(
             'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
           ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $cities = json_decode($response);

        if($request->file('image')){
            $imagefile = $request->file('image');
            $ext = $imagefile->getClientOriginalExtension();
            if($ext == "jpg" || $ext == "png" || $ext == "webp" || $ext == "jpeg"){
                $filename = Str::slug($request->name, '-').".webp";

                Subcategory::find($id)->update(
                    [
                        'user_id' => 1,
                        'name' => $request->name,
                        'category_id' => $request->category,
                        'description' => $request->description,
                        'image' => $filename,
                        'slug' => Str::slug($request->name, '-'),
                        'status' => $status,
                        'country' => $country->name,
                        'state' => $state->name,
                        'city' => $cities[$request->city]->name,
                        'area' => $request->area,
                    ]
                );

                $category = Category::where('id', $id)->first();
                if ($category->image) {
                    if (file_exists(public_path() . '/images/subcategory/' . $category->image)) {
                        unlink(public_path() . '/images/subcategory/' . $category->image);
                    }
                }

                $destinationPath = public_path('/images/subcategory/');
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

                return redirect('/admin/system/subcategory')->with('success', 'Sub Category updated successfull !');
            }else{
                return redirect()->back()->with('error', 'please select image file !');
            }
        }else{
            Subcategory::find($id)->update(
                [
                    'user_id' => 1,
                    'name' => $request->name,
                    'category_id' => $request->category,
                    'description' => $request->description,
                    'slug' => Str::slug($request->name, '-'),
                    'status' => $status,
                    'country' => $country->name,
                    'state' => $state->name,
                    'city' => $cities[$request->city]->name,
                    'area' => $request->area,
                ]
            );
            return redirect('/admin/system/subcategory')->with('success', 'Sub Category updated successfull !');
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
        $subcategory = Subcategory::where('id', $id)->first();
        if ($subcategory->image) {
            if (file_exists(public_path() . '/images/subcategory/' . $subcategory->image)) {
                unlink(public_path() . '/images/subcategory/' . $subcategory->image);
            }
        }
        Subcategory::find($id)->delete();
    }
}
