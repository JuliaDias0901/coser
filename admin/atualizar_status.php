<?php
include '../db.php';

// Receber dados do formulário
$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

// Validar
if (empty($id) || empty($status)) {
    header('Location: pedidos.php');
    exit;
}

// Atualizar status
$sql = "UPDATE pedidos SET status = ? WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header('Location: pedidos.php?success=1');
} else {
    header('Location: pedidos.php?error=1');
}

exit;

?>
