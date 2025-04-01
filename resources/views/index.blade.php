<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }} ?v={{ time() }}">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Produtos</h1>
        <form action="" method="">
            <input type="text" name="" placeholder="Nome" required>
            <select name="" required>
                <option value="" disabled selected>Selecione a categoria</option>
                <option value="Utensilios">Utensílios</option>
                <option value="Roupas">Roupas</option>
                <option value="Calçados">Calçados</option>
                <option value="Lar">Lar</option>
            </select>
            <button type="submit">Cadastrar</button>
        </form>
        <section class="lista">
            <h3>Tabela de Registros</h3>
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
                </tbody>
            </table>
        </section>
    </div>
</body>

</html>
