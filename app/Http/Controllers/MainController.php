<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyRating;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function top_rated()
    {

        $data = Company::all();

        for ($x = 0; $x < sizeof($data); $x++) {
            $data[$x]['rating'] = CompanyRating::all()->where('company_id', $data[$x]['id'])->avg('rating');

        }
foreach ($data as $datas){
    if($datas->rating >= 2){
       return response()->json($datas);
    }
}


        return view('welcome', compact('data'));



    }
}
