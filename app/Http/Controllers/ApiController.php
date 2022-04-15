<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getcountries()
    {
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
        
        echo $response;
    }
    public function getstates(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->ciso.'/states',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        echo $response;
    }
    public function getcities(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$request->ciso.'/states/'.$request->siso.'/cities',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: akVWZFZwTnpMU1N0QzNNNkJHNndJNU9sTmRpWk1uZDlyOXZDTlU3aA=='
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        echo $response;
    }
}
