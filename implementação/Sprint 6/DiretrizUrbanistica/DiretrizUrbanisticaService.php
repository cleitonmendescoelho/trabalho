<?php

namespace App\Http\Models\Services;

use App\Http\Models\Repository\DiretrizUrbanisticaRepository;

class DiretrizUrbanisticaService
{
    public static function criarDiretrizUrbanistica($id_parcelamento, $descricao)
    {

        return DiretrizUrbanisticaRepository::criarDiretrizUrbanistica($id_parcelamento, $descricao);
    }

    public static function editarDiretrizUrbanistica($id_diretriz_urbanistica, $descricao)
    {

        return DiretrizUrbanisticaRepository::editarDiretrizUrbanistica($id_diretriz_urbanistica, $descricao);
    }

    public static function excluirDiretrizUrbanistica($id_diretriz_urbanistica)
    {

        return DiretrizUrbanisticaRepository::excluirDiretrizUrbanistica($id_diretriz_urbanistica);
    }

    public static function listarDiretrizUrbanisticaPorParcelamento($id_parcelamento)
    {

        return DiretrizUrbanisticaRepository::listarDiretrizUrbanisticaPorParcelamento($id_parcelamento);
    }
}
