<?php
require_once 'conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// C - CADASTRAR MENSAGEM
if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $assunto = trim($_POST['assunto']);
    $mensagem = trim($_POST['mensagem']);

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
        $stmt = $pdo->prepare("INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $assunto, $mensagem]);
    }
    header("Location: mensagens.php");
    exit();
}

// U - EDITAR MENSAGEM
if ($acao === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $assunto = trim($_POST['assunto']);
    $mensagem = trim($_POST['mensagem']);

    if ($id > 0 && !empty($nome) && !empty($email)) {
        $stmt = $pdo->prepare("UPDATE mensagens SET nome = ?, email = ?, assunto = ?, mensagem = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $assunto, $mensagem, $id]);
    }
    header("Location: mensagens.php");
    exit();
}

// D - EXCLUIR MENSAGEM
if ($acao === 'excluir') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM mensagens WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: mensagens.php");
    exit();
}
?>