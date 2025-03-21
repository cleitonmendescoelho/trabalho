<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <title>Cadastro de Produtos</title>
</head>

<body>
    <!-- Header com título principal da página -->
    <header>
        <h1>Cadastro de Produtos</h1>
    </header>

    <main>
        <!-- Seção do formulário de cadastro de produto -->
        <section class="formulario">
            <h2>Adicionar Novo Produto</h2>
            <form action="/cadastro_prod" method="POST">
                @csrf
                <!-- Grupo de campo de entrada para o nome do produto -->
                <div class="form-group">
                    <label for="nome">Nome do Produto</label> <!-- Adicionado label para acessibilidade -->
                    <input type="text" name="nome" id="nome" placeholder="Nome do Produto" required> <!-- Adicionado atributo required -->
                </div>

                <!-- Grupo de campo de seleção de categoria -->
                <div class="form-group">
                    <label for="category">Categoria</label> <!-- Adicionado label para acessibilidade -->
                    <select name="category" id="category" required> <!-- Adicionado atributo required -->
                        <option value="Utensilios">Utensílios</option>
                        <option value="Roupas">Roupas</option>
                        <option value="Calçados">Calçados</option>
                        <option value="Lar">Lar</option>
                    </select>
                </div>

                <!-- Botão de envio com classe para estilização -->
                <button type="submit" class="btn-submit">Cadastrar</button> <!-- Adicionada classe 'btn-submit' para estilização -->
            </form>
        </section>

        <!-- Seção da lista de registros de produtos -->
        <section class="lista">
            <h2>Tabela de Registros</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Data de Criação</th>
                        <th>Ações</th> <!-- Adicionado título de ações -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->category }}</td>
                            <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <!-- Formulário de exclusão com segurança -->
                                <form action="/produto/{{ $produto->id }}" method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Botão de exclusão com texto alternativo para acessibilidade -->
                                    <button type="submit" class="btn-delete" aria-label="Excluir produto {{ $produto->nome }}">Excluir</button> <!-- Adicionado 'aria-label' para acessibilidade -->
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

    <!-- Rodapé da página -->
    <footer>
        <p>&copy; 2025 Sistema de Cadastro de Produtos</p> <!-- Adicionada a tag <footer> para uma estrutura mais completa -->
    </footer>

</body>

</html>
