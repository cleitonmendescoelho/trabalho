<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}?v={{ time()}}">
    <title>Document</title>
</head>
<body>
    <div class="conteiner">
        <h1>Cadastro de produtos</h1>
        <form action="/cadastro_prod" method="post">
            @csrf
            <input type="text" name="nome" placeholder="Nome">
            <select name="category" id="category">
                <option value="Utensilios">Utensilios</option>
                <option value="Roupas">Roupas</option>
                <option value="Calçados">Calçados</option>
                <option value="Lar">Lar</option>
            </select>
            <button type="submit">Cadastrar</button>
        </form>
        <section class="lista">
            <h3>Tabela de registros</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Data de Criação</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Estrutura 1 - Listando os dados -->
                    <!-- @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->category }}</td>
                        <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach -->

                    <!-- Estrutura 2 Listando os dados e adicionando o Update e Delete-->
                     @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->category }}</td>
                        <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="/produto/{{ $produto->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color:red;">Excluir</button>
                            </form>
                        </td>
                          <!-- Edit -->
                           <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    </div>
</body>
</html>
