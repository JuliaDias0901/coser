<?php
include 'proteger.php';
include '../db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: index.php');
exit;
?>