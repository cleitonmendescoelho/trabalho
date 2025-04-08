<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <title>Cadastro de Produtos</title>
    <!-- Incluindo o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <header>
            <h1>Cadastro de Produtos</h1>
        </header>
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
                        <th>Última Edição</th>
                        <th class="action">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->category }}</td>
                        <td>{{ $produto->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $produto->updated_at->format('d/m/Y H:i') }}</td>
                        <!-- Button delete -->
                        <td>
                            <form action="/produto/{{ $produto->id }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" aria-label="Excluir produto {{ $produto->nome }}">Excluir</button>
                            </form>
                            <!-- Button Edit -->
                            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $produto->id }}">
                                Editar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for Editing -->
                    <div class="modal fade" id="editModal{{ $produto->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $produto->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel{{ $produto->id }}">Editar Produto</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/produto/{{ $produto->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nome">Nome do Produto</label>
                                            <input type="text" name="nome" id="nome" value="{{ $produto->nome }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Categoria</label>
                                            <select name="category" id="category" required>
                                                <option value="Utensilios" {{ $produto->category == 'Utensilios' ? 'selected' : '' }}>Utensílios</option>
                                                <option value="Roupas" {{ $produto->category == 'Roupas' ? 'selected' : '' }}>Roupas</option>
                                                <option value="Calçados" {{ $produto->category == 'Calçados' ? 'selected' : '' }}>Calçados</option>
                                                <option value="Lar" {{ $produto->category == 'Lar' ? 'selected' : '' }}>Lar</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn-submit">Salvar Alterações</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Sistema de Cadastro de Produtos</p>
    </footer>

    <!-- Incluindo o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Aqui podemos adicionar JavaScript personalizado para manipulação do modal, se necessário -->
    <script>
        // Inicializando o modal do Bootstrap se necessário
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            new bootstrap.Modal(modal);
        });
    </script>
</body>

</html>