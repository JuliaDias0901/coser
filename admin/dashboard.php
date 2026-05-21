<?php
include 'proteger.php';
include '../db.php';

$totalPedidos = $conn->query(
    "SELECT COUNT(*) as total FROM pedidos"
)->fetch_assoc()['total'];

$faturamento = $conn->query(
    "SELECT SUM(total) as total FROM pedidos"
)->fetch_assoc()['total'];

$pedidosHoje = $conn->query(
    "SELECT COUNT(*) as total
     FROM pedidos
     WHERE DATE(data_pedido) = CURDATE()"
)->fetch_assoc()['total'];

$faturamentoMes = $conn->query(
    "SELECT SUM(total) as total
     FROM pedidos
     WHERE MONTH(data_pedido) = MONTH(NOW())"
)->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="sidebar">

    <h2>Coser Admin</h2>

    <a href="dashboard.php">Dashboard</a>

    <a href="pedidos.php">Pedidos</a>

    <a href="index.php">Produtos</a>

    <a href="mensagens.php">Mensagens</a>

</div>

<div class="main">

    <h1>Dashboard</h1>

    <div class="cards">

        <div class="card">

            <h3>Total de Pedidos</h3>

            <p>
                <?= $totalPedidos ?>
            </p>

        </div>

        <div class="card">

            <h3>Faturamento Total</h3>

            <p>
                R$ <?= number_format($faturamento, 2, ',', '.') ?>
            </p>

        </div>

        <div class="card">

            <h3>Pedidos Hoje</h3>

            <p>
                <?= $pedidosHoje ?>
            </p>

        </div>

        <div class="card">

            <h3>Faturamento do Mês</h3>

            <p>
                R$ <?= number_format($faturamentoMes, 2, ',', '.') ?>
            </p>

        </div>

    </div>

</div>

</body>

</html>