<?php

namespace App\Http\Models\Repository;

use Illuminate\Support\Facades\DB;

class DiretrizUrbanisticaRepository
{

    public static function criarDiretrizUrbanistica($id_parcelamento, $descricao)
    {

        return DB::table('tb_diretriz_urbanistica')->insertGetId(['id_parcelamento' => $id_parcelamento, 'descricao' => $descricao]);
    }

    public static function editarDiretrizUrbanistica($id_diretriz_urbanistica, $descricao)
    {

        return DB::table('tb_diretriz_urbanistica')->where('id_diretriz_urbanistica', $id_diretriz_urbanistica)->update([
            'descricao' => $descricao
        ]);
    }

    public static function excluirDiretrizUrbanistica($id_diretriz_urbanistica)
    {

        return DB::table('tb_diretriz_urbanistica')->where('id_diretriz_urbanistica', $id_diretriz_urbanistica)->delete();
    }

    public static function listarDiretrizUrbanisticaPorParcelamento($id_parcelamento)
    {

        return DB::table('tb_diretriz_urbanistica')->where('id_parcelamento', $id_parcelamento)->get();
    }
}
