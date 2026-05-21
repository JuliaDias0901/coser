<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "coser_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function getProdutos($conn) {

    $sql = "SELECT * FROM produtos ORDER BY id DESC";

    $result = $conn->query($sql);

    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
