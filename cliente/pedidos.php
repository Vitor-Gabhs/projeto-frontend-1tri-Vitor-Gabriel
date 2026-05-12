<?php
session_start();
require_once '../mock_data.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
} else if ($_SESSION['perfil'] === 'funcionario') {
    header('location: ../funcionario/pedidos.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_fechar_pedido'])) {
    $idEscolhido = $_POST['peca_id'];
    $qtd = (int) $_POST['quantidade'];
    $peca = MockData::encontrar('pecas', $idEscolhido);

    if ($peca) {
        $total = $peca['preco_unitario'] * $qtd;
        $pedidos = MockData::get('pedidos');
        $pedidos[] = [
            'id' => MockData::proximoId('pedidos'),
            'cliente_id' => $_SESSION['usuario_id'],
            'status_id' => 1, // ABERTO
            'valor_total' => $total,
            'criado_em' => date('Y-m-d H:i:s'),
            'atualizado_em' => date('Y-m-d H:i:s'),
        ];
        MockData::salvar('pedidos', $pedidos);
    }
}

$meusPedidos = MockData::pedidosDetalhados();

if (isset($_POST['btn_fechar_pedido'])) {
    // 1. Pega TODOS os pedidos que já existem no "banco" primeiro
    $todosOsPedidosQueJaExistem = MockData::get('pedidos');

    // 2. Busca os dados da peça e calcula
    $peca = MockData::encontrar('pecas', $_POST['peca_id']);
    $total = $peca['preco_unitario'] * $_POST['quantidade'];

    // 3. Monta o NOVO pedido
    $novoPedido = [
        'id'            => MockData::proximoId('pedidos'),
        'cliente_id'    => $_SESSION['usuario_id'],
        'status_id'     => 1, 
        'valor_total'   => $total,
        'criado_em'     => date('Y-m-d H:i:s'),
        'atualizado_em' => date('Y-m-d H:i:s'),
    ];

    // 4. ADICIONA o novo ao final da lista que já existia (o segredo é o []= )
    $todosOsPedidosQueJaExistem[] = $novoPedido;

    // 5. SALVA a lista completa de volta
    MockData::salvar('pedidos', $todosOsPedidosQueJaExistem);
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pagina Inicial Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../css/style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="titulos-LOL">
        <h1 class="titulo-principal">LOL</h1>
        <h2 class="titulo-menor">Lavanderia On-line</h2>
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Meus Pedidos</h2>
                <a href="novo_pedido.php" class="btn btn-primary">+ Novo Pedido</a>
            </div>

            <div class="row">
                <?php foreach ($meusPedidos as $p): ?>
                    <?php if ($p['cliente_id'] == $_SESSION['usuario_id']): ?>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header d-flex justify-content-between">
                                    <span class="fw-bold">Pedido #<?= $p['id'] ?></span>
                                    <span class="badge bg-info text-dark"><?= $p['status_nome'] ?></span>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1 text-muted small">Data: <?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?>
                                    </p>
                                    <h4 class="card-title text-primary">R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                                    </h4>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <small class="text-muted">Atualizado em:
                                        <?= date('d/m/Y H:i', strtotime($p['atualizado_em'])) ?></small>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

</body>

</html>