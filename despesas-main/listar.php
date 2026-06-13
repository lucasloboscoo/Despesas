<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Empréstimos — Biblioteca</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>


  <?php
  require_once '../includes/auth.php';
  require_once '../includes/funcoes.php';


  $livros      = lerArquivo('../data/livros.txt');
  $alunos      = lerArquivo('../data/alunos.txt');
  $msg         = $_GET['msg'] ?? '';

  if(isset($_GET) && isset($_GET["acao"]) && $_GET["acao"]== "remover"){
    removerArquivo('../data/emprestimos.txt',0,$_GET["id"]);

  }
  $emprestimos = lerArquivo('../data/emprestimos.txt');
  ?>


<div class="app-shell">

  <!-- ════ SIDEBAR ════ -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <span class="brand-icon">📚</span>
      <h1>Biblioteca</h1>
      <p>Sistema de Gestão</p>
    </div>
    <nav class="sidebar-nav">
      <p class="nav-section-label">Geral</p>
      <a href="../index.php" class="nav-item"><span class="nav-icon">🏠</span> Painel</a>
      <p class="nav-section-label">Cadastros</p>
      <a href="../livros/listar.php" class="nav-item"><span class="nav-icon">📖</span> Livros</a>
      <a href="../alunos/listar.php" class="nav-item"><span class="nav-icon">🎓</span> Alunos</a>
      <a href="listar.php" class="nav-item active"><span class="nav-icon">📋</span> Empréstimos</a>
    </nav>
    <div class="sidebar-user">
      <div class="user-avatar">AD</div>
      <div class="user-info">
        <div class="user-name">Admin</div>
        <div class="user-role">Bibliotecário</div>
      </div>
      <a href="../login.php" class="btn-logout" title="Sair">⏻</a>
    </div>
  </aside>

  <!-- ════ MAIN ════ -->
  <main class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">📋 Empréstimos</div>
        <div class="topbar-sub">Controle de empréstimos e devoluções</div>
      </div>
      <div class="topbar-actions">
        <a href="cadastrar.php" class="btn btn-primary">＋ Novo empréstimo</a>
      </div>
    </div>

    <div class="content">

    
      <?php if ($msg === 'cadastrado'): ?>
        <div class="alert alert-success">✓ Empréstimo registrado com sucesso!</div>
      <?php elseif ($msg === 'alterado'): ?>
        <div class="alert alert-success">✓ Empréstimo atualizado com sucesso!</div>
      <?php elseif ($msg === 'removido'): ?>
        <div class="alert alert-success">✓ Empréstimo removido com sucesso!</div>
      <?php endif; ?>
    

      <div class="table-header">
  <h2>Empréstimos</h2>

  <span class="table-count">
    <?= count($emprestimos) ?> registros
  </span>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Livro</th>
        <th>Aluno</th>
        <th>Matrícula</th>
        <th>Empréstimo</th>
        <th>Devolução</th>
        <th>Situação</th>
        <th>Ações</th>
      </tr>
    </thead>

    <tbody>

      <?php if (!empty($emprestimos) && is_array($emprestimos)): ?>
        <?php foreach ($emprestimos as $index => $emp): ?>
          <?php
            $livro = null;
            foreach ($livros as $item) {
                if (($emp[0] ?? '') === ($item[0] ?? '')) {
                    $livro = $item;
                    break;
                }
            }

            $aluno = null;
            foreach ($alunos as $item) {
                if (($emp[1] ?? '') === ($item[1] ?? '')) {
                    $aluno = $item;
                    break;
                }
            }

            $situacao = 'Em andamento';
            if (!empty($emp[3]) && strtotime($emp[3]) < strtotime(date('Y-m-d'))) {
                $situacao = 'Atrasado';
            }
          ?>

          <tr>
            <td class="td-mono"><?= htmlspecialchars($livro[1] ?? $livro[0] ?? '') ?></td>
            <td class="td-mono"><?= htmlspecialchars($aluno[0] ?? '') ?></td>
            <td class="td-main"><?= htmlspecialchars($emp[1] ?? '') ?></td>
            <td><?= htmlspecialchars($emp[2] ?? '') ?></td>
            <td style="text-align:center"><?= htmlspecialchars($emp[3] ?? '') ?></td>
            <td><?= htmlspecialchars($situacao) ?></td>
            <td class="td-actions">
              <a href="alterar.php?idx=<?= $index ?>" class="btn btn-sm btn-edit">Editar</a>
              <a href="?acao=remover&id=<?= urlencode($emp[0] ?? '') ?>"
                 onclick="return confirm('Deseja remover este empréstimo?')"
                 class="btn btn-sm btn-danger">Remover</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" style="text-align: center;">Nenhum empréstimo encontrado.</td>
        </tr>
      <?php endif; ?>

    </tbody>
  </table>
</div>

    </div>
  </main>
</div>

</body>
</html>
