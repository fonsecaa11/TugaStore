<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Conexão com a base de dados
include ('conn.php');

// Excluir utilizador
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = $id_user ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Usuários</title>
    <link rel="stylesheet" href="usuarios_style.css">
</head>
<body>
    <h1>Gerir Usuários</h1>
    <h2>Lista de Usuários</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT id, nome, email FROM users");
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['username'] . " (" . $row['email'] . ")" . 
                 " <a href='gerir_usuarios.php?delete=" . $row['id'] . "'>Excluir</a></li>";
        }
        ?>
    </ul>
</body>
</html>
