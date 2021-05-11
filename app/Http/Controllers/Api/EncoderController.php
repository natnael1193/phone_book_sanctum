<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class EncoderController extends Controller
{
    //
    public function index(){
        return view('encoder.index');
    }
}