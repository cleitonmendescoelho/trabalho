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
    <header>
        <h1>Cadastro de Produtos</h1>
    </header>

    <main>
        <section class="formulario">
            <h2>Adicionar Novo Produto</h2>
            <form action="/cadastro_prod" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" name="nome" id="nome" placeholder="Nome do Produto" required>
                </div>
                <div class="form-group">
                    <label for="category">Categoria</label>
                    <select name="category" id="category" required>
                        <option value="Utensilios">Utensílios</option>
                        <option value="Roupas">Roupas</option>
                        <option value="Calçados">Calçados</option>
                        <option value="Lar">Lar</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Cadastrar</button>
            </form>
        </section>
        <section class="lista">
            <h2>Tabela de Registros</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Data de Criação</th>
                        <th>Ações</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->category }}</td>
                            <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                            <!-- Button delete -->
                            <td>
                                <form action="/produto/{{ $produto->id }}" method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" aria-label="Excluir produto {{ $produto->nome }}">Excluir</button>
                                </form>
                            </td>
                            <!-- Button Edit -->
                             
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Sistema de Cadastro de Produtos</p>
    </footer>

</body>

</html>
