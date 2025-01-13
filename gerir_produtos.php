<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Conexão com a base de dados
include ('conn.php');

// Inserir produtos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO produto (nome, preco, descricao) VALUES ($nome, $preco, $descricao)";
    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("sds", $nome, $preco, $descricao);

    if ($stmt->execute()) {
        echo "Produto adicionado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }
}

// Remover um produto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM produto WHERE id = $id_produto";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Produto excluído com sucesso!";
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
    <title>Gerir Produtos</title>
    <link rel="stylesheet" href="style/produtos_style.css">
</head>
<body>
    <h1>Gerir Produtos</h1>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome do Produto" required>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <textarea name="descricao" placeholder="Descrição"></textarea>
        <button type="submit" name="add_product">Adicionar Produto</button>
    </form>

    <h2>Lista de Produtos</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM produto");
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['nome'] . " - R$" . $row['preco'] . 
                 " <a href='gerir_produtos.php?delete=" . $row['id'] . "'>Excluir</a></li>";
        }
        ?>
    </ul>
</body>
</html>
