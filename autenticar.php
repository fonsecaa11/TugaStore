<?php
session_start();
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Depuração: Verifique se os valores foram recebidos
    if (empty($username) || empty($password)) {
        die("Por favor, preencha todos os campos.");
    }

    // Consulta SQL
    $query = "SELECT * FROM users WHERE nome = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifique a senha
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            header("Location: backoffice.php");
            exit;
        } else {
            echo "Password incorreta.";
        }
    } else {
        echo "Utilizador não encontrado.";
    }
} else {
    echo "Método inválido.";
}
?>
