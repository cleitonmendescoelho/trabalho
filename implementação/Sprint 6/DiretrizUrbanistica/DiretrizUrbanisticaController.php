<?php

namespace App\Http\Controllers;

use App\Http\Models\Services\DiretrizUrbanisticaService;
use Illuminate\Http\Request;


class DiretrizUrbanisticaController extends Controller
{
    public function editarDiretrizUrbanistica(Request $request)
    {
        try {
            DiretrizUrbanisticaService::editarDiretrizUrbanistica($request['descricao'], $request['id_diretriz_urbanistica']);

            return  back()->withInput();
        } catch (\Throwable $th) {
            dd('deu erro');
        }
    }

    public function deletarDiretrizUrbanistica($id_diretriz_urbanistica)
    {
        try {
            DiretrizUrbanisticaService::excluirDiretrizUrbanistica($id_diretriz_urbanistica);

            return response()->json([
                'id_diretriz_urbanistica' => $id_diretriz_urbanistica,
                'status' => 200,
                'message' => 'Deletado com sucesso!!!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Erro ao deletar!!!',
            ]);
        }
    }
}
