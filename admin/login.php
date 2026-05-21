<?php
if (session_status() === PHP_SESSION_NONE) {

    session_start();

}
include '../db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];

    $senha = md5($_POST['senha']);

    $sql = "SELECT * FROM admin
            WHERE usuario = ?
            AND senha = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ss",
        $usuario,
        $senha
    );

    $stmt->execute();

    $resultado =
        $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $_SESSION['admin'] = $usuario;

        header('Location: dashboard.php');

        exit;

    } else {

        $erro = 'Usuário ou senha inválidos';

    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Login Admin</title>

<style>

body{

    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f5f5f5;
    font-family:Arial;

}

.box{

    background:white;
    padding:40px;
    border-radius:20px;
    width:350px;
    box-shadow:0 0 20px rgba(0,0,0,0.1);

}

h2{

    text-align:center;
    margin-bottom:30px;
    color:#c8a27a;

}

input{

    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid #ddd;
    box-sizing:border-box;

}

button{

    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#c8a27a;
    color:white;
    font-size:16px;
    cursor:pointer;

}

.erro{

    color:red;
    margin-bottom:15px;
    text-align:center;

}

</style>

</head>

<body>

<div class="box">

<h2>Painel Admin 💛</h2>

<?php if($erro != '') : ?>

<div class="erro">

<?= $erro ?>

</div>

<?php endif; ?>

<form method="POST">

<input
type="text"
name="usuario"
placeholder="Usuário"
required
>

<input
type="password"
name="senha"
placeholder="Senha"
required
>

<button type="submit">

Entrar

</button>

</form>

</div>

</body>
</html>