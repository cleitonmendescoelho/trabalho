$auxarine = 0;
$auxaris = 0;
$auxpuiarine = 0;
$auxpuiaris = 0;
$auxra = 1;
$auxmapa = 1;
$auxurbreg = 0;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    $('.cabecalho').addClass('width-fixo');
    $('.barra-gdf').addClass('width-fixo');
    $('map').imageMapResize();

    var tabelaInfo = $('#tb-info').DataTable({

        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },

        "dom": "<'top row'lf>" +
            "<'col-md-12'tr>" +
            "<'bot col-md-2'p>",

        "ordering": false,
        "info": false,

        "columns": [{
            "data": "arine/aris",
            "render": function (data, type, row, meta) {
                console.log(row);
                return row[0];
            }
        },
        {
            "data": "setor_habitacional",
            "render": function (data, type, row, meta) {
                return row[1];
            }
        },
        {
            "data": "parcelamento",
            "render": function (data, type, row, meta) {
                return row[2] + " - " + row[4];
            }
        },
        {
            "data": 'ocupacao',
            "visible": false,
            "render": function (data, type, row, meta) {
                return row[3];
            }
        },
        ],
    });

    tabelaInfo.on('click', 'tbody tr', function () {
        p();

        startLoader();
        var $row = $(this);
        var $idParcelamento = $row[0].id;

        $.ajax({
            url: 'busca-parcelamentos/' + $idParcelamento,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                $('#info-ocupacoes').empty()
                $('#info-DecretoPortaria').empty()
                $('info-deretrizUrbanistica').empty()

                let ocupacao = "<h2>Ocupação: " + data["ocupacoes"][0]['ocupacao'] +
                    "</h2>";

                    let diretrizUrbanistica = "<h2>Diretriz Urbanistica: " + data["diretrizUrbanistica"][0]['diretrizUrbanistica'] +
                    "</h2>";



                if (data['parcelamento_info']['natureza_propriedade']) {
                    let diretriz_urbanistica = "<ul><li>" + data['parcelamento_info'][
                        'natureza_propriedade'
                    ] + "</li></ul>";
                    $('#info-natureza-propriedade').append($(diretriz_urbanistica));
                    document.getElementById("titulo-natureza-propriedade").style
                        .display = 'block';
                } else {
                    document.getElementById("titulo-natureza-propriedade").style
                        .display = 'none';
                }

                if (data['parcelamento_info']['processo']) {
                    let processo = "<ul><li>" + data['parcelamento_info']['processo'] +
                        "</li></ul>";
                    $('#info-processo').append($(processo));
                    document.getElementById("titulo-processo").style.display = 'block';
                } else {
                    document.getElementById("titulo-processo").style.display = 'none';
                }

                if (data['parcelamento_info']['responsavel_projeto']) {
                    let responsavel_projeto = "<ul><li>" + data['parcelamento_info'][
                        'responsavel_projeto'
                    ] + "</li></ul>";
                    $('#info-responsavel-projeto').append($(responsavel_projeto));
                    document.getElementById("titulo-responsavel-projeto").style
                        .display = 'block';
                } else {
                    document.getElementById("titulo-responsavel-projeto").style
                        .display = 'none';
                }

                if (data['parcelamento_info']['classificacao_regularizacao']) {
                    let classificacao_regularizacao = "<ul><li>" + data['parcelamento_info'][
                        'classificacao_regularizacao'
                    ] + "</li></ul>";
                    $('#info-classificacao-regularizacao').append($(classificacao_regularizacao));
                    document.getElementById("titulo-classificacao-regularizacao").style
                        .display = 'block';
                } else {
                    document.getElementById("titulo-classificacao-regularizacao").style
                        .display = 'none';
                }

                if (data['parcelamento_info']['decisao_publicacao']) {
                    let decisao_publicacao = "<ul><li>" + data['parcelamento_info'][
                        'decisao_publicacao'
                    ] + "</li></ul>";
                    $('#info-conplan').append($(decisao_publicacao));
                    document.getElementById("titulo-conplan").style.display = 'block';
                } else {
                    document.getElementById("titulo-conplan").style.display = 'none';
                }

                if (data['parcelamento_info']['n_publicacao']) {
                    let n_publicacao = "<ul><li>" + data['parcelamento_info'][
                        'n_publicacao'
                    ] + "</li></ul>";
                    $('#info-npublicacao').append($(n_publicacao));
                    document.getElementById("titulo-npublicacao").style.display =
                        'block';
                } else {
                    document.getElementById("titulo-npublicacao").style.display =
                        'none';
                }

                if (data['parcelamento_info']['ra']) {
                    let ra = "<ul><li>" + data['parcelamento_info']['ra'] +
                        "</li></ul>";
                    $('#info-ra').append($(ra));
                    document.getElementById("titulo-ra").style.display = 'block';
                } else {
                    document.getElementById("titulo-ra").style.display = 'none';
                }


                if (data['parcelamento_info']['id_status']) {
                    let id_status = data['parcelamento_info']['id_status']; // Obtém o status do objeto

                    // // Define o badge com base no status
                    let statusBadge = '';

                    // Verifica o status e atribui o badge correspondente
                    if (id_status === 1) {
                        statusBadge = '<span class="p-2 badge badge-primary"><i class="fas fa-list"></i> Em Progresso</span>';
                    } else if (id_status === 2) {
                        statusBadge = '<span class="p-2 badge badge-warning"><i class="fas fa-archive"></i> Arquivado</span>';
                    } else if (id_status === 3) {
                        statusBadge = '<span class="p-2 badge badge-danger"><i class="fas fa-ban"></i> Indeferido</span>';
                    } else if (id_status === 4) {
                        statusBadge = '<span class="p-2 badge badge-success"><i class="fas fa-check"></i> Concluído</span>';
                    } else {
                        statusBadge = '<span class="p-2 badge badge-secondary">Status Desconhecido</span>';
                    }


                    // Insere o badge no elemento com o ID "info-status"
                    $('#info-status').html(statusBadge);// Substitui o conteúdo de #info-status
                } else {
                    $('#info-status').html('<span class="badge badge-secondary">Status Indefinido</span>');
                }

                console.log(data);



                // Validação para ocupações
                if (data.ocupacoes && data.ocupacoes.length > 0) {
                    data.ocupacoes.forEach(element => {
                        $('#info-ocupacoes').append(
                            `<li class="list-group-item">` + element.descricao + `</li>`
                        );
                    });
                    document.getElementById("titulo-ocupacoes").style.display = 'block';
                } else {
                    document.getElementById("titulo-ocupacoes").style.display = 'none';
                }

                // // Validação para decreto e portaria
                // if (data.decretoPortaria && data.decretoPortaria.length > 0) {
                //     // Obtém o último item da lista
                //     const ultimoItem = data.decretoPortaria[data.decretoPortaria.length - 1];

                //     // Insere o número de publicação no elemento com o ID info-npublicacao
                //     // document.getElementById("info-npublicacao").innerHTML = `<ul><li>` + ultimoItem.numero_publicacao + `</li></ul>`;
                //     document.getElementById("info-npublicacao").innerHTML = `<ul><li>${ultimoItem.numero_publicacao} - ${ultimoItem.data_decreto_portaria}</li></ul>`;

                //     // Exibe o título, caso esteja oculto
                //     document.getElementById("titulo-npublicacao").style.display = 'block';
                // } else {
                //     // Oculta o título caso não haja itens na lista
                //     document.getElementById("titulo-npublicacao").style.display = 'none';
                // }

                if (data.decretoPortaria && data.decretoPortaria.length > 0) {
                    // Obtém o último item da lista
                    const ultimoItem = data.decretoPortaria[data.decretoPortaria.length - 1];

                    // Verificar se a data está no formato correto (assumindo que seja 'YYYY-MM-DD' ou similar)
                    const dataDecreto = new Date(ultimoItem.data_decreto_portaria);

                    // Verificar se a data é válida
                    if (isNaN(dataDecreto)) {
                        console.error('Data inválida:', ultimoItem.data_decreto_portaria);
                    } else {
                        // Formatar a data para o formato D/M/A (Dia/Mês/Ano)
                        const dia = dataDecreto.getDate(); // Pega o dia
                        const mes = dataDecreto.getMonth() + 1; // Pega o mês (mês começa de 0, então soma-se 1)
                        const ano = dataDecreto.getFullYear(); // Pega o ano

                        // Insere o número de publicação e a data formatada no elemento com o ID info-npublicacao
                        document.getElementById("info-npublicacao").innerHTML = `<ul><li>${ultimoItem.numero_publicacao} - ${dia}/${mes}/${ano}</li></ul>`;

                        // Exibe o título, caso esteja oculto
                        document.getElementById("titulo-npublicacao").style.display = 'block';
                    }
                } else {
                    // Oculta o título caso não haja itens na lista
                    document.getElementById("titulo-npublicacao").style.display = 'none';
                }


                // Ajax Diretriz Urbanistica
                if (data.diretrizUrbanistica && diretrizUrbanistica.length > 0) {
                    data.diretrizUrbanistica.forEach(element => {
                        $('#info-diretrizUrbanistica').append(
                            `<li class="list-group-item">` + element.descricao + `</li>`
                        );
                    });
                    document.getElementById("titulo-diretrizUrbanistica").style.display = 'block';
                } else {
                    document.getElementById("titulo-diretrizUrbanistica").style.display = 'none';
                }


                if (data.parcelamento_info.mapa != null) {
                    let mapa = "<img class='info-mapa' src='/storage/mapas/" +
                        data.parcelamento_info.mapa + "' onclick='mapaMax()'>";
                    $('#info-mapa').append($(mapa));
                    document.getElementById("titulo-mapa").style.display = 'block';
                    $auxmapa = 1;
                } else {
                    document.getElementById("titulo-mapa").style.display = 'none';
                }

                $('#info-parcelamento').append($("<ul><li>" + data['parcelamento_info'][
                    'nome'
                ] + "</li></ul>"));

                if (data["urbs"][0]) {
                    var auxUrbs = "<ul>";

                    for (var i = 0; i < data["urbs"].length; i++) {

                        if (data["urbs"][i]['registrado'] == true) {
                            $auxurbreg = 1;
                            var urbAgora = data["urbs"][i]['descricao'];
                            var urbLink = urbAgora.replace("/", "(barra)");

                            if (data["urbs"][i]['arquivo'] === '1') {
                                var urbDownload =
                                    ' <i class="fas fa-file-download" onclick="baixarArquivosUrb(\'' +
                                    urbLink + '\')"></i>';
                            } else {
                                var urbDownload = '';
                            }

                            auxUrbs += "<li>" + urbAgora + urbDownload + '</li>';
                        }
                    }

                    auxUrbs += "</ul>";
                    if ($auxurbreg == 1) {
                        $('#info-urbs').append($(auxUrbs));
                        document.getElementById("titulo-urbs").style.display = 'block';
                    } else {
                        document.getElementById("titulo-urbs").style.display = 'none';
                    }
                } else {
                    document.getElementById("titulo-urbs").style.display = 'none';
                }

                for (var i = 1; i < 11; i++) {
                    if (data["etapas"][i]) {
                        if (i === 1) {
                            if (data["etapas"][i] === "Não Iniciado") {
                                $('#card-' + (i) + ' div').append($(
                                    '<p class="card-text">' + data["etapas"][
                                    i
                                    ] + '</p>'));
                                $('#card-' + i).addClass('inativo').removeClass('ativo')
                                    .removeClass('concluido');
                            } else {
                                $('#card-' + (i) + ' div').append($(
                                    '<p class="card-text">' + data["etapas"][
                                    i
                                    ] + '</p>'));
                                if (data["etapas"][i] === "Concluído" || data["etapas"][
                                    i
                                ] === "Aprovado" || data["etapas"][i] ===
                                    "Decreto Publicado" || data["etapas"][i] ===
                                    "Registrado") {
                                    $('#card-' + i).addClass('concluido').removeClass(
                                        'inativo').removeClass('ativo');
                                } else {
                                    $('#card-' + i).addClass('ativo').removeClass(
                                        'inativo').removeClass('concluido');
                                }
                            }
                        } else {
                            $('#card-' + (i) + ' div').append($(
                                '<p class="card-text">' + data["etapas"][i] +
                                '</p>'));
                            if (data["etapas"][i] === "Concluído" || data["etapas"][
                                i
                            ] === "Aprovado" || data["etapas"][i] ===
                                "Decreto Publicado" || data["etapas"][i] ===
                                "Registrado") {
                                $('#card-' + i).addClass('concluido').removeClass(
                                    'inativo').removeClass('ativo');
                            } else {
                                $('#card-' + i).addClass('ativo').removeClass('inativo')
                                    .removeClass('concluido');
                            }
                        }
                    } else {
                        $('#card-' + i).addClass('inativo').removeClass('ativo')
                            .removeClass('concluido');
                    }
                }

                stopLoader();

                document.getElementById("titulo-parcelamento").style.display = 'block';
                document.getElementById("etapas").style.display = 'flex';
                document.getElementById("info-legenda").style.display = 'block';
                document.getElementById("info-ocupacao").style.visibility = 'visible';

                setTimeout(() => {
                    window.scrollTo(0, 1000);
                }, 200);
            }
        });
    });

    $('#pesquisar-local').keypress(function (e) {
        if (e.keyCode === 13) {
            pesquisarLocal();
        }
    });

    var tabelaOcupacao = $('#tb-ocupacao').DataTable({

        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },

        "dom": "<'top row'lf>" +
            "<'col-md-12'tr>" +
            "<'bot col-md-2'p>",

        "ordering": false,
        "info": false,

        "columns": [
            {
                "data": "id_parcelamento",
                "visible": false,
                "render": function (data, type, row, meta) {
                    return row.id_parcelamento;
                }
            },
            {
                "data": "arine/aris",
                "render": function (data, type, row, meta) {

                    if (row.arine != null) {
                        return row.arine;
                    }

                    return row.aris;
                }
            },
            {
                "data": "setor_habitacional",
                "render": function (data, type, row, meta) {
                    return row.setor_habitacional;
                }
            },
            {
                "data": "nome_parcelamento",
                "visible": false,
                "render": function (data, type, row, meta) {
                    return row.nome_parcelamento;
                }
            },
            {
                "data": 'nome_ocupacao',
                "render": function (data, type, row, meta) {
                    return row.nome_ocupacao;
                }
            },
        ],
    });

    tabelaOcupacao.on('click', 'tr', function () {
        p();

        startLoader();

        let row = tabelaOcupacao.row(this).data()


        $.ajax({
            url: 'busca-parcelamentos/' + row.id_parcelamento,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                $('#info-ocupacoes').empty()

                let ocupacao = "<h2>Ocupação: " + data["ocupacoes"][0]['ocupacao'] +
                    "</h2>";

                if (data['parcelamento_info']['diretriz_urbanistica']) {
                    var diur = data['parcelamento_info']['diretriz_urbanistica'];
                    var diurLink = diur.replace("/", "(barra)");
                    let diretriz_urbanistica = "<ul><li>" + data['parcelamento_info'][
                        'diretriz_urbanistica'
                    ] +
                        ' <i class="fas fa-file-download" onclick="baixarArquivosDiur(\'' +
                        diurLink + '\')"></i>' + "</li></ul>";
                    $('#info-diretriz-urb').append($(diretriz_urbanistica));
                    document.getElementById("titulo-diretriz-urb").style.display =
                        'block';
                } else {
                    document.getElementById("titulo-diretriz-urb").style.display =
                        'none';
                }

                if (data['parcelamento_info']['natureza_propriedade']) {
                    let diretriz_urbanistica = "<ul><li>" + data['parcelamento_info'][
                        'natureza_propriedade'
                    ] + "</li></ul>";
                    $('#info-natureza-propriedade').append($(diretriz_urbanistica));
                    document.getElementById("titulo-natureza-propriedade").style
                        .display = 'block';
                } else {
                    document.getElementById("titulo-natureza-propriedade").style
                        .display = 'none';
                }

                if (data['parcelamento_info']['processo']) {
                    let processo = "<ul><li>" + data['parcelamento_info']['processo'] +
                        "</li></ul>";
                    $('#info-processo').append($(processo));
                    document.getElementById("titulo-processo").style.display = 'block';
                } else {
                    document.getElementById("titulo-processo").style.display = 'none';
                }

                if (data['parcelamento_info']['responsavel_projeto']) {
                    let responsavel_projeto = "<ul><li>" + data['parcelamento_info'][
                        'responsavel_projeto'
                    ] + "</li></ul>";
                    $('#info-responsavel-projeto').append($(responsavel_projeto));
                    document.getElementById("titulo-responsavel-projeto").style
                        .display = 'block';
                } else {
                    document.getElementById("titulo-responsavel-projeto").style
                        .display = 'none';
                }

                // CR
                if (data['parcelamento_info']['classificacao_regularizacao']) {
                    let classificacao_regularizacao = "<ul><li>" + data['parcelamento_info'][
                        'classificacao_regularizacao'
                    ] + "</li></ul>";
                    $('#info-classificacao').append($(classificacao_regularizacao));
                    document.getElementById("titulo-classificacao-regularizacao").style.display =
                        'block';
                } else {
                    document.getElementById("titulo-classificacao-regularizacao").style.display =
                        'none';
                }

                if (data['parcelamento_info']['decisao_publicacao']) {
                    let decisao_publicacao = "<ul><li>" + data['parcelamento_info'][
                        'decisao_publicacao'
                    ] + "</li></ul>";
                    $('#info-conplan').append($(decisao_publicacao));
                    document.getElementById("titulo-conplan").style.display = 'block';
                } else {
                    document.getElementById("titulo-conplan").style.display = 'none';
                }

                if (data['parcelamento_info']['n_publicacao']) {
                    let n_publicacao = "<ul><li>" + data['parcelamento_info'][
                        'n_publicacao'
                    ] + "</li></ul>";
                    $('#info-npublicacao').append($(n_publicacao));
                    document.getElementById("titulo-npublicacao").style.display =
                        'block';
                } else {
                    document.getElementById("titulo-npublicacao").style.display =
                        'none';
                }

                if (data['parcelamento_info']['ra']) {
                    let ra = "<ul><li>" + data['parcelamento_info']['ra'] +
                        "</li></ul>";
                    $('#info-ra').append($(ra));
                    document.getElementById("titulo-ra").style.display = 'block';
                } else {
                    document.getElementById("titulo-ra").style.display = 'none';
                }

                if (data.ocupacoes.length > 0) {
                    data.ocupacoes.forEach(element => {
                        $('#info-ocupacoes').append(
                            `<li  class="list-group-item">` + element
                                .descricao + `</li>`);
                    });


                    document.getElementById("titulo-ocupacoes").style.display = 'block';
                } else {
                    document.getElementById("titulo-ocupacoes").style.display = 'none';
                }

                if (data.parcelamento_info.mapa != null) {
                    let mapa = "<img class='info-mapa' src='/storage/mapas/" +
                        data.parcelamento_info.mapa + "' onclick='mapaMax()'>";
                    $('#info-mapa').append($(mapa));
                    document.getElementById("titulo-mapa").style.display = 'block';
                    $auxmapa = 1;
                } else {
                    document.getElementById("titulo-mapa").style.display = 'none';
                }

                $('#info-parcelamento').append($("<ul><li>" + data['parcelamento_info'][
                    'nome'
                ] + "</li></ul>"));

                if (data["urbs"][0]) {
                    var auxUrbs = "<ul>";

                    for (var i = 0; i < data["urbs"].length; i++) {

                        if (data["urbs"][i]['registrado'] == true) {
                            $auxurbreg = 1;
                            var urbAgora = data["urbs"][i]['descricao'];
                            var urbLink = urbAgora.replace("/", "(barra)");

                            if (data["urbs"][i]['arquivo'] === '1') {
                                var urbDownload =
                                    ' <i class="fas fa-file-download" onclick="baixarArquivosUrb(\'' +
                                    urbLink + '\')"></i>';
                            } else {
                                var urbDownload = '';
                            }

                            auxUrbs += "<li>" + urbAgora + urbDownload + '</li>';
                        }
                    }

                    auxUrbs += "</ul>";
                    if ($auxurbreg == 1) {
                        $('#info-urbs').append($(auxUrbs));
                        document.getElementById("titulo-urbs").style.display = 'block';
                    } else {
                        document.getElementById("titulo-urbs").style.display = 'none';
                    }
                } else {
                    document.getElementById("titulo-urbs").style.display = 'none';
                }

                for (var i = 1; i < 11; i++) {
                    if (data["etapas"][i]) {
                        if (i === 1) {
                            if (data["etapas"][i] === "Não Iniciado") {
                                $('#card-' + (i) + ' div').append($(
                                    '<p class="card-text">' + data["etapas"][
                                    i
                                    ] + '</p>'));
                                $('#card-' + i).addClass('inativo').removeClass('ativo')
                                    .removeClass('concluido');
                            } else {
                                $('#card-' + (i) + ' div').append($(
                                    '<p class="card-text">' + data["etapas"][
                                    i
                                    ] + '</p>'));
                                if (data["etapas"][i] === "Concluído" || data["etapas"][
                                    i
                                ] === "Aprovado" || data["etapas"][i] ===
                                    "Decreto Publicado" || data["etapas"][i] ===
                                    "Registrado") {
                                    $('#card-' + i).addClass('concluido').removeClass(
                                        'inativo').removeClass('ativo');
                                } else {
                                    $('#card-' + i).addClass('ativo').removeClass(
                                        'inativo').removeClass('concluido');
                                }
                            }
                        } else {
                            $('#card-' + (i) + ' div').append($(
                                '<p class="card-text">' + data["etapas"][i] +
                                '</p>'));
                            if (data["etapas"][i] === "Concluído" || data["etapas"][
                                i
                            ] === "Aprovado" || data["etapas"][i] ===
                                "Decreto Publicado" || data["etapas"][i] ===
                                "Registrado") {
                                $('#card-' + i).addClass('concluido').removeClass(
                                    'inativo').removeClass('ativo');
                            } else {
                                $('#card-' + i).addClass('ativo').removeClass('inativo')
                                    .removeClass('concluido');
                            }
                        }
                    } else {
                        $('#card-' + i).addClass('inativo').removeClass('ativo')
                            .removeClass('concluido');
                    }
                }

                stopLoader();

                document.getElementById("titulo-parcelamento").style.display = 'block';
                document.getElementById("etapas").style.display = 'flex';
                document.getElementById("info-legenda").style.display = 'block';
                document.getElementById("info-ocupacao").style.visibility = 'visible';

                setTimeout(() => {
                    window.scrollTo(0, 1000);
                }, 200);
            }
        });
    });

    $('.btn-parcelamento').click(function () {
        if (!$('.btn-parcelamento').hasClass('active-btn')) {
            $('.btn-parcelamento').addClass('active-btn');
            $('.btn-ocupacao').removeClass('active-btn');
        }
    });

    $('.btn-ocupacao').click(function () {
        if (!$('.btn-ocupacao').hasClass('active-btn')) {
            $('.btn-ocupacao').addClass('active-btn');
            $('.btn-parcelamento').removeClass('active-btn');
        }
    });
});

window.addEventListener('mousemove', function (e) {
    var mouse = {
        x: e.clientX,
        y: e.clientY
    };

    document.getElementById("nome-ra").style.top = mouse.y + "px";
    document.getElementById("nome-ra").style.left = (mouse.x + 13) + "px";

});

function myLeave($ra) {
    $('#ra-' + $ra).fadeOut(300);
    $('#nome-ra').css('display', 'none');
}

function clickRA($ra) {
    var table = $('#tb-info').DataTable();
    var tableOcupacao = $('#tb-ocupacao').DataTable();

    table.clear().draw();
    tableOcupacao.clear().draw();

    $('#info-header h1').remove();

    p();

    $.ajax({
        url: 'lista-parcelamentos/' + $ra,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            let header = '<h1 id="info-header-titulo">Região Administrativa ' + data["nome-Ra"] +
                '</h1>';

            if (data["tabela"]) {
                for (var i = 0; i < data["tabela"].length; i++) {
                    table.row.add(data["tabela"][i]).node().id = data["id_parcelamento"][i];
                    table.draw(false);
                    table.column(3).visible(false);
                    table.search('').draw();
                }
            }

            if (data["ocupacao"]) {
                data["ocupacao"].forEach(element => {
                    tableOcupacao.row.add(element).draw();
                });
            }

            $('#info').fadeIn(300);
            $('#info-header').append($(header));
        }
    });
}

function clickVoltar() {
    $('#info').fadeOut(200);
}

function showarine() {
    if ($auxarine === 1) {
        $('#img-arine').fadeOut(200);
        $auxarine = 0;
    } else {
        $('#img-arine').fadeIn(200);
        $auxarine = 1;
    }
}

function showaris() {
    if ($auxaris === 1) {
        $('#img-aris').fadeOut(200);
        $auxaris = 0;
    } else {
        $('#img-aris').fadeIn(200);
        $auxaris = 1;
    }
}

function showpuiarine() {
    if ($auxpuiarine === 1) {
        $('#img-pui-arine').fadeOut(200);
        $auxpuiarine = 0;
    } else {
        $('#img-pui-arine').fadeIn(200);
        $auxpuiarine = 1;
    }
}

function showpuiaris() {
    if ($auxpuiaris === 1) {
        $('#img-pui-aris').fadeOut(200);
        $auxpuiaris = 0;
    } else {
        $('#img-pui-aris').fadeIn(200);
        $auxpuiaris = 1;
    }
}

function showra() {
    if ($auxra === 1) {
        $('#img-ra').fadeOut(200);
        $auxra = 0;
    } else {
        $('#img-ra').fadeIn(200);
        $auxra = 1;
    }
}

function startLoader() {
    let loader =
        '<span class="text">Carregando...</span><span class="l-1"></span><span class="l-2"></span><span class="l-3"></span><span class="l-4"></span><span class="l-5"></span><span class="l-6"></span>';
    $('#loader').append($(loader));
    $('#lock').show();
    document.body.style.overflow = 'hidden';
}

function stopLoader() {
    $('#loader span').remove();
    $('#lock').hide();
    document.body.style.overflow = 'visible';
}

function myHover($ra) {
    $('#ra-' + $ra).fadeIn(10);
    $('#nome-ra').css('display', 'block');

    var nome;
    switch ($ra) {
        case '01':
            nome = "Plano Piloto";
            break;
        case '02':
            nome = "Gama";
            break;
        case '03':
            nome = "Taguatinga";
            break;
        case '04':
            nome = "Brazlândia";
            break;
        case '05':
            nome = "Sobradinho";
            break;
        case '06':
            nome = "Planaltina";
            break;
        case '07':
            nome = "Paranoá";
            break;
        case '08':
            nome = "Núcleo Bandeirante";
            break;
        case '09':
            nome = "Ceilândia";
            break;
        case '10':
            nome = "Guará";
            break;
        case '11':
            nome = "Cruzeiro";
            break;
        case '12':
            nome = "Samambaia";
            break;
        case '13':
            nome = "Santa Maria";
            break;
        case '14':
            nome = "São Sebastião";
            break;
        case '15':
            nome = "Recanto das Emas";
            break;
        case '16':
            nome = "Lago Sul";
            break;
        case '17':
            nome = "Riacho Fundo";
            break;
        case '18':
            nome = "Lago Norte";
            break;
        case '19':
            nome = "Candangolândia";
            break;
        case '20':
            nome = "Águas Claras";
            break;
        case '21':
            nome = "Riacho Fundo II";
            break;
        case '22':
            nome = "Sudoeste/Octogonal";
            break;
        case '23':
            nome = "Varjão";
            break;
        case '24':
            nome = "Park Way";
            break;
        case '25':
            nome = "SCIA";
            break;
        case '26':
            nome = "Sobradinho II";
            break;
        case '27':
            nome = "Jardim Botânico";
            break;
        case '28':
            nome = "Itapoã";
            break;
        case '29':
            nome = "SIA";
            break;
        case '30':
            nome = "Vicente Pires";
            break;
        case '31':
            nome = "Fercal";
            break;
        case '32':
            nome = "Sol Nascente e Pôr do Sol";
            break;
        case '33':
            nome = "Arniqueira";
            break;
    }

    document.getElementById("nome-ra").innerHTML = "<i id='icon-ra' class='fas fa-map-marker-alt'></i>" + nome;
}

function p() {

    for (var i = 0; i < 10; i++) {
        $('#card-' + (i + 1) + ' div p').remove();
    }

    $('#info-parcelamento ul').remove();
    $('#info-urbs ul').remove();
    $('#info-diretriz-urb ul').remove();
    $('#info-processo ul').remove();
    $('#info-responsavel-projeto ul').remove();
    $('#info-natureza-propriedade ul').remove();
    $('#info-conplan ul').remove();
    $('#info-npublicacao ul').remove();
    $('#info-ra ul').remove();
    $('#info-mapa img').remove();

    document.getElementById("info-ocupacao").style.visibility = 'hidden';
    document.getElementById("etapas").style.display = 'none';
    document.getElementById("info-legenda").style.display = 'none';
    document.getElementById("titulo-mapa").style.display = 'none';
}

function pesquisarLocal() {
    var pesquisa = $('#pesquisar-local').val().trim();

    if (pesquisa !== '') {

        var table = $('#tb-info').DataTable();
        var tableOcupacao = $('#tb-ocupacao').DataTable();

        table.clear().draw();
        tableOcupacao.clear().draw();

        table.search('').draw();
        tableOcupacao.search('').draw();

        $('#info-header h1').remove();

        p();

        $.ajax({
            url: 'pesquisa-parcelamentos/' + pesquisa,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {

                let header = '<h1 id="info-header-titulo">Resultado para ' + pesquisa + '</h1>';
                if (data["tabela"]) {
                    for (var i = 0; i < data["tabela"].length; i++) {
                        table.row.add(data["tabela"][i]).node().id = data["id_parcelamento"][i];
                        // table.column(3).visible(true);
                        table.draw(false);
                    }
                }

                if (data["ocupacoes"]) {
                    data["ocupacoes"].forEach(element => {
                        tableOcupacao.row.add(element).draw();
                    });
                }
                $('#info').fadeIn(300);
                $('#info-header').append($(header));
            }
        });
    }
}

function mapaMax() {
    if ($auxmapa === 1) {
        $("#info-mapa img").addClass("info-mapa-max");
        $auxmapa = 0;
    } else {
        $("#info-mapa img").removeClass("info-mapa-max");
        $auxmapa = 1;
    }
}

function baixarArquivosUrb(urbLink) {
    startLoader();
    $.ajax({
        url: '/baixar-arquivos-urb?urb=' + urbLink,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            if (data == 0) {
                alert('Download indisponivel, tente novamente mais tarde.');
            } else {
                window.location.href = data;
                stopLoader();
            }
        }
    });
}

function baixarArquivosDiur(diurLink) {
    startLoader();
    $.ajax({
        url: '/baixar-arquivos-diur?diur=' + diurLink,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            if (data == 0) {
                alert('Download indisponivel, tente novamente mais tarde.');
            } else {
                window.location.href = data;
                stopLoader();
            }
        }
    });
}

