<?php
include 'proteger.php';
include '../db.php';

function h($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$produto = $result->fetch_assoc();

if (!$produto) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    $stmt = $conn->prepare(
        "UPDATE produtos
         SET nome=?, preco=?, categoria=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "sdsi",
        $nome,
        $preco,
        $categoria,
        $id
    );

    $stmt->execute();

    header('Location: index.php');

    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Editar Produto</title>

    <style>

        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 30px;
        }

        .box {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6b4b3e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<div class="box">

    <h2>Editar Produto</h2>

    <form method="POST">

        <input
            type="text"
            name="nome"
            value="<?= h($produto['nome']) ?>"
            required
        >

        <input
            type="number"
            step="0.01"
            name="preco"
            value="<?= h($produto['preco']) ?>"
            required
        >

        <input
            type="text"
            name="categoria"
            value="<?= h($produto['categoria']) ?>"
            required
        >

        <button type="submit">
            Atualizar Produto
        </button>

    </form>

</div>

</body>
</html>
