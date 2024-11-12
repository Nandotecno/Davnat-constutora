<?php
header('Content-Type: application/json');
session_start();
include "conexaodb.php";

if (isset($_POST['dia'], $_POST['periodo'], $_POST['horarioRetirada'], $_POST['horarioDevolucao'])) {
    $dia = $mysqli->real_escape_string($_POST['dia']);
    $periodo = $mysqli->real_escape_string($_POST['periodo']);
    $horarioDevolucao = str_pad($_POST['horarioDevolucao'], 5, "0", STR_PAD_LEFT);
    $horarioRetirada = str_pad($_POST['horarioRetirada'], 5, "0", STR_PAD_LEFT);

    $totalNotebooks = 8;

    $sql_count = "SELECT SUM(quant) AS total FROM requisicao 
                  WHERE dia = '$dia' 
                  AND (horarioRetirada <= '$horarioRetirada' 
                  AND horarioDevolucao > '$horarioRetirada')";
    $result = $mysqli->query($sql_count);

    if (!$result) {
        echo json_encode(['error' => 'Erro na consulta SQL: ' . $mysqli->error]);
        exit;
    }

    $row = $result->fetch_assoc();
    $quantidadeAgendada = $row['total'] ? (int)$row['total'] : 0;

    $quantidadeDisponivel = $totalNotebooks - $quantidadeAgendada;
    $quantidadeDisponivel = max(0, $quantidadeDisponivel); 

    $sql_requisicoes = "SELECT r.*, u.nome, u.email FROM requisicao r 
                        JOIN usuarios u ON r.id_usuario = u.id 
                        WHERE dia = '$dia' 
                        ORDER BY r.id DESC";
    $result_requisicoes = $mysqli->query($sql_requisicoes);

    if (!$result_requisicoes) {
        echo json_encode(['error' => 'Erro na consulta SQL: ' . $mysqli->error]);
        exit;
    }

    $requisicoes = [];
    while ($user_data = $result_requisicoes->fetch_assoc()) {
        $requisicoes[] = [
            'nome' => $user_data['nome'],
            'email' => $user_data['email'],
            'quant' => $user_data['quant'],
            'dia' => date('d/m/Y', strtotime($user_data['dia'])),
            'horarioRetirada' => $user_data['horarioRetirada'],
            'horarioDevolucao' => $user_data['horarioDevolucao'],
            'semanas' => $user_data['semanas'],
        ];
    }
    echo json_encode([
        'quantidadeDisponivel' => $quantidadeDisponivel,
        'requisicoes' => $requisicoes 
    ]);
}

