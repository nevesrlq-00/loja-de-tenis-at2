<?php
require_once 'conexao.php';

// R - LISTAR REGISTROS
$stmt = $pdo->query("SELECT * FROM mensagens ORDER BY data_envio DESC");
$mensagens = $stmt->fetchAll();

// Se for para editar um item específico
$editando = false;
$msgEdit = null;
if (isset($_GET['editar_id'])) {
    $idEdit = (int)$_GET['editar_id'];
    $stmtEdit = $pdo->prepare("SELECT * FROM mensagens WHERE id = ?");
    $stmtEdit->execute([$idEdit]);
    $msgEdit = $stmtEdit->fetch();
    if ($msgEdit) $editando = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador - Mensagens</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">👟 SneakerStore (Admin)</div>
        <nav>
            <a href="index.html">Home</a>
            <a href="produtos.html">Produtos</a>
            <a href="carrinho.html">Carrinho</a>
            <a href="contato.html">Contato</a>
            <a href="mensagens.php" class="active">Painel Admin</a>
        </nav>
    </header>

    <main>
        <?php if ($editando): ?>
            <!-- Form de Edição -->
            <div class="form-container">
                <h2>Editar Mensagem #<?= $msgEdit['id'] ?></h2>
                <br>
                <form action="processa_contato.php" method="POST">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id" value="<?= $msgEdit['id'] ?>">

                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($msgEdit['nome']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($msgEdit['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Assunto:</label>
                        <input type="text" name="assunto" value="<?= htmlspecialchars($msgEdit['assunto']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Mensagem:</label>
                        <textarea name="mensagem" rows="4" required><?= htmlspecialchars($msgEdit['mensagem']) ?></textarea>
                    </div>
                    <button type="submit" class="btn">Salvar Alterações</button>
                    <a href="mensagens.php" class="btn btn-danger">Cancelar</a>
                </form>
            </div>
            <br>
        <?php endif; ?>

        <h2>Mensagens / Suporte Recebidos</h2>
        <div class="tabela-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Assunto</th>
                        <th>Mensagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($mensagens) > 0): ?>
                        <?php foreach ($mensagens as $msg): ?>
                            <tr>
                                <td><?= $msg['id'] ?></td>
                                <td><?= htmlspecialchars($msg['nome']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= htmlspecialchars($msg['assunto']) ?></td>
                                <td><?= htmlspecialchars($msg['mensagem']) ?></td>
                                <td>
                                    <a href="mensagens.php?editar_id=<?= $msg['id'] ?>" class="btn btn-warning" style="padding:0.3rem 0.6rem; font-size:0.8rem; text-decoration:none;">Editar</a>
                                    <a href="processa_contato.php?acao=excluir&id=<?= $msg['id'] ?>" onclick="return confirm('Deseja excluir este registro?')" class="btn btn-danger" style="padding:0.3rem 0.6rem; font-size:0.8rem; text-decoration:none;">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhuma mensagem cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 SneakerStore - Todos os direitos reservados.</p>
    </footer>
</body>
</html>