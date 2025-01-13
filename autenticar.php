<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('conn.php');

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    // Consulta SQL
    $login = "SELECT * FROM users WHERE nome = '$username' AND password = '$password'";
    $result = $conn->query($login);

    if (!$result) {
        die("Erro ao executar a consulta: " . $conn->error);
    }

    // Verifica se o utilizador foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Configura a sessão
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['nome'];
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];

        // Redireciona com base no role
        if ($user['role'] == 1) {
            header("Location: backoffice.php");
        } elseif ($user['role'] == 2) {
            header("Location: catalogo.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Utilizador ou senha incorretos.";
        header("Location: login.php");
        exit;
    }
}

// Verifica se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
