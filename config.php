<?php

$host = "localhost";
$banco = "instagram_db";
$usuario = "root";
$senha = "";

try {
    $con = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "erro" => "Erro na conexão com o banco de dados"
    ]);
    exit;
}

?>