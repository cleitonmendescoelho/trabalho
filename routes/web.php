<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\produto;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/cadastro_prod',function (Request $dados) {
    produto::create([
        'nome' => $dados-> nome,
        'category' => $dados-> category
    ]);
    echo "Cadastro realizado!";
});
