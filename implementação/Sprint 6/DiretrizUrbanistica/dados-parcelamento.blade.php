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
                <div class="col-md-6 col-sm-6 col-6">
                    <h3 id="titulo-diretrizUrbanistica">Diretriz Urbanistica</h3>
                    <ul id="info-diretrizUrbanistica" class="list-group"></ul>
                </div>
                </div>
                </div>
