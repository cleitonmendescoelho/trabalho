<?php

namespace App\Http\Models\Services;

use Illuminate\Http\Request;
use App\Http\Models\Services\SetorHabitacionalService;
use App\Http\Models\Services\DecisaoPublicacaoService;
use App\Http\Models\Services\SituacaoDetalhamentoService;
use App\Http\Models\Services\NormativoService;
use App\Http\Models\Services\UrbService;
use App\Http\Models\Services\EtapasService;
use App\Http\Models\Services\LogsService;
use App\Http\Models\Repository\ParcelamentoRepository;
use App\Http\Models\Repository\ProcessoRepository;
use App\Http\Models\Repository\OcupacaoRepository;
use App\Http\Models\Repository\UrbRepository;
use App\Http\Models\Repository\NormativoRepository;
use App\Helpers\Helper;
use App\Helpers\Constante;
use Exception;
use PHPUnit\Util\Json;

class ParcelamentoService
{

    public static function cadastrarParcelamento($idAr, $dadosParcelamento)
    {
        $array = json_decode($dadosParcelamento['ocupacaoArray']);
        $nomeMapaOcupacao = ParcelamentoService::uploadMapaOcupacao($dadosParcelamento);

        $idRegiaoAdministrativa = $dadosParcelamento['regiao_administrativa'];
        $idSetorHabitacional = SetorHabitacionalService::verificaSetorHabitacional($dadosParcelamento['setor_habitacional']);
        $idSituacaoFundiaria = $dadosParcelamento['situacao_fundiaria'];
        $idResponsavelProjeto = $dadosParcelamento['responsavel_projeto'];
        $idDecisaoPublicacao = DecisaoPublicacaoService::verificaDecisaoPublicacao($dadosParcelamento['decisao_publicacao']);
        $idSituacao = $dadosParcelamento['situacao'];
        $idSituacaoDetalhamento = SituacaoDetalhamentoService::verificaSituacaoDetalhamento($dadosParcelamento['situacao_detalhamento']);
        $idClassificacaoRegularizacao = $dadosParcelamento['id_classificacao_regularizacao'];

        $arineAris = SELF::_verificaArineAris($idAr);

        $nomeParcelamento = $dadosParcelamento['nome_parcelamento'];
        $diretrizUrbanistica = $dadosParcelamento['diretriz_urbanistica'];
        $area = $dadosParcelamento['area'];
        $populacaoEstimada = $dadosParcelamento['populacao_estimada'];
        $habitacaoUnifamiliar = $dadosParcelamento['habitacao_unifamiliar'];
        $habitacaoColetiva = $dadosParcelamento['habitacao_coletiva'];
        $epcEpu = $dadosParcelamento['epc_epu'];
        $comercialServicosIndustrial = $dadosParcelamento['comercial_servicos_industrial'];
        $institucionalColetivo = $dadosParcelamento['institucional_coletivo'];
        $usoMisto = $dadosParcelamento['uso_misto'];
        $totalUnidadesImobiliarias = $dadosParcelamento['total_unidades_imobiliarias'];
        $conplan = $dadosParcelamento['conplan'];
        $numeroHabitacional = $dadosParcelamento['numero_habitacional'];
        $anoAtuacaoProcesso = $dadosParcelamento['ano_atuacao_processo'];
        $nProcessoTopografia = $dadosParcelamento['n_processo_topografia'];
        $nProcessoConsultas = $dadosParcelamento['n_processo_consultas'];
        $nProcessoLicenciamentoAmbiental = $dadosParcelamento['n_processo_licenciamento_ambiental'];
        $nProcessoReurb = $dadosParcelamento['n_processo_reurb'];
        $documentoReurb = $dadosParcelamento['documento_reurb'];
        $certidao_reg_fundiaria = $dadosParcelamento['certidao_reg_fundiaria'];
        $idModalidade = $dadosParcelamento['id_modalidade'];
        $nProcessoReurb = $dadosParcelamento['n_processo_reurb'];
        $documentoReurb = $dadosParcelamento['documento_reurb'];
        $certidao_reg_fundiaria = $dadosParcelamento['certidao_reg_fundiaria'];
        $registroCartorial = $dadosParcelamento['registro_cartorial'];
        $dataConplan = $dadosParcelamento['data_conplan'];

        $decreto = SELF::_verificaDecreto($dadosParcelamento);

        $numeroPublicacao = $dadosParcelamento['n_publicacao'];
        $idNaturezaPropriedade = $dadosParcelamento['natureza_propriedade'];

        $idParcelamento = ParcelamentoRepository::cadastrarParcelamento(
            $arineAris,
            $idRegiaoAdministrativa,
            $idSetorHabitacional,
            $idSituacaoFundiaria,
            $idResponsavelProjeto,
            $idDecisaoPublicacao,
            $idSituacao,
            $idSituacaoDetalhamento,
            $nomeParcelamento,
            $diretrizUrbanistica,
            $area,
            $populacaoEstimada,
            $habitacaoUnifamiliar,
            $habitacaoColetiva,
            $epcEpu,
            $comercialServicosIndustrial,
            $institucionalColetivo,
            $usoMisto,
            $totalUnidadesImobiliarias,
            $conplan,
            $numeroHabitacional,
            $decreto,
            $numeroPublicacao,
            $idNaturezaPropriedade,
            $nomeMapaOcupacao,
            $anoAtuacaoProcesso,
            $nProcessoTopografia,
            $nProcessoConsultas,
            $nProcessoLicenciamentoAmbiental,
            $nProcessoReurb,
            $documentoReurb,
            $certidao_reg_fundiaria,
            $idClassificacaoRegularizacao,
            $idModalidade,
            $registroCartorial,
            $dataConplan
        );

        $processo = $dadosParcelamento['processo'];

        ProcessoRepository::cadastrarProcesso($idParcelamento, $processo);

        $arrayNormativos = json_decode($dadosParcelamento['normativoArray'], true);
        if (!empty($arrayNormativos)) {
            foreach ($arrayNormativos as $descricao) {
                NormativoService::criarNormativo($idParcelamento, $descricao);
            }
        }

        $arrayDecretoPortaria = json_decode($dadosParcelamento['decretoPortariaArray'], true);
        if (!empty($arrayDecretoPortaria)) {
            foreach ($arrayDecretoPortaria as $numero_publicacao) {
                DecretoPortariaService::criarDecretoPortaria($numero_publicacao, $idParcelamento);
            }
        }

        $arrayDecisaoAmbiental = json_decode($dadosParcelamento['decisaoAmbientalArray'], true);

        if (!empty($arrayDecisaoAmbiental)) {
            foreach ($arrayDecisaoAmbiental as $decisaoAmbiental) {
                // Agora, $decisao['descricao'] e $decisao['data'] têm os valores de descrição e data
                $descricao = $decisaoAmbiental['descricao'];
                $data = $decisaoAmbiental['data'];

                // Chama o método para salvar a decisão ambiental
                DecisaoAmbientalService::criarDecisaoAmbiental($idParcelamento, $descricao, $data);
            }
        }

        $arrayDiretrizUrbanistica = json_decode($dadosParcelamento['diretrizUrbanisticaArray'], true);


        if (!empty($arrayDiretrizUrbanistica)) {

            foreach ($arrayDiretrizUrbanistica as $diretrizUrbanistica) {

                $descricao = $diretrizUrbanistica['descricao'];

                DiretrizUrbanisticaService::criarDiretrizUrbanistica($idParcelamento, $descricao);
            }
        }

        OcupacaoRepository::cadastrarOcupacao($idParcelamento, $array);
        EtapasService::verificaEtapas($dadosParcelamento, $idParcelamento);
        EtapasService::verificaEtapas($dadosParcelamento, $idParcelamento);
        LogsService::cadastroParcelamento($nomeParcelamento);
        UrbService::verificaUrb($dadosParcelamento, $idParcelamento);
    }

   

    public static function buscarDadosParcelamentoPorId($dadosAr)
    {
        $dadosArAux = explode('|', $dadosAr);
        $valorAr = $dadosArAux['0'];
        $idParcelamento = $dadosArAux['1'];

        $dadosParcelamento = ParcelamentoRepository::buscarDadosParcelamentoPorId($valorAr, $idParcelamento)[0];
        $dadosParcelamento = ParcelamentoService::trataParcelamentoArineAris($dadosParcelamento);
        $listaOcupacoes = OcupacaoRepository::listarOcupacoesPorParcelamento($idParcelamento);
        $numeroProcesso = ProcessoRepository::buscarProcessoPorParcelamento($idParcelamento);
        $listaUrb = UrbService::buscarUrbsPorParcelamento($idParcelamento);
        $listaEtapas = EtapasService::percorrerIdsEtapas($idParcelamento);
        $listarNormativos = NormativoService::listarNormativoPorParcelamento($idParcelamento);
        $listarDecisaoAmbiental = DecisaoAmbientalService::listarDecisaoAmbientalPorParcelamento($idParcelamento);

        $dadosParcelamento->ocupacoes = $listaOcupacoes;
        $dadosParcelamento->numero_processo = $numeroProcesso[0]->descricao;
        $dadosParcelamento->lista_urb = $listaUrb;
        $dadosParcelamento->lista_etapas = $listaEtapas;
        $dadosParcelamento->normativos = $listarNormativos;
        $dadosParcelamento->decisoes_ambientais = $listarDecisaoAmbiental;

        //Isso é novo
        $listaDecretoPortaria = DecretoPortariaService::listarDecretosPortariasPorParcelamento($idParcelamento);
        //Isso é novo
        $dadosParcelamento->decretoPortarias = $listaDecretoPortaria;

        $listaDiretrizUrbanistica = DiretrizUrbanisticaService::listarDiretrizUrbanisticaPorParcelamento($idParcelamento);
        $dadosParcelamento->diretriz_urbanistica = $listaDiretrizUrbanistica;

        return $dadosParcelamento;
    }

    public static function editarParcelamento($dadosParcelamento)
    {

        $idParcelamento = $dadosParcelamento['id_parcelamento'];

        $arrayNormativos = json_decode($dadosParcelamento['normativoArray'], true);
        if (!empty($arrayNormativos)) {
            foreach ($arrayNormativos as $descricao) {
                NormativoService::criarNormativo($idParcelamento, $descricao);
            }
        }

        $arrayDecretoPortaria = json_decode($dadosParcelamento['decretoPortariaArray'], true);
        if (!empty($arrayDecretoPortaria)) {
            foreach ($arrayDecretoPortaria as $numero_publicacao) {
                DecretoPortariaService::criarDecretoPortaria($numero_publicacao, $dadosParcelamento['id_parcelamento']);
            }
        }

        $arrayDiretrizUrbanistica = json_decode($dadosParcelamento['diretrizUrbanisticaArray'], true);

        if (!empty($arrayDiretrizUrbanistica)) {

            foreach ($arrayDiretrizUrbanistica as $diretrizUrbanistica) {

                $descricao = $diretrizUrbanistica['descricao'];

                DiretrizUrbanisticaService::criarDiretrizUrbanistica($dadosParcelamento['id_parcelamento'], $descricao);
            }
        }


        $arrayDecisaoAmbiental = json_decode($dadosParcelamento['decisaoAmbientalArray'], true);

        // dd($arrayDecisaoAmbiental);

        if (!empty($arrayDecisaoAmbiental)) {
            foreach ($arrayDecisaoAmbiental as $decisaoAmbiental) {
                // dd($decisaoAmbiental);
                // Agora, $decisao['descricao'] e $decisao['data'] têm os valores de descrição e data
                $descricao = $decisaoAmbiental['descricao'];
                $data = $decisaoAmbiental['data'];

                // Chama o método para salvar a decisão ambiental
                DecisaoAmbientalService::criarDecisaoAmbiental($idParcelamento, $descricao, $data);
            }
        }


        $array = json_decode($dadosParcelamento['ocupacaoArray']);

        $nomeMapaOcupacao = ParcelamentoService::uploadMapaOcupacao($dadosParcelamento);

        $idRegiaoAdministrativa = $dadosParcelamento['regiao_administrativa'];
        $idSetorHabitacional = SetorHabitacionalService::verificaSetorHabitacional($dadosParcelamento['setor_habitacional']);
        $idSituacaoFundiaria = $dadosParcelamento['situacao_fundiaria'];
        $idResponsavelProjeto = $dadosParcelamento['responsavel_projeto'];
        $idDecisaoPublicacao = DecisaoPublicacaoService::verificaDecisaoPublicacao($dadosParcelamento['decisao_publicacao']);
        $idSituacao = $dadosParcelamento['situacao'];
        $idSituacaoDetalhamento = SituacaoDetalhamentoService::verificaSituacaoDetalhamento($dadosParcelamento['situacao_detalhamento']);
        $idClassificacaoRegularizacao = $dadosParcelamento['id_classificacao_regularizacao'];
        $idParcelamento = $dadosParcelamento['id_parcelamento'];
        $nomeParcelamento = $dadosParcelamento['nome_parcelamento'];
        $diretrizUrbanistica = $dadosParcelamento['diretriz_urbanistica'];
        $area = $dadosParcelamento['area'];
        $populacaoEstimada = $dadosParcelamento['populacao_estimada'];
        $habitacaoUnifamiliar = $dadosParcelamento['habitacao_unifamiliar'];
        $habitacaoColetiva = $dadosParcelamento['habitacao_coletiva'];
        $epcEpu = $dadosParcelamento['epc_epu'];
        $comercialServicosIndustrial = $dadosParcelamento['comercial_servicos_industrial'];
        $institucionalColetivo = $dadosParcelamento['institucional_coletivo'];
        $usoMisto = $dadosParcelamento['uso_misto'];
        $totalUnidadesImobiliarias = $dadosParcelamento['total_unidades_imobiliarias'];
        $conplan = $dadosParcelamento['conplan'];
        $numeroHabitacional = $dadosParcelamento['numero_habitacional'];
        $anoAtuacaoProcesso = $dadosParcelamento['ano_atuacao_processo'];
        $nProcessoTopografia = $dadosParcelamento['n_processo_topografia'];
        $nProcessoConsultas = $dadosParcelamento['n_processo_consultas'];
        $nProcessoLicenciamentoAmbiental = $dadosParcelamento['n_processo_licenciamento_ambiental'];
        $nProcessoReurb = $dadosParcelamento['n_processo_reurb'];
        $documentoReurb = $dadosParcelamento['documento_reurb'];
        $certidao_reg_fundiaria = $dadosParcelamento['certidao_reg_fundiaria'];
        $idNaturezaPropriedade = $dadosParcelamento['natureza_propriedade'];
        $idModalidade = $dadosParcelamento["id_modalidade"];
        $justificativa = $dadosParcelamento['justificativa'];
        $registroCartorial = $dadosParcelamento['registro_cartorial'];
        $dataConplan = $dadosParcelamento['data_conplan'];

        ParcelamentoRepository::editarParcelamento(
            $idParcelamento,
            $idRegiaoAdministrativa,
            $idSetorHabitacional,
            $idSituacaoFundiaria,
            $idResponsavelProjeto,
            $idDecisaoPublicacao,
            $idSituacao,
            $idSituacaoDetalhamento,
            $nomeParcelamento,
            $diretrizUrbanistica,
            $area,
            $populacaoEstimada,
            $habitacaoUnifamiliar,
            $habitacaoColetiva,
            $epcEpu,
            $comercialServicosIndustrial,
            $institucionalColetivo,
            $usoMisto,
            $totalUnidadesImobiliarias,
            $conplan,
            $numeroHabitacional,
            $idNaturezaPropriedade,
            $anoAtuacaoProcesso,
            $nProcessoTopografia,
            $nProcessoConsultas,
            $nProcessoLicenciamentoAmbiental,
            $nProcessoReurb,
            $documentoReurb,
            $certidao_reg_fundiaria,
            $idClassificacaoRegularizacao,
            $idModalidade,
            $justificativa,
            $registroCartorial,
            $dataConplan
        );

        $processo = $dadosParcelamento['processo'];

        ProcessoRepository::editarProcesso($idParcelamento, $processo);

        OcupacaoService::editarOcupacao($idParcelamento, $array);

        if ((isset($nomeMapaOcupacao)) && ($nomeMapaOcupacao != false)) {
            OcupacaoRepository::setarNomeMapaOcupacao($idParcelamento, $nomeMapaOcupacao);
        }

        UrbService::verificaUrb($dadosParcelamento, $idParcelamento);

        EtapasService::verificaEtapas($dadosParcelamento, $idParcelamento);
        LogsService::edicaoParcelamento($nomeParcelamento);
    }

    
}
