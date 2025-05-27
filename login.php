<?php
session_start();

// Conexão com o banco de dados (ajuste conforme seu ambiente)
$host = 'localhost';
$db = 'login_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Recebe os dados do formulário
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($usuario) || empty($senha)) {
    die("Por favor, preencha todos os campos.");
}

// Consulta segura com prepared statements
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);
$usuarioData = $stmt->fetch();

if ($usuarioData && password_verify($senha, $usuarioData['senha'])) {
    // Login bem-sucedido
    $_SESSION['usuario'] = $usuarioData['usuario'];
    header("Location: painel.php"); // redireciona para área protegida
    exit;
} else {
    // Login falhou
    echo "Usuário ou senha incorretos.";
}
?>
