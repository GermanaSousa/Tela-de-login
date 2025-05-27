<?php
require 'conexao.php';

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($usuario) || empty($senha)) {
  die("Preencha todos os campos.");
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

try {
  $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
  $stmt->execute([$usuario, $hash]);
  echo "Cadastro realizado com sucesso! <a href='index.html'>Fazer login</a>";
} catch (PDOException $e) {
  if ($e->getCode() == 23000) {
    echo "Usuário já existe. <a href='cadastro.html'>Tente outro</a>";
  } else {
    echo "Erro: " . $e->getMessage();
  }
}
?>
