<?php

header("Content-Type: application/json;charset=utf-8");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: GET, POST, PUT, DELETE");

require "config.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

$corpo = json_decode(file_get_contents("php://input"), true) ?? [];

function teste(){
    echo json_encode(["mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}

function createUsuario($con, $dados){
 $stmt = $con->prepare(
    "INSERT INTO usuarios (nome, username, email, senha)
    VALUES (?,?,?,?)"
);
$stmt->execute([$dados["nome"],
                $dados["username"],
                $dados["email"],
                $dados["senha"]]);
http_response_code(201);
echo json_encode(
    ["mensagem" => "Usuário registrado com sucesso!",
    "id" => $con->lastInsertId()]
    );
}
function readUsuario($con){
    $stmf = $con->query("SELECT * FROM usuarios");
    echo json_encode(
        $stmf->fetchAll(PDO::FETCH_ASSOC)
    );
}
function updateUsuario($con, $id, $dados){
    $stmt = $con-> prepare(
        "UPDATE usuarios SET nome = ?, username = ?, email = ?, senha = ? WHERE id_usuario = ?"
    );
    $stmt -> execute([ $dados["nome"],
                       $dados["username"],
                       $dados["email"],
                       $dados["senha"],
                       $id]);
    echo json_encode(["mensagem" => "Usuário alterado com sucesso"]);
}

function deleteUsuario($con,$id){
    $stmt= $con->prepare("DELETE FROM usuarios WHERE Id_usuario = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Usuário removido com sucesso!"]);
}

if ($rota === "usuarios") {
    switch($metodo){
        case "POST":
            createUsuario($con, $corpo);
            break;
        case "GET":
            readUsuario($con);
            break;
        case "PUT":
            updateUsuario($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteUsuario($con,$_GET["id"]);
            break;
        default:
        teste();
    }

}