<?php
header('Content-Type: application/json');
session_start();
include "conexaodb.php";

$ordenarPor = 'r.dia';
$ordem = 'ASC';

if (isset($_POST['periodos'])) {
    $periodos = json_decode($_POST['periodos']);
    
    if (count($periodos) > 0) {
        $queryPeriodo = " AND r.periodo IN ('" . implode("','", $periodos) . "')";
    }
}

$dia = "";
if (isset($_POST['dia']) && !empty($_POST['dia'])) {
    $dia = $mysqli->real_escape_string($_POST['dia']);
} else {
    $inicioSemana = date('Y-m-d', strtotime('monday this week'));
    $fimSemana = date('Y-m-d', strtotime('friday this week'));
    $filtroDia = "'$inicioSemana' AND '$fimSemana'";
}
                    
if (isset($_POST['ordenarPor'])) {
    $ordenarPor = $_POST['ordenarPor'];
    $ordem = $_POST['ordem'];

    switch ($ordenarPor) {
        case 'quant':
            $ordenarPor = 'r.quant';
            break;
        case 'semanas':
            $ordenarPor = 'r.semanas';
            break;
        case 'horarioRetirada':
            $ordenarPor = 'r.horarioRetirada';
            break;
    }
}

if($dia != "")
{
$sql = "SELECT r.*, u.nome, u.email 
        FROM requisicao r 
        JOIN usuarios u ON r.id_usuario = u.id WHERE dia = '$dia' ORDER BY dia DESC," 
        . (isset($queryPeriodo) ? $queryPeriodo : '') . 
        " ORDER BY $ordenarPor $ordem";
}else{
    $sql = "SELECT r.*, u.nome, u.email 
        FROM requisicao r 
        JOIN usuarios u ON r.id_usuario = u.id WHERE r.dia BETWEEN $filtroDia" 
        . (isset($queryPeriodo) ? $queryPeriodo : '') . 
        " ORDER BY dia DESC, $ordenarPor $ordem";
}
 
        error_log("Consulta SQL: $sql");    
$result = $mysqli->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Erro na consulta: ' . $mysqli->error]);
    exit;
}

$requisicoes = []; 

while ($user_data = mysqli_fetch_assoc($result)) {
    $requisicoes[] = [
        'nome' => $user_data['nome'],
        'email' => $user_data['email'],
        'quant' => $user_data['quant'],
        'dia' => date('d/m/Y', strtotime($user_data['dia'])),
        'horarioRetirada' => $user_data['horarioRetirada'],
        'horarioDevolucao' => $user_data['horarioDevolucao'],
        'semanas' => $user_data['semanas'],
        'materia' => $user_data['materia'],
        'observacoes' => $user_data['observacoes']
    ];
}

if (empty($requisicoes)) {
    echo json_encode(['error' => 'Nenhuma requisição encontrada']);
    exit;
}

echo json_encode(['requisicoes' => $requisicoes]);
?>