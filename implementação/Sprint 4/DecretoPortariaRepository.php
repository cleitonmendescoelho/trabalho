<?php

namespace App\Http\Models\Repository;

use Illuminate\Support\Facades\DB;

class DecretoPortariaRepository
{
    public static function criarDecretoPortaria($numero_publicacao, $id_parcelamento, $dataDecretoPortaria)
    {
        return DB::table('tb_decreto_portaria')->insertGetId(['id_parcelamento' => $id_parcelamento, 'numero_publicacao' => $numero_publicacao, 'data_decreto_portaria'=>$dataDecretoPortaria]);
    }

    public static function editarDecretoPortaria($numero_publicacao, $id_decreto_Portaria, $dataDecretoPortaria)
    {
        return DB::table('tb_decreto_portaria')->where('id_decreto_portaria', $id_decreto_Portaria)->update(['numero_publicacao' => $numero_publicacao, 'data_decreto_portaria'=>$dataDecretoPortaria]);
    }

    public static function excluirDecretoPortaria($id_decreto_Portaria)
    {
        return DB::table('tb_decreto_portaria')->where('id_decreto_portaria', $id_decreto_Portaria)->delete();
    }

    public static function buscarDecretoPortaria($id_decreto_Portaria)
    {
        return DB::table('tb_decreto_portaria')->where('id_decreto_portaria', $id_decreto_Portaria)->first();
    }

    public static function buscarTodosDecretoPortaria()
    {
        return DB::table('tb_decreto_portaria')->get();
    }

    public static function listarDecretosPortariasPorParcelamento($id_parcelamento)
    {
        return DB::table('tb_decreto_portaria')->where('id_parcelamento', $id_parcelamento)->get();
    }
}
