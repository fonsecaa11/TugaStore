<?php
// Conexão com a base de dados
include('conn.php');

// Consultas para obter os produtos
$top_vendas_query = "SELECT nome, preco, imagem FROM produto LIMIT 1";
$top_vendas_result = $conn->query($top_vendas_query);

$ultimas_roupas_query = "SELECT nome, preco, imagem FROM produto order by id_produto desc LIMIT 3 ";
$ultimas_roupas_result = $conn->query($ultimas_roupas_query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuga Store</title>
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
        <section id="catalogo">
            <h2>Catálogo</h2>

            <div class="top-vendas">
                <h3>Top 3 Vendas</h3>
                <div class="produtos">
                    <?php
                    if ($top_vendas_result->num_rows > 0) {
                        while ($row = $top_vendas_result->fetch_assoc()) {
                            echo "<div class='produto'>";
                            echo "<img src='" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
                            echo "<h4>" . $row['nome'] . "</h4>";
                            echo "<p>€" . $row['preco'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="ultimas-roupas">
                <h3>Últimas Roupas Adicionadas</h3>
                <div class="produtos">
                    <?php
                    if ($ultimas_roupas_result->num_rows > 0) {
                        while ($row = $ultimas_roupas_result->fetch_assoc()) {
                            echo "<div class='produto'>";
                            echo "<img src='" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
                            echo "<h4>" . $row['nome'] . "</h4>";
                            echo "<p>€" . $row['preco'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhuma roupa adicionada recentemente.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>

        <section id="sobre-nos">
            <h2>Sobre Nós</h2>
            <p>A <strong>Roupa Tuga</strong> nasceu da paixão pela moda tradicional portuguesa, valorizando a herança cultural com peças contemporâneas inspiradas nas nossas raízes.</p>
        </section>

        <section id="contactos">
            <h2>Contactos</h2>
            <form id="contact-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Roupa Tuga. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
