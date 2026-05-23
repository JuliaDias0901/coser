<?php
include 'proteger.php';
include '../db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: pedidos.php');
    exit;
}

$stmt = $conn->prepare("DELETE FROM itens_pedido WHERE pedido_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: pedidos.php');
exit;
?>