<?php
include 'proteger.php';
include 'db.php';

header('Content-Type: application/json');

//receber dados
$data = json_decode(

    file_get_contents("php://input"),

    true

);
$nome = $data['nome'] ?? '';
$whatsapp = $data['whatsapp'] ?? '';
$email = $data['email'] ?? '';
$total = $data['total'] ?? 0;
$forma_pagamento =
    $data['forma_pagamento'] ?? '';

$itens = $data['itens'] ?? [];

//validar
if (

    empty($nome)

    || empty($whatsapp)

    || empty($itens)

) {

    echo json_encode([

        'success' => false,

        'error' => 'Dados incompletos'

    ]);

    exit;

}

// produtos
$produtos = "";

foreach ($itens as $item) {
    $nomeProduto =
        $item['nome'] ?? 'Produto';
    $babyName =
        $item['babyName']
        ?? 'Não informado';
    $preco =
        $item['preco'] ?? 0;

    $produtos .=
        "🧸 " .
        $nomeProduto .
        " | Bebê: " .
        $babyName .

        " | R$ " .
        number_format($preco, 2, ',', '.'). "\n";

}

// STATUS
$status = 'Pendente';

// INSERT
$sql = "

INSERT INTO pedidos (

    nome_cliente,

    whatsapp,

    email,

    produtos,

    total,

    forma_pagamento,

    status

)

VALUES (

    ?,

    ?,

    ?,

    ?,

    ?,

    ?,

    ?

)

";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

    "ssssdss",

    $nome,

    $whatsapp,

    $email,

    $produtos,

    $total,

    $forma_pagamento,

    $status

);

// EXECUTAR
if ($stmt->execute()) {

    echo json_encode([

        'success' => true,

        'id' => $stmt->insert_id

    ]);

} else {

    echo json_encode([

        'success' => false,

        'error' => $conn->error

    ]);

}

?>