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

    // Verifica se o produto já está no carrinho
    $query = "SELECT quantidade FROM carrinho WHERE id_utilizador = ? AND id_produto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_utilizador, $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Atualiza a quantidade
        $query = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE id_utilizador = ? AND id_produto = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_utilizador, $id_produto);
        $stmt->execute();
    } else {
        // Insere um novo produto no carrinho
        $query = "INSERT INTO carrinho (id_utilizador, id_produto, quantidade) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_utilizador, $id_produto);
        $stmt->execute();
    }

    header("Location: carrinho.php");
    exit;
}
?>
