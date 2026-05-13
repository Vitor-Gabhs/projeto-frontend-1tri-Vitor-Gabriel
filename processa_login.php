<?php
session_start();

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login.php?erro=2');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

require_once __DIR__ . '/mock_data.php';
$usuarios = MockData::get('usuarios');

$usuario = null;
foreach ($usuarios as $u) {
    if (strtolower($u['email']) === strtolower($email)) {
        $usuario = $u;
        break;
    }
}

$senhaOk = $usuario ? password_verify($senha, $usuario['senha']) : false;

if ($usuario && $senhaOk) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['perfil'] = $usuario['perfil_id'] == 1 ? 'cliente' : 'funcionario';

    if ($_SESSION['perfil'] === 'funcionario') {
        header('Location: funcionario/pedidos.php');
    } else {
        header('Location: cliente/pedidos.php');
    }
    exit;
} else {
    header('Location: login.php?erro=1');
    exit;
}