<?php
session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

// ✅ USAR OS DADOS MOCK EM VEZ DO BANCO REAL
require_once 'mock_data.php';
$usuarios = MockData::get('usuarios');

// Busca o usuário no mock
$usuario = null;
foreach ($usuarios as $u) {
    if ($u['email'] === $email) {
        $usuario = $u;
        break;
    }
}

if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION['usuario_id']   = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['perfil']       = $usuario['perfil_id'] == 1 ? 'cliente' : 'funcionario';

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