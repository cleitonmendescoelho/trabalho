<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('welcome', ['produtos' => $produtos]);
    }
    public function store(Request $dados)
    {
        Produto::create([
            'nome' => $dados->nome,
            'category' => $dados->category
        ]);

        return redirect('/');
    }
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect('/');
    }
}
