<?php
session_start();  // sempre na primeira linha quando usa sessão

// Pega o que veio do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Busca o usuário no banco (ou no mock)
require_once 'conexao.php';
$pdo = getConexao();

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
$stmt->execute([':email' => $email]);
$usuario = $stmt->fetch();

// Verifica se existe e se a senha bate
if ($usuario && password_verify($senha, $usuario['senha'])) {
    // Login OK — salva na sessão e manda para a área certa
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
    // Login falhou — volta com mensagem de erro
    header('Location: login.php?erro=1');
    exit;
}