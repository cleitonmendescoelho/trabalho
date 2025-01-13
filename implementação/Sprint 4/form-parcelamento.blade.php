<form action="{{ route('editar-parcelamento') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{-- {{dd($dadosParcelamento->id_status)}} --}}
    <input type="hidden" value="{{ $dadosParcelamento->id_ar }}" name="id_ar">
    <input type="hidden" value="{{ $dadosParcelamento->tipo_ar }}" name="tipo_ar">
    <input type="hidden" value="{{ $dadosParcelamento->id_parcelamento }}" name="id_parcelamento">
    <fieldset>

            <div class="form-group col-md-6 ">
                <label class="texto control-label" for="n_publicacao">Decreto ou Portaria:</label>
                <div class="col-md-12 input-group-append">
                    <input id="n_publicacao" name="n_publicacao" value="" type="text"
                        placeholder="Nº Publicação" maxlength="50" class="form-control input-md">
                    <input id="data_decretoPortaria" name="data_decretoPortaria" type="date" placeholder="Data"
                        class="form-control input-md">
                    <div class="input-group-append">
                        <button id="id_decretoPortaria" class="btn btn-outline-secondary" type="button"
                            onclick="adcionarDecretoPortaria()">Adicionar</button>
                    </div>
                </div>

                <div class="m-2">
                    <ul class="list-group " id='lista-decretoPortaria'>
                        @foreach ($dadosParcelamento->decretoPortarias as $decretoPortaria)
                            <li class="list-group-item "
                                id="decretoPortaria-{{ $decretoPortaria->id_decreto_portaria }}">
                                <div class="d-flex justify-content-between">
                                    <span class="text-decretoPortaria">
                                        {{ $decretoPortaria->numero_publicacao }}
                                    </span>
                                    <span class="text-data">
                                        {{ \Carbon\Carbon::parse($decretoPortaria->data_decreto_portaria)->format('d/m/Y') }}
                                    </span>

                                    <div>

                                        <div>
                                            <button type="button" class="btn btn-outline-success"
                                                data-toggle="modal"
                                                onclick="preencherEditDecretoPortaria(`{{ $decretoPortaria->numero_publicacao }}`, `{{ $decretoPortaria->id_decreto_portaria }}`, `{{ $decretoPortaria->data_decreto_portaria }}`)"
                                                data-target="#modalDecretoPortaria">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-danger"
                                                onclick="deleteDecretoPortaria({{ $decretoPortaria->id_decreto_portaria }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                    </div>
                            </li>
                        @endforeach
                    </ul>

                </div>

                <input id="decretoPortariaArray" name="decretoPortariaArray" type="text" hidden>

            </div>


<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

@section('footer')
    <script>
        var count = 0;

        var valorUrb = <?= $valorUrb ?>;

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
            })
        });

        $(function() {
            $("#setor_habitacional").autocomplete({
                source: "{{ route('autocomplete-setor-habitacional') }}"
            });

            $("#decisao_publicacao").autocomplete({
                source: "{{ route('autocomplete-decisao-publicacao') }}"
            });

            $("#situacao_detalhamento").autocomplete({
                source: "{{ route('autocomplete-situacao-detalhamento') }}"
            });

            $("#normativo").autocomplete({
                source: "{{ route('autocomplete-normativo') }}"
            });

            $("#input_urb").autocomplete({
                source: "{{ route('autocomplete-urb') }}"
            });
        });

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

        function removerDecretoPortaria(count) {
            document.getElementById('dados-decretoPortaria-' + count).remove();
        }

        function preencherEditDecretoPortaria(numero_publicacao, id_decreto_portaria, dataDecretoPortaria) {
            $("#numero_publicacao_modal").val(numero_publicacao);
            $("#id_decreto_portaria_modal").val(id_decreto_portaria);
            $("#dataDecretoPortariaModal").val(dataDecretoPortaria);
        }

        function deleteDecretoPortaria(id_decretoPortaria) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            swal.fire({
                title: 'Você deseja mesmo excluir esse número de publicação?',
                text: "Essa ação é irreversível",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Deletar',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#1324854d',
                confirmButtonColor: '#ff1744',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: `/deletar-decreto-portaria/${id_decretoPortaria}`,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set CSRF token in headers
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                $('#decretoPortaria-' + response.id_decretoPortaria)
                                    .remove(); // Correct selector syntax

                                swal.fire(
                                    'Deletado com sucesso!',
                                    '',
                                    'success'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.error('AJAX Error:', error);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.fire(
                        'Cancelado',
                        'Nenhuma ação foi realizada!',
                        'error'
                    );
                }
            });
        }
    </script>
@endsection('footer')
