<?php
include 'proteger.php';
include '../db.php';

$sql = "SELECT * FROM mensagens ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Mensagens</title>

<link rel="stylesheet" href="../style.css">

<style>

body{

    font-family:Arial;

    background:#f5f5f5;

    padding:30px;

}

h1{

    margin-bottom:20px;

}

table{

    width:100%;

    border-collapse:collapse;

    background:white;

    border-radius:15px;

    overflow:hidden;

}

th{

    background:#c8a27a;

    color:white;

    padding:15px;

}

td{

    padding:15px;

    border-bottom:1px solid #eee;

}

.btn{

    display:inline-block;

    padding:10px 15px;

    border-radius:10px;

    text-decoration:none;

    color:white;

    background:#25D366;

    font-size:14px;

}

textarea{

    width:100%;

    padding:10px;

    border-radius:10px;

    border:1px solid #ddd;

}

.sidebar a{

    display:block;
    color:black;
    text-decoration:none;
    margin-bottom:15px;
    font-weight:bold;

}
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

<h1>Mensagens Recebidas 💖</h1>

<table>

<tr>

<th>Nome</th>

<th>Telefone</th>

<th>Mensagem</th>

<th>Data</th>

<th>WhatsApp</th>

</tr>

<?php while($msg = $result->fetch_assoc()) : ?>

<tr>

<td>
<?= $msg['nome'] ?>
</td>

<td>
<?= $msg['telefone'] ?>
</td>

<td>
<?= $msg['mensagem'] ?>
</td>

<td>

<?= date(
'd/m/Y H:i',
strtotime($msg['data_envio'])
) ?>

</td>

<td>

<?php

$texto = urlencode(


"Olá {$msg['nome']}!

Recebemos sua mensagem com carinho.
\"{$msg['mensagem']}\"


Em breve responderemos.

Coser Clau Dias 💛"

);

$link = "https://wa.me/55" .
preg_replace('/[^0-9]/', '', $msg['telefone']) .
"?text=$texto";

?>

<a
href="<?= $link ?>"
target="_blank"
class="btn"
>

Responder

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</body>
</html>