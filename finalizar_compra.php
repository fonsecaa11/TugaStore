<?php
session_start();
include('conn.php');

// Verifica se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "É necessário fazer login para finalizar a compra.";
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// Obtém os itens do carrinho
$sql_carrinho = "
    SELECT 
        c.quantidade, 
        p.nome AS nome_produto, 
        t.descricao AS tamanho_produto, 
        p.preco * c.quantidade AS valor
    FROM 
        carrinho c
    INNER JOIN 
        produto_tamanho pt ON c.produto_tamanho_id = pt.id_produto_tamanho
    INNER JOIN 
        produto p ON pt.produto_id = p.id_produto
    INNER JOIN 
        tamanho t ON pt.tamanho_id = t.id_tamanho
    WHERE 
        c.user_id = '$id_user'
";
$stmt_carrinho = $conn->prepare($sql_carrinho);
$stmt_carrinho->execute();
$result_carrinho = $stmt_carrinho->get_result();

if ($result_carrinho->num_rows > 0) {
    // Inicia a transação
    $conn->begin_transaction();

    try {
        // Insere os itens na tabela `order`
        echo $sql_insert_order = "
            INSERT INTO order (user_id, nome_produto, tamanho_produto, quantidade, valor)
            VALUES (?, ?, ?, ?, ?)
        ";
        $stmt_order = $conn->prepare($sql_insert_order);

        while ($row = $result_carrinho->fetch_assoc()) {
            $stmt_order->bind_param(
                "issid", 
                $id_user, 
                $row['nome_produto'], 
                $row['tamanho_produto'], 
                $row['quantidade'], 
                $row['valor']
            );
            $stmt_order->execute();
        }

        // Apaga os itens do carrinho
        $sql_delete_carrinho = "DELETE FROM carrinho WHERE user_id = '$id_user'";
        $stmt_delete = $conn->prepare($sql_delete_carrinho);
        $stmt_delete->execute();

        // Confirma a transação
        $conn->commit();

        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Erro ao finalizar a compra. Tente novamente.";
        header("Location: carrinho.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Seu carrinho está vazio.";
    header("Location: carrinho.php");
    exit;
}
?>
