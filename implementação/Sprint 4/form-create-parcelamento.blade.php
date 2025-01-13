<form action="{{ route('cadastrar-parcelamento-' . $tipoAr . '') }}" method="POST" class="form-horizontal"
    enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $nomeAr }}" name="nome_ar">
    <input type="hidden" value="{{ $checkPui }}" name="check_pui">
    <input type="hidden" value="{{ $areaAr }}" name="area_ar">
    <input type="hidden" value="{{ $checkNucleoUrbano }}" name="check_nucleo_urbano">
    <fieldset>
        <!-- Form Name -->
        <legend class="titulo">Cadastro do parcelamento</legend>



            <!-- Text input-->
            <div class="form-group col-md-6">
                <label class="texto control-label" for="n_publicacao">Decreto ou Portaria:</label>
                <div class="col-md-12 input-group">
                    <input id="n_publicacao" name="n_publicacao"
                        value="{{ isset($dadosParcelamento->numero_publicacao) ? $dadosParcelamento->numero_publicacao : '' }}"
                        type="text" placeholder="Nº Publicação" maxlength="50" class="form-control input-md">
                    <input type="date" id="data_decretoPortaria" name="data_decretoPortaria"
                        placeholder="Nº Publicação" maxlength="50" class="form-control input-md">
                    <button id="addDecreto" class="btn btn-outline-secondary" type="button"
                        onclick="adcionarDecretoPortaria()">Adicionar</button>
                </div>
                <div class="mt-2">
                    <ul class="list-group " id='lista-decretoPortaria'>
                    </ul>

                    <input id="decretoPortariaArray" name="decretoPortariaArray" type="text" hidden>
                </div>
            </div>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

@section('footer')
<script>
    // Counter for dynamic item additions
    var count = 0;

    // Variables for form inputs and data storage
    var valorUrb = {{ $valorUrb }};
    let decretoPortariaArray = [];
    let decisaoAmbientalArray = [];
    let diretrizUrbanisticaArray = [];

    // Autocomplete sources
    const autocompleteSources = {
        setorHabitacional: "{{ route('autocomplete-setor-habitacional') }}",
        decisaoPublicacao: "{{ route('autocomplete-decisao-publicacao') }}",
        situacaoDetalhamento: "{{ route('autocomplete-situacao-detalhamento') }}",
        normativo: "{{ route('autocomplete-normativo') }}",
        urb: "{{ route('autocomplete-urb') }}"
    };

    // Event listener for adding URB
    $("#adicionar_urb").click(function() {
        var texto = $("#input_urb").val();

        $.ajax({
            url: '{{ Request::root() }}/autocomplete-urb-final?term=' + texto,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                if (data.length === 0) {
                    alert(
                        'A Urb especificada não se encontra na base de dados do SISDUC.\n\nPara o cadastramento da URB na base de dados no SISDUC entre em contato com a DIGEO.\n\nRamal: 4143\nE-mail: pedro.siqueira@seduh.df.gov.br'
                    );
                } else {
                    if (texto) {
                        var html = "<div id='div_urb_" + valorUrb +
                            "' class='input-group col-md-12'>" +
                            "<input id='urb_" + valorUrb + "' name='urb_" + valorUrb +
                            "' type='text' class='form-control' placeholder='Ocupação' maxlength='70' aria-describedby='button-addon' value='" +
                            texto + "'>" +
                            "<div class='input-group-append'>" +
                            "<button type='button' class='btn btn-remover texto-form' onclick='removerUrb(" +
                            valorUrb + ")'><i class='far fa-trash-alt'></i> Remover Urb</button>" +
                            "</div>" +
                            "</div>";
                        $("#div_urb").append(html);
                        $("#input_urb").val('');
                        valorUrb++;
                    }
                }
            }
        });
    });

    // Autocomplete initialization for various inputs
    $(function() {
        $("#setor_habitacional").autocomplete({
            source: autocompleteSources.setorHabitacional
        });

        $("#decisao_publicacao").autocomplete({
            source: autocompleteSources.decisaoPublicacao
        });

        $("#situacao_detalhamento").autocomplete({
            source: autocompleteSources.situacaoDetalhamento
        });

        $("#normativo").autocomplete({
            source: autocompleteSources.normativo
        });

        $("#input_urb").autocomplete({
            source: autocompleteSources.urb
        });
    });



    // Function to add decretoPortaria
    function adcionarDecretoPortaria() {
        let decretoPortaria = document.getElementById("n_publicacao").value;
        let dataDecretoPortaria = document.getElementById("data_decretoPortaria").value;
        let dataFormatada = formatarData(dataDecretoPortaria);

        count++;

        if (decretoPortaria != "") {
            document.getElementById("lista-decretoPortaria").insertAdjacentHTML('beforeend',
                `<li class="list-group-item display: flex" id='dados-decretoPortaria-${count}' >
                <div class="d-flex justify-content-between">
                    <input class='item-decretoPortaria' hidden value="${decretoPortaria}">
                    <input class='item-decretoPortaria' hidden value="${dataDecretoPortaria}">
                    <span class="text-ocupacao">${decretoPortaria}</span>
                    <span class="text-ocupacao">${dataFormatada}</span>
                    <button type="button" class="btn btn-outline-danger remover-decretoPortaria" onclick="removerDecretoPortaria(${count})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </li>`
            );

            document.getElementById("n_publicacao").value = "";
            document.getElementById("data_decretoPortaria").value = "";

            decretoPortariaArray.push({
                id: count,
                numero_publicacao: decretoPortaria,
                data_decreto_portaria: dataDecretoPortaria
            });

            document.getElementById("decretoPortariaArray").value = JSON.stringify(decretoPortariaArray);
        }
    }

    // Function to remove decretoPortaria
    function removerDecretoPortaria(count) {
        document.getElementById('dados-decretoPortaria-' + count).remove();
    }


@endsection('footer')
