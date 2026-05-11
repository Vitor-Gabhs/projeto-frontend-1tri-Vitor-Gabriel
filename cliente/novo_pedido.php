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

$pecas = MockData::get('pecas');
$pedidos  = MockData::pedidosDetalhados();

?>

<div class="area_pedido_novo">
      <p class="titulo_pedido_novo">Novo Pedido</p>
      <form action="pedidos.php" method="POST">
        <label>selecione as peças:</label>
        <select name="peca_id" required>
            <?php foreach ($pecas as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['nome'] ?> - R$<?= $p['preco_unitario'] ?></option>
            <?php endforeach; ?>
        </select> 
        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="1" value="1" required>
        <button type="submit" name="btn_fechar_pedido">Finalizar Pedido</button>
    </form>
</div>