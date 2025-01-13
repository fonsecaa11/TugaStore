<?php
session_start();
include('conn.php');

// Verifica se a conexão foi estabelecida
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    $_SESSION['error'] = "Erro ao aceder à base de dados.";
    header("Location: registar.php");
    exit;
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verifica se todos os campos estão preenchidos
    if (empty($nome) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Todos os campos são obrigatórios.";
        header("Location: registar.php");
        exit;
    }

    // Verifica se as senhas coincidem
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "As senhas não coincidem.";
        header("Location: registar.php");
        exit;
    }

    // Encripta a senha
    $hashed_password = sha1($password);

    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "O email já está registado.";
        header("Location: registar.php");
        exit;
    }

    // Insere o novo utilizador no banco de dados
    $insert_query = "INSERT INTO users (nome, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $nome, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registo efetuado com sucesso! Faça login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Erro ao registar. Tente novamente.";
        header("Location: registar.php");
        exit;
    }
}
?>
