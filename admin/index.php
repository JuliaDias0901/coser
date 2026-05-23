<?php
include 'proteger.php';
include '../db.php';

function h($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$sql = "SELECT * FROM produtos ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Painel Administrativo</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f5f5;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
            color: #6b4b3e;
        }

        .top-bar {
            margin-bottom: 20px;
        }

        .btn {
            background: #6b4b3e;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #6b4b3e;
            color: white;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .edit {
            color: #007bff;
        }

        .delete {
            color: red;
        }

.sidebar a{

    display:block;
    color:black;
    text-decoration:none;
    margin-bottom:15px;
    font-weight:bold;

}
</style>

</style>

<div class="sidebar">

    <h2>Coser Admin</h2>

    <a href="dashboard.php">
        Dashboard
    </a>

    <a href="pedidos.php">
        Pedidos
    </a>

    <a href="index.php">
        Produtos
    </a>

    <a href="mensagens.php">
        Mensagens
    </a>

</div>
</head>

<body>

<div class="container">

    <h1>Painel Administrativo</h1>

    <div class="top-bar">

        <a href="novo_produto.php" class="btn">
            + Novo Produto
        </a>

    </div>

    <table>

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>

        <?php while($produto = $result->fetch_assoc()) : ?>

        <tr>

            <td><?= h($produto['id']) ?></td>

            <td><?= h($produto['nome']) ?></td>

            <td>
                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </td>

            <td><?= h($produto['categoria']) ?></td>

            <td class="actions">

                <a class="edit"
                   href="editar_produto.php?id=<?= h($produto['id']) ?>">
                    Editar
                </a>

                <a class="delete"
                   href="excluir_produto.php?id=<?= h($produto['id']) ?>"
                   onclick="return confirm('Deseja excluir?')">

                    Excluir

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
