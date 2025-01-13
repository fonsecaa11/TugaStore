<?php

session_start();

// Inclui o arquivo de conexão com a base de dados
include('conn.php');


// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = intval($_POST['id_produto']);
    $tamanho_id = intval($_POST['id_tamanho']);
    $id_user = $_SESSION['user_id'];

    $sql = "SELECT * FROM produto_tamanho WHERE produto_id = '$produto_id' AND tamanho_id = '$tamanho_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtém o id_produto_tamanho correspondente
        $produto_tamanho = $result->fetch_assoc();
        $id_produto_tamanho = $produto_tamanho['id_produto_tamanho'];

        // Insere no carrinho
        $sql_insert = "INSERT INTO carrinho (user_id, produto_tamanho_id) VALUES ('$id_user', '$id_produto_tamanho')";
        $stmt_insert = $conn->prepare($sql_insert);

        if ($stmt_insert->execute()) {
            $_SESSION['success'] = "Produto adicionado ao carrinho com sucesso!";
            header("Location: detalhes.php?id_produto=$produto_id");
            exit;
        } else {
            $_SESSION['error'] = "Erro ao adicionar o produto ao carrinho. Tente novamente.";
            header("Location: detalhes.php?id_produto=$produto_id");
            exit;
        }
    } else {
        $_SESSION['error'] = "O tamanho selecionado não está disponível para este produto.";
        header("Location: detalhes.php?id_produto=$produto_id");
        exit;
    }
} else {
    // Redireciona caso o acesso seja inválido
    header("Location: catalogo.php");
    exit;
}

// Verifica se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "É necessário fazer login para adicionar ao carrinho.";
    header("Location: login.php");
    exit;
}
