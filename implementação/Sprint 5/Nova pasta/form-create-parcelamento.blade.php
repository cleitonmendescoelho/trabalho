<form action="{{ route('cadastrar-parcelamento-' . $tipoAr . '') }}" method="POST" class="form-horizontal"
    enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $nomeAr }}" name="nome_ar">
    <input type="hidden" value="{{ $checkPui }}" name="check_pui">
    <input type="hidden" value="{{ $areaAr }}" name="area_ar">
    <input type="hidden" value="{{ $checkNucleoUrbano }}" name="check_nucleo_urbano">
    <fieldset>

            <!--Text input-->
            <div class="form-group col-md-4">
                <label class="texto control-label" for="processo">Ano de atuação do processo:</label>
                <div class="col-md-12">
                    <input type="date" id="ano_atuacao_processo" name="ano_atuacao_processo" maxlength="8"
                        placeholder="Ano de atuação do processo" class="form-control input-md" value="">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group col-md-4">
                <label class="texto control-label" for="n_processo_topografia">N° Processo Topografia:</label>
                <div class="col-md-12">
                    <input type="text" id="n_processo_topografia" name="n_processo_topografia"
                        placeholder="Ano de atuação do processo" class="form-control input-md" value="">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group col-md-4">
                <label class="texto control-label" for="n_processo_consultas">N° processo Consultas:</label>
                <div class="col-md-12">
                    <input type="text" id="n_processo_consultas" name="n_processo_consultas"
                        placeholder="N° processo Consultas" class="form-control input-md" value="">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group col-md-4">
                <label class="texto control-label" for="n_processo_licenciamento_ambiental">N° Processo Licenciamento
                    Ambiental:</label>
                <div class="col-md-12">
                    <input type="text" id="n_processo_licenciamento_ambiental"
                        name="n_processo_licenciamento_ambiental" placeholder="N° Processo Licenciamento Ambiental"
                        class="form-control input-md" value="">
                </div>
            </div>
