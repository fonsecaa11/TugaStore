<?php
session_start();
include('conn.php');

//Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_utilizador = $_SESSION['user_id'];

// Busca os produtos no carrinho do utilizador
$query = "
    SELECT carrinho.id_carrinho, carrinho.user_id, produto.nome, produto.imagem, produto.descricao, produto.preco, tamanho.descricao, carrinho.quantidade, produto_tamanho.stock 
    FROM carrinho 
    INNER JOIN produto_tamanho ON carrinho.produto_tamanho_id = produto_tamanho.id_produto_tamanho 
    INNER JOIN produto ON produto_tamanho.produto_id = produto.id_produto 
    INNER JOIN tamanho ON produto_tamanho.tamanho_id = tamanho.id_tamanho 
    WHERE carrinho.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_utilizador);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Tuga Store</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img class="logo" src="image/logo.png" alt="Logo"></a>
            <ul class="menu">
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="sobre-nos.php">Sobre Nós</a></li>
                <li><a href="contactos.php">Contactos</a></li>
            </ul>
            <div class="login-icon">
                <?php
                session_start(); // Inicia ou retoma a sessão
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    // Exibe o nome do utilizador logado
                    echo "<a href='carrinho.php'>Carrinho</a>";
                    echo "🔒 Bem-vindo, " . htmlspecialchars($_SESSION['username']) . "!";
                    echo " <a href='logout.php'>Sair</a>"; // Link para logout
                } else {
                    // Exibe o link de login
                    echo '<a href="login.php">🔒 Login</a>';
                }
                ?>
            </div>

        </nav>
    </header>
    <main>
        <h1>Carrinho de Compras</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Imagem</th>
                    <th>Tamanho</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form action="acao_carrinho.php" method="POST">
                        <tr>
                            <td><?php echo $row['nome']; ?></td>
                            <td><img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>" style="width: 100px; height: 100px;"></td>
                            <td><?php echo $row['descricao'] ?></td>
                            <td>€<?php echo number_format($row['preco'], 2); ?></td>
                            <td><input type="number" id="quantidade" name="quantidade" min="1" max="<?php echo $row['stock']; ?>" value="<?php echo $row['quantidade']; ?>"></td>
                            <td>€<?php echo number_format($total = $row['preco'] * $row['quantidade'], 2); ?></td>
                            <td>
                                <input type="hidden" name="id_carrinho" value="<?php echo $row['id_carrinho']; ?>">
                                <button type="submit" name ="atualizar">Atualizar</button>
                                <button type="submit" name ="remover">Remover</button>
                            </td>
                        </tr>
                    </form>
                <?php endwhile; ?>
            </table>

            <h3>TOTAL:</h3>
            <?php 
                $sql_total = "
                SELECT 
                    SUM(p.preco * c.quantidade) as total_geral
                FROM 
                    carrinho c
                INNER JOIN 
                    produto_tamanho pt ON c.produto_tamanho_id = pt.id_produto_tamanho
                INNER JOIN 
                    produto p ON pt.produto_id = p.id_produto
                WHERE 
                    c.user_id = '$id_utilizador'
                ";
                $stmt = $conn->prepare($sql_total);
                $stmt->execute();
                $result_total = $stmt->get_result();
                $total_geral = $result_total->fetch_assoc()['total_geral'] ?? 0;

                
            ?>
            <p><?php echo number_format($total_geral, 2); ?></p>
            <a href="finalizar_compra.php"><button type="submit">Finalizar Compra</button></a>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            } ?>
        <?php else: ?>
            <p>O seu carrinho está vazio.</p>
        <?php endif; ?>
    </main>
</body>
</html>
