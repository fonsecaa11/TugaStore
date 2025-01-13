<?php
session_start();
include('conn.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_carrinho = $_POST['id_carrinho'];
    
    // Remove o produto do carrinho
    $query = "DELETE FROM carrinho WHERE id_carrinho = '$id_carrinho'";
    $stmt = $conn->prepare($query);
    
    header("Location: carrinho.php");
    exit;
}
// Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
