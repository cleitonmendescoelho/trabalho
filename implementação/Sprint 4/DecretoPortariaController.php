<?php

namespace App\Http\Controllers;

use App\Http\Models\Services\DecretoPortariaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecretoPortariaController extends Controller
{
    public function editarDecretoPortaria(Request $request)
    {
        try {
            DecretoPortariaService::editarDecretoPortaria($request['numero_publicacao'], $request['id_decreto_portaria'], $request['data_decreto_portaria']);

            return  back()->withInput();
        } catch (\Throwable $th) {
            dd('deu erro');
        }
    }

    public function deletarDecretoPortaria($id_decretoPortaria)
    {
        try {
            DecretoPortariaService::excluirPortaria($id_decretoPortaria);

            return response()->json([
                'id_decretoPortaria' => $id_decretoPortaria,
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
