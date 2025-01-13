<?php
session_start();
include('conn.php');

// Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utilizador = $_SESSION['user_id'];
    $id_produto = $_POST['id_produto'];

    // Remove o produto do carrinho
    $query = "DELETE FROM carrinho WHERE id_utilizador = ? AND id_produto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_utilizador, $id_produto);
    $stmt->execute();

    header("Location: carrinho.php");
    exit;
}
?>
