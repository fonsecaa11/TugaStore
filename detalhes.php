<?php
// Inclui o arquivo de conexão com a base de dados
include('conn.php');

// Obtém o ID do produto a partir da URL
$id_produto = isset($_GET['id_produto']) ? (int)$_GET['id_produto'] : 0;

// Verifica se o ID do produto foi passado
if ($id_produto === 0) {
    echo "Produto inválido.";
    exit;
}

// Consulta para buscar os detalhes do produto
$sql_produto = "SELECT * FROM produto WHERE id_produto = ?";
$stmt_produto = $conn->prepare($sql_produto);
$stmt_produto->bind_param("i", $id_produto);
$stmt_produto->execute();
$result_produto = $stmt_produto->get_result();

// Consulta para buscar os tamanhos disponíveis do produto
$sql_tamanhos = "
    SELECT *
    FROM produto_tamanho pt
    INNER JOIN tamanho t ON pt.tamanho_id = t.id_tamanho
    WHERE pt.produto_id = ?
";
$stmt_tamanhos = $conn->prepare($sql_tamanhos);
$stmt_tamanhos->bind_param("i", $id_produto);
$stmt_tamanhos->execute();
$result_tamanhos = $stmt_tamanhos->get_result();

// Verifica se o produto existe
if ($result_produto->num_rows === 0) {
    echo "Produto não encontrado.";
    exit;
}

// Obtém os dados do produto
$produto = $result_produto->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - Tuga Store</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img style="width:170px;height:50px;"g  src="image/logo.png" alt="Logo"></a>
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
    <h1>Detalhes do Produto</h1>
    <div class="detalhes-container">
        <div class="imagem-produto">
            <img src="<?= $produto['imagem']; ?>" alt="<?= htmlspecialchars($produto['nome']); ?>">
        </div>
        <div class="informacoes-produto">
            <h2><?= htmlspecialchars($produto['nome']); ?></h2>

            <p><?= htmlspecialchars($produto['descricao']); ?></p>

            <p><strong>Preço:</strong> €<?= number_format($produto['preco'], 2, ',', '.'); ?></p>

            <?php if ($produto['desconto'] > 0): ?>
                <p><strong>Desconto:</strong> <?= $produto['desconto']; ?>%</p>
            <?php endif; ?>
            
            <form action="adicionar_ao_carrinho.php" method="POST">
                <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']; ?>">

                <label for="tamanho"><p><strong>Tamanhos disponíveis:</strong></p></label>
                <select name="id_tamanho" id="tamanho">
                    <?php while ($tamanho = $result_tamanhos->fetch_assoc()): ?>
                        <option value="<?php echo $tamanho['id_tamanho']; ?>"><?php echo $tamanho['descricao']; ?></option>
                    <?php endwhile; ?>
                </select>
                <br><br><br>

                <button type="submit">Adicionar ao Carrinho</button>
                <br><br>
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
                    unset($_SESSION['success']);
                }elseif (isset($_SESSION['error'])) {
                    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
                ?>

            </form>
        </div>
    </div>
</main>

    <footer>
        <p>&copy; 2024 Tuga Store. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
