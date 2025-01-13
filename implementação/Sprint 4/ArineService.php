<?php

namespace App\Http\Models\Services;

use Illuminate\Http\Request;
use App\Http\Models\Services\EtapasService;
use App\Http\Models\Services\LogsService;
use App\Http\Models\Repository\ArineRepository;
use App\Http\Models\Repository\ParcelamentoRepository;
use App\Http\Models\Repository\OcupacaoRepository;
use App\Http\Models\Repository\ProcessoRepository;
use App\Http\Models\Repository\UrbRepository;
use App\Helpers\Helper;
use App\Http\Models\Repository\NormativoRepository;

class ArineService
{
    public static function detalhesArine($idArine)
    {

        $arine = ArineRepository::buscarArinePorId($idArine);
        $dadosParcelamentos = ParcelamentoRepository::buscarParcelamentosPorArine($idArine);
        // dd('toqui');
        $dadosArine = ['id_arine' => $arine[0]->id_arine, 'nome_arine' => $arine[0]->descricao, 'area_arine' => $arine[0]->area, 'check_pui' => $arine[0]->check_pui];


        foreach ($dadosParcelamentos as $k => $dadosParcelamento) {
            $listaOcupacoes = OcupacaoRepository::listarOcupacoesPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaNormativos = NormativoRepository::listarNormativoPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDecretos = DecretoPortariaService::listarDecretosPortariasPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDecisaoAmbiental = DecisaoAmbientalService::listarDecisaoAmbientalPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaDiretrizUrbanistica = DiretrizUrbanisticaService::listarDiretrizUrbanisticaPorParcelamento($dadosParcelamento->id_parcelamento);


            $listaUrb = UrbService::buscarUrbsPorParcelamento($dadosParcelamento->id_parcelamento);
            $listaEtapas = EtapasService::percorrerEtapas($dadosParcelamento->id_parcelamento);


            if ($dadosParcelamento->decreto == '0') {
                $dadosParcelamento->decreto = null;
            } else if ($dadosParcelamento->decreto == '1') {
                $dadosParcelamento->decreto = 'Válido';
            }

            if ($dadosParcelamento->conplan == '0') {
                $dadosParcelamento->conplan = 'Não';
            } else if ($dadosParcelamento->conplan == '1') {
                $dadosParcelamento->conplan = 'Sim';
            } else {
                $dadosParcelamento->conplan = null;
            }

            $dadosParcelamento->ocupacoes = $listaOcupacoes;
            $dadosParcelamento->normativos = $listaNormativos;
            $dadosParcelamento->decretos = $listaDecretos;
            $dadosParcelamento->decisoes_ambientais = $listaDecisaoAmbiental;
            $dadosParcelamento->diretrizUrbanistica = $listaDiretrizUrbanistica;


            $dadosParcelamento->lista_urb = $listaUrb;
            $dadosParcelamento->lista_etapas = $listaEtapas;

            $numeroProcesso = ProcessoRepository::buscarProcessoPorParcelamento($dadosParcelamento->id_parcelamento);

            // Verifica se a consulta retornou algum processo
            if (!empty($numeroProcesso) && isset($numeroProcesso[0]->descricao)) {
                // Se o array não estiver vazio e a descrição existir
                $dadosParcelamento->numero_processo = $numeroProcesso[0]->descricao;
            } else {
                // Caso contrário, atribui um valor padrão ou uma mensagem de erro
                $dadosParcelamento->numero_processo = 'Descrição não disponível';
            }


            $dadosParcelamento->msgCriacaoAlteracao = ArineService::_tratarMsgCriacaoAlteracao($dadosParcelamento->dt_criacao, $dadosParcelamento->dt_ultima_alteracao, $dadosParcelamento->responsavel_ultima_alteracao);

            $dadosArine['parcelamentos'][$k] = $dadosParcelamento;
        }


        return $dadosArine;
    }


}
