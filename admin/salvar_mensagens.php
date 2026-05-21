<?php
include '../db.php';

header('Content-Type: application/json');

$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

if(
    empty($nome) ||
    empty($telefone) ||
    empty($mensagem)
){

    echo json_encode([
        "success" => false
    ]);

    exit;

}

$stmt = $conn->prepare(

    "INSERT INTO mensagens
    (nome, telefone, mensagem)
    VALUES (?, ?, ?)"

);

$stmt->bind_param(
    "sss",
    $nome,
    $telefone,
    $mensagem
);

$stmt->execute();

echo json_encode([
    "success" => true
]);