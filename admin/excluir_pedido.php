<?php
include '../db.php';

$id = $_GET['id'];

$conn->query(
    "DELETE FROM itens_pedido WHERE pedido_id = $id"
);

$conn->query(
    "DELETE FROM pedidos WHERE id = $id"
);

header('Location: pedidos.php');
exit;
?>