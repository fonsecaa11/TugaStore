<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice</title>
</head>
<body>
    <h1>Bem-vindo ao Backoffice, <?php echo $_SESSION['username']; ?>!</h1>
    <nav>
        <ul>
            <li><a href="gerir_produtos.php">Gerir Produtos</a></li>
            <li><a href="gerir_usuarios.php">Gerir Usuários</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
