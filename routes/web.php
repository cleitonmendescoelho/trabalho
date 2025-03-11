<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\produto;

// Rota padrão
Route::get('/', function(){
    return view('welcome');
});

// Rota que cria os dados no BD
Route::post('/cadastro_prod',function (Request $dados) {
    produto::create([
        'nome' => $dados-> nome,
        'category' => $dados-> category
    ]);

    echo "Cadastro realizado!";
});

// Rota que acessa a model e exibi os dados na lista
Route::get('/', function () {
    $produtos = produto::all();  //defini que a variável $produtos interage com a model Produto para trazer todos os dados da tabela.
    return view('welcome', ['produtos' => $produtos]); //retorna para a view os dados referente a tabela produtos definida na linha 9 quando chamada a variável $produtos.
});

// Deletar
Route::delete('/produto/{id}', function ($id) {
    $produto = Produto::findOrFail($id);
    $produto->delete();

    return redirect('/')->with('status', 'Produto excluído com sucesso!');
});

// Editar

