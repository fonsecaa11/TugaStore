<?php

session_start();

// Inclui o arquivo de conexão com a base de dados
include('conn.php');


// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = intval($_POST['id_produto']);
    $tamanho_id = intval($_POST['id_tamanho']);
    $id_user = $_SESSION['user_id'];

    // Obter o id_produto_tamanho correspondente
    $sql = "SELECT * FROM produto_tamanho WHERE produto_id = '$produto_id' AND tamanho_id = '$tamanho_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produto_tamanho = $result->fetch_assoc();
        $id_produto_tamanho = $produto_tamanho['id_produto_tamanho'];

        // Verificar se o item já está no carrinho
        $sql_carrinho = "SELECT * FROM carrinho WHERE user_id = '$id_user' AND produto_tamanho_id = '$id_produto_tamanho'";
        $result_carrinho = $conn->query($sql_carrinho);

        if ($result_carrinho->num_rows > 0) {
            // Produto já está no carrinho, incrementar a quantidade
            $item_carrinho = $result_carrinho->fetch_assoc();
            $id_carrinho = $item_carrinho['id_carrinho'];
            $nova_quantidade = $item_carrinho['quantidade'] + 1;

            $sql_atualizar = "UPDATE carrinho SET quantidade = '$nova_quantidade' WHERE id_carrinho = '$id_carrinho'";
            if ($conn->query($sql_atualizar)) {
                $_SESSION['success'] = "Quantidade atualizada no carrinho com sucesso!";
                header("Location: carrinho.php");
                exit;
            } else {
                $_SESSION['error'] = "Erro ao atualizar a quantidade no carrinho.";
                header("Location: detalhes.php?id_produto=$produto_id");
                exit;
            }
        } else {
            // Produto não está no carrinho, inserir um novo item
            $sql_insert = "INSERT INTO carrinho (user_id, produto_tamanho_id, quantidade) VALUES ('$id_user', '$id_produto_tamanho', 1)";
            if ($conn->query($sql_insert)) {
                $_SESSION['success'] = "Produto adicionado ao carrinho com sucesso!";
                header("Location: carrinho.php");
                exit;
            } else {
                $_SESSION['error'] = "Erro ao adicionar o produto ao carrinho. Tente novamente.";
                header("Location: detalhes.php?id_produto=$produto_id");
                exit;
            }
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
