<?php

namespace App\Http\Models\Services;

use Illuminate\Http\Request;
use App\Http\Models\Services\EtapasService;
use App\Http\Models\Services\LogsService;
use App\Http\Models\Repository\ArisRepository;
use App\Http\Models\Repository\ParcelamentoRepository;
use App\Http\Models\Repository\OcupacaoRepository;
use App\Http\Models\Repository\ProcessoRepository;
use App\Http\Models\Repository\UrbRepository;
use App\Helpers\Helper;

class ArisService {

    public static function detalhesAris($idAris)
    {
        $aris = ArisRepository::buscarArisPorId($idAris);

        $dadosParcelamentos = ParcelamentoRepository::buscarParcelamentosPorAris($idAris);

        $dadosAris = ['id_aris' => $aris[0]->id_aris,'nome_aris' => $aris[0]->descricao,'area_aris' => $aris[0]->area,'check_pui' => $aris[0]->check_pui];

        foreach($dadosParcelamentos as $k => $dadosParcelamento){
            $listaOcupacoes = OcupacaoRepository::listarOcupacoesPorParcelamento($dadosParcelamento->id_parcelamento);
            $numeroProcesso = ProcessoRepository::buscarProcessoPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaUrb = UrbService::buscarUrbsPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaEtapas = EtapasService::percorrerEtapas($dadosParcelamento->id_parcelamento);
            $listaNormativos = NormativoService::listarNormativoPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDecretos = DecretoPortariaService::listarDecretosPortariasPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDecisaoAmbiental = DecisaoAmbientalService::listarDecisaoAmbientalPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDiretrizUrbanistica = DiretrizUrbanisticaService::listarDiretrizUrbanisticaPorParcelamento($dadosParcelamento->id_parcelamento);



            if($dadosParcelamento->decreto == '0'){
                $dadosParcelamento->decreto = null;
            }else if($dadosParcelamento->decreto == '1'){
                 $dadosParcelamento->decreto = 'Válido';
            }

            if($dadosParcelamento->conplan == '0'){
                $dadosParcelamento->conplan = 'Não';
            }else if($dadosParcelamento->conplan == '1'){
                 $dadosParcelamento->conplan = 'Sim';
            }else{
                $dadosParcelamento->conplan = null;
            }

            $dadosParcelamento->ocupacoes = $listaOcupacoes;
            $dadosParcelamento->numero_processo = $numeroProcesso[0]->descricao;
            $dadosParcelamento->lista_urb = $listaUrb;
            $dadosParcelamento->lista_etapas = $listaEtapas;
            $dadosParcelamento->msgCriacaoAlteracao = ArisService::_tratarMsgCriacaoAlteracao($dadosParcelamento->dt_criacao, $dadosParcelamento->dt_ultima_alteracao, $dadosParcelamento->responsavel_ultima_alteracao);
            $dadosParcelamento->normativos = $listaNormativos;
            $dadosParcelamento->decretos = $listaDecretos;
            $dadosParcelamento->decisoes_ambientais = $listaDecisaoAmbiental;
            $dadosParcelamento->diretrizUrbanistica = $listaDiretrizUrbanistica;

            $dadosAris['parcelamentos'][$k] = $dadosParcelamento;

        }

        return $dadosAris;
    }
}
