<?php

namespace App\Http\Controllers;

use App\Http\Models\Services\DecretoPortariaService;
use Illuminate\Http\Request;
use App\Http\Models\Services\ParcelamentoService;
use App\Http\Models\Services\OcupacaoService;
use App\Http\Models\Services\UrbService;
use App\Http\Models\Services\EtapasService;
use App\Http\Models\Services\NormativoService;
use App\Http\Models\Services\DecisaoAmbientalService;
use App\Http\Models\Services\DiretrizUrbanisticaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParcelamentoController extends Controller
{


    public function buscaParcelamento($idParcelamento)
    {
        // Buscar dados do parcelamento
        $parcelamento = ParcelamentoService::buscarParcelamentoPorId($idParcelamento);
        $ocupacoes = OcupacaoService::buscarOcupacoesPorParcelamento($idParcelamento);
        $urbs = UrbService::buscarUrbsPorParcelamento($idParcelamento);
        $etapas = EtapasService::percorrerSituacaoEtapas($idParcelamento);

        // Buscar normativos
        $normativos = NormativoService::listarNormativoPorParcelamento($idParcelamento);

        // Verificar se os normativos existem, caso contrário, definir um array vazio
        if (empty($normativos)) {
            $normativos = [];
        }

        // Buscar decisão ambiental
        $decisaoAmbiental = DecisaoAmbientalService::listarDecisaoAmbientalPorParcelamento($idParcelamento);

        // Buscar decretos e portarias
        $decretoPortaria = DecretoPortariaService::listarDecretosPortariasPorParcelamento($idParcelamento);

        //Buscar diretriz Urbanistica
        $diretrizUrbanistica = DiretrizUrbanisticaService::listarDiretrizUrbanisticaPorParcelamento($idParcelamento);

        // Montar o array de resposta
        $arrParcelamentos['parcelamento_info'] = $parcelamento;
        $arrParcelamentos['ocupacoes'] = $ocupacoes;
        $arrParcelamentos['urbs'] = $urbs;
        $arrParcelamentos['etapas'] = $etapas;
        $arrParcelamentos['normativos'] = $normativos;  // Pode ser um array vazio se não houver normativos
        $arrParcelamentos['decretoPortaria'] = $decretoPortaria;
        $arrParcelamentos['decisaoAmbiental'] = $decisaoAmbiental;
        $arrParcelamentos['diretrizUrbanistica'] = $diretrizUrbanistica;

        // Retornar os dados como JSON
        echo json_encode($arrParcelamentos);
    }
}
