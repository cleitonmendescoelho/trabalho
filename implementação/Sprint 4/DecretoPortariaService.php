<?php

namespace App\Http\Models\Services;

use App\Http\Models\Repository\DecretoPortariaRepository;

class DecretoPortariaService
{

    public static function criarDecretoPortaria($numero_publicacao, $id_parcelamento, $dataDecretoPortaria)
    {
        return DecretoPortariaRepository::criarDecretoPortaria($numero_publicacao, $id_parcelamento, $dataDecretoPortaria);
    }

    public static function editarDecretoPortaria($numero_publicacao, $id_decretoPortaria, $dataDecretoPortaria)
    {
        return DecretoPortariaRepository::editarDecretoPortaria($numero_publicacao, $id_decretoPortaria, $dataDecretoPortaria);
    }

    public static function excluirPortaria($id_decretoPortaria)
    {
        return DecretoPortariaRepository::excluirDecretoPortaria($id_decretoPortaria);
    }

    public static function buscarDecretoPortaria($id_decretoPortaria)
    {
        return DecretoPortariaRepository::buscarDecretoPortaria($id_decretoPortaria);
    }

    public static function buscarTodosDecretoPortaria()
    {
        return DecretoPortariaRepository::buscarTodosDecretoPortaria();
    }

    public static function listarDecretosPortariasPorParcelamento($id_parcelamento)
    {
        return DecretoPortariaRepository::listarDecretosPortariasPorParcelamento($id_parcelamento);
    }
}
