<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\produto;

Route::get('/', function(){
    return view('welcome');
});

Route::get('/', function () {
    $produtos = produto::all();
    return view('welcome', ['produtos' => $produtos]);
});

// Linha 8: defini que a variável $produtos interage com a model Produto para trazer todos os dados da tabela.
// Linha 9: retorna para a view os dados referente a tabela produtos definida na linha 9 quando chamada a variável $produtos.

Route::post('/cadastro_prod',function (Request $dados) {
    produto::create([
        'nome' => $dados-> nome,
        'category' => $dados-> category
    ]);

    echo "Cadastro realizado!";
});

// Delete
Route::delete('/produto/{id}', function ($id) {
    $produto = Produto::findOrFail($id);
    $produto->delete();

    return redirect('/')->with('status', 'Produto excluído com sucesso!');
});
