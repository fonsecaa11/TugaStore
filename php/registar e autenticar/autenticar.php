<?php
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('conn.php');

// Verifica se a conexão foi estabelecida
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    echo "Erro ao aceder à base de dados: $e";
}

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    // Verifica se os campos foram preenchidos
    if (empty($username) || empty($password)) {
        die("Por favor, preencha todos os campos.");
    }

    // Consulta SQL (insegura - apenas para demonstração)
    $login = "SELECT * FROM users WHERE nome = '$username' AND password = '$password'";
    $result = $conn->query($login);

    if (!$result) {
        die("Erro ao executar a consulta: " . $conn->error);
    }

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Configura a sessão
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['nome'];
        header("Location: backoffice.php");
        exit;
    } else {
        $_SESSION['error'] = "Utilizador ou senha incorretos.";
        header("Location: login.php");
        exit;
    }
}
?>