<?php
  require_once '../includes/auth.php';
  require_once '../includes/funcoes.php';

  $emprestimos = lerArquivo('../data/emprestimos.txt');
  $livros      = lerArquivo('../data/livros.txt');
  $alunos      = lerArquivo('../data/alunos.txt');
  $msg         = $_GET['msg'] ?? '';



  ?>