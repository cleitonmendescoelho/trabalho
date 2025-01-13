                {{-- Img Etapas --}}

                <div id="info-footer" class="col-md-12 mb-2">
                    <div id="etapas">
                        @for ($i = 1; $i < 11; $i++)
                            <div class="etapa-{{ $i }}">
                                <div id="card-{{ $i }}" class="card">
                                    <div class="card-body">
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <br>
                    <div id="info-legenda" style="float: right; margin-right: 5%">
                        <p class="texto-pequeno no-padding no-margin" style="font-size: 11px;"><b>Legenda:</b></p>
                        <p class="texto-pequeno no-padding no-margin" style="font-size: 11px;">Etapas Iniciadas -
                            Colorido</p>
                        <p class="texto-pequeno no-padding no-margin" style="font-size: 11px;">Etapas Não Iniciadas -
                            Preto e
                            Branco</p>
                    </div>
                    <br><br>
                </div>
                <div class="col-md-12 p-5 mb-3">
                    <div id="info-ocupacao" class="row align-content-md-center mb-5">
                        <div class="col-md-12 col-sm-12 col-12">
                            <h2 style="text-align: left; padding-top: 0;"><b>Dados:</b></h2>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <div id="info-status" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-responsavel-projeto">Responsável pelo Projeto</h3>
                            <div id="info-responsavel-projeto" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-processo">Processo</h3>
                            <div id="info-processo" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-natureza-propriedade">Natureza da propriedade</h3>
                            <div id="info-natureza-propriedade" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-parcelamento">Parcelamento</h3>
                            <div id="info-parcelamento" class="row"></div>

                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-conplan">CONPLAN</h3>
                            <div id="info-conplan" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-ra">Região Administrativa</h3>
                            <div id="info-ra" class="row"></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <h3 id="titulo-classificacao-regularizacao">Classificação de Regularização:</h3>
                            <div id="info-classificacao-regularizacao" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-npublicacao">Decreto ou Portaria</h3>
                            <div id="info-npublicacao" class="row"></div>
                            <div id="info-data-publicacao" class="row"></div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <h3 id="titulo-urbs">URB</h3>
                            <div id="info-urbs" class="row"></div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <h3 id="titulo-ocupacoes">Lista Ocupações</h3>
                            <ul id="info-ocupacoes" class="list-group"></ul>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <h3 id="titulo-modalidade">Modalidade</h3>
                            <ul id="info-modalidade" class="list-group"></ul>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <h3 id="titulo-diretrizUrbanistica">Diretriz Urbanistica</h3>
                            <ul id="info-diretrizUrbanistica" class="list-group"></ul>
                        </div>
                        <div class=" row align-content-md-center">
                            <div class="col-md-12">
                                <h2 id="titulo-mapa" style="text-align: left; padding-top: 0;"><b>Mapa:</b></h2>
                                <div id="info-mapa" class="row"></div>
                            </div>
                        </div>
                    </div>
                </div>
