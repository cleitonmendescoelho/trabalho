<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\produto;


Route::get('/',function(){
    return view('welcome');
});

//
