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
        <form action="" method="">
            <input type="text" name="" placeholder="Nome">
            <select name="" id="">
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
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
    </div>
    </div>
</body>
</html>