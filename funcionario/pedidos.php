<?php
session_start();
require_once '../mock_data.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

$caminhoCliente = '../cliente/mock_store.json';
$caminhoFuncionario = __DIR__ . '/pedidos_alterados.json';

$pedidosFinais = MockData::get('pedidos');

if (file_exists($caminhoCliente)) {
    $jsonCompleto = json_decode(file_get_contents($caminhoCliente), true);
    if (isset($jsonCompleto['pedidos']) && is_array($jsonCompleto['pedidos'])) {
        foreach ($jsonCompleto['pedidos'] as $p) {
            $pedidosFinais[$p['id']] = $p;
        }
    }
}

if (file_exists($caminhoFuncionario)) {
    $dadosFunc = json_decode(file_get_contents($caminhoFuncionario), true);
    if (is_array($dadosFunc)) {
        $pedidosFinais = array_replace($pedidosFinais, $dadosFunc);
    }
}

MockData::salvar('pedidos', array_values($pedidosFinais));
$pedidos = MockData::pedidosDetalhados();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #e6d5bc !important; }
        .container { margin-top: 20px; border-radius: 15px; }
    </style>
</head>
<body>
    <div class="titulos-LOL text-center my-4">
        <h1 class="titulo-principal">LOL</h1>
        <h2 class="titulo-menor">Lavanderia On-line</h2>
    </div>
    <div class="container bg-white p-4 shadow-sm">
        <h2 class="mb-4">Painel de Controle - Lavanderia</h2>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Status Atual</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td>#<?= $p['id'] ?></td>
                        <td><?= $p['cliente_nome'] ?? 'Cliente #' . $p['cliente_id'] ?></td>
                        <td>R$ <?= number_format($p['valor_total'], 2, ',', '.') ?></td>
                        <td><span class="badge bg-secondary"><?= $p['status_nome'] ?></span></td>
                        <td>
                            <form action="processar_status.php" method="POST">
                                <input type="hidden" name="pedido_id" value="<?= $p['id'] ?>">
                                <?php if ($p['status_id'] == 1): ?>
                                    <input type="hidden" name="novo_status_id" value="2">
                                    <button type="submit" class="btn btn-sm btn-primary">Aceitar Pedido</button>
                                <?php elseif ($p['status_id'] == 2): ?>
                                    <input type="hidden" name="novo_status_id" value="3">
                                    <button type="submit" class="btn btn-sm btn-info">Iniciar Lavagem</button>
                                <?php elseif ($p['status_id'] == 3): ?>
                                    <input type="hidden" name="novo_status_id" value="4">
                                    <button type="submit" class="btn btn-sm btn-warning">Finalizar Lavagem</button>
                                <?php elseif ($p['status_id'] == 4): ?>
                                    <input type="hidden" name="novo_status_id" value="5">
                                    <button type="submit" class="btn btn-sm btn-success">Entregar ao Cliente</button>
                                <?php else: ?>
                                    <span class="text-muted small">Concluído</span>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>