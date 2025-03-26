<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Produto;

Route::Get('',function(){
    return view('index');
});