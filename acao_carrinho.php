<?php
session_start();
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o ID do carrinho está presente
    if (isset($_POST['id_carrinho']) && is_numeric($_POST['id_carrinho'])) {
        $id_carrinho = $_POST['id_carrinho'];
    } else {
        die("ID do carrinho inválido.");
    }

    // Caso seja uma atualização
    if (isset($_POST['atualizar'])) {
        if (isset($_POST['quantidade']) && is_numeric($_POST['quantidade']) && $_POST['quantidade'] > 0) {
            $nova_quantidade = $_POST['quantidade'];

            // Atualizar a quantidade no banco de dados
            $sql = "UPDATE carrinho SET quantidade = '$nova_quantidade' WHERE id_carrinho = '$id_carrinho'";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute()) {
                header("Location: carrinho.php"); 
                exit;
            } else {
                die("Erro ao atualizar o carrinho: " . $conn->error);
            }
        } else {
            die("Quantidade inválida.");
        }
    }

    // Caso seja uma remoção
    if (isset($_POST['remover'])) {
        // Remover o item do banco de dados
        $sql = "DELETE FROM carrinho WHERE id_carrinho = '$id_carrinho'";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            header("Location: carrinho.php"); 
            exit;
        } else {
            die("Erro ao remover o item do carrinho: " . $conn->error);
        }
    }
}
// Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
