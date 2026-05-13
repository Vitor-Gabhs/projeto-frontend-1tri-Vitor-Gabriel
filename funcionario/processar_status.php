<?php
session_start();
require_once '../mock_data.php';

if ($_SESSION['perfil'] !== 'funcionario' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pedidos.php');
    exit;
}

$pedidoId = (int)$_POST['pedido_id'];
$novoStatusId = (int)$_POST['novo_status_id'];
$caminhoCliente = '../cliente/mock_store.json';
$caminhoFuncionario = __DIR__ . '/pedidos_alterados.json';

$pedidos = MockData::get('pedidos');
if (file_exists($caminhoCliente)) {
    $jsonC = json_decode(file_get_contents($caminhoCliente), true);
    if (isset($jsonC['pedidos'])) {
        foreach($jsonC['pedidos'] as $p) $pedidos[$p['id']] = $p;
    }
}
if (file_exists($caminhoFuncionario)) {
    $dadosF = json_decode(file_get_contents($caminhoFuncionario), true);
    if (is_array($dadosF)) $pedidos = array_replace($pedidos, $dadosF);
}

$todosStatus = MockData::get('status_pedido');

foreach ($pedidos as &$p) {
    if ((int)$p['id'] === $pedidoId) {
        $statusAtualId = (int)$p['status_id'];
        $atualObj = null; $novoObj = null;
        foreach ($todosStatus as $s) {
            if ((int)$s['id'] === $statusAtualId) $atualObj = $s;
            if ((int)$s['id'] === $novoStatusId) $novoObj = $s;
        }
        if ($atualObj && $novoObj && (int)$novoObj['sequencia'] === (int)$atualObj['sequencia'] + 1) {
            $p['status_id'] = $novoStatusId;
            $p['atualizado_em'] = date('Y-m-d H:i:s');
            file_put_contents($caminhoFuncionario, json_encode($pedidos, JSON_PRETTY_PRINT));
        }
        break;
    }
}

header('Location: pedidos.php');
exit;