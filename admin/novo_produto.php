<?php
include 'proteger.php';
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    $imagem = '';

    // Upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {

        $pasta = '../uploads/';

        $nomeImagem = time() . '_' . $_FILES['imagem']['name'];

        $caminhoImagem = $pasta . $nomeImagem;

        move_uploaded_file(
            $_FILES['imagem']['tmp_name'],
            $caminhoImagem
        );

        $imagem = 'uploads/' . $nomeImagem;
    }

    $stmt = $conn->prepare(
        "INSERT INTO produtos (nome, preco, categoria, imagem)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sdss",
        $nome,
        $preco,
        $categoria,
        $imagem
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
    <title>Novo Produto</title>
</head>
<body>

    <h2>Adicionar Produto</h2>

    <form method="POST" enctype="multipart/form-data">

        <input
            type="text"
            name="nome"
            placeholder="Nome do produto"
            required
        >

        <br><br>

        <input
            type="number"
            step="0.01"
            name="preco"
            placeholder="Preço"
            required
        >

        <br><br>

        <input
            type="text"
            name="categoria"
            placeholder="Categoria"
            required
        >

        <br><br>

        <input
            type="file"
            name="imagem"
            accept="image/*"
            required
        >

        <br><br>

        <button type="submit">
            Salvar Produto
        </button>

    </form>

</body>
</html>