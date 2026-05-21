<?php
include 'proteger.php';
include '../db.php';

$sql = "SELECT * FROM pedidos ORDER BY data_pedido DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Pedidos</title>

<link rel="stylesheet" href="../style.css">

<style>

body{

    margin:0;
    font-family:Arial;
    background:#f5f5f5;

}

.sidebar{

    width:220px;
    height:100vh;
    background:#c8a27a;
    position:fixed;
    padding:20px;

}

.sidebar h2{

    color:white;
    margin-bottom:30px;

}

.sidebar a{

    display:block;
    color:white;
    text-decoration:none;
    margin-bottom:15px;
    font-weight:bold;

}

.main{

    margin-left:260px;
    padding:30px;

}

table{

    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:15px;
    overflow:hidden;

}

th{

    background:#d8b08c;
    color:white;
    padding:15px;

}

td{

    padding:15px;
    border-bottom:1px solid #eee;
    vertical-align:top;

}

select{

    padding:8px;
    border-radius:8px;
    border:1px solid #ddd;

}

.btn{

    padding:10px 15px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    display:inline-block;
    margin-bottom:5px;
    font-size:14px;

}

.whatsapp{

    background:#25D366;

}

.delete{

    background:#d9534f;

}

.produtos-box{

    background:#fafafa;
    padding:10px;
    border-radius:10px;
    margin-top:10px;
    font-size:14px;

}

</style>

</head>

<body>

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

<div class="main">

<h1>Pedidos 💖</h1>

<table>

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Pedido</th>

<th>Total</th>

<th>Pagamento</th>

<th>Status</th>

<th>Data</th>

<th>Ações</th>

</tr>

<?php while($pedido = $result->fetch_assoc()) : ?>

<tr>

<td>

<?= $pedido['id'] ?>

</td>

<td>

<strong>

<?= $pedido['nome_cliente'] ?>

</strong>

<br><br>

<?= $pedido['whatsapp'] ?>

</td>

<td>

<div class="produtos-box">

<?= nl2br(
    $pedido['produtos']
    ?? 'Pedido antigo sem produtos salvos'
) ?>

</div>

</td>

<td>

R$
<?= number_format(
    $pedido['total'],
    2,
    ',',
    '.'
) ?>

</td>

<td>

<?= $pedido['forma_pagamento']
?? 'Não informado' ?>

</td>

<td>

<form
action="atualizar_status.php"
method="POST"
>

<input
type="hidden"
name="id"
value="<?= $pedido['id'] ?>"
>

<select
name="status"
onchange="this.form.submit()"
>

<option
value="Pendente"
<?= ($pedido['status'] ?? '')
== 'Pendente'
? 'selected'
: '' ?>
>

Pendente

</option>

<option
value="Produção"
<?= ($pedido['status'] ?? '')
== 'Produção'
? 'selected'
: '' ?>
>

Produção

</option>

<option
value="Finalizado"
<?= ($pedido['status'] ?? '')
== 'Finalizado'
? 'selected'
: '' ?>
>

Finalizado

</option>

<option
value="Entregue"
<?= ($pedido['status'] ?? '')
== 'Entregue'
? 'selected'
: '' ?>
>

Entregue

</option>

</select>

</form>

</td>

<td>

<?= date(
'd/m/Y H:i',
strtotime($pedido['data_pedido'])
) ?>

</td>

<td>

<?php

$msg = urlencode(

"Olá {$pedido['nome_cliente']}!

Recebemos seu pedido com carinho.

Pedido:
" .

($pedido['produtos']
?? 'Produtos não encontrados')

.

"

Total:
R$ {$pedido['total']}

Status:
{$pedido['status']}

Em breve entraremos em contato para confirmar os detalhes.

Coser Clau Dias 💛"

);


?>

<a
class="btn whatsapp"
target="_blank"

href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $pedido['whatsapp']) ?>?text=<?= $msg ?>">

WhatsApp

</a>

<br>

<a
class="btn delete"

href="excluir_pedido.php?id=<?= $pedido['id'] ?>"

onclick="return confirm('Deseja excluir este pedido?')">

Excluir

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>

</html>